@extends('layouts.app')
@push('pg_btn')
    <a href="{{route('users.index')}}" class="btn btn-sm btn-neutral">All Users</a>
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-body">
                    {!! Form::open(['route' => 'users.store', 'files' => true]) !!}
                    <h6 class="heading-small text-muted mb-4">User information</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('name', 'Name', ['class' => 'form-control-label']) }}
                                        {{ Form::text('name', null, ['class' => 'form-control']) }}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('email', 'E-mail', ['class' => 'form-control-label']) }}
                                        {{ Form::email('email', null, ['class' => 'form-control' , 'required']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('phone_number', 'Phone number', ['class' => 'form-control-label']) }}
                                        {{ Form::text('phone_number', null, ['class' => 'form-control', 'required']) }}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('profile_photo', 'Photo', ['class' => 'form-control-label']) }}
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
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('role', 'Select Role', ['class' => 'form-control-label']) }}
                                        {{ Form::select('role', $roles, null, ['class' => 'selectpicker form-control', 'placeholder' => 'Select role...', 'id' => 'role']) }}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                     <div class="form-group">
                                        {{ Form::label('bio', 'Bio', ['class' => 'form-control-label']) }}
                                        {{ Form::textarea('bio', null, ['class' => 'form-control','rows'=>1]) }}
                                    </div>
                                </div>
                                <div class="col-lg-6 test-fields" style="display: none;">
                                    <div class="form-group">
                                        {{ Form::label('referred_state_id', 'Referred centre state', ['class' => 'form-control-label']) }}
                                        {{ Form::select('referred_state_id', $states, null, [ 'class'=> 'selectpicker form-control', 'placeholder' => 'Select state...', 'required'=>true, 'id' => 'referred_state_id']) }}
                                    </div>
                                </div>
                                <div class="col-lg-6 test-fields" style="display: none;">
                                    <div class="form-group">
                                        {{ Form::label('referred_district_id', 'Referred centre district', ['class' => 'form-control-label']) }}
                                        {{ Form::select('referred_district_id', [], null, [ 'class'=> 'form-control', 'placeholder' => 'Select choice...', 'required'=>true, 'disabled'=> true, 'id' => 'referred_district_id']) }}
                                    </div>
                                </div>
                                <div class="col-lg-6 test-fields" style="display: none;">
                                    <div class="form-group">
                                        {{ Form::label('test_center_id', 'Name and address of centre', ['class' => 'form-control-label']) }}
                                        {{ Form::select('test_center_id', [], null, ['class' => 'form-control', 'required'=>true, 'disabled'=> true, 'id' => 'test_center_id']) }}
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
                                        <input type="checkbox" name="status" value="1" class="custom-control-input" id="status">
                                        {{ Form::label('status', 'Status', ['class' => 'custom-control-label']) }}
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
@endsection

@push('scripts')
    <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
    <script>
        jQuery(document).ready(function(){
            // jQuery('#uploadFile').filemanager('file');

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

            $('#referred_state_id').on('change', function() {
                getDistricts(this, '#referred_district_id', '#test_center_id');
            });

            $('#test_centre_state_id').on('change', function() {
                getDistricts(this, '#test_centre_district_id', '#service_accessed_center_id');
            });

            $('#referred_district_id, #test_centre_district_id').on('change',function() {
                var id = $(this).val(), input = $(this);
                if($(input).attr('id') == 'referred_district_id')
                    $('#test_center_id').attr('disabled', true);
                else if($(input).attr('id') == 'test_centre_district_id')
                    $('#service_accessed_center_id').attr('disabled', true);

                $.ajax({
                    url : "/get-centres",
                    method : 'GET',
                    dataType : 'json',
                    data : {
                        'district_id' : id
                    },
                    success : function(data) {
                        var html = '<option selected hidden>---Select Center---</option>';
                        $.each(data.data,function(key,val) {
                            var name = val.name;
                            if(val.address != null) name += ', ' + val.address;
                            html += '<option value="'+val.id+'">'+ name + '</option>'
                        });
                        if($(input).attr('id') == 'referred_district_id') {
                            $('#test_center_id').empty();
                            $('#test_center_id').append(html);
                            $('#test_center_id').attr('disabled', false);
                        } else if($(input).attr('id') == 'test_centre_district_id') {
                            $('#service_accessed_center_id').empty();
                            $('#service_accessed_center_id').append(html);
                            $('#service_accessed_center_id').attr('disabled', false);
                        }
                    }
                });
            });
        });

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
