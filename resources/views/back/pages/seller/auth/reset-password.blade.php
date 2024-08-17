@extends('back.layout.auth-master')

@section('pageTitle', isset($pageTitle) ?: 'reset password')

@section('content')

    <div class="login-box bg-white box-shadow border-radius-10">
        <div class="login-title">
            <h2 class="text-center text-primary">Reset Password</h2>
        </div>
        <h6 class="mb-20">Enter your new password, confirm and submit</h6>
        <form method="post" action="{{route('seller.reset-password-handler',['token' => request()->token])}}">
            @csrf
            <x-alert.form-alert />

            <div class="input-group custom">
                <input
                    type="password"
                    name="new_password"
                    class="form-control form-control-lg"
                    placeholder="New Password"
                />
                <div class="input-group-append custom">
					<span class="input-group-text">
                        <i class="dw dw-padlock1"></i>
                    </span>
                </div>
            </div>
            {{-- <x-input-error :messages="$errors->get('new-password')" class="mt-2" />--}}
            <x-forms.error name="new_password" />

            <div class="input-group custom">
                <input
                    type="password"
                    name="new_password_confirmation"
                    class="form-control form-control-lg"
                    placeholder="Confirm New Password"
                />
                <div class="input-group-append custom">
					<span class="input-group-text">
                        <i class="dw dw-padlock1"></i>
                    </span>
                </div>
            </div>
            <x-forms.error name="new_password_confirmation" />

            <div class="row align-items-center">
                <div class="col-5">
                    <div class="input-group mb-0">
                        <!-- use code for form submit-->
                        <input class="btn btn-primary btn-lg btn-block" type="submit" value="Submit">
                    </div>
                </div>
            </div>
        </form>
    </div>

@endSection
