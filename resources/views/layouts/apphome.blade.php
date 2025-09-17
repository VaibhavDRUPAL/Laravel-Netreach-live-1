<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="robots" content="index, follow">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="og:image" content="{{ asset('assets/img/web/logo-bac.png') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @production
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=AW-11110592036"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config', 'AW-11110592036');
        </script>
        <!-- Event snippet for Website traffic conversion page -->
        <script>
            gtag('event', 'conversion', {
                'send_to': 'AW-11110592036/CVY_COiHtPMYEKTc-LEp'
            });
        </script>
        <script type="text/javascript">
            (function(c, l, a, r, i, t, y) {
                c[a] = c[a] || function() {
                    (c[a].q = c[a].q || []).push(arguments)
                };
                t = l.createElement(r);
                t.async = 1;
                t.src = "https://www.clarity.ms/tag/" + i;
                y = l.getElementsByTagName(r)[0];
                y.parentNode.insertBefore(t, y);
            })
            (window, document, "clarity", "script", "jo7067wsd0");
        </script>
        <script>
            (function(w, d, s, l, i) {
                w[l] = w[l] || [];
                w[l].push({
                    'gtm.start': new Date().getTime(),
                    event: 'gtm.js'
                });
                var f = d.getElementsByTagName(s)[0],
                    j = d.createElement(s),
                    dl = l != 'dataLayer' ? '&l=' + l : '';
                j.async = true;
                j.src =
                    'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
                f.parentNode.insertBefore(j, f);
            })(window, document, 'script', 'dataLayer', 'GTM-KW2BR43J');
        </script>
    @endproduction

    @stack('meta_data')

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" media="all" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" media="all" href="{{ asset('assets/css/all.min.css') }}">
    <link rel="stylesheet" media="all" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet"
        href="{{ App::isProduction() ? secure_asset('assets/css/chatbot.css') : asset('assets/css/chatbot.css') }}">
    <link rel="stylesheet"
        href="{{ App::isProduction() ? secure_asset('assets/css/custom.css') : asset('assets/css/custom.css') }}">

    <style>
        .topfooter .footer-disclaimer {
            display: none;
        }

        .chcek_box_valid {
            border: 1px solid red;
        }

        .font1 {
            color: #1E57BE !important;
        }

        .font2 {
            color: #726b6b !important;
            font-weight: 400
        }

        .font3 {
            color: !important;
            font-style: bold !important
        }

        .font4 {
            color: #1476A1 !important;
            font-style: bold !important
        }

        .font5 {
            font-weight: 650 !important;
            color: #1E57BE !important;
            font-style: bold !important
        }

        .font6 {
            color: #3f3e3e
        }

        .font7 {
            color: #3f3e3e !important;
            font-weight: normal !important;
        }

        .right1 {
            text-align: right;
        }

        .btn1 {
            background-color: #00A79D !important;
            text-transform: capitalize !important;
            padding: 20px 15px 20px 15px;
            color: white;
            border-radius: 0px !important;
            box-shadow: none !important;
        }

        .btn_letsgo {
            padding: 20px 55px 20px 100px;
            background-image: url("{{ asset('assets/img/web/letsgo.png') }}") !important;
            background-repeat: no-repeat;
            border: none;
        }

        .btn_next {
            padding: 20px 50px 20px 100px;
            background-color: #ADB1D4;
            background-image: url("{{ asset('assets/img/web/right_arrow.png') }}") !important;
            background-repeat: no-repeat;
            border: none;
            background-position: 30px center;
        }

        .btn_back {
            padding: 23px 15px 23px 30px !important;
            background-color: #C1E1FF !important;
            /*    background-image: url("{{ asset('assets/img/web/left_arrow.png') }}") !important;*/
            border: none !important;
            background-position: 30px center !important;
        }

        /*  Social Media CSS Start  */
        .float1 {
            position: fixed;
            width: 60px;
            height: 30px;
            bottom: 150px;
            right: 20px;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            z-index: 98;
        }

        .float2 {
            position: fixed;
            width: 60px;
            height: 30px;
            bottom: 200px;
            right: 20px;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            z-index: 98;
        }

        .float3 {
            position: fixed;
            width: 60px;
            height: 30px;
            bottom: 250px;
            right: 20px;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            z-index: 98;
        }

        .float4 {
            position: fixed;
            width: 60px;
            height: 30px;
            bottom: 100px;
            right: 25px;
            /* border-radius: 50px; */
            text-align: center;
            font-size: 30px;
            z-index: 98;
        }


        .my-float {
            margin-top: 16px;
        }

        .nav-bar-logo-mobile {
            display: none !important;
        }

        .nav-bar-logo-mobile,
        .footer-dial {
            display: flex;
            justify-content: flex-end;
            width: 100%;
        }

        .btn1:hover {
            color: white;
        }

        .footerDisclaimer {
            font-size: 12px !important;
        }

        @media screen and (max-width: 767px) {
            #nav-bar-logo-web {
                display: none !important;
            }

            .footerDisclaimer {
                font-size: 12px !important;
            }

            #netreach-logo {
                width: 40% !important;
            }

            .nav-bar-logo-mobile {
                display: flex !important;
            }

            .nav-bar-logo-mobile,
            .footer-dial {
                justify-content: space-around;
            }

            #consent img {
                opacity: 0.2;
            }
        }
    </style>
    @stack('styles')
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-220550387-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-220550387-1');
    </script>
    <!-- Meta Pixel Code -->
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '968178221229247');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
            src=https://www.facebook.com/tr?id=968178221229247&ev=PageView&noscript=1 /></noscript>
    <!-- End Meta Pixel Code -->
