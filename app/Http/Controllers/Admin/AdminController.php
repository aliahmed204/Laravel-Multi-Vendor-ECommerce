<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminUpdateProfileRequest;
use App\Models\Admin;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    public function viewProfile()
    {
        if (Auth::guard('admin')->check()) {
            return view('back.pages.profile', [
                'admin' => Auth::guard('admin')->user(),
            ]);
        }else{
            session()->flash('error', 'Please login first');
            return redirect()->route('admin.login');
        }
    }

    public function changeProfilePicture(Request $request)
    {
        /** @var Admin $admin*/
        $admin = Admin::findOrFail(auth('admin')->id());
        $admin->addMedia($request->file('adminProfilePictureFile'))->toMediaCollection('avatars');
        return response()->json(['status'=>1,'msg'=>'Your profile picture has been successfully updated.']);

        /*
        $file = $request->file('adminProfilePictureFile');
        $old_picture = $admin->image;
        $filename = 'ADMIN_IMG_'.rand(2,1000).$admin->id.time().uniqid().'.jpg';

        $upload = $file->move(public_path(Admin::IMAGE_PATH),$filename);

        if($upload){
            if( $old_picture != null && File::exists(public_path($old_picture)) ){
                File::delete(public_path($old_picture));
            }
            $admin->update(['image' => $filename]);
            return response()->json(['status'=>1,'msg'=>'Your profile picture has been successfully updated.']);
        }else{
            return response()->json(['status'=>0,'msg'=>'Something went wrong.']);
        }*/

    }

    public function changeLogo(Request $request)
    {
        $file = $request->file('site_logo');
        $site_logo = GeneralSetting::setValue('site_logo', $file->getClientOriginalName());
        $site_logo->addMedia($request->file('site_logo'))->toMediaCollection('site_logo');
        return response()->json(['status'=>1,'msg'=>'Site logo has been updated successfully.']);
    }
    public function changeFavicon(Request $request)
    {
        $file = $request->file('site_favicon');
        $site_logo = GeneralSetting::setValue('site_favicon', $file->getClientOriginalName());
        $site_logo->addMedia($request->file('site_favicon'))->toMediaCollection('site_favicon');
        return response()->json(['status'=>1,'msg'=>'site favicon has been updated successfully.']);
    }


}
