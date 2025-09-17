@extends('layouts.apphome')

@section('content')
<section class="landing-sec-1 thanku-page">
    <img src="{{asset('assets/img/web/slider-bg.jpg')}}" class="main-banner">
    <div class="banner-caption">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center">
                    <h1 class="heading1">Thank You</h1>
                    @if (isset($uid))
                        <p>Your appointment is <strong>CONFIRMED.</strong></p>
                        <p>You will receive an SMS shortly.</p>
                        <p>Your NETREACH Unique ID is <strong>{{$uid}}</strong></p>
                        
                    @else
                        <p>Self Risk Assessment submitted <strong>SUCCESSFULLY.</strong></p>
                    @endif
                    @isset($book_pdf)
                        <div class="thanku-btn-ab">
                            <a href="/storage/pdf/{{$book_pdf}}" target="_blank"><button>Download</button></a>
                        </div><!--thanku-btn-ab-->
                    @endisset
                </div><!--col-md-6-->
                <div class="col-md-6 text-right">
                    <img src="{{asset('assets/img/web/thanku-banner.png')}}">
                </div><!--col-md-6-->
            </div><!--row-->
        </div><!--container-->
    </div><!--banner-caption-->
</section><!--landing-sec-1-->
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        $(document).prop('title','Appointment Confirmed|NETREACH');
    });
</script>
@endpush