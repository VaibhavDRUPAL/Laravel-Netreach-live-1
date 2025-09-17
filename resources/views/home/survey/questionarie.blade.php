@extends('layouts.apphome')

@section('content')


    <style>
        @media (max-width: 768px) {
            .w-sm-100 {
                width: 100% !important;
            }
        }
    </style>
    <section class="landing-sec-1">
        <img src="{{ asset('assets/img/web/bg_two.jpeg') }}" class="main-banner d-none d-sm-block">
        <div class="banner-caption">
            <div class="container">
                <div class="row">

                    <div class="col-lg-1"> </div>
                    <div class="col-md-5 mb-5">
                        <h1 class="font4"> <b> Lets Get Going </b> </h1>
                        <h4 class="font5" style=""> Help Us Get To Know You Better Question Part</h4>


                        @csrf

                        @if (!empty($vn) || old('vn'))
                            <input type="hidden" name="vn" value="{{ old('vn') ? old('vn') : $vn }}">
                        @endif

                        @if ($questionnaire->isNotEmpty())
                            @php
                                $questionNumber = 1;
                            @endphp

                            @foreach ($questionnaire as $sectionIndex => $section)
                                {{ $section->question_slug }}

                                <input value="{{ $stateDetails->state_name ?? 'Unknown' }}" readonly class="form-control" />
                            @endforeach
                        @else
                            <p>No questions available.</p>
                        @endif
                    </div>


                    <div class="col-md-5 px-0 d-block d-sm-none">
                        <div class="card border-0">
                            <img src="{{ asset('assets/img/web/q1.png') }}" class="card-img-top rounded-0" alt="...">
                        </div>
                    </div>
                </div>
                <!--row-->


            </div>
            <!--container-->
        </div>
        <!--banner-caption-->
    </section>
    <!--landing-sec-1-->

@endsection
