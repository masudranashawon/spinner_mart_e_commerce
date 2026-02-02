<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="wpOceans">
    <link rel="shortcut icon" type="image/png" href="assets/images/favicon.png">

    <title>
        @hasSection('title')
        @yield('title') | {{ config('app.name') }}
        @else
        {{ config('app.name') }}
        @endif
    </title>

    <link href="{{ asset('frontend/assets/css/themify-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/sass/style.css') }}" rel="stylesheet">

    @stack('style')
</head>

<body>

    <!-- start page-wrapper -->
    <div class="page-wrapper">
        <!-- start preloader -->
        <div class="preloader">
            <div class="vertical-centered-box">
                <div class="content">
                    <div class="loader-circle"></div>
                    <div class="loader-line-mask">
                        <div class="loader-line"></div>
                    </div>
                    <img src="{{ asset('frontend/assets/images/preloader.png') }}" alt="Loading...">
                </div>
            </div>
        </div>
        <!-- end preloader -->

        @yield('content')
    </div>
    <!-- end of page-wrapper -->

    <!-- All JavaScript files
    ================================================== -->
    <script src="{{ asset('frontend/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/jquery-plugin-collection.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/script.js') }}"></script>

    @stack('script')
</body>

</html>
