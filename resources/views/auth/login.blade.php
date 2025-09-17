@extends('layouts.auth')

@section('content')
    <div class="header bg-gradient-primary py-5" style="padding-top:0 !important;">
        <div class="container">
            <div class="header-body text-center mb-9">
                <div class="row justify-content-center">
                    <div class="col-xl-6 col-lg-6 col-md-6 image-bg-content ">
                        <a href="{{ URL::to('/') }}"><img src="{{ asset('assets/img/web/logo.png') }}"></a>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 image-bg-content">
                        <a href="{{ URL::to('/') }}"><img src="{{ asset('assets/img/web/humsafar-logo.png') }}"
                                style="width: 125px"></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="separator separator-bottom separator-skew zindex-100">
            <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1"
                xmlns="http://www.w3.org/2000/svg">
                <polygon class="fill-white" points="2560 0 2560 100 0 100"></polygon>
            </svg>
        </div>
    </div>
    <div class="container mt--9 pb-5">
        <!-- Table -->
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-8">
                <div class="card bg-secondary border border-soft">
                    <div class="card-header px-lg-5 bg-transparent" style="padding:0;">
                        <h3 class="text-muted text-center my-2">Sign In</h3>
                        @include('flash::message')
                    </div>
                    <div class="card-body px-lg-5 py-lg-3 pt-2">
                        <form method="POST" action="{{ route('login') }}" id="frm-login">
                            @csrf
                            <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                    </div>
                                    <input id="email" type="text"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus
                                        placeholder="Email ID">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                    </div>
                                    <input id="password" type="password" value=""
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password" placeholder="Password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="g-recaptcha mb-4" data-sitekey="{{ env('G_SITE_KEY') }}" data-callback="enableBtn">
                            </div>
                            <input type="hidden" id="fcmToken" name="fcmToken" value="">
                            <div class="custom-control custom-control-alternative custom-checkbox">
                                <input class="custom-control-input" id=" customCheckLogin" name="remember"
                                    {{ old('remember') ? 'checked' : '' }} type="checkbox">
                                <label class="custom-control-label" for=" customCheckLogin">
                                    <span>Remember me</span>
                                </label>
                            </div>
                            <div class="text-left">
                                <button type="button" class="btn mt-4 loginbtn" id="loginbtn" disabled>Login</button>
                            </div>
                            <div class="modal fade" id="confirmation" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header btn-primary">
                                            <h5 class="modal-title text-white" id="analatical-title">Confidentiality</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span class="text-white" aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            I declare that the data I am provided access to and authorized by The Humsafar
                                            Trust, has not been breached by me and I have maintained the confidentiality of
                                            all Confidential Information in the past months. I shall comply with all
                                            provisions of HIV and AIDS Prevention and Control Act, 2017 and Data Management
                                            Guidelines.
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Disagree</button>
                                            <button type="submit" class="btn btn-primary">Agree</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footertopimg fixed-footer">
        <div class="midcontainer">
            <div class="footertop">
                <a href="javascript:void(0);" data-toggle="modal" data-target="#terms_of_use" title="Teams of Use">
                    Terms of Use</a> | <a href="javascript:void(0);" data-toggle="modal" data-target="#policy"
                    title="Privacy Policy - NETREACH Web Portal">Privacy Policy - NETREACH Web Portal</a> | <a
                    href="javascript:void(0);" data-toggle="modal" data-target="#copyright"
                    title="Copyright Policy">Copyright Policy</a>
            </div>

        </div>
    </div>
    <script src="https://www.gstatic.com/firebasejs/9.16.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.16.0/firebase-messaging-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.16.0/firebase-analytics-compat.js"></script>
    <script>
        // Your Firebase configuration object
        // const firebaseConfig = {
        //     apiKey: "{{ env('FIREBASE_API_KEY') }}",
        //     authDomain: "{{ env('FIREBASE_AUTH_DOMAIN') }}",
        //     projectId: "{{ env('FIREBASE_PROJECT_ID') }}",
        //     storageBucket: "{{ env('FIREBASE_STORAGE_BUCKET') }}",
        //     messagingSenderId: "{{ env('FIREBASE_MESSAGING_SENDER_ID') }}",
        //     appId: "{{ env('FIREBASE_APP_ID') }}",
        //     measurementId: "{{ env('FIREBASE_MEASUREMENT_ID') }}"
        // };

        // Initialize Firebase
        // firebase.initializeApp(firebaseConfig);

        // // Retrieve Firebase Messaging object
        // const messaging = firebase.messaging();

        // // Get FCM token
        // messaging.getToken({
        //     vapidKey: "{{ env('FIREBASE_VAPID_KEY') }}"
        // }).then((token) => {
        //     document.getElementById('fcmToken').value = token;
        // }).catch((error) => {
        //     console.error('Error getting FCM token', error);
        // });

        // Handle incoming messages
        // messaging.onMessage((payload) => {
        //     console.log('Message received. ', payload);
        //     const notificationOptions = {
        //         body: payload.notification.body,
        //         icon: payload.notification.icon
        //     };
        //     if (Notification.permission === 'granted') {
        //         new Notification(payload.notification.title, notificationOptions);
        //     }
        // });
        // // Register service worker
        // if ('serviceWorker' in navigator) {
        //     navigator.serviceWorker.register('/firebase-messaging-sw.js')
        //         .then((registration) => {
        //             console.log('ServiceWorker registration successful with scope: ', registration.scope);
        //         }).catch((err) => {
        //             console.log('ServiceWorker registration failed: ', err);
        //         });
        // }
    </script>
