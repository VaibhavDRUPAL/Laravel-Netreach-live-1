@php
    $extend = $isLanding ? 'layouts.apphome' : 'self.layout.layout';
    $section = $isLanding ? 'content' : 'body';
@endphp

@extends($extend)

@section('title')
    Self Risk Assessment Appointment Booked
@endsection

@section($section)
    <div @class(['row' => !$isLanding, 'p-1 mt-xl-5' => $isLanding]) style="margin-top:100px">
        <div class="col-12 col-sm-7 mx-auto text-center mt-5">
            <h1 class="" style="font-weight: bold; color: #1476A1 !important">{{__('surveyAppointment.b1')}}</h1>
            <br />
            <p style="font-size:25px">
                {{__('surveyAppointment.b2')}}<br />
                {{__('surveyAppointment.b3')}}<br />
                {{__('surveyAppointment.b4')}}<br />
                
            </p>
            <div style="min-height: 40px;display:flex; justify-content: center;">
                <span class="my-5" style="font-weight:600;">
                    {{ $uid }}
                </span>
            </div>
           
            <div class="text-center">
                @isset($path)
                    @empty(!$path)
                        <a href="{{ Storage::disk('public')->url($path) }}" role="button" class="btn btn-lg" style="background-color: #1476A1; color: #fff;">
                            {{__('surveyAppointment.b5')}}
                        </a>
                    @endempty
                @endisset
            </div>
        </div>
    </div>
@endsection
