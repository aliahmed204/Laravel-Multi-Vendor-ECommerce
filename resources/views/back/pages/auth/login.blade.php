@extends('back.layout.auth-master')

@section('pageTitle', isset($pageTitle) ?? 'auth-page')

@section('content')
    <div class="login-box bg-white box-shadow border-radius-10">
        <div class="login-title">
            <h2 class="text-center text-primary">Login To Dashboard</h2>
        </div>
        <form action="{{route('admin.authenticate')}}" method="post" >
            @csrf

            <x-session.flash name="fail" type="danger" />
            <x-session.flash name="success" type="success" />

            {{-- email, username, phone --}}
            <div class="input-group custom">
                <input
                    type="text"
                    class="form-control form-control-lg"
                    placeholder="Email/Username/Phone"
                    name="login_id"
                    value="{{old('login_id')}}"
                />
                <div class="input-group-append custom">
                    <span class="input-group-text">
                        <i class="icon-copy dw dw-user1"></i>
                    </span>
                </div>
            </div>
            <x-forms.error name="login_id" />

            {{-- password --}}
            <div class="input-group custom">
                <input
                    type="password"
                    class="form-control form-control-lg"
                    placeholder="**********"
                    name="password"
                />
                <div class="input-group-append custom">
                    <span class="input-group-text">
                        <i class="dw dw-padlock1"></i>
                    </span>
                </div>
            </div>
            <x-forms.error name="password" />

            {{-- Remember-Me Forgot-Password --}}
            <div class="row pb-30">
                <div class="col-6">
                    <div class="custom-control custom-checkbox">
                        <input
                            type="checkbox"
                            class="custom-control-input"
                            id="customCheck1"
                            name="remember"
                        />
                        <label class="custom-control-label" for="customCheck1">Remember</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="forgot-password">
                        <a href="{{route('admin.forget-password')}}">Forgot Password</a>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="row">
                <div class="col-sm-12">
                    <div class="input-group mb-0">
                        <!--use code for form submit-->
                        <input class="btn btn-primary btn-lg btn-block" type="submit" value="Sign In">
                    </div>
                    <div class="font-16 weight-600 pt-10 pb-10 text-center" data-color="#707373">
                        OR
                    </div>
                    <div class="input-group mb-0">
                        <a class="btn btn-outline-primary btn-lg btn-block"
                            href="register.html">
                            Register To Create Account
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endSection
