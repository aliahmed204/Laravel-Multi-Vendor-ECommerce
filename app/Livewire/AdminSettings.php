<?php

namespace App\Livewire;

use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Livewire\Component;

class AdminSettings extends Component
{
    public $tab = null;
    public $default_tab = 'general_settings';
    protected $queryString = ['tab'=>['keep'=>true]];
    public $site_name, $site_email, $site_phone, $site_meta_keywords, $site_meta_description, $site_logo, $site_favicon, $site_address;
    public $facebook_url, $twitter_url, $instagram_url, $youtube_url, $github_url, $linkedin_url;

    public function selectTab($tab)
    {
        $this->tab = $tab;
    }

    public function mount()
    {
        $this->tab = request()->tab ?: $this->default_tab;

        $data = GeneralSetting::getAllValues();

        $this->site_name             = $data['site_name'] ?? null;
        $this->site_email            = $data['site_email'] ?? null;
        $this->site_phone            = $data['site_phone'] ?? null;
        $this->site_address          = $data['site_address'] ?? null;
        $this->site_meta_keywords    = $data['site_meta_keywords'] ?? null;
        $this->site_meta_description = $data['site_meta_description'] ?? null;
        $this->site_logo             = (GeneralSetting::firstWhere('key', 'site_logo'))->getFirstMediaUrl('site_logo') ?? null;
        $this->site_favicon          = getSettingMedia('site_favicon') ?? null;

        $this->facebook_url          = $data['facebook_url'] ?? null;
        $this->twitter_url           = $data['twitter_url'] ?? null;
        $this->instagram_url         = $data['instagram_url'] ?? null;
        $this->youtube_url           = $data['youtube_url'] ?? null;
        $this->github_url            = $data['github_url'] ?? null;
        $this->linkedin_url          = $data['linkedin_url'] ?? null;
    }

    public function updateGeneralSettings()
    {
        $this->validate([
            'site_name' => 'required',
            'site_email' => 'required|email',
            'site_phone' => 'required',
            'site_address' => 'required',
            'site_meta_keywords' => 'required',
            'site_meta_description' => 'required',
        ]);

        $settings = [
            'site_name'  => $this->site_name,
            'site_email' => $this->site_email,
            'site_phone' => $this->site_phone,
            'site_meta_keywords' => $this->site_meta_keywords,
            'site_meta_description' => $this->site_meta_description,
            'site_address' => $this->site_address,
        ];

        $updatedSettings = GeneralSetting::setValues($settings);
        if( $updatedSettings ){
            $this->showToastr('success','General settings have been successfully updated.');
        }else{
            $this->showToastr('error','Something went wrong.');
        }
    }

    public function updateSocialNetworks()
    {
        $this->validate([
            'facebook_url'  => 'required',
            'twitter_url'   => 'required',
            'instagram_url' => 'required',
            'youtube_url'   => 'required',
            'github_url'    => 'required',
            'linkedin_url'  => 'required',
        ]);

        $settings = [
            'facebook_url'  => $this->facebook_url,
            'twitter_url'   => $this->twitter_url,
            'instagram_url' => $this->instagram_url,
            'youtube_url'   => $this->youtube_url,
            'github_url'    => $this->github_url,
            'linkedin_url'  => $this->linkedin_url,
        ];

        $updatedSettings = GeneralSetting::setValues($settings);
        if( $updatedSettings ){
            $this->showToastr('success','Social Media have been successfully updated.');
        }else{
            $this->showToastr('error','Something went wrong.');
        }
    }

    public function showToastr($type, $message){
        return $this->dispatch('showToastr',[
            'type'=>$type,
            'message'=>$message
        ]);
    }

    public function render()
    {
        return view('livewire.admin-settings');
    }
}