</head>

<body>
    @production
        <noscript>
            <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KW2BR43J" height="0" width="0"
                style="display:none;visibility:hidden"></iframe>
        </noscript>
    @endproduction
    @include('includes.chatbot')
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v16.0"
        nonce="WX8qimVq"></script>
    <a href="https://youtube.com/@netreachofficial" class="float1 d-none d-sm-block" target="_blank">
        <img src="{{ asset('assets/img/web/youtube.png') }}">
    </a>
    <a href="https://www.instagram.com/netreachofficial/" class="float2 d-none d-sm-block" target="_blank">
        <img src="{{ asset('assets/img/web/insta.png') }}">
    </a>
    <a href="https://m.facebook.com/NETREACHofficial/" class="float3 d-none d-sm-block" target="_blank">
        <img src="{{ asset('assets/img/web/fb.png') }}">
    </a>
    <a href="tel:1097" class="float4 d-none d-sm-block aids_icon" target="_blank">
        <img src="{{ asset('assets/img/web/NACO_helpline_new.png') }}">
    </a>

    <header class="header">
        <!-- <a class="d-block px-3 py-2 text-right text-bold old-bv" id="google_translate_element"></a> -->
        <div class="container-fluid">
            <div class="row align-items-center" style="padding-top: 10px;">
                <div class="col-md-2 d-flex  logo" id="nav-bar-logo-web">
                    <a class="mr-3" href="{{ URL::to('https://humsafar.org/') }}"><img
                            src="{{ asset('assets/img/web/humsafar-logo.png') }}" style="width: 125px"></a>
                    <a href="{{ URL::to('https://allianceindia.org/') }}"><img
                            src="{{ asset('assets/img/web/alliance-india.png') }}"></a>
                </div>
                <!--logo-->
                <div class="col-md-8 mt-3 navigation">
                    <div class="nav-icon" onclick="myFunction()" style="z-index: 99;"><i class="fas fa-bars"></i></div>
                    <div class="main-nav" id="opennav">
                        <!-- backnav -->
                        <div class="bgoverlay"></div>
                        <!-- bgoverlay -->
                        <ul>
                            <li><div class="backnav" onclick="myFunctiondel()"><i class="fas fa-chevron-left"></i></div></li>

                            @if (session('locale'))
                                @php
                                    $lang = session('locale');
                                @endphp
                            @else
                                @php
                                    $lang = app()->getLocale(); // Get the current locale
                                @endphp
                            @endif

                            <li><a
                                    href="{{ URL::to($lang !== 'en' ? '/' . $lang : '/') }}">{{ __('navbar.home') }}</a>
                            </li>
                            <li><a
                                    href="{{ URL::to($lang !== 'en' ? '/' . $lang . '/about-us' : '/about-us') }}">{{ __('navbar.about') }}</a>
                            </li>
                            <li><a
                                    href="{{ URL::to($lang !== 'en' ? '/' . $lang . '/faqs' : '/faqs') }}">{{ __('navbar.faqs') }}</a>
                            </li>
                            <li><a
                                    href="{{ URL::to($lang !== 'en' ? '/' . $lang . '/sra' : '/sra') }}">{{ __('navbar.risk') }}</a>
                            </li>
                            <li><a
                                    href="{{ URL::to($lang !== 'en' ? '/' . $lang . '/contact-us' : '/contact-us') }}">{{ __('navbar.contact') }}</a>
                            </li>
                            <li><a
                                    href="{{ URL::to($lang !== 'en' ? '/' . $lang . '/our-team' : '/our-team') }}">{{ __('navbar.team') }}</a>
                            </li>
                            <li><a
                                    href="{{ URL::to($lang !== 'en' ? '/' . $lang . '/blog' : '/blog') }}">{{ __('navbar.blog') }}</a>
                            </li>
                            {{-- <li>
                                <select class="form-control" id="language-select" onchange="changeLanguage(this)">
                                    <option value="en" {{ session('locale', 'en') == 'en' ? 'selected' : '' }}>
                                        English</option>
                                    <option value="hi" {{ session('locale') == 'hi' ? 'selected' : '' }}>Hindi
                                    </option>
                                    <option value="mr" {{ session('locale') == 'mr' ? 'selected' : '' }}>Marathi
                                    </option>
                                    <option value="ta" {{ session('locale') == 'ta' ? 'selected' : '' }}>Tamil
                                    </option>
                                    <option value="te" {{ session('locale') == 'te' ? 'selected' : '' }}>Telugu
                                    </option>
                                </select>
                            </li> --}}
                            <li id="google_translate_element"></li>


                            {{-- @if (session('locale'))
                                @php
                                    // $lang = session("locale");
                                    
                                @endphp
                            @else
                            @endif --}}
                            {{-- @php
                            $lang = app()->getLocale();
                            @endphp   --}}

                            {{-- @dd($lang,$lang=="en"); --}}
                            {{-- @if ($lang != 'en')
                            <li><a href="{{ URL::to('/'.$lang) }}">{{ __('navbar.home') }}</a></li>
                            <li><a href="{{ URL::to('/'.$lang.'/about-us') }}">{{ __('navbar.about') }}</a></li>
                            <li><a href="{{ URL::to('/'.$lang.'/faqs') }}">{{ __('navbar.faqs') }}</a></li>
                            <li><a href="{{ URL::to('/'.$lang.'/sra') }}">{{ __('navbar.risk') }}</a></li>
                            <li><a href="{{ URL::to('/'.$lang.'/contact-us') }}">{{ __('navbar.contact') }}</a></li>
                            <li><a href="{{ URL::to('/'.$lang.'/our-team') }}">{{ __('navbar.team') }}</a></li>
                            <li><a href="{{ URL::to('/'.$lang.'/blog') }}">{{ __('navbar.blog') }}</a></li>
                            <li id="google_translate_element"> </li>
                            @else
                            <li><a href="{{ URL::to('/') }}">{{ __('navbar.home') }}</a></li>
                            <li><a href="{{ URL::to('/about-us') }}">{{ __('navbar.about') }}</a></li>
                            <li><a href="{{ URL::to('/faqs') }}">{{ __('navbar.faqs') }}</a></li>
                            <li><a href="{{ URL::to('/sra') }}">{{ __('navbar.risk') }}</a></li>
                            <li><a href="{{ URL::to('/contact-us') }}">{{ __('navbar.contact') }}</a></li>
                            <li><a href="{{ URL::to('/our-team') }}">{{ __('navbar.team') }}</a></li>
                            <li><a href="{{ URL::to('/blog') }}">{{ __('navbar.blog') }}</a></li>
                            <li id="google_translate_element"> </li>
                            @endif --}}

                            <!-- <li><button id="clickMe">clickme</button></li> -->
                        </ul>
                    </div>
                    <!--nav-->
                </div>
                <!--navigation-->
                <div class="col-md-2">
                    <a href="{{ URL::to('/') }}" target="_blank">
                        <img class="ml-3" id="netreach-logo" src="{{ asset('assets/img/web/logo-bac.png') }}"
                            style="width:80%"></a>
                </div>
                <!--humsafar-logo-->
            </div>
            <!--row-->
        </div>
        <!--container-->
    </header>
    <!--header-->
    @yield('content')
    {{-- prajwal chatbot --}}

    @if (App::isProduction())
        <script>
            (function(w, d, s, o, f, js, fjs) {
                w["botsonic_widget"] = o;
                w[o] =
                    w[o] ||
                    function() {
                        (w[o].q = w[o].q || []).push(arguments);
                    };
                (js = d.createElement(s)), (fjs = d.getElementsByTagName(s)[0]);
                js.id = o;
                js.src = f;
                js.async = 1;
                fjs.parentNode.insertBefore(js, fjs);
            })(window, document, "script", "Botsonic", "https://widget.botsonic.com/CDN/botsonic.min.js");
            Botsonic("init", {
                serviceBaseUrl: "https://api-azure.botsonic.ai",
                token: "28614927-b570-4d54-8b44-bfac655b3427",
            });
        </script>
    @endif
    {{-- prajwal chatbot --}}
    <div class="topfooter bottomfooter">
        <div class="container d-none d-sm-block">
            <div class="row mb-4 mr-md-4">
                <div class="footer-dial">
                    {{-- <a href="tel:1097" class="mr-3" target="_blank"><img src="{{asset('assets/img/web/NACO_helpline.png')}}" style="width:100px;display:inline"></a> --}}
                    &nbsp;
                    <a href="tel:1097" target="_blank" style="display: none;"><img
                            src="{{ asset('assets/img/web/Counsellor_Hotline_button.png') }}"
                            style="width:150px;display:inline"></a>
                </div>
            </div>
        </div>



        <!--container-->
        <div class="container mb-5 text-center d-block d-sm-none" style="padding-left: 80px;padding-right:80px;">
            <div class="row">
                {{-- <div class="col">
                    <div class="card shadow">
                        <div class="card-body">
                            <a href="tel:1097" target="_blank"><img src="{{asset('assets/img/web/Counsellor_Hotline_button.png')}}"></a>
            </div>
        </div>
    </div> --}}
                <div class="col">
                    <div class="card shadow">
                        <div class="card-body">
                            <a href="tel:1097" class="mr-3" target="_blank"><img
                                    src="{{ asset('assets/img/web/NACO_helpline.png') }}" style="width: 60px;"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>





        <!--container-->
        <div class="container-fluid d-block" style="background-color:#F2FBFF;">
            <div class="row">
                <div class="col-6 d-flex justify-content-start">
                    <img src="{{ asset('assets/img/web/humsafar-logo.png') }}" class="img-fluid"
                        style="height:50px" />
                </div>
                <div class="col-6 d-flex justify-content-end">
                    <img src="{{ asset('assets/img/web/alliance-india.png') }}" class="img-fluid"
                        style="height:50px" />
                </div>
            </div>

            <div class="p-2 footerDisclaimer">
                <strong> {{ __('navbar.disclaimer1') }}</strong>{{ __('navbar.disclaimer2') }}
            </div>
            <!--row-->
        </div>
        <div class="container-fluid d-block" style="background-color:#1476A1;">
            <div class="p-2 px-5 text-white footerDisclaimer">
                <a href="javascript:void(0);" data-toggle="modal" data-target="#terms_of_use" title="Teams of Use"
                    class="text-white" style="text-decoration: none">
                    {{ __('navbar.terms') }}
                </a> |
                {{-- <a href="{{ url('privacy-policy') }}" target="_self" title="Privacy Policy - NETREACH Web Portal" --}}
                <a href="{{ url(session('locale', 'en') == 'en' ? 'privacy-policy' : session('locale') . '/privacy-policy') }}" target="_self" title="Privacy Policy - NETREACH Web Portal"
                    class="text-white" style="text-decoration: none">
                    {{ __('navbar.policy') }}
                </a> |
                <a href="javascript:void(0);" data-toggle="modal" data-target="#copyright" title="Copyright Policy"
                    class="text-white" style="text-decoration: none">
                    {{ __('navbar.copyright') }}
                </a>
            </div>
            <!--row-->
        </div>
        <!--container-->
    </div>

    <div class="modal fade" id="copyright" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Copyright Policy</h5>
                </div>
                <div class="modal-body text-secondary">
                    <p>
                        Material featured on this website may not be reproduced or distributed to unauthorised parties.
                        The material should not to be used in a derogatory manner or in a misleading context. Wherever
                        the material is being published or issued to others (with necessary permissions), the source
                        must be prominently acknowledged. However, the permission to reproduce this material shall not
                        extend to any material which is identified as being copyright of a third party. Authorisation to
                        reproduce such material must be obtained from the departments/copyright holders concerned.
                        These terms and conditions shall be governed by and construed in accordance with the Indian
                        Laws. Any dispute arising under these terms and conditions shall be subject to the exclusive
                        jurisdiction of the courts of India.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary mx-auto" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Terms of Use -->
    <div class="modal fade" id="terms_of_use" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{__('navbar.terms')}} </h5>
                </div>
                <div class="modal-body text-secondary">
                    <p>
                        {{__('navbar.terms_text')}}
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary mx-auto" data-dismiss="modal">{{__('navbar.Close')}} </button>
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
                </div>
                <div class="modal-body text-secondary">
                    <p>This is the Privacy Policy for web usage of NETREACH website</p>
                    <p>

                        The Humsafar Trust (HST) respects your privacy rights and cares about protecting your
                        information collected on our website applications. This website is hosted on GoDaddy Cloud, the
                        content is looked and maintained by HST – NETREACH project. These terms and conditions shall be
                        governed by extent regulations. Any dispute arising under these terms and conditions shall be
                        subject to the jurisdiction of the Government of India. The information posted on this website
                        could include hypertext links or pointers to information created and maintained by
                        non-Government/private organizations. The website is providing these links and pointers solely
                        for your information and convenience. When you select a link to an outside website, you are
                        leaving this site and are subject to the privacy and security policies of the owners/sponsors of
                        the outside website.

                    </p>
                    <p>
                        <b>User Account & Personal Information</b><br />
                        Using the NETREACH web portal requires a user to be registered in the system. Certain personal
                        information and contact details such as username, mobile number, email address is required to
                        log into your account or retrieve forgotten account information and to protect your account from
                        unauthorised access.

                    </p>
                    <p>
                        <b>Emails & SMS</b><br />
                        By giving your email address and mobile number as registration details, you have consented to
                        receiving emails and SMS from NETREACH project. NETREACH will use your email address and mobile
                        number to send NETREACH related information and updates. We reserve the right to send you
                        important program related emails and SMS.

                    </p>

                    <p>
                        <b>Disclosure</b><br />
                        Your name and registration details shall remain confidential and will not be available to
                        anybody other than you, authorised website personnel and program implementation and evaluation
                        teams. Information on your usages, frequency of usage, progress on treatment or services
                        referred within the NETREACH program will be collected by the system and shall be used for
                        analysis internally by NETREACH. These data shall not be shared with any other third party
                        except with authorised authorities as per the extent regulations.
                    </p>

                    <p>
                        <b>Standard browser data collected</b><br />
                        For browsing of our website, NETREACH will collect regular server logs which include IP
                        (Internet Protocol) address, domain name, browser type, operating system, files you downloaded,
                        pages you visited, date and time stamps of your visit. We use Cookies to ease your navigation on
                        our website.

                    </p>
                    <p>
                        <b>Security</b><br />
                        NETREACH uses industry standard Secured Socket Layer (SSL) protocol which provides data
                        encryption, message integrity and server authentication when your data is sent to it. A small
                        lock you see next to the NETREACH URL address bar on your browser window indicates that your
                        data is being encrypted for transmission.

                    </p>

                    <p>
                        <b>Changes to Privacy Policy</b><br />
                        In the event of any change to our privacy policy, it will be updated here. It is your obligation
                        to visit regularly and make yourself aware of any changes in the Policy and it will be deemed to
                        be notified and read by you on your using this website.

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

    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en',
                includedLanguages: 'en,as,bn,bho,gu,hi,kn,gom,mai,doi,ml,mr,mni-Mtei,or,pa,sa,sd,ta,te,ur'
            }, 'google_translate_element');
        }
    </script>

    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
    </script>

    <script src="{{ asset('assets/vendor/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/validation.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script
        src="{{ App::isProduction() ? secure_asset('assets/js/custom/chatbot.js') : asset('assets/js/custom/chatbot.js') }}">
    </script>
    <script>
        function myFunction() {
            var element = document.getElementById("opennav");
            element.classList.toggle("opennav");
        }

        function myFunctiondel() {
            var delelement = document.getElementById("opennav");
            delelement.classList.remove("opennav");
        }
    </script>
    
    <script>
        //create button with name send in javascript

        $("#clickMe").click(() => {
            let datax = `
return [
 
`;
            const test = $("body").find("font")
            test.each((index, element) => {
                // if ($(element).find("font").text() != "") {
                datax = datax + `'test${index}'=>'${$(element).find("font").text().trim()}',`;
                // }
            });


            datax = datax + ` ];`;
            console.log(datax);
        })
    </script>
    <script>
        var base_url = "{{ URL::to('/') }}";
    </script>

<script>
    function changeLanguage(select) {
        let selectedLang = select.value;
        let currentUrl = window.location.href;
        let url = new URL(currentUrl);
        let path = url.pathname.split('/').filter(segment => segment);
        let languages = ['en', 'hi', 'mr', 'ta', 'te'];
        if (languages.includes(path[0])) {
            path.shift();
        }

        if (selectedLang !== 'en') {
            path.unshift(selectedLang);
        }
        if (selectedLang == 'en') {
            fetch('/set-english', {
                method: 'GET',
            }).then(() => {

            })
        }

        // Construct new URL while preserving search parameters
        let newUrl = `${url.origin}/${path.join('/')}${url.search}`;


        // path.unshift(selectedLang);

        // let newUrl = selectedLang === 'en' ? `${url.origin}/` : `${url.origin}/${path.join('/')}`;
        // let newUrl = `${url.origin}/${path.join('/')}`;

        window.location.href = newUrl;
    }
</script>
    @stack('scripts')
</body>

</html>
