<?php

namespace App\Livewire\Seller;

use App\Mail\Seller\SellerPasswordResetMail;
use App\Mail\Seller\SellerPasswordResetSuccessfullyMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class SellerProfile extends Component
{
    public $tab = null;
    public $tabName = 'personal_details';
    public $first_name, $last_name, $email, $username, $phone, $address;
    public $current_password, $new_password, $new_password_confirmation;

    protected $queryString = ['tab' => ['keep' => true] ];

    protected $listeners = [
        'updateSellerProfilePage' => '$refresh'
    ];
    public function selectTab($tab)
    {
        $this->tab = $tab;
    }

    public function mount()
    {
        $this->tab = request()->tab ?: $this->tabName;
        $seller = auth('seller')->user();
        $this->first_name = $seller->first_name;
        $this->last_name = $seller->last_name;
        $this->email = $seller->email;
        $this->username = $seller->username;
        $this->phone = $seller->phone;
        $this->address = $seller->address;

    }

    public function updateSellerPersonalDetails()
    {
        $this->validate([
            'first_name' =>'required|min:5',
            'last_name'  =>'required|min:5',
            'username'   =>'required|min:5|unique:sellers,username,'.auth('seller')->id(),
            'phone'      =>'required|min:10|unique:sellers,phone,'.auth('seller')->id(),
            'address'    =>'required|min:5',
        ]);
        $seller = auth('seller')->user();
        $seller->first_name = $this->first_name;
        $seller->last_name = $this->last_name;
        $seller->username = $this->username;
        $seller->address = $this->address;
        $seller->phone = $this->phone;
        $update = $seller->save();

        if( $update ){
            $this->dispatch('updateAdminSellerHeaderInfo');
            $this->showToastr('success','Personal Details have been successfully updated.');
        }else{
            $this->showToastr('error','Something went wrong.');
        }
    }

    public function updatePassword(){
        $seller = auth('seller')->user();

        //Validate the form
        $this->validate([
            'current_password'=>[
                'required',
                function($attribute, $value, $fail) use ($seller){
                    if( !Hash::check($value, $seller->password) ){
                        return $fail(__('The current password is incorrect.'));
                    }
                }
            ],
            'new_password'=>'required|min:5|max:45|confirmed'
        ]);

        //Update password
        $update = $seller->update([
            'password'=> Hash::make($this->new_password)
        ]);

        if( $update ){
            //Send email notification to seller that contains new password
            $data = [
                'seller' => $seller,
                'password' => $this->new_password,
            ];

            Mail::to($seller)->send(new SellerPasswordResetSuccessfullyMail($data));

            $this->current_password = null;
            $this->new_password = null;
            $this->new_password_confirmation = null;

            $this->showToastr('success','Password successfully updated.');
        }else{
            $this->showToastr('error','Something went wrong.');
        }
    }

    public function render()
    {
        return view('livewire.seller.seller-profile',[
            'seller' => auth('seller')->user(),
        ]);
    }

    public function showToastr($type, $message){
        return $this->dispatch('showToastr',[
            'type'=>$type,
            'message'=>$message
        ]);
    }
}
