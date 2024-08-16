<?php

namespace App\Http\Controllers\Seller\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Seller\RegisterRequest;
use App\Mail\Seller\SellerVerifyMail;
use App\Models\Seller;
use App\Models\VerificationToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $seller = Seller::create($request->validated());

        $token  = base64_encode(Str::random(64));

        VerificationToken::create([
            'verify_type' => Seller::class,
            'verify_id'   => $seller->getKey(),
            'email'       => $seller->email,
            'token'       => $token,
        ]);

        $data = array(
            'actionLink' => route('seller.verify',['token' => $token]),
            'seller'    => $seller,
        );

        // using laravel mail
        if( Mail::to($seller)->send(new SellerVerifyMail($data)) ){
            session()->flash('success','We have e-mailed your password reset link.');
            return to_route('seller.register-success');
        }else{
            session()->flash('fail','Something went wrong while sending verification link.');
            return redirect()->route('seller.register');
        }
    }

    public function verify($token)
    {
        $verification = VerificationToken::where('token', $token)->first();

        if (! $verification){
            return redirect()->route('seller.register')->with('fail','Invalid verification token or this token is deprecated');
        }

        $seller = Seller::firstWhere('email', $verification->email);
        if ( $seller->isVerified() ){
            return redirect()->route('seller.login')->with('info', 'Your email is already verified. You can now login.');
        }

        $seller->verify();

        $verification->delete();

        return redirect()->route('seller.login')->with('success', 'Your email has been verified. You can now login.');

    }

    public function registerSuccess()
    {

    }

    public function authenticate(Request $request)
    {
        $filedType = filter_var($request->login_id, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $request->validate([
            'login_id' => [
                'required',
                'exists:sellers,' . $filedType
            ],
            'password' => ['required', 'min:6', 'max:45'],
        ],
            [
                'login_id.required' => 'The Email\Username field is required.',
                'login_id.exists' => 'Username Is not exists in system.',
                'password.required' => 'Password is required.'
            ]
        );

        $credentials = [
            $filedType => $request->login_id,
            'password' => $request->password
        ];

        if (auth()->guard('seller')->attempt($credentials)) {
            return redirect()->route('seller.home');
        }

        return redirect()->back()->with('fail', 'Wrong Credentials');

    }

    public function logout(Request $request)
    {
        Auth::guard('seller')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        Session::flash('fail', 'Logout Successfully');

        return to_route('seller.login');
    }
}
