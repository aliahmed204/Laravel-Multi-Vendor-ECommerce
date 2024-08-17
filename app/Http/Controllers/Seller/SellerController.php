<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class SellerController extends Controller
{
    public function home()
    {
        $data = [
            'pageTitle' => 'Seller Home'
        ];

        return view('back.pages.seller.home', $data);
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

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function changeProfilePicture(Request $request)
    {
        /** @var Seller $seller*/
        $seller = auth('seller')->user();
        $seller->addMedia($request->file('sellerProfilePictureFile'))->toMediaCollection('avatars');
        return response()->json(['status'=>1,'msg'=>'Your profile picture has been successfully updated.']);
    }

}