@endsection
@push('captcha')
    <script type="text/javascript">
        $(".btn-refresh").click(function() {
            $.ajax({
                type: 'GET',
                url: '/refresh_captcha',
                success: function(data) {
                    $(".captcha span").html(data.captcha);
                }
            });
        });
        $(function() {
            $('#loginbtn').on('click', function() {
                $.ajax({
                    url: 'loginVerify',
                    dataType: 'JSON',
                    data: {
                        email: $('#email').val()
                    },
                    success: function(data) {
                        if (data) $('#frm-login').trigger('submit');
                        else $('#confirmation').modal('show');
                    }
                })
            });
        });
    </script>
    <style>
        .footertopimg {
            height: 35px;
            float: left;
            background: #00749f85;
            width: 100%;
        }

        .footertop {
            width: auto;
            padding: 10px;
            font-family: open_sansbold;
            margin-bottom: 13px;
            color: #fff;
            font-size: 14px;
            text-align: center;
        }

        .footertop a {
            color: #fff;
            font-size: 13px;
            font-family: open_sansregular;
            margin: 0 10px;
        }

        .modal-dialog p {
            color: #6c757d;
            text-align: justify;
        }
    </style>


    <div class="modal fade" id="copyright" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Copyright Policy</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body text-secondary">
                    <p>
                        Material featured on this website may not be reproduced or distributed to unauthorised parties. The
                        material should not to be used in a derogatory manner or in a misleading context. Wherever the
                        material is being published or issued to others (with necessary permissions), the source must be
                        prominently acknowledged. However, the permission to reproduce this material shall not extend to any
                        material which is identified as being copyright of a third party. Authorisation to reproduce such
                        material must be obtained from the departments/copyright holders concerned.
                        These terms and conditions shall be governed by and construed in accordance with the Indian Laws.
                        Any dispute arising under these terms and conditions shall be subject to the exclusive jurisdiction
                        of the courts of India.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary mx-auto" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Terms of Use -->
    <div class="modal fade" id="terms_of_use" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Terms of Use</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body text-secondary">
                    <p>
                        This website is designed, developed and maintained by HST – NETREACH Project, the content is looked
                        and maintained by The Humsafar Trust (HST) – NETREACH Project. These terms and conditions shall be
                        governed by and construed in accordance with the Indian Laws. Any dispute arising under these terms
                        and conditions shall be subject to the jurisdiction of the courts of India. The information posted
                        on this website could include hypertext links or pointers to information created and maintained by
                        non-Government/private organizations. The website is providing these links and pointers solely for
                        your information and convenience. When you select a link to an outside website, you are leaving this
                        site and are subject to the privacy and security policies of the owners/sponsors of the outside
                        website.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary mx-auto" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Terms of Use -->
    <div class="modal fade" id="policy" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Privacy Policy - NETREACH Web Portal</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">X</button>
                </div>
                <div class="modal-body text-secondary">
                    <p>This is the Privacy Policy for web usage of NETREACH website</p>
                    <p>

                        The Humsafar Trust (HST) respects your privacy rights and cares about protecting your information
                        collected on our website applications. This website is hosted on GoDaddy Cloud, the content is
                        looked and maintained by HST – NETREACH project. These terms and conditions shall be governed by
                        extent regulations. Any dispute arising under these terms and conditions shall be subject to the
                        jurisdiction of the Government of India. The information posted on this website could include
                        hypertext links or pointers to information created and maintained by non-Government/private
                        organizations. The website is providing these links and pointers solely for your information and
                        convenience. When you select a link to an outside website, you are leaving this site and are subject
                        to the privacy and security policies of the owners/sponsors of the outside website.

                    </p>
                    <p>
                        <b>User Account & Personal Information</b><br />
                        Using the NETREACH web portal requires a user to be registered in the system. Certain personal
                        information and contact details such as username, mobile number, email address is required to log
                        into your account or retrieve forgotten account information and to protect your account from
                        unauthorised access.

                    </p>
                    <p>
                        <b>Emails & SMS</b><br />
                        By giving your email address and mobile number as registration details, you have consented to
                        receiving emails and SMS from NETREACH project. NETREACH will use your email address and mobile
                        number to send NETREACH related information and updates. We reserve the right to send you important
                        program related emails and SMS.

                    </p>

                    <p>
                        <b>Disclosure</b><br />
                        Your name and registration details shall remain confidential and will not be available to anybody
                        other than you, authorised website personnel and program implementation and evaluation teams.
                        Information on your usages, frequency of usage, progress on treatment or services referred within
                        the NETREACH program will be collected by the system and shall be used for analysis internally by
                        NETREACH. These data shall not be shared with any other third party except with authorised
                        authorities as per the extent regulations.
                    </p>

                    <p>
                        <b>Standard browser data collected</b><br />
                        For browsing of our website, NETREACH will collect regular server logs which include IP (Internet
                        Protocol) address, domain name, browser type, operating system, files you downloaded, pages you
                        visited, date and time stamps of your visit. We use Cookies to ease your navigation on our website.

                    </p>
                    <p>
                        <b>Security</b><br />
                        NETREACH uses industry standard Secured Socket Layer (SSL) protocol which provides data encryption,
                        message integrity and server authentication when your data is sent to it. A small lock you see next
                        to the NETREACH URL address bar on your browser window indicates that your data is being encrypted
                        for transmission.

                    </p>

                    <p>
                        <b>Changes to Privacy Policy</b><br />
                        In the event of any change to our privacy policy, it will be updated here. It is your obligation to
                        visit regularly and make yourself aware of any changes in the Policy and it will be deemed to be
                        notified and read by you on your using this website.

                    </p>

                    <p>
                        <b>Your Consent</b><br />
                        By using NETREACH website, you consent to our privacy policy.<br /><br />

                        If you have any questions or suggestions regarding our privacy policy, please contact us at
                        helpdesk[at]humsafar[dot]org

                    </p>
                    <p>
                        <b>The Humsafar Trust – NETREACH Project</b><br>
                        3rd Floor, Manthan Plaza,<br>
                        Nehru road, Vakola, <br>
                        Santacruz (East), <br>
                        Mumbai – 400055<br>
                        helpdesk[at]humsafar[dot]org

                    </p>
                    <p>
                        PUBLISHED DATE: 29 July 2022><br>
                        PUBLISHED BY: NETREACH><br>
                        LAST UPDATED ON: 29 July 2022

                    <p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary mx-auto" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endpush
