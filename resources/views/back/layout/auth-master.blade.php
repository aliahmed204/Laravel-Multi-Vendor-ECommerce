<!DOCTYPE html>
<html>
<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8" />
    <title>@yield('pageTitle', 'Home')</title>

    <!-- Site favicon -->
    <link
        rel="apple-touch-icon"
        sizes="180x180"
        href="{{getSettingMedia('site_favicon')}}"
    />
    <link
        rel="icon"
        type="image/png"
        sizes="32x32"
        href="{{getSettingMedia('site_favicon')}}"
    />
    <link
        rel="icon"
        type="image/png"
        sizes="16x16"
        href="{{getSettingMedia('site_favicon')}}"
    />

    <!-- Mobile Specific Metas -->
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1"
    />

    <!-- Google Font -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet"
    />
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('back')}}/vendors/styles/core.css" />
    <link
        rel="stylesheet"
        type="text/css"
        href="{{asset('back')}}/vendors/styles/icon-font.min.css"
    />
    <link rel="stylesheet" type="text/css" href="{{asset('back')}}/vendors/styles/style.css" />

   @stack('styleSheets')
</head>
<body class="login-page">
<div class="login-header box-shadow">
    <div
        class="container-fluid d-flex justify-content-between align-items-center"
    >
        <div class="brand-logo">
            <a href="login.html">
                <img src="{{ asset('/images/site/'.\App\Models\GeneralSetting::getValue('site_logo'))}}" alt="" />
            </a>
        </div>
        <div class="login-menu">
            <ul>
                @if( !Route::is('admin.*') )
                    @if( Route::is('seller.login') )
                        <li><a href="{{route('seller.register')}}">Register</a></li>
                    @else
                        <li><a href="{{route('seller.login')}}">Login</a></li>
                    @endif
                @endif
            </ul>
        </div>
    </div>
</div>
<div
    class="login-wrap d-flex align-items-center flex-wrap justify-content-center"
>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 col-lg-7">
                <img src="{{asset('back')}}/vendors/images/login-page-img.png" alt="" />
            </div>
            <div class="col-md-6 col-lg-5">
                @yield('content')
            </div>
        </div>
    </div>
</div>

<!-- js -->
<script src="{{asset('back')}}/vendors/scripts/core.js"></script>
<script src="{{asset('back')}}/vendors/scripts/script.min.js"></script>
<script src="{{asset('back')}}/vendors/scripts/process.js"></script>
<script src="{{asset('back')}}/vendors/scripts/layout-settings.js"></script>
<script>
    // prevent back history from firefox
    if( navigator.userAgent.indexOf("Firefox") !== -1 ){
        history.pushState(null, null, document.URL);
        window.addEventListener('popstate', function(){
            history.pushState(null, null, document.URL);
        });
    }
</script>
    @stack('scripts')

</body>
</html>
