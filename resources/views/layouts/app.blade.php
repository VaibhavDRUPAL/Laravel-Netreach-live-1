<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="{{ asset('assets/fonts/stylesheet.css') }}">
    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/nucleo/css/nucleo.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}"
        type="text/css">
    <!-- Page plugins -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fullcalendar/dist/fullcalendar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/sweetalert2/dist/sweetalert2.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-select.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-confirm.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}" type="text/css">

    {{-- GOOGLE ANALYTICS --}}
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ env('GOOGLE_MEASUREMENT_ID') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', '{{ env('GOOGLE_MEASUREMENT_ID') }}');
    </script>

    <style>
        .topfooter .footer-disclaimer {
            display: none;
        }

        .chcek_box_valid {
            border: 1px solid red;
        }


        .font1 {
            color: #1E57BE !important;
        }


        .font2 {
            color: #726b6b !important;
        }

        .font3 {
            color: black !important;
            font-style: bold !important
        }

        .right1 {
            text-align: right;
        }

        .btn1 {
            background-color: #00A79D !important;
        }

        /*  Social Media CSS Start  */

        .float1 {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 30px;
            right: 20px;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            z-index: 100;
        }


        .float2 {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 80px;
            right: 20px;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            z-index: 100;
        }


        .float3 {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 130px;
            right: 20px;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            z-index: 100;
        }


        .my-float {
            margin-top: 16px;
        }


        /*Social Media CSS End*/
    </style>

    @stack('styles')

</head>

<body>


    @include('includes.navbar')
    <div class="main-content" id="panel">
        @include('includes.header')
        @include('includes.page-header')
        <div class="container-fluid mt--6">
            @yield('content')
        </div>
        <script src="{{ asset('assets/vendor/jquery/dist/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/js-cookie/js.cookie.js') }}"></script>
        <script src="{{ asset('assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') }}"></script>

        <script src="{{ asset('assets/js/bootstrap-select.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery-confirm.min.js') }}"></script>
        <script src="{{ asset('assets/js/dashboard.js') }}"></script>
        <script src="{{ asset('assets/js/chart/Chart.bundle.min.js') }}"></script>

        <script>
            function debounce(func, timeout = 300) {
                let timer;
                return (...args) => {
                    clearTimeout(timer);
                    console.log(args);
                    timer = setTimeout(() => {
                        func.apply(this, args);
                    }, timeout);
                };
            }
            // use this function to control the enable/disable state of optional fields
            const changeEventRegister = {};

            function updateOptionalEnablement(dependentFieldId, optionalFieldId, enableVal, defaultVal) {
                if ($(`#${dependentFieldId}`).val() == enableVal) {
                    $(`#${optionalFieldId}`).prop("disabled", false);
                } else {
                    $(`#${optionalFieldId}`).val(defaultVal);
                    $(`#${optionalFieldId}`).prop("disabled", true);
                }
                $('.selectpicker').selectpicker('refresh');
                if (changeEventRegister[`${dependentFieldId}_${optionalFieldId}`])
                    return;
                $(`#${dependentFieldId}`).on('change', () => updateOptionalEnablement(dependentFieldId, optionalFieldId,
                    enableVal));
                changeEventRegister[`${dependentFieldId}_${optionalFieldId}`] = true;
            }
        </script>
        @stack('scripts')

        @stack('modal')
</body>

</html>
