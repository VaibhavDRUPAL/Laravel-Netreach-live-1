@extends('layouts.app')

@push('pg_btn')
    <a href="{{ route('announcements.index') }}" class="btn btn-sm btn-neutral">All Announcements</a>
@endpush

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-5">
            <div class="card-body">
                {!! Form::model($announcement, ['route' => ['announcements.update', $announcement->id], 'method' => 'PUT', 'files' => true]) !!}
                <h6 class="heading-small text-muted mb-4">Edit Announcement</h6>
                <div class="pl-lg-4">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('title', 'Title', ['class' => 'form-control-label']) }}
                                {{ Form::text('title', null, ['class' => 'form-control', 'required']) }}
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                {{ Form::label('content', 'Content', ['class' => 'form-control-label']) }}
                                {{ Form::textarea('content', null, ['class' => 'form-control', 'rows'=>3, 'required']) }}
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('start_date', 'Start Date', ['class' => 'form-control-label']) }}
                                {{ Form::date('start_date', $announcement->start_date, ['class' => 'form-control', 'required']) }}
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('end_date', 'End Date', ['class' => 'form-control-label']) }}
                                {{ Form::date('end_date', $announcement->end_date, ['class' => 'form-control', 'required']) }}
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="custom-control custom-checkbox mt-4">
                                {{ Form::checkbox('is_active', 1, $announcement->is_active, ['class' => 'custom-control-input', 'id' => 'is_active']) }}
                                {{ Form::label('is_active', 'Active', ['class' => 'custom-control-label']) }}
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4" />

                <div class="pl-lg-4">
                    <div class="row">
                        <div class="col-md-12">
                            {{ Form::submit('Update', ['class'=> 'mt-3 btn btn-primary']) }}
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
