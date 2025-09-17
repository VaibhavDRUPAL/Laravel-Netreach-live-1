@extends('layouts.app')
@push('pg_btn')
    <a href="{{ route('user.vms') }}" class="btn btn-sm btn-neutral">All Users</a>
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-body">
                    {!! Form::open(['route' => 'user.store_vms', 'files' => true]) !!}
                    <h6 class="heading-small text-muted mb-4">User information</h6>
                    <div class="pl-lg-4">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('parent Name', 'Parent VN', ['class' => 'form-control-label']) }}
                                    {{ Form::select('parent_id', $vms_list, null, ['class' => 'selectpicker form-control', 'placeholder' => 'Select Parent...']) }}

                                </div>
                            </div>


                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('name', 'First Name', ['class' => 'form-control-label']) }}
                                    {{ Form::text('name', null, ['class' => 'form-control']) }}
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('name', 'Last Name', ['class' => 'form-control-label']) }}
                                    {{ Form::text('last_name', null, ['class' => 'form-control']) }}
                                </div>
                            </div>

                        </div>
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('email', 'E-mail', ['class' => 'form-control-label']) }}
                                    {{ Form::email('email', null, ['class' => 'form-control']) }}
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('phone_number', 'Phone number', ['class' => 'form-control-label']) }}
                                    {{ Form::text('phone_number', null, ['class' => 'form-control']) }}
                                </div>
                            </div>


                        </div>


                        <div class="row">

                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('username', 'VNCODE', ['class' => 'form-control-label']) }}
                                    {{ Form::text('username', null, ['class' => 'form-control']) }}
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('region', 'Region', ['class' => 'form-control-label']) }}
                                    {{ Form::select('region[]', ['east' => 'East', 'west' => 'West', 'north' => 'North', 'south' => 'South'], null, ['class' => 'selectpicker form-control', 'multiple' => 'multiple', 'placeholder' => 'Select Region...']) }}
                                </div>

                            </div>


                        </div>


                        <div class="row">

                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('role', 'Select Role', ['class' => 'form-control-label']) }}
                                    {{ Form::select('role', $roles, null, ['class' => 'selectpicker form-control role-select', 'placeholder' => 'Select role...']) }}
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('state', 'State', ['class' => 'form-control-label']) }}
                                    {{-- {{ Form::select('state', $state, null, ['class' => 'selectpicker form-control', 'placeholder' => 'Select Region...']) }} --}}
                                    {{ Form::select('state[]', $state, null, ['class' => 'selectpicker form-control', 'multiple' => 'multiple', 'placeholder' => 'Select Region...' ,'id'=>'state']) }}

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
                    <!--<hr class="my-4" />-->
                    <div class="pl-lg-4">
                        <div class="row">

                            <div class="col-md-12">
                                {{ Form::submit('Submit', ['class' => 'mt-5 btn btn-primary']) }}
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
<script>
    jQuery(document).ready(function() {
     
        $('#role').on('changed.bs.select', function () {
            let obj=$(this)
            
    var selectedValue = $(obj).parent().find('.filter-option-inner-inner').text();
    if(selectedValue=="PO-Permission"){
        $('#state').prop('disabled', true);
        $('#state').val('')
        $('#state').siblings('button').find('.filter-option-inner-inner').text("Select Region...");
    }
    else{
        $('#state').prop('disabled', false);
    }
});
    })
</script>
    <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
    <script>
        jQuery(document).ready(function() {
            jQuery('#uploadFile').filemanager('file');
          
        })
    </script>
@endpush
