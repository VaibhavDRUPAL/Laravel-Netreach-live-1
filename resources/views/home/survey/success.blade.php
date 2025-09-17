@extends('layouts.apphome')

@section('title')
    Self Risk Assessment Calculation
@endsection

@section('content')
    <div class="p-5 mt-xl-5 mt-5">
        <h2 class="text-center">
            {{__('surveyAppointment.Assessment Complete')}}
        </h2>
        <div class="row">
            <div class="col-12 col-sm-10 col-md-5 text-center mx-auto mt-3"
                style="border: 2px solid black; border-bottom-width: 7px; border-right-width: 7px; border-radius:10px">
                @if ($score < 20)
                    <img src="{{ asset('assets/img/sra/low.jpeg') }}" height="200px" />
                @elseif($score >= 20 && $score < 40)
                    <img src="{{ asset('assets/img/sra/medium.jpeg') }}" height="200px" />
                @elseif($score >= 40 && $score < 60)
                    <img src="{{ asset('assets/img/sra/high.jpeg') }}" height="200px" />
                @elseif($score >= 60 && $score < 80)
                    <img src="{{ asset('assets/img/sra/max.jpeg') }}" height="200px" />
                @elseif($score >= 80)
                    <img src="{{ asset('assets/img/sra/max.jpeg') }}" height="200px" />
                @endif
            </div>
            {{-- @php
                $param = [
                    'mobile' => Crypt::encryptString($mobileNo),
                    'assessment' => Crypt::encryptString($riskAssessmentID),
                    'state' => $stateID,
                ];
                if (!empty($vn)) $param['key'] = $vn;
            @endphp --}}
            <div class="col-12 col-sm-10 col-md-5 text-center mx-auto mt-3"
                style="border: 2px solid black; border-bottom-width: 7px; border-right-width: 7px; border-radius:10px">
                <p class="mt-5">
                    {{ __('surveyAppointment.quote') }}
                </p>
                <br />
                @php
                    $locale = app()->getlocale();
                    if ($locale && $locale!='en') {
                        $href = isset($isLanding) ? route('survey.book-appoinment',compact('locale')) : route('self.book-appointment');
                    } elseif($locale=='en') {
                        $href = isset($isLanding) ? url('/book-appoinment') : route('self.book-appointment');
                    } else {
                        $href = isset($isLanding) ? route('survey.book-appoinment') : route('self.book-appointment');
                    }
                @endphp
                <a href="{{ $href }}" role="button" class="btn mb-3" style="background:#1476A1; color:white ">
                    {{ __('surveyAppointment.Book an Appointment') }}
                </a>
            </div>
        </div>
        <h3 class="text-center my-5" style="font-weight: bold">
            {{ __('surveyAppointment.speak') }}
        </h3>
        @include('includes.team')
    </div>
@endsection
