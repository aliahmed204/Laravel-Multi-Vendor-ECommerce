<?php

namespace App\Http\Controllers\Seller\Auth;

use App\Helpers\constantDefaults;
use App\Helpers\constantGuards;
use App\Http\Controllers\Controller;
use App\Mail\Seller\SellerPasswordResetMail;
use App\Mail\Seller\SellerPasswordResetSuccessfullyMail;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgetPasswordController extends Controller
{
    public function sendPasswordLink(Request $request)
    {
        $request->validate(['email' => 'required|exists:sellers,email']);
        $email = $request->email;
        $seller = Seller::firstWhere('email', $email);

        $token = base64_encode(Str::random(64));

        $oldTokenCheck = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->where('guard', constantGuards::SELLER)
            ->first();
        if ($oldTokenCheck){
            DB::table('password_reset_tokens')
                ->where('email', $email)
                ->where('guard', constantGuards::SELLER)
                ->update([
                    'token' => $token,
                    'created_at' => Carbon::now()
                ]);
        }else{
            DB::table('password_reset_tokens')->insert([
                'email'=> $email,
                'guard'=> constantGuards::SELLER,
                'token'=> $token,
                'created_at'=> Carbon::now()
            ]);
        }

        $data = [
            'actionLink' => route('seller.reset-password',['token'=>$token]),
            'seller'     => $seller
        ];

        // should be event
        Mail::to($seller)->send(new SellerPasswordResetMail($data));

        return to_route('seller.forget-password')
                ->with('success','We have e-mailed your password reset link.');

    }
    public function resetPasswordForm($token)
    {
        $checkToken = DB::table('password_reset_tokens')
            ->where('guard', constantGuards::SELLER)
            ->where('token', $token)
            ->first();

        if (! $checkToken)
            return to_route('admin.forget-password')->with('fail','Invalid token, request another password reset link.');

        $diffMinutes = Carbon::parse($checkToken->created_at)->addMinutes(constantDefaults::tokenExpiredMinute)->isPast();
        if($diffMinutes){
            return to_route('admin.forget-password')->with('fail','Token expired, request another password reset link.');
        }else{
            return view('back.pages.seller.auth.reset-password', compact('token'));
        }
    }
    public function resetPasswordHandler(Request $request)
    {
        $request->validate([
            'new_password' => ['required', 'min:6', 'max:45','required_with:new_password_confirmation'],
            'new_password_confirmation' => ['required', 'same:new_password']
        ]);

        $check_token = DB::table('password_reset_tokens')
            ->where('token', $request->token)
            ->where('guard', constantGuards::SELLER)
            ->first();
        if(! $check_token)
            return to_route('seller.forget-password')->with('fail','Invalid token, request another password reset link.');

        $seller = Seller::firstWhere('email', $check_token->email);

        $seller->update([
            'password' => bcrypt($request->new_password)
        ]);

        DB::table('password_reset_tokens')
            ->where('email', $check_token->email)
            ->where('guard', constantGuards::SELLER)
            ->delete();

        $data = [
            'seller' => $seller,
            'password' => $request->new_password
        ];

        // job
        Mail::to($seller->email)->send(new SellerPasswordResetSuccessfullyMail($data));

        return to_route('seller.login')->with('success','Done!, Your password has been changed. Use new password to login into system.');
    }
    public function updatePassword()
    {}

}
