@extends('layouts.apphome')
@push('meta_data')
    <title>{{ $blog->meta_title }}</title>
    <meta name="description" content="{{ $blog->meta_description }}">
    <meta name="keywords" content="{{ $blog->meta_keywords }}">
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
            padding: 1rem 0rem 0rem 0rem;
        }

        .fsize {
            font-size: 20px;
        }

        .fsize_desc {
            font-size: 20px;
        }

        .jb_bg {
            background-color: #D7F3FF;

        }
    </style>



    <div class="jumbotron w-100 jb_bg" style="margin-top: 100px;">
        <div class="container">
            <h1 class="font-weight-bold">{{ $blog->title }}</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" style="background-color:#D7F3FF">
                    <li class="breadcrumb-item"><a href="{{ URL::to('/') }}">
                            <h5>{{ __('blog.1') }} </h5>
                        </a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="{{ URL::to('/blog') }}">
                            <h5>{{ __('blog.2') }}</h5>
                        </a></li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container">



        <div class="row">
            <div class="col-sm-12 mb-5">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card border-0">
                            <div class="card-body">
                                @if ($blog->youtube_video_embed)
                                    <div class="embed-responsive embed-responsive-16by9 rounded">
                                        {!! $blog->youtube_video_embed !!}
                                    </div>
                                @else
                                    <img src="{{ asset('storage/blog/' . $blog->image) }}" class="card-img-top">
                                @endif
                                <h3 class="card-title mt-4 font-weight-bold">
                                    @if ($locale == 'mr')
                                        {{ $blog->title_mr }}
                                    @elseif ($locale == 'hi')
                                        {{ $blog->title_hi }}
                                    @elseif ($locale == 'ta')
                                        {{ $blog->title_ta }}
                                    @elseif ($locale == 'te')
                                        {{ $blog->title_te }}
                                    @else
                                        {{ $blog->title }}
                                    @endif
                                </h3>
                                <p class="mb-2">
                                    <span class="mr-2 fsize">{{ parseDateTime($blog->created_at, 'M d, Y') }}</span> |
                                    <span class="ml-2 mr-2 text-capitalize fsize">
                                        @if ($locale == 'mr')
                                            {{ $blog->author_name_mr }}
                                        @elseif ($locale == 'hi')
                                            {{ $blog->author_name_hi }}
                                        @elseif ($locale == 'ta')
                                            {{ $blog->author_name_ta }}
                                        @elseif ($locale == 'te')
                                            {{ $blog->author_name_te }}
                                        @else
                                            {{ $blog->author_name }}
                                        @endif
                                    </span>
                                    @if ($blog->blogCategories->deleted_at)
                                    @else
                                        | <span
                                            class="ml-2 mr-2 fsize">{{ $blog->blogCategories->blog_category_name }}</span>
                                    @endif
                                </p>
                                <p class="mb-4">
                                <h4 class="text-muted fsize_desc">
                                    @if ($locale == 'mr')
                                        {!! $blog->description_mr !!}
                                    @elseif($locale == 'hi')
                                        {!! $blog->description_hi !!}
                                    @elseif($locale == 'ta')
                                        {!! $blog->description_ta !!}
                                    @elseif($locale == 'te')
                                        {!! $blog->description_te !!}
                                    @else
                                        {!! $blog->description !!}
                                    @endif
                                </h4>
                                </p>
                                <h5 class="mt-4 font-weight-bold">{{ __('blog.3') }}</h5>
                                <div class="main-content">
                                    <div class="column ml-4 mb-2">
                                        <a href="https://wa.me/?text={{ url()->current() }}"
                                            class="btn btn-sm btn-success"><i class="fa-brands fa-whatsapp"
                                                aria-hidden="true"></i> WhatsApp</a>
                                    </div>

                                    <div class="column ml-4 mb-2">
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}&quote={{ createSlug($blog->title, '-') }}"
                                            class="btn btn-sm btn-primary"><i class="fa-brands fa-facebook"></i>
                                            Facebook</a>
                                    </div>

                                    <div class="column ml-4 mb-2">
                                        <button type="button"
                                            onclick="navigator.clipboard.writeText(window.location.href);"
                                            class="btn btn-sm btn-info"><i class="fa fa-link" aria-hidden="true"></i> Copy
                                            Link</button>
                                    </div>

                                    <div class="column ml-4 mb-2">
                                        <a href="mailto:?body={{ url()->current() }}" class="btn btn-sm btn-warning"><i
                                                class="fa fa-envelope" aria-hidden="true"></i> Email</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 d-none d-sm-block">
                        <div class="card border-0">
                            <div class="card-body">
                                <h4 class="font-weight-bold">{{ __('blog.4') }}</h4>
                                @if ($blog->tags)
                                    @php
                                        $tags = explode(',', $blog->tags);
                                    @endphp
                                    @foreach ($tags as $tag)
                                        <a href="{{ URL::to('/blog?search=' . $tag) }}"
                                            class="btn btn-sm btn-outline-secondary mr-2 mb-2">{{ $tag }}</a>
                                    @endforeach
                                @endif

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card text-white mb-4 mt-3">
                        <div class="card-header text-capitalize" style="background-color: #1476A1;">
                            <h4 class="font-weight-bold">{{ __('blog.5') }}
                                {{ $blog->author_name }}</h4>
                        </div>
                        @if (!empty($blog->author_details))
                            <div class="card-body text-dark" style="background-color: #F2FBFF;">
                                <span class="fsize text-dark"> {{ $blog->author_details }} </span>

                                <div class="main-content mt-3">
                                    @if ($blog->facebook)
                                        <div class="column p-0">
                                            <a href="{{ $blog->facebook }}" target="_BLANK"><img
                                                    src="{{ asset('assets/img/web/fbbk.png') }}" /></a>
                                        </div>
                                    @endif
                                    @if ($blog->whatsapp)
                                        <div class="column p-0">
                                            <a href="https://wa.me/+91{{ $blog->whatsapp }}" target="_BLANK"><img
                                                    src="{{ asset('assets/img/web/whatsappbk.png') }}" /></a>
                                        </div>
                                    @endif
                                    @if ($blog->instagram)
                                        <div class="column p-0">
                                            <a href="{{ $blog->instagram }}" target="_BLANK"><img
                                                    src="{{ asset('assets/img/web/instabk.png') }}" /></a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-md-12 d-block d-sm-none">
                    <div class="card border-0">
                        <div class="card-body p-0">
                            <h5>{{ __('blog.6') }}</h5>
                            @if ($blog->tags)
                                @php
                                    $tags = explode(',', $blog->tags);
                                @endphp
                                @foreach ($tags as $tag)
                                    <a href="{{ URL::to('/blog?search=' . $tag) }}"
                                        class="btn btn-sm btn-outline-secondary mr-2 mb-2">{{ $tag }}</a>
                                @endforeach
                            @endif

                        </div>
                    </div>
                </div>


                <div class="d-flex justify-content-center mt-5 mb-5">
                    <h3 class="float-center font-weight-bold">{{ __('blog.7') }}</h3>
                </div>


                {{-- Related Blogs --}}
                <div class="col-sm-12">
                    <div class="row">
                        @if ($related_blogs->isNotEmpty())
                            @foreach ($related_blogs as $blog)
                                <div class="col-sm-4 mb-5">
                                    {{--<a href="{{ URL::to('/blog-details/' . $blog->blog_id . '/' . createSlug($blog->title, '-')) }}"> --}}
                                    <a href="{{ $locale != 'en' ? URL::to('/' . $locale . '/blog-details/' . $blog->blog_id . '/' . createSlug($blog->title, '-')) : URL::to('/blog-details/' . $blog->blog_id . '/' . createSlug($blog->title, '-')) }}">
                                        <div class="card shadow">
                                            <img src="{{ asset('storage/blog/' . $blog->image) }}" class="card-img-top">
                                            <div class="card-body">
                                                <a
                                                    href="{{ URL::to('/blog-details/' . $blog->blog_id . '/' . createSlug($blog->title, '-')) }}">
                                                    <h4 class="card-title font-weight-bold text-dark">
                                                        @if ($locale=='mr')
                                                            {{ $blog->title_mr }}</h4>
                                                        @elseif ($locale=='hi')
                                                         {{ $blog->title_hi }}</h4>
                                                        @elseif ($locale=='ta')
                                                            {{ $blog->title_ta }}</h4>
                                                        @elseif ($locale=='te')
                                                            {{ $blog->title_te }}</h4>
                                                        @else 
                                                            {{ $blog->title }}</h4>
                                                        @endif
                                                    </h4>
                                                </a>
                                                <p class="text-secondary mb-2"><i
                                                        class="fas text-secondary fa-calendar-alt mr-2"></i>
                                                    {{ parseDateTime($blog->created_at, 'M d, Y') }} </p>
                                                <u>
                                                    {{-- <a href="{{ URL::to('/blog-details/' . $blog->blog_id . '/' . createSlug($blog->title, '-')) }}"
                                                        class="text-secondary">{{ __('blog.12') }}</a> --}}
                                                        <a href="{{ $locale != 'en' ? URL::to('/' . $locale . '/blog-details/' . $blog->blog_id . '/' . createSlug($blog->title, '-')) : URL::to('/blog-details/' . $blog->blog_id . '/' . createSlug($blog->title, '-')) }}">{{ __('blog.12') }}</a>
                                                    </u>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        @else
                            <div class="row justify-content-center mt-5 mb-5">
                                <h5>{{ __('blog.8') }}</h5>
                            </div>
                        @endif



                    </div>

                </div>








            </div>
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
