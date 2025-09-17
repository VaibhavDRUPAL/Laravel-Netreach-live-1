@extends('layouts.apphome')
@section('content')

<style>
  .bgcard {
    background-color: #F2FBFF;
  }

  .font3 {
    font-size: 1rem;
    ;
  }


  .bgcard:hover {
    background-color: #D7F3FF;

  }


  @media (max-width: 768px) {
    .otp-pop .banerform {
      width: 400px;
    }


    .otp-pop .banerform ul li input[type="text"] {
      width: 300px;
      margin-bottom: 8px;
    }
  }
</style>
<section class="landing-sec-1 landing-page7-sec-1">
  @foreach ($errors->all() as $error)
  <div>{{ $error }}</div>
  @endforeach
  <img src="{{asset('assets/img/web/bg_blank.png')}}" class="main-banner">
  <div class="banner-caption">
    <div class="container">
      <!-- {{ Form::open(array('url' => '/user-register')) }} -->
      <div class="row mt-4">
        <div class="col-md-1 col-xs-12">
        </div>
        <div class="col-md-4 col-xs-12 clientPage">
          <h4 style="color:#1476A1;"><b>Share Your Information</b></h4>
          <div class="banerform border-0 shadow-none">

            <ul style="padding: 12px !important;">
              <li>
                <div class="bh-err"></div>
              </li>
              <li class="span-2bx" style="display:none;">
                <span>
                  <input type="radio" name="user" value="1" checked onclick="return returning('new');"><label>New/Followup</label>
                  <!-- <input type="radio" value="3" name="hiv_test" checked> <label>New/Returning User</label></span> -->
                </span>
                <!-- <span>
                  <input type="radio"  name="user"  value="2" onclick="return returning('anonymous');"><label>Anonymous</label> -->
                <!-- <input type="radio" value="4" name="hiv_test" > <label>Acrimonious User</label></span> 
                  -->
                <!-- </span> -->
              </li>
              <li><i class="fa fa-user icon font-icon"></i>
                <input type="text" value="" placeholder="NAME*" name="name" id="name" class="required" data-bind="characterwithspace">
              </li>
              <li class="user_hide"><i class="fa fa-phone" aria-hidden="true"></i><input type="text" maxlength="10" value="" placeholder="MOBILE NUMBER*" name="phone_number" id="phone_number" class="required" data-bind="mobilenumber" onblur="return getExistClientInfo('mobile');"></li>
              <li>
                <div class="bh-email-err"></div>
              </li>
              <li class="user_hide"><i class="fa fa-envelope icon font-icon"></i><input type="text" value="" placeholder="EMAIL ID" name="email" id="email" class="" data-bind="emailnew" onblur="return getExistClientInfo('email');"></li>

              <li class="font-weight-bold">Have you been referred for an HIV test before, by any CBO or NGO?<span>*</span></li>
              <li class="span-2bx mt-3">
                <div class="row">
                  <label for="1" class="mb-0">
                    <div class="card-body bgcard py-2 mr-4">
                      <input type="radio" id="1" value="1" name="hiv_test">
                      <h5 class="font3" style="display:inline;"><b>Yes</b> </h5>
                    </div>
                  </label>
                  <label for="2" class="mb-0">
                    <div class="card-body bgcard py-2">
                      <input type="radio" id="2" value="2" name="hiv_test" checked>
                      <h5 class="font3" style="display:inline;"> <b>No</b> </h5>
                    </div>
                  </label>
                </div>
              </li>
            </ul>
            <a href="javascript:void(0);" id="submit" style="background-color:#00A79D;border-color:#00A79D" class="btn btn-primary btn-lg mb-5">
              <h4 style="display: inline;"><b>Lets Go </b>&nbsp; <img src="{{asset('assets/img/web/arrow.png')}}" style="width:40px"> </h4>
            </a>

          </div>
          <!--banerform-->
          <!--<button class="backbtn dore">Back</button>-->
          <!-- <button class="go-aheadbtn dore" type="submit" id="submit">Go Ahead</button> -->

        </div>
        <!--col-md-4-->
        <!-- mobile otp -->
        <div class="otp-pop" style="display: none;">
          <div class="overlay-pop"></div>
          <div class="banerform">
            <div class="modal-header border-0">
              <h5 class="modal-title">&nbsp;</h5>

              <span aria-hidden="true" style="cursor: pointer;font-weight:800" onClick="window.location.href=window.location.href" style="font-size: 30px;">&#x2715</span>

            </div>
            <h5 class="px-4 pt-3">Enter 4 digit verification code send sent to your number</h5>
            <ul style="display: block;">
              <li class="user_hide">
                <i class="fa fa-phone" aria-hidden="true"></i>
                <input type="text" placeholder="OTP*" name="otp" id="otp" class="required"><br>
                <!--   <div>Time left = <span id="timer"></span></div> -->
                <button class="go-aheadbtn dore resendOTP" type="button" id="resendOtp">Resend OTP</button>
              </li>
              <button class="btn btn-sm btn-warning text-dark" style="background-color: #FFD325;" type="button" id="otpSubmit">Verify OTP &nbsp;&nbsp;</button>
            </ul>
          </div>
        </div>
        <!-- email otp -->
        <div class="otp-popth" style="display: none;">
          <!--<div class="overlay-pop"></div>-->
          <div class="banerform">
            <!-- <h2 class="heading2">OTP Information</h2> -->
            <ul class="social-login">
              <li><a href="#" class="facebookbg"><i class="fab fa-facebook-f"></i> Log in with Facebook</a></li>
              <li><a href="#" class="google-plus"><i class="fab fa-google-plus-g"></i> Log in with Google</a></li>
              <!--<li><a href="#" class="twitter"><i class="fab fa-twitter"></i> Log in with Twitter</a></li>  -->
            </ul>
          </div>
        </div>
        <div class="col-md-1 col-xs-12">
        </div>
        <div class="col-md-6 col-xs-12 text-right">
          <img src="{{asset('assets/img/web/client_info.png')}}">
        </div>
      </div>
      <!--row-->
      {{ Form::close() }}
    </div>
    <!--container-->
  </div>
  <!--banner-caption-->
