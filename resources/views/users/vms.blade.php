@extends('layouts.app')
@push('pg_btn')
    @can('create-vm')
        <a href="{{ route('user.vms.create') }}" class="btn btn-sm btn-neutral">Create New User VMS</a>
    @endcan
@endpush
@section('content')
    <style>
        .table-responsive {
            overflow-x: auto;
        }

        /* Make the first column sticky */
        .table thead th:first-child,
        .table tbody td:first-child {
            position: sticky;
            left: 0;
            background-color: #4ad2ff36;
            backdrop-filter: blur(20px);
            z-index: 2;
        }

        /* Optional: Add a border to separate the sticky column */
        .table thead th:first-child {
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }
    </style>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-header bg-transparent">
                    <div class="row">
                        <div class="col-lg-8">
                            <h3 class="mb-0">All PO/CO/VN</h3>
                            <input id="activeCheck" type="checkbox" class="mr-2">All Users
                        </div>
                        <div class="col-lg-4">
                            {!! Form::open(['route' => 'user.vms', 'method' => 'get']) !!}
                            <div class="form-group mb-0">
                                {{ Form::text('search', request()->query('search'), ['class' => 'form-control form-control-sm', 'placeholder' => 'Search VN']) }}
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
                                        <th scope="col">Name</th>
                                        <th scope="col">Last Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">VM Code</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">State</th>
                                        <th scope="col">Region</th>
                                        <th scope="col">Link</th>
                                        <th scope="col">Old Link</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Password</th>
                                        <th scope="col">Action</th>

                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @foreach ($vms_list as $key => $list)
                                        <?php
                                        $state_name = '';
                                        if (!empty($list->state_code)) {
                                            $state_codeArr = explode(',', $list->state_code);
                                            $results = App\Models\StateMaster::getStateName($state_codeArr);
                                            if ($results->count() > 0) {
                                                foreach ($results as $key => $val) {
                                                    $state_name .= $val->state_name . ' ,';
                                                }
                                            }
                                        }
                                        ?>
                                        <tr class="status-{{ $list->status == 1 ? 'active' : 'inactive' }}">
                                            <td>{{ $list->name }}</td>
                                            <td>{{ $list->last_name }}</td>
                                            <td>{{ $list->email }}</td>
                                            <td>{{ $list->vncode }}</td>
                                            <td>{{ $list->mobile_number }}</td>
                                            <td>{{ rtrim($state_name, ',') }}</td>
                                            <td>
                                                @php
                                                    $regions = json_decode($list->regions_list, true);
                                                    $region_list = is_array($regions)
                                                        ? strtoupper(implode(', ', $regions))
                                                        : strtoupper($list->region);
                                                @endphp
                                                {{$region_list}}
                                                {{-- {{ strtoupper($list->region) }}</td> --}}
                                            <td>{{ route('self.sra', ['key' => $list->link_name]) }} </td>
                                            <td>{{ route('self.sra', ['key' => urlencode(base64_encode($list->link_name))]) }}
                                            </td>
                                            <td>
                                                @if ($list->status == 1)
                                                    <a href="javascript:;" class="btn btn-sm btn-info  mr-4 "
                                                        onclick="return userStatus({{ $list->id }},'DeActive');">Active</a>
                                                @else
                                                    <a href="javascript:;" class="btn btn-sm btn-danger  mr-4 "
                                                        onclick="return userStatus({{ $list->id }},'Active');">Inactive</a>
                                                @endif
                                            </td>
                                            <td>{{ $list->txt_password }}</td>
                                            <td>
                                                @can('update-user')
                                                    <a class="btn btn-info btn-sm m-1" data-toggle="tooltip"
                                                        data-placement="top" title="Edit Vn details"
                                                        href="{{ route('vn.edit', $list->id) }}">
                                                        <i class="fa fa-edit" aria-hidden="true"></i>
                                                    </a>

                                                    <a class="btn btn-info btn-sm m-1" data-toggle="tooltip"
                                                        data-placement="top" title="Password"
                                                        href="{{ route('vn.pass', $list->id) }}">
                                                        <i class="fa fa-key" aria-hidden="true"></i>
                                                    </a>
                                                @endcan
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="6">
                                            {{-- {{ $vms_list->links() }} --}}
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
        $(document).ready(function() {
            $(".status-inactive").hide()
            $('#activeCheck').on('click', function() {

                if ($("#activeCheck").is(":checked")) {
                    $(".status-inactive").show()
                } else {
                    $(".status-inactive").hide()
                }

            })

        })
    </script>






    <script>
        function userStatus(ursid, type) {

            var con = confirm("Are you sure? you want to change status?");
            if (!con)
                return false;

            var jsonData = {
                "_token": "{{ csrf_token() }}",
                "ursid": ursid,
                "type": type
            }
            $.ajax({
                type: 'POST',
                url: "{{ route('usr.staus.update') }}",
                data: jsonData,
                dataType: "json",
                success: (data) => {
                    window.location.href = window.location.href;
                },
                error: function(data) {}
            });
        }
    </script>
@endpush
