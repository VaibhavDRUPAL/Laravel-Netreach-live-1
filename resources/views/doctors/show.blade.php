@extends('layouts.app')

@push('pg_btn')
    <a href="{{ route('doctors.index') }}" class="btn btn-sm btn-neutral">All Doctors</a>
    <a href="{{ route('doctors.edit', $doctor) }}" class="btn btn-sm btn-info">Edit</a>
@endpush

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-5">
            <div class="card-header bg-transparent">
                <h3 class="mb-0">Doctor Details</h3>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">Name</dt>
                    <dd class="col-sm-9">{{ $doctor->name }}</dd>

                    <dt class="col-sm-3">Email</dt>
                    <dd class="col-sm-9">{{ $doctor->email }}</dd>

                    <dt class="col-sm-3">Specialization</dt>
                    <dd class="col-sm-9">{{ $doctor->specialization }}</dd>

                    <dt class="col-sm-3">Phone</dt>
                    <dd class="col-sm-9">{{ $doctor->phone }}</dd>

                    <dt class="col-sm-3">Status</dt>
                    <dd class="col-sm-9">
                        @if($doctor->is_active)
                            <span class="badge badge-success">Active</span>
                        @else
                            <span class="badge badge-danger">Inactive</span>
                        @endif
                    </dd>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection
