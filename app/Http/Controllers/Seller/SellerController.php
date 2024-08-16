<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function home()
    {
        $data = [
            'pageTitle' => 'Seller Home'
        ];

        return view('back.pages.seller.home');
    }
}
