@extends('layouts.apphome')

@section('content')

<style>
    input[type="checkbox"] {
        appearance: none;
        border: 1px solid skyblue;
        width: 20px;
        height: 20px;
        content: none;
        outline: none;
        margin: 0;
        border-radius: 3px;
        border-width: 2px;
        box-shadow: rgba(0, 0, 0, 0.10) 0px 3px 8px;

    }

    input[type="checkbox"]:checked {
        appearance: none;
        outline: none;
        padding: 0;
        content: none;
        border: none;
    }

    input[type="checkbox"]:checked::before {
        position: absolute;
        color: green !important;
        content: "\00A0\2713\00A0" !important;
        border: 1px solid skyblue;
        font-weight: bolder;
        font-size: 13px;
        width: 20px;
        height: 20px;
        border-radius: 3px;
        border-width: 3px;
    }

    .bgcard {
        background-color: #F2FBFF;
    }

    .font3 {
        font-size: 1rem;

    }


    .bgcard:hover {
        background-color: #D7F3FF;

    }
    .tt_icon{
        position: absolute;
        right: 10px;
        bottom: 10px;

    }
</style>

<section class="landing-sec-1">
    <img src="{{asset('assets/img/web/bg_blank.png')}}" class="main-banner">
    <div class="banner-caption">
        <div class="container">
            <div class="row">
                <div class="col-md-1"> </div>
                <div class="col-md-6">
                    <div class="ab-mid-section">
                        <div class="container">
                            {{ Form::open(array('url' => '/services_required_submit')) }}

                            <h1 class="heading4 text-info">&nbsp;&nbsp; Services Required</h1>
                            <div class="space-10"></div>

                            <div class="col-12 col-md-8">
                                <div class="card border-0 mb-2">
                                    <label for="hiv" class="mb-0" title="An HIV test is a medical procedure to detect the presence of the human immunodeficiency virus in a person's bloodstream.">
                                        <div class="card-body bgcard py-2">
                                            <input id="hiv" type="checkbox" name="services[]" value="1">&nbsp;&nbsp;
                                             <h5 class="font3" style="display:inline"> &nbsp; &nbsp;<b>HIV Test</b> </h5> 
                                             <span class="tt tt_icon" data-bs-placement="top"><i class="fa-solid fa-circle-info"></i></span> <br>
                                             
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div class="col-12 col-md-8">
                                <div class="card border-0 mb-2">
                                    <label for="sti" class="mb-0" title="STI services refer to healthcare offerings related to the prevention, diagnosis, and treatment of sexually transmitted infections.">
                                        <div class="card-body bgcard py-2">
                                            <input id="sti" type="checkbox" name="services[]" value="2">
                                            <h5 class="font3" style="display:inline" > &nbsp; &nbsp;<b>STI Services</b> </h5>
                                            <span class="tt tt_icon" data-bs-placement="top"><i class="fa-solid fa-circle-info"></i></span> <br>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div class="col-12 col-md-8">
                                <div class="card border-0 mb-2">
                                    <label for="pre" class="mb-0" title="Pre-Exposure Prophylaxis is a medication taken by individuals at high risk of HIV infection to reduce the likelihood of contracting the HIV virus. This should be taken under Doctors supervision only.">
                                        <div class="card-body bgcard py-2">
                                            <input id="pre" type="checkbox" name="services[]" value="3">
                                            <h5 class="font3" style="display:inline"> &nbsp; &nbsp;<b>Pre-Exposure Prophylaxis (PrEP)</b> </h5> 
                                            <span class="tt tt_icon" data-bs-placement="top" ><i class="fa-solid fa-circle-info"></i></span><br>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div class="col-12 col-md-8">
                                <div class="card border-0 mb-2">
                                    <label for="counselling" class="mb-0" title="Counselling is a therapeutic process where a counsellor provides guidance and support to help individuals address emotional issues and common concerns such as Depression, Anxiety etc. In HIV related counseling, the counselor provides information regarding the HIV transmission/prevention, assesses the risk of the client and offers risk reduction counseling to the clients.">
                                        <div class="card-body bgcard py-2">
                                            <input id="counselling" type="checkbox" name="services[]" value="5">
                                            <h5 class="font3" style="display:inline"> &nbsp; &nbsp;<b>Counselling</b> </h5>
                                            <span class="tt tt_icon" data-bs-placement="top" ><i class="fa-solid fa-circle-info"></i></span> <br>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div class="col-12 col-md-8">
                                <div class="card border-0 mb-2">
                                    <label for="referral" class="mb-0" title="Referral to TI and CBO/NGO Services involves directing individuals to services provided by Targeted Interventions (TI) and Community-Based Organisations (CBO) or Non-Governmental Organisations (NGO) for additional support in addressing health and social needs.">
                                        <div class="card-body bgcard py-2">
                                            <input id="referral" type="checkbox" name="services[]" value="6">
                                            <h5 class="font3" style="display:inline"> &nbsp; &nbsp;<b>Referral to TI / CBO / NGO services</b> </h5>
                                            <span class="tt tt_icon" data-bs-placement="top" ><i class="fa-solid fa-circle-info"></i></span> <br>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div class="col-12 col-md-8">
                                <div class="card border-0 mb-2">
                                    <label for="art" class="mb-0" title="Art linkage is the process of connecting individuals who test positive for HIV to Antiretroviral Therapy (ART) for the management of the virus and related health services.">
                                        <div class="card-body bgcard py-2">
                                            <input id="art" type="checkbox" name="services[]" value="7">
                                            <h5 class="font3" style="display:inline"> &nbsp; &nbsp;<b>ART Linkages</b> </h5>
                                            <span class="tt tt_icon" data-bs-placement="top" ><i class="fa-solid fa-circle-info"></i></span> <br>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div id="services_required_err"></div>
                            </p>
                           
                            <!--<button class="backbtn">Back</button>-->
                            <!-- <button class="go-aheadbtn" type="submit" id="submit">Go  Ahead</button>        							 -->
                            <div class="col-12 col-md-8">
                                <button type="submit" class="btn btn-primary btn-lg mb-5" style="background-color:#00A79D;border-color:#00A79D;height:50px;text-transform: none;" value="" id="submit"><b>&nbsp;&nbsp;Lets Go </b><img src="{{asset('assets/img/web/arrow.png')}}" style="width:40px;margin-left:10px"></button>
                            </div>





                            {{ Form::close() }}
                        </div><!-- ab-mid-left -->

                    </div><!-- ab-mid-section -->
                </div><!-- col-7 -->
                <div class="col-md-5 text-right">
                    <img src="{{asset('assets/img/web/services_required.png')}}">
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

@push('scripts')
<!-- icon script from font_awesome website -->
<script src="https://kit.fontawesome.com/64cd45b3e2.js" crossorigin="anonymous"></script>
<script>


    $(document).ready(function() {
        $(document).prop('title','Services Required|NETREACH');
        $('#submit').click(function() {
            //alert("ff");
            var mesg = {};
            if (hiv.validate(mesg)) {
                return true;
            }
            return false;
        });
    });
</script>
<script src="{{asset('assets/js/popper.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });


    //for tooltip by yash
    const tooltip = document.querySelectorAll('tt')
    tooltip.forEach(t => {
        new bootstrap.Tooltip(t);
    })
</script>

@endpush