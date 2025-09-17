@extends('layouts.apphome')

@section('content')
<section class="top-menu-banner">
  <div class="home-slider">
    <div id="myCarousel" class="carousel slide" data-ride="carousel">


      <!-- The slideshow -->
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="{{asset('assets/img/web/slider2.jpg')}}">
          <div class="carousel-caption d-none d-md-block">
            <h5>We are India's first #LGBTQ<br>
              organization</h5>
            <!-- <p>The Humsafar Trust is a proud recipient of the Global Fund<br>(GTFM) grant that will help reach the unreached population<br>with a unique virtual HIV intervention program - Project<br> NETREACH. </p> -->
          </div>
        </div>
        <div class="carousel-item">
          <img src="{{asset('assets/img/web/slider2.jpg')}}">
          <div class="carousel-caption d-none d-md-block">
            <h5>We are India's first #LGBTQ<br>
              organization</h5>
            <!-- <p>The Humsafar Trust is a proud recipient of the Global Fund<br>(GTFM) grant that will help reach the unreached population<br>with a unique virtual HIV intervention program - Project<br> NETREACH. </p> -->
          </div>
        </div>
        <div class="carousel-item">
          <img src="{{asset('assets/img/web/slider2.jpg')}}">
          <div class="carousel-caption d-none d-md-block">
            <h5>We are India's first #LGBTQ<br>
              organization</h5>
            <!-- <p>The Humsafar Trust is a proud recipient of the Global Fund<br>(GTFM) grant that will help reach the unreached population<br>with a unique virtual HIV intervention program - Project<br> NETREACH. </p> -->
          </div>
        </div>
      </div>

      <!-- Left and right controls -->
      <a class="carousel-control-prev" href="#myCarousel" data-slide="prev">
        <img src="{{asset('assets/img/web/slider-arrow.png')}}">
      </a>
      <a class="carousel-control-next" href="#myCarousel" data-slide="next">
        <img src="{{asset('assets/img/web/slider-arrow.png')}}">
      </a>
    </div>

  </div>
  </div>
</section>



<section class="about-bottom">
  <div class="main-bottom">
    <div class="container">
      <div class="heading-about">
        <h1>About <span>NETREACH</span></h1>
        <p>Project NETREACH aims to accelerate the national HIV response to reach the first 95 targets by reaching key and vulnerable populations (high-risk groups, at-risk adolescents and youth, men and women with high-risk behaviors) through virtual platforms. The project "NETREACH" is implemented across all states and union territories of India. It is implemented by the Humsafar Trust and supported by Global Fund (GFTAM) in partnership with India HIV/AIDS (Alliance India). NETREACH functions under the aegis of the National AIDS Control Organisation (NACO), Ministry of Family and Health Welfare (MoHFW), Government of India. </p>
      </div><!-- heading-about -->
      <!-- <a href="#" class="ab-btn">know more<i class="fas fa-long-arrow-alt-right"></i></a> -->
    </div><!-- container -->
  </div><!-- main-bottom -->
</section><!-- about-bottom -->

<section class="consent" id="consent">
  <img src="{{asset('assets/img/web/bg-image.jpg')}}">
  <div class="bag-consent">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <div class="heading-clause">
            <h1>Consent and Confidentiality clause</h1>
            <p>Self-assessment for HIV risk is a simple tool to know whether you are required to get tested for HIV. You are requested to provide the right information for an accurate assessment. The information provided by you will be kept strictly confidential and in no way will reveal your identity. The responses you record may be used only for project purposes. </p>
          </div><!-- heading-about -->
          <!-- <a href="#" class="ab-button">know more<i class="fas fa-long-arrow-alt-right"></i></a> -->
        </div><!-- col-md-6 -->
      </div><!-- row -->
    </div><!-- container -->
  </div><!-- bag-consent -->
</section><!-- consent -->

@endsection