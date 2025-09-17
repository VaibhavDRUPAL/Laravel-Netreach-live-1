@extends('layouts.app')
@push('pg_btn')
    <a href="{{ route('all.centre.index') }}" class="btn btn-sm btn-neutral">All Centers</a>
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-body">
                    <h6 class="heading-small text-muted mb-4">{{$title}}</h6>

                    <div class="card-body">
                        {!! Form::open(['route' => 'center.add_center']) !!}
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('centre_name', 'Centre Name *', ['class' => 'form-control-label']) }}
                                        {{ Form::text('centre_name', null, ['class' => 'form-control', 'required']) }}
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('address', 'Address', ['class' => 'form-control-label']) }}
                                        {{ Form::textarea('address', null, ['class' => 'form-control']) }}
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('Pin Code', 'Pin code *', ['class' => 'form-control-label']) }}
                                        {{ Form::text('pin_code', null, ['class' => 'form-control', 'required']) }}
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('State', 'State *', ['class' => 'form-control-label', 'required']) }}

                                        {{ Form::select('state_id', $state, null, ['class' => 'selectpicker form-control', 'placeholder' => 'Select state...', 'id' => 'state_code']) }}
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('district', 'District *', ['class' => 'form-control-label', 'required']) }}

                                        <select class="form-control" name="district_id" id="district_id" required>
                                        </select>

                                    </div>
                                </div>


                                <div class="col-lg-6">
                                    @if ($userType == 2)
                                    @else
                                        <div class="form-group">
                                            {{ Form::label('Name Of VN', 'Name Of VN', ['class' => 'form-control-label']) }}
                                            {{ Form::select('name_counsellor', $vn, null, ['class' => 'selectpicker form-control', 'placeholder' => 'Select vn...', 'id' => 'name']) }}

                                        </div>
                                    @endif

                                </div>


                            </div>
                        </div>

                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('Services Available', 'Services Available *', ['class' => 'form-control-label']) }}


                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="HIV_Test"
                                                name="seravail[]" value="1">
                                            <label class="custom-control-label" for="HIV_Test">HIV Test</label>
                                        </div>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" value="2"
                                                name="seravail[]" id="STI_Services">
                                            <label class="custom-control-label" for="STI_Services">STI Services</label>
                                        </div>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" value="3"
                                                name="seravail[]" id="PrEP">
                                            <label class="custom-control-label" for="PrEP">PrEP</label>
                                        </div>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" value="4"
                                                name="seravail[]" id="Counselling_for_Mental_Healt">
                                            <label class="custom-control-label"
                                                for="Counselling_for_Mental_Healt">Counselling
                                                for Mental Health</label>
                                        </div>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" value="5"
                                                name="seravail[]" id="Referral_to_TI_services">
                                            <label class="custom-control-label" for="Referral_to_TI_services">Referral to TI
                                                services</label>
                                        </div>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" value="6"
                                                name="seravail[]" id="ART_Linkages">
                                            <label class="custom-control-label" for="ART_Linkages">ART Linkages</label>
                                        </div>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" value="7"
                                                name="seravail[]" id="Others">
                                            <label class="custom-control-label" for="Others">Others</label>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-lg-6">

                                    <div class="form-group">
                                        {{ Form::label('Facility', 'Facility *', ['class' => 'form-control-label']) }}

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="ICTC"
                                                value="1" name="faculty[]">
                                            <label class="custom-control-label" for="ICTC">ICTC</label>
                                        </div>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="FICTC"
                                                name="faculty[]" value="2">
                                            <label class="custom-control-label" for="FICTC">FICTC</label>
                                        </div>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="ART"
                                                name="faculty[]" value="3">
                                            <label class="custom-control-label" for="ART">ART</label>
                                        </div>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="TI"
                                                name="faculty[]" value="4">
                                            <label class="custom-control-label" for="TI">TI</label>
                                        </div>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="Private_lab"
                                                name="faculty[]" value="5">
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
                                        {{ Form::text('centre_contact_no', '', ['class' => 'form-control']) }}
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('Name of the ICTC Incharge / Medical Officer', ' Name of the ICTC Incharge / Medical Officer', ['class' => 'form-control-label']) }}
                                        {{ Form::text('incharge', '', ['class' => 'form-control']) }}
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="pl-lg-4">
                            <div class="row">
                                <!-- <div class="col-md-12">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="status" class="custom-control-input" id="status">
                                                {{ Form::label('status', 'Status', ['class' => 'custom-control-label']) }}
                                            </div>
                                        </div> -->
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
        $(document).ready(function() {
            $('#state_code').change(function() {
                var state_id = $(this).val();

                var DataJson = {
                    "_token": "{{ csrf_token() }}",
                    "std_code": state_id
                }

                $.ajax({
                    type: "POST",
                    url: "{{ route('district.state') }}",
                    data: (DataJson),
                    dataType: "json",
                    success: function(data) {
                        $("#district_id").html(data.resultsHtml);
                    }
                });
            });
        });
    </script>
@endpush
