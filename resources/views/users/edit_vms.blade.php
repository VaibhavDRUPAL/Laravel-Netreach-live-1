@extends('layouts.app')
@push('pg_btn')
    <a href="{{ route('user.vms') }}" class="btn btn-sm btn-neutral">All Users</a>
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-body">
                    {!! Form::open(['route' => 'edit.store_vns', 'files' => true]) !!}
                    <h6 class="heading-small text-muted mb-4">User information</h6>

                    <div class="pl-lg-4">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('parent Name', 'Parent VN', ['class' => 'form-control-label']) }}
                                    {{ Form::select('parent_id', $vms_list, $vns_results->parent_id, ['class' => 'form-control', 'placeholder' => 'Select Parent...']) }}

                                </div>
                            </div>


                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('name', 'First Name', ['class' => 'form-control-label']) }}
                                    {{ Form::text('name', $vns_results->name, ['class' => 'form-control']) }}
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('name', 'Last Name', ['class' => 'form-control-label']) }}
                                    {{ Form::text('last_name', $vns_results->last_name, ['class' => 'form-control']) }}
                                </div>
                            </div>

                        </div>
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('email', 'E-mail', ['class' => 'form-control-label']) }}
                                    {{ Form::email('email', $vns_results->email, ['class' => 'form-control']) }}
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('phone_number', 'Phone number', ['class' => 'form-control-label']) }}
                                    {{ Form::text('phone_number', $vns_results->mobile_number, ['class' => 'form-control']) }}
                                </div>
                            </div>


                        </div>


                        <div class="row">



                            <div class="col-lg-6">
                                @php
                                    $selected_regions = json_decode($vns_results->regions_list, true);
                                @endphp
                                <div class="form-group">
                                    {{ Form::label('region', 'Region', ['class' => 'form-control-label']) }}
                                    {{ Form::select(
                                        'region[]',
                                        ['east' => 'East', 'west' => 'West', 'north' => 'North', 'south' => 'South'],
                                        $selected_regions,
                                        // $vns_results->region,
                                        ['class' => 'selectpicker form-control', 'multiple' => 'multiple', 'placeholder' => 'Select Region...'],
                                    ) }}
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('phone_number', 'Phone number', ['class' => 'form-control-label']) }}
                                    {{ Form::text('phone_number', $vns_results->mobile_number, ['class' => 'form-control']) }}
                                </div>
                            </div>


                        </div>


                        <div class="row">

                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('state', 'State', ['class' => 'form-control-label']) }}
                                    <?php
                                    $stateArr = explode(',', $vns_results->state_code);
                                    ?>
                                    @foreach ($state as $key => $val)
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="{{ $key }}"
                                                name="state[]" value="{{ $key }}"
                                                {{ in_array($key, $stateArr) ? 'checked' : '' }}>
                                            <label class="custom-control-label"
                                                for="{{ $key }}">{{ $val }}</label>
                                        </div>
                                    @endforeach

                                </div>
                            </div>


                        </div>




                    </div>


                    <!--<hr class="my-4" />-->
                    <div class="pl-lg-4">
                        <div class="row">

                            <div class="col-md-12">
                                <input type="hidden" value="{{ $id }}" name="update_id">
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
    <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
    <script>
        jQuery(document).ready(function() {
            jQuery('#uploadFile').filemanager('file');
        })
    </script>
@endpush
