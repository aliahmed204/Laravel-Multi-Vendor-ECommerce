<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\Seller\UpdateShopRequest;
use App\Models\Seller;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        $seller = auth('seller')->user();
        $shop   = $seller->shop;
        if(!$shop){
            $shop = $seller->shop()->create();
        }

        return view('back.pages.seller.shop.index', compact('shop'));
    }

    public function update(UpdateShopRequest $request)
    {
        $data = $request->except(['_token', '_method','logo']);
        $shop = auth('seller')->user()->shop;
        $shop->update($data);

        if ($request->hasFile('logo')){
            $shop->addMedia($request->file('logo'))->toMediaCollection('logos');
        }

        return redirect()->back()->with('success', 'shop updated successfully');
    }
}
