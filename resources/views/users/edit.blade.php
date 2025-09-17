@extends('layouts.app')
@push('pg_btn')
    <a href="{{route('users.index')}}" class="btn btn-sm btn-neutral">All Users</a>
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-body">
                    @can('update-user')
                    {!! Form::open(['route' => ['users.update', $user], 'method'=>'put', 'files' => true]) !!}
                    @endcan
                    <h6 class="heading-small text-muted mb-4">User information</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('name', 'Name', ['class' => 'form-control-label']) }}
                                        {{ Form::text('name', $user->name, ['class' => 'form-control']) }}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('email', 'E-mail', ['class' => 'form-control-label']) }}
                                        {{ Form::email('email', $user->email, ['class' => 'form-control']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('phone_number', 'Phone number', ['class' => 'form-control-label']) }}
                                        {{ Form::text('phone_number', $user->phone_number, ['class' => 'form-control']) }}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {{ Form::label('profile_photo', 'Photo', ['class' => 'form-control-label d-block']) }}
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                              <a id="uploadFile" data-input="thumbnail" data-preview="holder" class="btn btn-secondary">
                                                <i class="fa fa-picture-o"></i> Choose Photo
                                              </a>
                                            </span>
                                            <input id="thumbnail" class="form-control d-none" type="text" name="profile_photo">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    @if ($user->profile_photo)
                                        <a href="{{ asset($user->profile_photo) }}" target="_blank">
                                            <img alt="Image placeholder"
                                            class="avatar avatar-xl  rounded-circle"
                                            data-toggle="tooltip" data-original-title="{{ $user->name }} Logo"
                                            src="{{ asset($user->profile_photo) }}">
                                        </a>
                                    @endif
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('role', 'Select Role', ['class' => 'form-control-label']) }}
                                        {{ Form::select('role', $roles, $userRoleId, [ 'class'=> 'selectpicker form-control', 'placeholder' => 'Select role...', 'id' => 'role']) }}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                     <div class="form-group">
                                        {{ Form::label('bio', 'Bio', ['class' => 'form-control-label']) }}
                                        {{ Form::textarea('bio', $user->bio, ['class' => 'form-control','rows'=>1]) }}
                                    </div>
                                </div>
                                <div class="col-lg-6 test-fields" style="display: none;">
                                    <div class="form-group">
                                        {{ Form::label('center_state_id', 'Referred centre state', ['class' => 'form-control-label']) }}
                                        {{ Form::select('center_state_id', $states,  $centerState, [ 'class'=> 'selectpicker form-control', 'placeholder' => 'Select state...', 'id' => 'center_state_id']) }}
                                    </div>
                                </div>
                                <div class="col-lg-6 test-fields" style="display: none;">
                                    <div class="form-group">
                                        {{ Form::label('center_district_id', 'Referred centre district', ['class' => 'form-control-label']) }}
                                        {{ Form::select('center_district_id', $districts, $centre->district_id, [ 'class'=> 'form-control', 'placeholder' => 'Select district...', 'id' => 'center_district_id']) }}
                                    </div>
                                </div>
                                <div class="col-lg-6 test-fields" style="display: none;">
                                    <div class="form-group">
                                        {{ Form::label('test_center_id', 'Name and address of centre', ['class' => 'form-control-label']) }}
                                        {{ Form::select('test_center_id',$centers , $centre->id, ['class' => 'form-control', 'placeholder' => 'Select centre...' , 'id' => 'test_center_id']) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-4" />
                        <!-- Address -->
                        <h6 class="heading-small text-muted mb-4">Password information</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('password', 'Password', ['class' => 'form-control-label']) }}
                                        {{ Form::password('password', ['class' => 'form-control']) }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('password_confirmation', 'Confirm password', ['class' => 'form-control-label']) }}
                                        {{ Form::password('password_confirmation', ['class' => 'form-control']) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-4" />
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="custom-control custom-checkbox">
                                        {!! Form::hidden('status', 0) !!}
                                        <input type="checkbox" name="status" value="1" {{ $user->status ? 'checked' : ''}} class="custom-control-input" id="status">
                                        {{ Form::label('status', 'Status', ['class' => 'custom-control-label']) }}
                                    </div>
                                </div>
                                @can('update-user')
                                <div class="col-md-12">
                                    {{ Form::submit('Submit', ['class'=> 'mt-5 btn btn-primary']) }}
                                </div>
                                @endcan
                            </div>
                        </div>
                    @can('update-user')
                    {!! Form::close() !!}
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
    <script>
        jQuery(document).ready(function(){
            // $('#uploadFile').filemanager('file');

            function toggleReferralFields() {
                var selectedRole = $('#role').val();
                var roleName = $('#role option:selected').text();

                if (roleName.toLowerCase() === 'center user' || roleName.toLowerCase() === 'cbo partner') {
                    $('.test-fields').show();
                    $('.test-fields select').attr('required', true);
                } else {
                    $('.test-fields').hide();
                    $('.test-fields select').attr('required', false);
                }
            }

            // Initial call to ensure correct state on page load
            toggleReferralFields();

            // Attach change event listener to role select
            $('#role').on('change', function() {
                toggleReferralFields();
            });

            $('#center_state_id').on('change', function() {
                getDistricts(this, '#center_district_id', '#test_center_id');
            });

            $('#center_district_id').on('change',function() {
                var id = $(this).val();
                $.ajax({
                    url : "/get-centres",
                    method : 'GET',
                    dataType : 'json',
                    data : { 'district_id' : id },
                    success : function(data) {
                        var html = '<option selected hidden>---Select Center---</option>';
                        $.each(data.data, function(key, val) {
                            var name = val.name;
                            if(val.address != null) name += ', ' + val.address;
                            html += '<option value="'+val.id+'">'+ name + '</option>'
                        });
                        $('#test_center_id').empty();
                        $('#test_center_id').append(html);
                        $('#test_center_id').attr('disabled', false);
                    }
                });
            });
        });

        function getCentres(input, appendTo) {
            $(appendTo).attr('disabled', true);
            var id = $(input).val();
            
            $.ajax({
                url : "/get-centres",
                method : 'GET',
                dataType : 'json',
                data : { 'district_id' : id },
                success : function(data) {
                    var html = '<option selected hidden>---Select Center---</option>';
                    $.each(data.data, function(key, val) {
                        var name = val.name;
                        if(val.address != null) name += ', ' + val.address;
                        html += '<option value="'+val.id+'">'+ name + '</option>'
                    });
                    $(appendTo).empty();
                    $(appendTo).append(html);
                    $(appendTo).attr('disabled', false);
                }
            });
        }

        function getDistricts(input, appendTo, center) {
            $(appendTo).attr('disabled', true);

            if($(input).attr('id') == 'referred_state_id')
                $('#test_center_id').attr('disabled', true);
            else if($(input).attr('id') == 'test_centre_state_id')
                $('#service_accessed_center_id').attr('disabled', true);

            var id = $(input).val(), district = $(appendTo).attr('data-district');
            $.ajax({
                url : "/district/getAll",
                method : 'GET',
                dataType : 'json',
                data : {
                    'state_code' : id
                },
                success : function(data) {
                    var html = '<option selected hidden value="">---Select District---</option>';
                    $.each(data.data,function(key,val) {
                        var select = district != undefined && district == val.id ? " selected" : "";
                        html += '<option value="'+ val.id +'"'+ select +'>'+ val.district_name +'</option>';
                    });
                    $(appendTo).empty();
                    $(appendTo).append(html);
                    $(appendTo).attr('disabled', false);
                    $(center).empty();
                }
            });
        }
    </script>
@endpush
