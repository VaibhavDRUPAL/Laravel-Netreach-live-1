@extends('layouts.app')

@push('pg_btn')
    <a href="{{ route('doctors.index') }}" class="btn btn-sm btn-neutral">All Doctors</a>
@endpush

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-5">
            <div class="card-body">
                {!! Form::open(['route' => 'doctors.store', 'files' => true]) !!}
                <h6 class="heading-small text-muted mb-4">Create Doctor</h6>
                <div class="pl-lg-4">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('name', 'Name', ['class' => 'form-control-label']) }}
                                {{ Form::text('name', null, ['class' => 'form-control', 'required']) }}
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('email', 'Email', ['class' => 'form-control-label']) }}
                                {{ Form::email('email', null, ['class' => 'form-control', 'required']) }}
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('phone', 'Phone', ['class' => 'form-control-label']) }}
                                {{ Form::text('phone', null, ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('specialization', 'Specialization', ['class' => 'form-control-label']) }}
                                {{ Form::text('specialization', null, ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('qualification', 'Qualification', ['class' => 'form-control-label']) }}
                                {{ Form::text('qualification', null, ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('profile_photo', 'Profile Photo', ['class' => 'form-control-label']) }}
                                {{ Form::file('profile_photo', ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="custom-control custom-checkbox mt-4">
                                {{ Form::checkbox('is_active', 1, true, ['class' => 'custom-control-input', 'id' => 'is_active']) }}
                                {{ Form::label('is_active', 'Active', ['class' => 'custom-control-label']) }}
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4" />

                <div class="pl-lg-4">
                    <div class="row">
                        <div class="col-md-12">
                            {{ Form::submit('Create', ['class'=> 'mt-3 btn btn-primary']) }}
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
