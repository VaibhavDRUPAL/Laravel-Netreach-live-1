@extends('layouts.apphome')
@push('styles')
<style>
    .font7 {
        color: black;
    }

    .column {
        display: inline-block
    }

     
</style>

@endpush
@section('content')
<section class="landing-sec-1 mt-5">
    <img src="{{asset('assets/img/web/bg_blank.png')}}" class="main-banner">
    <div class="banner-caption">
        <div class="container">
            <div class="row">
                @if (!isset($isFromSRA))
                    <div class="col-md-6 mb-4">
                        <h1 class="heading5 text-center" style="color:#1476A1;">Assessment Complete</h1>

                        <div class="card-deck">
                            <div class="card border-info mt-5" style="box-shadow: 10px 10px 0rem rgba(2,2,78,1);">
                                <div class="card-body">
                                    @if(Session::get('risk_leavel')=="High Risk")
                                    <img class="risk-image img-fluid mt-3" src="{{asset('assets/img/web/hight-ristk.png')}}">
                                    @elseif(Session::get('risk_leavel')=="Medium Risk")
                                    <img class="risk-image img-fluid mt-3" src="{{asset('assets/img/web/medium-risk.png')}}">
                                    @elseif(Session::get('risk_leavel')=="May be Low Risk")
                                    <img class="risk-image img-fluid mt-3" src="{{asset('assets/img/web/low-risk.png')}}">
                                    @endif

                                    <p class="risk-level mt-2 text-center" style="color: #02024E;">Risk Level:<span class="high">
                                            @if(Session::has('risk_leavel'))
                                            {{ str_replace("RISK","",strtoupper(Session::get('risk_leavel')))}}
                                            @endif
                                        </span></p>
                                </div>
                            </div>

                            <div class="card border-info mt-5" style="box-shadow: 10px 10px 0rem rgba(2,2,78,1);">
                                <div class=" card-body">
                                    @if(Session::get('risk_leavel')=="High Risk")
                                    <p class="font7" style="font-size: 20px; text-align: start;">No worries, help is right around the corner.
                                        Book an Appointment to know your options. </p>
                                    @elseif(Session::get('risk_leavel')=="Medium Risk")
                                    <p class="font7" style="font-size: 20px; text-align: start;">No worries, help is right around the corner.<br><br>Book an appointment to
                                        know your options</p>
                                    @elseif(Session::get('risk_leavel')=="May be Low Risk")
                                    <p class="font7" style="font-size: 20px;text-align: start;">Please continue to stay safe and in case of any incident of unsafe sex
                                        please get tested and know your status.<br> <br>
                                        Click below for an appointment for HIV test. </p>
                                    @endif

                                    <a href="{{URL::to('/client-information')}}" class="btn btn-primary btn-block mt-3" style="background-color: #00A79D;border-color: #00A79D;">Book an Appointment</a>
                                </div>
                            </div>

                        </div>

                        <div class="space-10"></div>

                        <!-- <div class="container">
                        <p class="font7">Use the NETREACH Referral Code to make it easier to book an appointment with the nearest centre.
                        </p>
                        <div class="space-20"></div>
                        <p class="font7" style="font-weight: 600;">HIV tests are Free of Cost at all Integrated Counselling and Testing Centre (ICTC) HIV tests can
                            be done <b>Free of Cost</b> at any government run ICTC centre.. </p>
                        <div class="space-20"></div>
                        <p class="font7">Our private lab partners across India offer discounted rates, confidentiality and in most cases
                            home collection is also an option.</p>
                        </div> -->
                    </div>
                @else
                    <div class="col-md-12">
                        <div @class(['alert', 'text-center', 'alert-primary' => $score < 20, 'alert-info' => $score >= 20 && $score < 40, 'alert-warning' => $score >= 40  && $score < 60, 'alert-danger' => ($score >= 60 && $score < 80) || $score >= 80 ]) role="alert">
                            @if ($score < 20)
                                You are at low possible risk.
                            @elseif($score >= 20 && $score < 40)
                                You are at moderate risk.
                            @elseif($score >= 40  && $score < 60)
                                You are at risk.
                            @elseif($score >= 60 && $score < 80)
                                You are at high risk.
                            @elseif($score >= 80)
                                You are at very high risk.
                            @endif
                        </div>
                        <p class="text-center bolder">Assessment complete</p>
                    </div>
                @endif


                <div @class(['d-none d-sm-block', 'col-md-6' => !isset($isFromSRA) , 'col-md-12' => isset($isFromSRA)])>
                    <div class="container text-center">
                        <h1 class="heading5">Speak With Our Counsellors </h1>

                        <div class="row text-center">
                            <div @class(['col-lg-4' => isset($isFromSRA), 'col-lg-3' => !isset($isFromSRA), 'col-6']) style="min-height: 350px;">
                                <img src="{{asset('assets/img/web/Meet_Counsellors_1.png')}}">
                                <h5 class=""><b>PARSEEN </b></h5>
                                <a href="tel:8812853117">
                                    <h5 style="color:black">8812853117 </h5>
                                </a>
                                <h5> East Region <br> (Speaks English, Hindi, Assamese, Bengali)
                                </h5>
                            </div>

                            <div @class(['col-lg-4' => isset($isFromSRA), 'col-lg-3' => !isset($isFromSRA), 'col-6']) style="min-height: 350px;">
                                <img src="{{asset('assets/img/web/Meet_Counsellors_3.png')}}">
                                <h5 class=""><b>VED </b></h5>
                                <a href="tel:8248703556">
                                    <h5 style="color:black">8248703556 </h5>
                                </a>
                                <h5> South Region <br> (Speaks: English, Hindi, Tamil, Bengali)</h5>
                            </div>

                            <div @class(['col-lg-4' => isset($isFromSRA), 'col-lg-3' => !isset($isFromSRA), 'col-6']) style="min-height: 350px;">
                                <img src="{{asset('assets/img/web/Meet_Counsellors_5.png')}}" style="width: 225px">
                                <h5 class=""><b>RUPA </b></h5>
                                <a href="tel:8287219410">
                                    <h5 style="color:black">8287219410 </h5>
                                </a>
                                <h5> North Region <br> (Speaks: English, Hindi) </h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 d-block d-sm-none">
                    <div class="container">
                        <h1 class="heading5">Speak With Our Counsellors </h1>
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="media border-bottom pb-4">
                                    <img src="{{asset('assets/img/web/Meet_Counsellors_1.png')}}" class="mr-3 img-fluid" style="width:70px" alt="...">
                                    <div class="media-body">
                                        <h6 class="mt-0 mb-0 font-weight-bold">Parseen</h6>
                                        East Region (English, Hindi, Assamese, Bengali)
                                        <br /><b>8812853117</b>
                                        <div class="main-content">
                                            <div class="column" style="margin-left: -5px;">
                                                <img src="{{asset('assets/img/web/fbbk.png')}}" />
                                            </div>

                                            <div class="column">
                                                <img src="{{asset('assets/img/web/whatsappbk.png')}}" />
                                            </div>

                                            <div class="column">
                                                <img src="{{asset('assets/img/web/instabk.png')}}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="media border-bottom pb-3 pt-3">
                                    <img src="{{asset('assets/img/web/Meet_Counsellors_2.png')}}" class="mr-3 img-fluid" style="width:70px" alt="...">
                                    <div class="media-body">
                                        <h6 class="mt-0 mb-0 font-weight-bold">Anuckriti</h6>
                                        West Region (English, Hindi)
                                        <br /><b> 9326078990</b>
                                        <div class="main-content">
                                            <div class="column" style="margin-left: -5px;">
                                                <img src="{{asset('assets/img/web/fbbk.png')}}" />
                                            </div>

                                            <div class="column">
                                                <img src="{{asset('assets/img/web/whatsappbk.png')}}" />
                                            </div>

                                            <div class="column">
                                                <img src="{{asset('assets/img/web/instabk.png')}}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="media border-bottom pb-3 pt-3">
                                    <img src="{{asset('assets/img/web/Meet_Counsellors_3.png')}}" class="mr-3 img-fluid" style="width:70px" alt="...">
                                    <div class="media-body">
                                        <h6 class="mt-0 mb-0 font-weight-bold">Ved</h6>
                                        South Region (English, Hindi, Tamil, Bengali)
                                        <br /><b> 8248703556</b>
                                        <div class="main-content">
                                            <div class="column" style="margin-left: -5px;">
                                                <img src="{{asset('assets/img/web/fbbk.png')}}" />
                                            </div>

                                            <div class="column">
                                                <img src="{{asset('assets/img/web/whatsappbk.png')}}" />
                                            </div>

                                            <div class="column">
                                                <img src="{{asset('assets/img/web/instabk.png')}}" />
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="media pb-3 pt-3">
                                    <img src="{{asset('assets/img/web/Meet_Counsellors_5.png')}}" class="mr-3 img-fluid" style="width:70px" alt="...">
                                    <div class="media-body">
                                        <h6 class="mt-0 mb-0 font-weight-bold">Rupa</h6>
                                        North Region (Speaks: English, Hindi)
                                        <br /><b> 8287219410</b>
                                        <div class="main-content">
                                            <div class="column" style="margin-left: -5px;">
                                                <img src="{{asset('assets/img/web/fbbk.png')}}" />
                                            </div>

                                            <div class="column">
                                                <img src="{{asset('assets/img/web/whatsappbk.png')}}" />
                                            </div>

                                            <div class="column">
                                                <img src="{{asset('assets/img/web/instabk.png')}}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <p style="font-size: 20px;" class="mt-5">Use the NETREACH Referral Code to make it easier to book and appointment with your nearest centre.
                            HIV tests are Free of Cost at all Government run ICTC centers
                            Our Private Lab partners across India offer discounted rates, confidentiality, in most cases home collection is also an option.</p>


                    </div>
                </div>
            </div>
        </div>

    </div>
    <!--banner-caption-->
</section>
<!--landing-sec-1-->

@endsection

@push('scripts')
<script src="{{asset('assets/js/popper.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $(document).prop('title','Our Counsellors|NETREACH');
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endpush