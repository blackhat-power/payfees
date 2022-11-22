<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>PayFee</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}"/>

    <link rel="stylesheet" href="{{ asset('assets/css/backend.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/remixicon/fonts/remixicon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/@icon/dripicons/dripicons.css') }}">

    <link rel='stylesheet' href='{{ asset('assets/vendor/fullcalendar/core/main.css') }}'/>
    <link rel='stylesheet' href='{{ asset('assets/vendor/fullcalendar/daygrid/main.css') }}'/>
    <link rel='stylesheet' href='{{ asset('assets/vendor/fullcalendar/timegrid/main.css') }}'/>
    <link rel='stylesheet' href='{{ asset('assets/vendor/fullcalendar/list/main.css') }}'/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/mapbox/mapbox-gl.css') }}">
</head>
<body class=" ">
<!-- loader Start -->
<div id="loading">
    <div id="loading-center">
    </div>
</div>
<!-- loader END -->

<div class="wrapper">
    <section class="login-content">
        <img src="{{ asset('assets/images/login/02.png') }}" class="lb-img" alt="">
        <img src="{{ asset('assets/images/login/03.png') }}" class="rb-img" alt="">
        <div class="container h-100">
            <div class="row align-items-center justify-content-center h-100">
                <div class="col-12">
                    <div class="row align-items-center">
                        <div class="col-lg-6 mb-lg-0 mb-4 mt-lg-0 mt-4">
                            <img src="{{ asset('assets/images/login/01.png') }}" class="img-fluid w-80" alt="">
                        </div>
                        <div class="col-lg-6">
                            <h2 class="mb-2">Sign In</h2>
                            <p>To Keep connected with us please login with your personal info.</p>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="floating-label form-group">
                                            <input class="floating-input form-control" id="username" type="text"
                                                   name="username" :value="old('username')" required autofocus/>
                                            <label>Username</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="floating-label form-group">
                                            <input class="floating-input form-control"
                                                   id="password" class="block mt-1 w-full"
                                                   type="password"
                                                   name="password"
                                                   required autocomplete="current-password"/>
                                            <label>Password</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="custom-control custom-checkbox mb-3">
                                            <input name="remember" type="checkbox" class="custom-control-input"
                                                   id="remember_me">
                                            <label class="custom-control-label"
                                                   for="customCheck1">{{ __('Remember me') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        @if (Route::has('password.request'))
                                            <a class="text-primary float-right" href="{{ route('password.request') }}">
                                                {{ __('Forgot your password?') }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">{{ __('Login') }}</button>

                                <p class="mt-3">
                                    Create an Account <a href="auth-sign-up.html" class="text-primary">Sign Up</a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Backend Bundle JavaScript -->
<script src="{{ asset('assets/js/backend-bundle.min.js') }}"></script>

<!-- Flextree Javascript-->
<script src="{{ asset('assets/js/flex-tree.min.js') }}"></script>
<script src="{{ asset('assets/js/tree.js') }}"></script>

<!-- Table Treeview JavaScript -->
<script src="{{ asset('assets/js/table-treeview.js') }}"></script>

<!-- Masonary Gallery Javascript -->
<script src="{{ asset('assets/js/masonry.pkgd.min.js') }}"></script>
<script src="{{ asset('assets/js/imagesloaded.pkgd.min.js') }}"></script>

<!-- Mapbox Javascript -->
<script src="{{ asset('assets/js/mapbox-gl.js') }}"></script>
<script src="{{ asset('assets/js/mapbox.js') }}"></script>

<!-- Fullcalender Javascript -->
<script src='{{ asset('assets/vendor/fullcalendar/core/main.js') }}'></script>
<script src='{{ asset('assets/vendor/fullcalendar/daygrid/main.js') }}'></script>
<script src='{{ asset('assets/vendor/fullcalendar/timegrid/main.js') }}'></script>
<script src='{{ asset('assets/vendor/fullcalendar/list/main.js') }}'></script>

<!-- SweetAlert JavaScript -->
<script src="{{ asset('assets/js/sweetalert.js') }}"></script>

<!-- Vectoe Map JavaScript -->
<script src="{{ asset('assets/js/vector-map-custom.js') }}"></script>

<!-- Chart Custom JavaScript -->
<script src="{{ asset('assets/js/customizer.js') }}"></script>

<!-- Chart Custom JavaScript -->
<script src="{{ asset('assets/js/chart-custom.js') }}"></script>

<!-- slider JavaScript -->
<script src="{{ asset('assets/js/slider.js') }}"></script>

<!-- app JavaScript -->
<script src="{{ asset('assets/js/app.js') }}"></script>
</body>
</html>
