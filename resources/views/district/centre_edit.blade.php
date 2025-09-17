@extends('layouts.app')
@push('pg_btn')

    @section('content')
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-5">
                    <div class="card-body">
                        <h6 class="heading-small text-muted mb-4">{{ $title }} </h6>

                        {!! Form::open(['route' => 'edit.center']) !!}
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('centre_name', 'Centre Name', ['class' => 'form-control-label']) }}
                                        {{ Form::text('centre_name', $centre->name, ['class' => 'form-control']) }}
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('address', 'Address', ['class' => 'form-control-label']) }}
                                        {{ Form::textarea('address', $centre->address, ['class' => 'form-control']) }}
                                    </div>
                                </div>

                            </div>
                        </div>



                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('Pin Code', 'Pin code', ['class' => 'form-control-label']) }}
                                        {{ Form::text('pin_code', $centre->pin_code, ['class' => 'form-control']) }}
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('State', 'State', ['class' => 'form-control-label']) }}

                                        {{ Form::select('state_id', $state, $centre->state_code, ['id' => 'state_code', 'class' => 'form-control', 'placeholder' => 'Select State...']) }}
                                    </div>
                                </div>

                            </div>
                        </div>



                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('district', 'District', ['class' => 'form-control-label']) }}
                                        <select class="form-control" name="district_id" id="district_id"
                                            value="{{ $centre->district_id }}">
                                            <option value="{{ $centre->district_id }}">{{ $centre->district_name }}</option>
                                        </select>

                                    </div>
                                </div>


                                <div class="col-lg-6">
                                    @if ($userType == 2)
                                    @else
                                        <div class="form-group">
                                            {{ Form::label('Name Of VN', 'Name Of VN', ['class' => 'form-control-label']) }}
                                            {{ Form::select('name_counsellor', $vn, $centre->name_counsellor ?? null, ['class' => 'selectpicker form-control', 'placeholder' => 'Select VN...', 'id' => 'name']) }}

                                        </div>
                                    @endif
                                </div>


                            </div>
                        </div>





                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('Services Available', 'Services Available', ['class' => 'form-control-label']) }}

                                        <?php $ServicesAvailableArr = explode(',', $centre->services_avail); ?>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="HIV_Test" name="seravail[]"
                                                value="1" <?php echo in_array(1, $ServicesAvailableArr) ? 'checked' : ''; ?>>
                                            <label class="custom-control-label" for="HIV_Test">HIV Test</label>
                                        </div>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" value="2" name="seravail[]"
                                                id="STI_Services" <?php echo in_array(2, $ServicesAvailableArr) ? 'checked' : ''; ?>>
                                            <label class="custom-control-label" for="STI_Services">STI Services</label>
                                        </div>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" value="3" name="seravail[]"
                                                id="PrEP" <?php echo in_array(3, $ServicesAvailableArr) ? 'checked' : ''; ?>>
                                            <label class="custom-control-label" for="PrEP">PrEP</label>
                                        </div>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" value="4" name="seravail[]"
                                                id="Counselling_for_Mental_Healt" <?php echo in_array(4, $ServicesAvailableArr) ? 'checked' : ''; ?>>
                                            <label class="custom-control-label" for="Counselling_for_Mental_Healt">Counselling
                                                for Mental Health</label>
                                        </div>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" value="5" name="seravail[]"
                                                id="Referral_to_TI_services" <?php echo in_array(5, $ServicesAvailableArr) ? 'checked' : ''; ?>>
                                            <label class="custom-control-label" for="Referral_to_TI_services">Referral to TI
                                                services</label>
                                        </div>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" value="6" name="seravail[]"
                                                id="ART_Linkages" <?php echo in_array(6, $ServicesAvailableArr) ? 'checked' : ''; ?>>
                                            <label class="custom-control-label" for="ART_Linkages">ART Linkages</label>
                                        </div>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" value="7" name="seravail[]"
                                                id="Others" <?php echo in_array(7, $ServicesAvailableArr) ? 'checked' : ''; ?>>
                                            <label class="custom-control-label" for="Others">Others</label>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-lg-6">

                                    <div class="form-group">
                                        {{ Form::label('Facility', 'Facility ', ['class' => 'form-control-label']) }}

                                        <?php $FacultyArr = explode(',', $centre->services_available); ?>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="ICTC" value="1"
                                                name="faculty[]" <?php echo in_array(1, $FacultyArr) ? 'checked' : ''; ?>>
                                            <label class="custom-control-label" for="ICTC">ICTC</label>
                                        </div>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="FICTC"
                                                name="faculty[]" value="2" <?php echo in_array(2, $FacultyArr) ? 'checked' : ''; ?>>
                                            <label class="custom-control-label" for="FICTC">FICTC</label>
                                        </div>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="ART"
                                                name="faculty[]" value="3" <?php echo in_array(3, $FacultyArr) ? 'checked' : ''; ?>>
                                            <label class="custom-control-label" for="ART">ART</label>
                                        </div>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="TI"
                                                name="faculty[]" value="4" <?php echo in_array(4, $FacultyArr) ? 'checked' : ''; ?>>
                                            <label class="custom-control-label" for="TI">TI</label>
                                        </div>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="Private_lab"
                                                name="faculty[]" value="5" <?php echo in_array(5, $FacultyArr) ? 'checked' : ''; ?>>
                                            <label class="custom-control-label" for="Private_lab">Private lab</label>
                                        </div>


                                    </div>
                                </div>


                            </div>
                        </div>



                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('Centre Contact No', 'Centre Contact No', ['class' => 'form-control-label']) }}
                                        {{ Form::text('centre_contact_no', $centre->centre_contact_no ?? '', ['class' => 'form-control']) }}
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('Name of the ICTC Incharge / Medical Officer', '	Name of the ICTC Incharge / Medical Officer', ['class' => 'form-control-label']) }}
                                        {{ Form::text('incharge', $centre->incharge ?? '', ['class' => 'form-control']) }}
                                    </div>
                                </div>

                            </div>
                        </div>



                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="hidden" name="cen_id" value="{{ $id }}" />
                                    {{ Form::submit('Submit', ['class' => 'mt-5 btn btn-primary']) }}
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>

            {{-- add centre user start --}}
            <div class="col-md-12" hidden>
                <div class="card mb-5">
                    <div class="card-header bg-transparent">
                        <h3 class="mb-0">CENTRE USER</h3>
                    </div>
                    <div class="card-body">
                        {{-- {!! Form::open(['route' => 'users.store', 'files' => true]) !!} --}}
                        <h6 class="heading-small text-muted mb-4">USER INFORMATION</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('user_email', 'E-mail', ['class' => 'form-control-label']) }}
                                        {{ Form::email('user_email', $email, ['class' => 'form-control', 'required']) }}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('password', 'Password', ['class' => 'form-control-label']) }}
                                        {{-- {{ Form::text('password',$password, ['class' => 'form-control']) }}  --}}
                                        <input type="password" name="password" id="password" class="form-control"
                                            value="{{ $password }}">
                                        <div class="custom-control custom-checkbox  my-2">
                                            <input type="checkbox" name="show-password" id="show-password"
                                                class="custom-control-input"> <!-- Checkbox to toggle password visibility -->
                                            {{-- <label for="show-password">Show Password</label> --}}
                                            {{ Form::label('show-password', 'Show Password', ['class' => 'custom-control-label']) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-4" />
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="user_status" value="1"
                                            class="custom-control-input" id="user_status" @checked($status)>
                                        {{ Form::label('user_status', 'User Status', ['class' => 'custom-control-label']) }}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <input type="hidden" name="cen_id" value="{{ $id }}" />
                                    <input type="hidden" name="user_id" value="{{ $centre->user_id }}" />
                                    {{ Form::submit('Submit', ['class' => 'mt-5 btn btn-primary']) }}
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        {{-- add centre user end --}}
    @endsection
    @push('scripts')
        <script>
            setTimeout(function() {
                getCityByStateCode(<?php echo $centre->state_code; ?>, <?php echo $centre->district_id; ?>);
            }, 1000);

            $("#state_code").change(function() {
                getCityByStateCode($(this).val());
            })

            function getCityByStateCode(std_code, district_id) {
                var DataJson = {
                    "_token": "{{ csrf_token() }}",
                    "std_code": std_code,
                    "district_id": district_id
                }

                $.ajax({
                    type: "POST",
                    url: "{{ route('city.state') }}",
                    data: DataJson,
                    dataType: "json",
                    success: function(data) {

                        //alert("sdfsdf");
                        $("#district_id").html(data.resultsHtml);
                    }

                });
                //alert(std_code);
            }
            $(document).ready(function() {
                $('#show-password').change(function() {
                    var isChecked = $(this).is(':checked');
                    $('#password').attr('type', isChecked ? 'text' : 'password');
                });
            });
        </script>
    @endpush
