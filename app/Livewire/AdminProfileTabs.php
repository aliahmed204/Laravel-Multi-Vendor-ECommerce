<?php

namespace App\Livewire;

use App\Mail\AdminPasswordResetSuccessfullyMail;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class AdminProfileTabs extends Component
{
    public $tab = null;
    public $tabname = 'personal_details'; // initial tab
    protected $queryString = ['tab'=>['keep'=>true]];
    public $first_name, $last_name, $email, $username, $admin_id;
    public $current_password, $new_password, $new_password_confirmation;

    public function mount()
    {
        $this->tab = request()->tab ?: $this->tabname;
        if( Auth::guard('admin')->check() ){
            $admin = Admin::findOrFail(auth()->id());
            $this->admin_id = $admin->id;
            $this->first_name = $admin->first_name;
            $this->last_name = $admin->last_name;
            $this->email = $admin->email;
            $this->username = $admin->username;
        }
    }
    public function selectTab($tab)
    {
        $this->tab = $tab;
    }

    public function updateAdminPersonalDetails()
    {
        $this->validate([
            'first_name' =>'required|min:5',
            'last_name'  =>'required|min:5',
            'email'      =>'required|email|unique:admins,email,'.$this->admin_id,
            'username'   =>'required|min:3|unique:admins,username,'.$this->admin_id
        ]);

        $admin = Admin::findOrFail($this->admin_id);
        $admin->update([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'username' => $this->username
        ]);

        $this->dispatch('updateAdminSellerHeaderInfo');
        $this->dispatch('updateAdminInfo',[
            'adminName'=>$this->first_name,
            'adminEmail'=>$this->email
        ]);
        $this->showToastr('success','Your personal details have been successfully updated.');

    }

    public function updatePassword(){
        $this->validate([
            // check current password is correct
            'current_password'=>[
                'required', function($attribute, $value, $fail){
                    if(!Hash::check($value, Admin::find(auth('admin')->id())->password)){
                        $fail(__('The current password is incorrect'));
                    }
                }
            ],
            'new_password'=>'required|min:6|max:45|confirmed'
        ]);

        $admin = Admin::findOrFail(auth('admin')->id());

        $admin->update([
            'password'=>Hash::make($this->new_password)
        ]);

        $data = [
            'admin'=> $admin,
            'password'=> $this->new_password
        ];

        Mail::to($admin->email)->send(new AdminPasswordResetSuccessfullyMail($data));

        $this->current_password = $this->new_password = $this->new_password_confirmation = null;
        $this->showToastr('success','Password successfull changed.');

            //$this->showToastr('error','Something went wrong.');

    }
    public function showToastr($type, $message){
        return $this->dispatch('showToastr',[
            'type'=>$type,
            'message'=>$message
        ]);
    }

    public function render()
    {
        return view('livewire.admin-profile-tabs');
    }
}
