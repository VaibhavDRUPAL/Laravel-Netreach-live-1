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
                <h3 class="mb-0">Announcement Details</h3>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">Title</dt>
                    <dd class="col-sm-9">{{ $announcement->title }}</dd>

                    <dt class="col-sm-3">Content</dt>
                    <dd class="col-sm-9">{{ $announcement->content }}</dd>

                    <dt class="col-sm-3">Start Date</dt>
                    <dd class="col-sm-9">{{ \Carbon\Carbon::parse($announcement->start_date)->format('d M, Y') }}</dd>

                    <dt class="col-sm-3">End Date</dt>
                    <dd class="col-sm-9">{{ \Carbon\Carbon::parse($announcement->end_date)->format('d M, Y') }}</dd>

                    <dt class="col-sm-3">Status</dt>
                    <dd class="col-sm-9">
                        @if($announcement->is_active)
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
