@extends('back.layout.auth-master')

@section('pageTitle', isset($pageTitle) ?: 'reset password')

@section('content')

    <div class="login-box bg-white box-shadow border-radius-10">
        <div class="login-title">
            <h2 class="text-center text-primary">Reset Password</h2>
        </div>
        <h6 class="mb-20">Enter your new password, confirm and submit</h6>
        <form method="post" action="{{route('admin.reset-password-handler',['token' => request()->token])}}">
            @csrf
            <x-session.flash name="fail" type="danger" />
            <x-session.flash name="success" type="success" />

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
            @error('new_password')
            <div class="d-block text-danger" style="margin-top: -25px; margin-bottom: 15px">
                <strong>{{ $message }}</strong>
            </div>
            @enderror

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
            @error('new_password_confirmation')
            <div class="d-block text-danger" style="margin-top: -25px; margin-bottom: 15px">
                <strong>{{ $message }}</strong>
            </div>
            @enderror
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
