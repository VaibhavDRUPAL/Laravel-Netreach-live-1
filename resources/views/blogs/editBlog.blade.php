@extends('layouts.app')
@push('pg_btn')
<a href="{{route('blogs_all')}}" class="btn btn-sm btn-neutral">All Blogs</a>
@endpush
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-5">
            <div class="card-body">
                {!! Form::open(['files' => true]) !!}
                @method('PUT')
                <h6 class="heading-small text-muted mb-4">Edit Blog</h6>
                <div class="pl-lg-4">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('title', 'Title', ['class' => 'form-control-label']) }}
                                {{ Form::text('title', $blog->title, ['class' => 'form-control']) }}
                            </div>
                            <div class="form-group">
                                {{ Form::Label('blog_category_id', 'Blog Category', ['class' => 'form-control-label']) }}
                                {{ Form::select('blog_category_id', $blog_categories, $blog->blog_category_id, [ 'class'=> 'selectpicker form-control', 'placeholder'
                                => 'Select Blog Category']) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('description', 'Description', ['class' => 'form-control-label']) }}
                                {{ Form::textarea('description', $blog->description, ['class' => 'form-control','rows'=> 15]) }}
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('image', 'Photo', ['class' => 'form-control-label']) }}
                                {{-- <div class="input-group"> --}}
                                {{-- <span class="input-group-btn">
                                        <a id="uploadFile" data-input="thumbnail" data-preview="holder"
                                            class="btn btn-secondary">
                                            <i class="fa fa-picture-o"></i> Choose Photo
                                        </a>
                                    </span> --}}
                                <br>
                                <input id="thumbnail" class="form-control" type="file" name="image">
                                {{--
                                </div> --}}
                            </div>
                            <div class="form-group">
                                {{ Form::label('youtube_video_embed', 'Youtube Video Embed', ['class' =>
                                'form-control-label']) }}
                                {{ Form::textarea('youtube_video_embed', $blog->youtube_video_embed, ['class' => 'form-control','rows'=>7]) }}
                                <small class="text-small text-muted">Paste youtube video embed code</small>
                            </div>
                            <div class="form-group">
                                {{ Form::label('tags', 'Tags', ['class' => 'form-control-label']) }}
                                {{ Form::textarea('tags', $blog->tags, ['class' => 'form-control','rows'=>3]) }}
                                <small class="text-small text-muted">Comma seperated words</small>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="my-4" />
                <!-- Address -->
                <h6 class="heading-small text-muted mb-4">SEO details</h6>
                <div class="pl-lg-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('meta_title', 'Meta Title', ['class' => 'form-control-label']) }}
                                {{ Form::text('meta_title', $blog->meta_title, ['class' => 'form-control']) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('meta_keywords', 'Meta Keywords', ['class' => 'form-control-label']) }}
                                {{ Form::text('meta_keywords', $blog->meta_keywords, ['class' => 'form-control']) }}
                                <small class="text-small text-muted">Comma seperated words</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('meta_description', 'Meta Description', ['class' =>
                                'form-control-label']) }}
                                {{ Form::textarea('meta_description', $blog->meta_description, ['class' => 'form-control','rows'=>6]) }}
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="my-4" />
                <h6 class="heading-small text-muted mb-4">Author details</h6>
                <div class="pl-lg-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('author_name', 'Author name', ['class' => 'form-control-label']) }}
                                {{ Form::text('author_name', $blog->author_name, ['class' => 'form-control']) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('author_details', 'Author details', ['class' => 'form-control-label']) }}
                                {{ Form::textarea('author_details', $blog->author_details, ['class' => 'form-control','rows'=>6]) }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('facebook', 'Facebook link', ['class' => 'form-control-label']) }}
                                {{ Form::text('facebook', $blog->facebook, ['class' => 'form-control']) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('whatsapp', 'Whatsapp number', ['class' => 'form-control-label']) }}
                                {{ Form::text('whatsapp', $blog->whatsapp, ['class' => 'form-control']) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('instagram', 'Instagram link', ['class' => 'form-control-label']) }}
                                {{ Form::text('instagram', $blog->instagram, ['class' => 'form-control']) }}
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="my-4" />
                <div class="pl-lg-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="status" value="1" class="custom-control-input" id="status" <input type="checkbox" name="status" @checked($blog->status)>
                                {{ Form::label('status', 'Active', ['class' => 'custom-control-label']) }}
                            </div>
                        </div>
                        <div class="col-md-12">
                            {{ Form::submit('Submit', ['class'=> 'mt-5 btn btn-primary']) }}
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
</div>
@push('scripts')
<script src="https://cdn.tiny.cloud/1/c0vs94lg4ti05nbrgct6j7yufm7qky7t1js3ho1prudbt51h/tinymce/6/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: 'textarea#description',
        menubar: false,
    });
</script>
@endpush
@endsection
{{--
@push('scripts')
<script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
<script>
    jQuery(document).ready(function() {
        jQuery('#uploadFile').filemanager('file');
    })
</script>
@endpush --}}