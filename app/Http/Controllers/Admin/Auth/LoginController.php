<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        $filedType = is_numeric($request->login_id)
            ? 'numeric'
            : (filter_var($request->login_id, FILTER_VALIDATE_EMAIL) ? 'email' : 'username');


        $request->validate([
                'login_id' => [
                    'required',
                    $filedType == 'email' ? 'email' : '',
                    'exists:admins,' . ($filedType == 'email' ? 'email' : ($filedType == 'numeric' ? 'phone' : 'username'))
                ],
                'password' => ['required', 'min:6', 'max:45'],
            ],
            [
                'login_id.required' => 'The Email\Username Or Phone field is required.',
                'login_id.exists' => 'Username Is not exists in system.',
                'password.exists' => 'Password is required.'
            ]);

        $credentials = [
            $filedType => $request->login_id,
            'password' => $request->password
        ];


        if (auth()->guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.home');
        }

        return back()->withErrors([
            'fail' => 'The provided credentials do not match our records.',
        ]);
    }
}
