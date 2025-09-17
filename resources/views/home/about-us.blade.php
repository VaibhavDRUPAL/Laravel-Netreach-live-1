@extends('layouts.apphome')

@section('content')
    <section class="landing-sec-1">
        <style>
            span {
                color: #1457A1
            }
        </style>
        {{-- <img src="{{ asset('assets/img/web/slider-bg.jpg') }}" class="main-banner"> --}}
        <div class="banner-caption">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h1 class="heading1">{{ __('aboutus.aboutus') }}</h1>
                        <p>
                            {{-- content --}}
                        <p><span style="color: rgb(7, 85, 120); font-family: Lato; font-size: 18px; text-align: justify;">
                                {{ __('aboutus.about_content') }}<br><br>
                                {{ __('aboutus.about_content2') }}
                            </span>

                    </div>
                    <div class="col-md-6">
                        <img src="{{ asset('assets/img/web/about2.png') }}" class="img-fluid" alt="Book Your Appointment">
                    </div>
                    <div class="m-3 mx-lg-3">

                        <span>
                            <h1 class="heading1">{{ __('aboutus.mission') }}</h1>
                            <span style="color: rgb(7, 85, 120); font-family: Lato; font-size: 18px; text-align: justify;">
                                {{ __('aboutus.mission_content') }}
                            </span></p>
                            {{-- content ends --}}

                    </div>
                </div><!--row-->
            </div><!--container-->
        </div><!--banner-caption-->
    </section><!--landing-sec-1-->
@endsection
