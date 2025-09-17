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
                        {{-- <h1 class="font4"> <b> Lets Get Going </b> </h1>
                        <h4 class="font5" style=""> Help Us Get To Know You Better </h4> --}}
                        <h1 class="mt-4" style="font-size: clamp(2rem, 2.5vw,2.5rem)"><b>{{__('verifyOtp.mob')}} </b></h1>
                        <input type="text" placeholder={{__('verifyOtp.PhoneNumber')}} name="mobilenumber" id="mobilenumber"
                            style="background: none; height: 70px; width: auto; min-width: 240px; max-width: 100%;"
                            pattern="[6-9][0-9]{9}" class="required" data-bind="number">


                        <div class="row">
                            <div class="col-6 col-md-4">
                                <button type="submit" name="verify_otp" id="verify_otp" class="btn text-center"
                                    style="width:150px;height:50px;background:#1476A1;margin-top:-5px; color: #fff; border-radius: 10px;">
                                    <strong>{{__('verifyOtp.Verify')}} </strong> </button>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-5 px-0 d-block d-sm-none">
                        <div class="card border-0">
                            <img src="{{ asset('assets/img/web/q1.png') }}" class="card-img-top rounded-0" alt="...">
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="verify-otp" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-body">

                                {{-- @dd(session('locale')); --}}

                                <form
                                    action="{{ route('verifyMobileOTP', ['locale' => app()->getLocale()]) }}"
                                    method="post">
                                    {{-- <form action="{{ route('verifyMobileOTP') }}" method="post"> --}}
                            
                                    @csrf
                                    <input type="hidden" name="mobile-no" id="mobile-no">
                                    <input type="hidden" name="name-vn" id="name-vn" value="<?php echo $vnname; ?>">
                                    <input type="hidden" name="vn" value="{{ !empty($vn) ? $vn : '' }}">

                                    <div class="form-group">
                                        <h5 class="modal-title">{{__('verifyOtp.verifymn')}} </h5>
                                        <h6 class="mt-1" for="otp">{{__('verifyOtp.otp')}} </h6>
                                        <small>{{__('verifyOtp.sentotp')}} </small><br>
                                        <small>{{__('verifyOtp.sentotp2')}} </small>
                                        <small for="otp" id="otp-small-text" class="form-text text-muted"></small>
                                        <input type="text" class="form-control" name="otp" id="otp"
                                            style="background:none" placeholder={{ __('verifyOtp.placeholder') }} required>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-success float-right" style="background:#1476A1;" value={{__('verifyOtp.Verify')}} >
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!--container-->
            </div>
            <!--banner-caption-->
    </section>
    <!--landing-sec-1-->
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('verify_otp').addEventListener('click', function(event) {
                var mobilenumber = document.getElementById('mobilenumber').value;

                if (mobilenumber === '' || mobilenumber.length !== 10 || !/^[6-9]\d{9}$/.test(
                        mobilenumber)) {
                    alert('Please enter a valid 10-digit mobile number.');
                } else {
                    document.getElementById('mobile-no').value = mobilenumber;
                    $('#verify-otp').modal('show');

                    fetch('{{ url('sendOTP') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                mobile_number: mobilenumber
                            })
                        })
                        .then(response => response.json());

                    event.preventDefault();
                }
            });
        });
    </script>
@endpush
