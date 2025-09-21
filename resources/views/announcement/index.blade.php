@extends('layouts.app')

@push('pg_btn')
@can('create-announcement')
    <a href="{{ route('announcements.create') }}" class="btn btn-sm btn-neutral">Create New Announcement</a>
@endcan
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-header bg-transparent">
                    <div class="row">
                        <div class="col-lg-8">
                            <h3 class="mb-0">All Announcements</h3>
                        </div>
                        <div class="col-lg-4">
                            {!! Form::open(['route' => 'announcements.index', 'method'=>'get']) !!}
                            <div class="form-group mb-0">
                                {{ Form::text('search', request()->query('search'), ['class' => 'form-control form-control-sm', 'placeholder'=>'Search announcements']) }}
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <div>
                            <table class="table table-hover align-items-center">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">Title</th>
                                    <th scope="col">Content</th>
                                    <th scope="col">Start Date</th>
                                    <th scope="col">End Date</th>
                                    <th scope="col">Status</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody class="list">
                                @foreach($announcements as $announcement)
                             
                                    <tr>
                                        <td scope="row">
                                            {{ $announcement->title }}
                                        </td>
                                        <td class="budget">
                                            {{ Str::limit($announcement->content, 50) }}
                                        </td>
                                        <td>
                                            {{ $announcement->start_date }}
                                        </td>
                                        <td>
                                            {{ $announcement->end_date }}
                                        </td>
                                        <td>
                                            @if($announcement->is_active)
                                                <span class="badge badge-pill badge-lg badge-success">Active</span>
                                            @else
                                                <span class="badge badge-pill badge-lg badge-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @can('destroy-announcement')
                                            {!! Form::open(['route' => ['announcements.destroy', $announcement],'method' => 'delete',  'class'=>'d-inline-block dform']) !!}
                                            @endcan
                                            @can('view-announcement')
                                            <a class="btn btn-primary btn-sm m-1" data-toggle="tooltip" data-placement="top" title="View details" href="{{route('announcements.show', $announcement)}}">
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                            </a>
                                            @endcan
                                            @can('update-announcement')
                                            <a class="btn btn-info btn-sm m-1" data-toggle="tooltip" data-placement="top" title="Edit details" href="{{route('announcements.edit',$announcement)}}">
                                                <i class="fa fa-edit" aria-hidden="true"></i>
                                            </a>
                                            @endcan
                                            @can('destroy-announcement')
                                                <button type="submit" class="btn delete btn-danger btn-sm m-1" data-toggle="tooltip" data-placement="top" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            {!! Form::close() !!}
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="6">
                                        {{-- $announcements->links() --}}
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        jQuery(document).ready(function(){
            $('.delete').on('click', function(e){
                e.preventDefault();
                let that = jQuery(this);
                jQuery.confirm({
                    icon: 'fas fa-wind-warning',
                    closeIcon: true,
                    title: 'Are you sure!',
                    content: 'You can not undo this action.!',
                    type: 'red',
                    typeAnimated: true,
                    buttons: {
                        confirm: function () {
                            that.parent('form').submit();
                        },
                        cancel: function () {}
                    }
                });
            })
        })
    </script>
@endpush
