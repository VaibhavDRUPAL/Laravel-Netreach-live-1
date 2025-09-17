@extends('layouts.apphome')

@push('meta_data')
    <title>Netreach Blogs</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
@endpush

@section('content')

    <style>
        .font7 {
            color: black;
        }

        .column {
            display: inline-block
        }

        .jumbotron {
            padding: 2rem 0rem;
        }

        .jb_bg {
            background-color: #D7F3FF;

        }

        .jumbotron {
            padding: 1rem 0rem 0rem 0rem;
        }

        .search_btn {
            background-color: #1476A1;
            border-color: #1476A1;
            color: #fff;
        }

        .page-item.active .page-link {
            background-color: #1476A1;
            border-color: #1476A1;
        }

        .page-link {
            color: #1476A1;
            font-size: 20px;
        }
    </style>




    <div class="jumbotron w-100 jb_bg rounded-0" style="margin-top: 100px;">
        <div class="container">
            <h1 class="font-weight-bold">{{ __('blog.2') }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb jb_bg">
                    <li class="breadcrumb-item"><a href="#">
                            <h5>{{ __('blog.1') }}</h5>
                        </a></li>
                    <li class="breadcrumb-item text-primary" aria-current="page">
                        <h5>{{ __('blog.2') }}</h5>
                    </li>
                </ol>
            </nav>
        </div>
    </div>


    <div class="container">





        <div class="row mb-5">
            <div class="col-md-3 d-none d-sm-block">

            </div>
            <div class="col-md-6">
                <form action="">
                    <div class="input-group input-group-lg">
                        <input name="search" type="search" class="form-control bg-light btn-lg"
                            aria-describedby="button-addon2">
                        <div class="input-group-append">
                            <button class="btn search_btn" type="submit" id="button-addon2">{{ __('blog.11') }}</button>
                        </div>
                    </div>

                </form>
            </div>
            <div class="col-md-3 d-none d-sm-block">

            </div>
        </div>

        {{-- @if (session('locale'))
            @php
                $locale = session('locale');
            @endphp
        @else --}}
        @php
            $locale = app()->getLocale();
        @endphp
        {{-- @endif --}}

        <div class="row">
            @if ($blogs->isNotEmpty())
                @foreach ($blogs as $blog)
                    <div class="col-sm-4 mb-5">
                        {{-- <a href="{{ URL::to('/blog-details/' . $blog->blog_id . '/' . createSlug($blog->title, '-')) }}"> --}}
                        <a
                            href="{{ $locale != 'en' ? URL::to('/' . $locale . '/blog-details/' . $blog->blog_id . '/' . createSlug($blog->title, '-')) : URL::to('/blog-details/' . $blog->blog_id . '/' . createSlug($blog->title, '-')) }}">
                            <div class="card shadow">
                                <img src="{{ asset('storage/blog/' . $blog->image) }}" class="card-img-top">
                                <div class="card-body">
                                    <a
                                        href="{{ $locale != 'en' ? URL::to('/' . $locale . '/blog-details/' . $blog->blog_id . '/' . createSlug($blog->title, '-')) : URL::to('/blog-details/' . $blog->blog_id . '/' . createSlug($blog->title, '-')) }}">
                                        @if ($locale == 'mr')
                                            <h4 class="card-title font-weight-bold text-dark">{{ $blog->title_mr }}</h4>
                                        @elseif ($locale == 'hi')
                                            <h4 class="card-title font-weight-bold text-dark">{{ $blog->title_hi }}</h4>
                                        @elseif ($locale == 'te')
                                            <h4 class="card-title font-weight-bold text-dark">{{ $blog->title_te }}</h4>
                                        @elseif ($locale == 'ta')
                                            <h4 class="card-title font-weight-bold text-dark">{{ $blog->title_ta }}</h4>
                                        @else
                                            <h4 class="card-title font-weight-bold text-dark">{{ $blog->title }}</h4>
                                        @endif
                                    </a>
                                    <p class="text-secondary mb-2"><i class="fas text-secondary fa-calendar-alt mr-2"></i>
                                        {{ parseDateTime($blog->created_at, 'M d, Y') }} </p>
                                    <u><a href="{{ URL::to('/blog-details/' . $blog->blog_id . '/' . createSlug($blog->title, '-')) }}"
                                            class="text-secondary">{{ __('blog.12') }}</a></u>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            @else
                <div class="row justify-content-center mb-5">
                    <h5> {{ __('blog.8') }}</h5>
                </div>
            @endif
        </div>

        <div class="row justify-content-center mb-5">
            {{ $blogs->onEachSide(2)->links('home.pagination') }}
        </div>



    </div>


    <!--container-->
    <section style="background-color:#F2FBFF;" class="d-none d-sm-block">
        <div class="container pt-4 pb-1">
            <div class="font-weight-bold" style="font-size: 18px;">
                <div class="row mb-3">
                    <div class="col">
                        <a class="mr-5" href="{{ URL::to('https://humsafar.org/') }}"><img
                                src="{{ asset('assets/img/web/humsafar-logo.png') }}" style="width: 125px"></a>
                        <a href="{{ URL::to('https://allianceindia.org/') }}"><img
                                src="{{ asset('assets/img/web/alliance-india.png') }}"></a>
                    </div>
                    <div class="col-9">
                        {{ __('blog.9') }}
                    </div>
                </div>
            </div>
            <!--row-->
        </div>

    </section>

    <section style="background-color:#1476A1;margin-bottom:-50px" class="d-none d-sm-block">
        <div class="container">
            <div class="py-3 text-white" style="font-size: 18px;">
                <p>{{ __('blog.10') }}</p>
            </div>
            <!--row-->
        </div>
    </section>
@endsection
