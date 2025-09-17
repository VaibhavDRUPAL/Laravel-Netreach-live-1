@extends('layouts.apphome')

@section('content')

<section class="landing-sec-1 accordion-section">
        {{-- <img src="{{ asset('assets/img/web/slider-bg.jpg') }}" class="main-banner"> --}}
        <div class="banner-caption">
            <div class="container">
                <div class="row" style="align-items: flex-start;">
                    <div class="col-md-12" style="height: inherit;">
                        <h1 class="heading1">{{ __('navbar.faq') }} </h1>
                        <?php echo $content; ?>

                    </div>

                </div><!--container-->
            </div><!--banner-caption-->
    </section><!--landing-sec-1-->
@endsection