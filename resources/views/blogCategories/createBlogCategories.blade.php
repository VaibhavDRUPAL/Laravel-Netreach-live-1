@extends('layouts.app')
@push('pg_btn')
<a href="{{route('blog_categories_all')}}" class="btn btn-sm btn-neutral">All Blog Categories</a>
@endpush
@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card mb-5">
            <div class="card-body">
                {!! Form::open(['route' => 'blog_categories_store']) !!}
                <h6 class="heading-small text-muted mb-4">Add Blog Category</h6>
                <div class="pl-lg-4">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('blog_category_name', 'Category Name', ['class' => 'form-control-label']) }}
                                {{ Form::text('blog_category_name', null, ['class' => 'form-control']) }}
                            </div> 
                         
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="status" value="1" class="custom-control-input" id="status">
                                {{ Form::label('status', 'Active', ['class' => 'custom-control-label']) }}
                            </div>
                        </div>
                    </div> 
                </div>
                <hr class="my-4" />
  
                <div class="pl-lg-4">
                    <div class="row">
                        
                        <div class="col-lg-6">
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
@endsection
{{-- 
@push('scripts')
<script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
<script>
    jQuery(document).ready(function(){
            jQuery('#uploadFile').filemanager('file');
        })
</script>
@endpush --}}