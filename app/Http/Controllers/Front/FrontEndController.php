<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class FrontEndController extends Controller
{
    public $data = [
        'pageTitle'=>'LARAVECOM | Online Shopping Website'
    ];
    public function homePage(Request $request){
        /**@var GeneralSetting $settings*/
        $settings = GeneralSetting::getAllValues();
        $categories = Category::isParent()->ordered()->with('subCategories', 'subCategories.children')->get();
        return view('front.pages.home',[
            'settings' => $settings,
            'pageTitle' => $this->data['pageTitle'],
            'categories' => $categories,
        ]);
    }
}
