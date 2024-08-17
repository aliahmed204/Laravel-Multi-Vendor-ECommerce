<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerController extends Controller
{
    public function home()
    {
        $data = [
            'pageTitle' => 'Seller Home'
        ];

        return view('back.pages.seller.home');
    }
    public function viewProfile()
    {
        if (Auth::guard('seller')->check()){
            return view('back.pages.seller.profile', [
                'seller' => Auth::guard('seller')->user(),
            ]);
        }else{
            return redirect()->route('seller.login')->with('fail', 'Please login first');
        }
    }
}
