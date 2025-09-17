@extends('layouts.apphome')
@section('content')
<style>
    .font7 {
        color: black;
    }

    .column {
        display: inline-block;
    }

    .text-primary {
        color: #1476A1 !important;
    }
</style>

<section class="landing-sec-1">
    <img src="{{asset('assets/img/web/bg_blank.png')}}" class="main-banner">
    <div class="banner-caption">
        <div class="container mt-4 mb-4">
            <h3 class="text-center" style="font-weight: bold">
                {{__('team.Team')}}
            </h3>
            @include('includes.team')
        </div>
        <!--row-->
    </div>
    <!--container-->
    </div>
    <!--banner-caption-->
</section>
<!--landing-sec-1-->
@endsection
