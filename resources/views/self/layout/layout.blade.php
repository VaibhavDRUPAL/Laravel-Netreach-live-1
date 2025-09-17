<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
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
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        @yield('title') | {{ config('app.name', 'Laravel') }}
    </title>
    <link rel="stylesheet" media="all" href="{{ asset('assets/css/bootstrap.min.css') }}">
</head>

<body>
    @production
        <noscript>
            <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KW2BR43J" height="0" width="0"
                style="display:none;visibility:hidden"></iframe>
        </noscript>
    @endproduction
    <header class="header">
        <div class="container">
            <div class="row align-items-center" style="padding-top: 10px;">
                <div class="col-md-2 d-flex  logo" id="nav-bar-logo-web">
                    <a class="mr-3" href="{{ URL::to('https://humsafar.org/') }}"><img
                            src="{{ asset('assets/img/web/humsafar-logo.png') }}" style="width: 125px"></a>
                    <a href="{{ URL::to('https://allianceindia.org/') }}"><img
                            src="{{ asset('assets/img/web/alliance-india.png') }}"></a>
                </div>
                <div class="col-md-7 mt-3 navigation">
                    <div class="nav-icon" onclick="myFunction()" style="z-index: 99;"><i class="fas fa-bars"></i></div>
                </div>
                <div class="col-md-3">
                    <a href="{{ url('/') }}" target="_blank">
                        <img class="ml-3" id="netreach-logo" src="{{ asset('assets/img/web/logo-bac.png') }}"
                            style="width:80%">
                    </a>
                    <div id="google_translate_element"> </div>
                </div>
            </div>
        </div>
    </header>

    <div class="my-3 container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('body')
    </div>
</body>
<script type="text/javascript" charset="utf8" src="{{ asset('assets/vendor/jquery/dist/jquery.min.js') }}"></script>
<script type="text/javascript" charset="utf8" src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" charset="utf8" src="{{ asset('assets/js/popper.min.js') }}"></script>
<script
    src="{{ App::isProduction() ? secure_asset('assets/js/custom/self-risk-assessment.js') : asset('assets/js/custom/self-risk-assessment.js') }}">
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
</script>
<script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'en',
            includedLanguages: 'as,bn,bho,doi,gu,hi,kn,kok,mai,ml,mr,mni-Mtei,or,pa,sa,sd,ta,te,ur'
        }, 'google_translate_element');
    }
    $(function() {
        if ($(window).width() < 760) {
            $('#sra-img').addClass('d-none');
            $('#sra-content').removeClass('positioning');
        }
    })
</script>

</html>
