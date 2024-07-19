<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Helpers\constantGuards;
use App\Helpers\constantDefaults;
use App\Http\Controllers\Controller;
use App\Mail\AdminPasswordResetSuccessfullyMail;
use App\Mail\AdminPasswordRestedSuccessfullyMail;
use App\Mail\AdminPasswordResetMail;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function sendPasswordLink(Request $request)
    {
        $request->validate([
            'email'=>'required|email|exists:admins,email'
        ],[
            'email.required' => 'The :attribute is required',
            'email.email'    => 'Invalid email address',
            'email.exists'   => 'The :attribute is not exists in system'
        ]);

        // get email details
        $admin = Admin::where('email', $request->email)->first();

        // generate token
        $token = base64_encode(Str::random(64));

        // check if there is old token for this admin
        $old_token = DB::table('password_reset_tokens')
            ->where('email', $admin->email)
            ->where('guard', constantGuards::ADMIN)
        ->first();

        if ($old_token)
        {
            DB::table('password_reset_tokens')
                ->where('email', $admin->email)
                ->where('guard', constantGuards::ADMIN)
                ->update([
                    'token' => $token,
                    'created_at' => Carbon::now()
                ]);
        }else{
            DB::table('password_reset_tokens')->insert([
                'email'=> $request->email,
                'guard'=> constantGuards::ADMIN,
                'token'=> $token,
                'created_at'=> Carbon::now()
            ]);
        }

        $actionLink = route('admin.reset-password',['token'=>$token]);

        $data = [
            'actionLink' => $actionLink,
            'admin'      => $admin
        ];

        $mail_body = view('email-templates.admin-forgot-email-template', $data)->render();

        $mail_config = [
            'mail_from_email' => env('MAIL_FROM_ADDRESS'),
            'mail_from_name' => env('MAIL_FROM_NAME'),
            'mail_recipient_email' => $admin->email,
            'mail_recipient_name' => $admin->name,
            'mail_subject' => 'Reset Password',
            'mail_body' => $mail_body
        ];

        // using PHPMailer
        if (sendEmail($mail_config)){
            session()->flash('success','We have e-mailed your password reset link.');
            return to_route('admin.forget-password');
        }else{
            session()->flash('fail','Something went wrong!');
            return redirect()->route('admin.forgot-password');
        }

        // using laravel mail
        if( Mail::to('user@gmail.com')->send(new AdminPasswordResetMail($data))){
            session()->flash('success','We have e-mailed your password reset link.');
            return to_route('admin.forget-password');
        }else{
            session()->flash('fail','Something went wrong!');
            return redirect()->route('admin.forgot-password');
        }

    }
    public function resetPassword($token)
    {
        // check token
        $check_token = DB::table('password_reset_tokens')
            ->where('token', $token)
            ->where('guard', constantGuards::ADMIN)
            ->first();
        if($check_token){
            // check if password token is expired
            $diffMinutes = Carbon::parse($check_token->created_at)->addMinutes(constantDefaults::tokenExpiredMinute)->isPast();
           // $diffMinutes = Carbon::createFromFormat('Y-m-d H:i:s',$check_token->created_at)->diffInMinutes(Carbon::now()) > constantDefaults::tokenExpiredMinute;

            if($diffMinutes){
                session()->flash('fail','Token expired, request another password reset link.');
                return to_route('admin.forget-password');
            }else{
                return view('back.pages.auth.reset-password', compact('token'));
            }
        }else{
            session()->flash('fail','Invalid token, request another password reset link.');
            return to_route('admin.forget-password');
        }
    }

    public function resetPasswordHandler(Request $request)
    {
        $request->validate([
            //'token' => ['required', 'exists:password_reset_tokens,token,guard:admin'],
            'new_password' => ['required', 'min:6', 'max:45','required_with:new_password_confirmation', 'same:new_password_confirmation'],
            'new_password_confirmation' => ['required', 'same:new_password']
        ]);

        $check_token = DB::table('password_reset_tokens')
            ->where('token', $request->token)
            ->where('guard', constantGuards::ADMIN)
            ->first();

        if($check_token){
            $admin = Admin::where('email', $check_token->email)->first();

            $admin->update([
                'password' => bcrypt($request->new_password)
            ]);

            DB::table('password_reset_tokens')
                ->where('email', $check_token->email)
                ->where('guard', constantGuards::ADMIN)
                ->delete();

            $data = [
                'admin' => $admin,
                'password' => $request->new_password
            ];

            // job
            Mail::to($admin->email)->send(new AdminPasswordResetSuccessfullyMail($data));

            session()->flash('success','Done!, Your password has been changed. Use new password to login into system.');
            return to_route('admin.login');
        }else{
            session()->flash('fail','Invalid token, request another password reset link.');
            return to_route('admin.forget-password');
        }
    }
}
