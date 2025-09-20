@extends('layouts.app')

@push('pg_btn')
    <a href="{{ route('doctors.index') }}" class="btn btn-sm btn-neutral">All Doctors</a>
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card mb-5">
            <div class="card-body">
                {!! Form::model($doctor, ['route' => ['doctors.update', $doctor], 'method' => 'PUT', 'files' => true]) !!}

                <h6 class="heading-small text-muted mb-4">Edit Doctor</h6>
                
                <div class="row">
                    <!-- Name -->
                    <div class="col-lg-6 mb-3">
                        {{ Form::label('name', 'Name', ['class' => 'form-control-label']) }}
                        {{ Form::text('name', null, ['class' => 'form-control', 'required']) }}
                    </div>

                    <!-- Email -->
                    <div class="col-lg-6 mb-3">
                        {{ Form::label('email', 'Email', ['class' => 'form-control-label']) }}
                        {{ Form::email('email', null, ['class' => 'form-control', 'required']) }}
                    </div>

                    <!-- Specialization -->
                    <div class="col-lg-6 mb-3">
                        {{ Form::label('specialization', 'Specialization', ['class' => 'form-control-label']) }}
                        {{ Form::text('specialization', null, ['class' => 'form-control']) }}
                    </div>

                    <!-- Phone -->
                    <div class="col-lg-6 mb-3">
                        {{ Form::label('phone', 'Phone', ['class' => 'form-control-label']) }}
                        {{ Form::text('phone', null, ['class' => 'form-control']) }}
                    </div>

                    <!-- Status -->
                    <div class="col-lg-6 mb-3 d-flex align-items-center">
                        <div class="custom-control custom-checkbox">
                            {{ Form::checkbox('is_active', 1, $doctor->is_active, ['class' => 'custom-control-input', 'id' => 'is_active']) }}
                            {{ Form::label('is_active', 'Active', ['class' => 'custom-control-label']) }}
                        </div>
                    </div>
                </div>

                <hr class="my-4" />

                <div class="row">
                    <div class="col-md-12 text-right">
                        {{ Form::submit('Update', ['class'=> 'btn btn-primary']) }}
                    </div>
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
