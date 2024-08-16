<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        $filedType = is_numeric($request->login_id)
            ? 'phone'
            : (filter_var($request->login_id, FILTER_VALIDATE_EMAIL) ? 'email' : 'username');


        $request->validate([
                'login_id' => [
                    'required',
                    $filedType == 'email' ? 'email' : '',
                    'exists:admins,' . ($filedType == 'email' ? 'email' : ($filedType == 'phone' ? 'phone' : 'username'))
                ],
                'password' => ['required', 'min:6', 'max:45'],
            ],
            [
                'login_id.required' => 'The Email\Username Or Phone field is required.',
                'login_id.exists' => 'Username Is not exists in system.',
                'password.required' => 'Password is required.'
            ]);

        $credentials = [
            $filedType => $request->login_id,
            'password' => $request->password
        ];


        if (auth()->guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.home');
        }
        session()->flash('fail','The provided credentials do not match our records.');
        return redirect()->back();
    }
}
