<?php

namespace App\Livewire\Seller;

use Livewire\Component;

class SellerProfile extends Component
{
    public $tab = null;
    public $tabName = 'personal_details';
    public $first_name, $last_name, $email, $username, $phone, $address;
    public $current_password, $new_password, $new_password_confirmation;

    protected $queryString = ['tab' => ['keep' => true] ];

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