</section>
<!--landing-sec-1-->
@endsection
@push('scripts')
<script>
  $(document).ready(function() {
    $(document).prop('title','Client Information|NETREACH');
    $('#submit').click(function() {
      //alert("ff");
      var mesg = {};
      if (hiv.validate(mesg)) {

        var user = $("#user").val();


        var name = $("#name").val();

        var phone_number = $("#phone_number").val();
        var email = $("#email").val();
        $.ajax({
          url: '{{route("varify-otp")}}',
          type: 'POST',
          dataType: "json",
          data: {
            "_token": "{{ csrf_token() }}",
            "user": user,
            "name": name,
            "phone_number": phone_number,
            "email": email
          },
          success: function(result) {

            if (result.statusCode == 200) {


              $(".otp-pop").css('display', 'block');

              // timer(30);

            } else {
              alert("something wrong... please try later");
            }
          }
        });

        return true;
      }
      return false;
    });



    let timerOn = true;

    function timer(remaining) {
      var m = Math.floor(remaining / 60);
      var s = remaining % 60;

      m = m < 10 ? '0' + m : m;
      s = s < 10 ? '0' + s : s;
      document.getElementById('timer').innerHTML = m + ':' + s;
      remaining -= 1;

      if (remaining >= 0 && timerOn) {
        setTimeout(function() {
          timer(remaining);
        }, 1000);
        return;
      }

      if (!timerOn) {

        return;
      } else {

        alert('Timeout for otp');
        $(".resendOTP").show();


      }
    }

    $('#resendOtp').click(function() {


      $.ajax({
        url: '{{route("resend-otp")}}',
        type: 'POST',
        dataType: "json",
        data: {
          "_token": "{{ csrf_token() }}"
        },
        success: function(result) {

          if (result.statusCode == 200) {

            // timer(30);

          } else {
            alert("something wrong... please try later");
          }
        }
      });

      return true;
    });

    $("#otpSubmit").click(function() {
      var otp = $("#otp").val();

      if (otp == '') {
        alert("Pls enter OTP");
      } else {

        $.ajax({
          url: '{{route("user_register")}}',
          type: 'POST',
          dataType: "json",
          data: {
            "_token": "{{ csrf_token() }}",
            "otp": otp,
            "user": 1
          },
          success: function(otpResult) {

            //console.log(otpResult);
            if (otpResult.statusCode == 200) {

              window.location.href = "{{ route('services-required')}}";

            } else {
              alert("otp not match. Please try again");
            }
          }
        });

      }


    });

  });

  function returning(usr_type) {

    if (usr_type == "new") {
      $(".user_hide").show();
    } else if (usr_type == "anonymous") {
      $(".user_hide").hide();
    }

  }

  function getExistClientInfo(type) {

    if (type == "mobile")
      var ph = $("input[name=phone_number]").val();
    else
      var ph = $("input[name=email]").val();

    if (ph != '') {

      $.ajax({
        type: "POST",
        url: "{{ route('usr.exist')}}",
        dataType: "json",
        data: {
          "_token": "{{ csrf_token() }}",
          "type": type,
          "ph_email": ph
        },
        success: function(data) {
          //console.log(data);
          if (data.results == "exist" && data.result_find == "email")
            $('.bh-email-err').html('Email ID already present in our database');
          else if (data.results == "exist" && data.result_find == "mobile")
            $('.bh-err').html('Welcome,you are already registered . Please continue');
          else
            $('.bh-err,.bh-email-err').html('');

        }
      });
      //alert(type);
    }
  }
</script>
<script src="{{asset('assets/js/popper.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
<script>
  $(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>
@endpush