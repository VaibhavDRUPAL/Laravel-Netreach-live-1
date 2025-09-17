@extends('layouts.app')
@push('pg_btn')
    <a href="{{ route('outreach.plhiv.index') }}" class="btn btn-sm btn-neutral">All PLHIV Tests</a>
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-body main-form-card">
                    @if (isset($plhiv))
                        {{ Form::model($plhiv, ['route' => ['outreach.plhiv.update', $plhiv], 'method' => 'put']) }}
                    @else
                        {{ Form::open(['route' => 'outreach.plhiv.store']) }}
                    @endif
                    <div class="pl-lg-4">
                        <input type="hidden" name="profile_id" value="{{ $profileID }}">
                        @isset($referral)
                            <input type="hidden" name="referral_service_id" value="{{ $referral['referral_service_id'] }}">
                        @endisset
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('unique_serial_number', 'Unique serial number', ['class' => 'form-control-label']) }}
                                    {{ Form::text('unique_serial_number', isset($unique_serial_number) ? urldecode($unique_serial_number) : '', ['class' => 'form-control', 'readonly' => true]) }}
                                </div>
                            </div>
                        </div>

                        {{-- <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="client_type_id" class="form-control-label">Client Type</label>
                                        <select name="client_type_id" id="client_type_id" class="form-control" required>
                                            <option value="" selected hidden disabled>--- Select Client Type ---</option>
                                            @foreach ($CLIENT_TYPE as $item)
                                                <option value="{{ $item?->client_type_id }}" @selected((isset($exists) && $exists == $item?->client_type_id) || (isset($plhiv) && $item?->client_type_id == $plhiv?->client_type_id) || (old('client_type_id') == $item?->client_type_id))>{{ $item?->client_type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div> --}}
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('pid_or_other_unique_id_of_the_service_center', 'PID Number', ['class' => 'form-control-label']) }}
                                    {{ Form::text('pid_or_other_unique_id_of_the_service_center', isset($referral['pid_or_other_unique_id_of_the_service_center']) ? $referral['pid_or_other_unique_id_of_the_service_center'] : null, ['class' => 'form-control', 'readonly']) }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('name_of_the_client', 'Name of client', ['class' => 'form-control-label']) }}
                                    {{ Form::text('name_of_the_client', $profile['profile_name'], ['class' => 'form-control', 'readonly' => true]) }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    @php
                                        if (isset($plhiv)) {
                                            $date = $plhiv['date_of_accessing_service'];
                                        } elseif (isset($referral)) {
                                            $date = $referral['date_of_accessing_service'];
                                        } else {
                                            $date = old('date_of_accessing_service');
                                        }
                                    @endphp
                                    {{-- {{ Form::label('date_of_confirmatory', 'HIV confirmatory test date', ['class' => 'form-control-label']) }} --}}
                                    {{-- {{ Form::date('date_of_confirmatory', $date, ['class' => 'form-control', 'readonly' => true]) }} --}}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                @empty(!$profile)
                                    <input type="hidden" name="profile_registration_date"
                                        value="{{ $profile['registration_date'] }}">
                                @endempty
                                <div class="form-group">
                                    {{ Form::label('date_of_art_reg', 'Date of ART registration', ['class' => 'form-control-label']) }}
                                    {{ Form::date('date_of_art_reg', null, ['class' => 'form-control']) }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('pre_art_reg_number', 'Pre-ART Registration Number', ['class' => 'form-control-label']) }}
                                    {{ Form::text('pre_art_reg_number', null, ['class' => 'form-control']) }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('date_of_on_art', 'Date of ON ART', ['class' => 'form-control-label']) }}
                                    {{ Form::date('date_of_on_art', null, ['class' => 'form-control']) }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('on_art_reg_number', 'ON ART Registration Number', ['class' => 'form-control-label']) }}
                                    {{ Form::text('on_art_reg_number', null, ['class' => 'form-control']) }}
                                </div>
                            </div>
                        </div>
                        {{-- <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('type_of_facility_where_treatment_sought', 'Type of facility where treatment sought', ['class' => 'form-control-label']) }}
                                        {{ Form::select('type_of_facility_where_treatment_sought', $TYPE_FACILITY, null, [ 'class'=> 'form-control', 'placeholder' => 'Select facility...', 'required'=>true]) }}
                                    </div>
                                </div>
                            </div> --}}
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('art_state_id', 'ART Centre State', ['class' => 'form-control-label']) }}
                                    {{ Form::select('art_state_id', $states, null, ['class' => 'form-control', 'placeholder' => 'Select state...', 'required' => true, 'data-state' => isset($plhiv) ? $plhiv['art_state_id'] : old('art_state_id')]) }}
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('art_district_id', 'ART Centre District', ['class' => 'form-control-label']) }}
                                    {{ Form::select('art_district_id', [], null, ['class' => 'form-control', 'placeholder' => 'Select district...', 'required' => true, 'disabled' => true, 'data-district' => isset($plhiv) ? $plhiv['art_district_id'] : old('art_district_id')]) }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('art_center_id', 'ART Centre Name', ['class' => 'form-control-label']) }}
                                    {{ Form::select('art_center_id', [], null, ['class' => 'form-control', 'required' => true, 'disabled' => true, 'data-center' => isset($plhiv) ? $plhiv['art_center_id'] : old('art_center_id')]) }}
                                </div>
                            </div>
                        </div>
                        {{-- <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('remarks', 'Remarks', ['class' => 'form-control-label']) }}
                                        {{ Form::text('remarks', null, ['class' => 'form-control']) }}
                                    </div>
                                </div>
                            </div> --}}
                        @if (isset($plhiv) && isset($canTakeAction) && $canTakeAction)
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('status', 'Take action', ['class' => 'form-control-label']) }}
                                        {{ Form::select('status', [2 => 'Accept', 3 => 'Reject'], null, ['class' => 'form-control', 'placeholder' => 'Select choice...']) }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="pl-lg-4">
                        <div class="row">
                            <div class="col-md-12">
                                {{ Form::submit('Save', ['class' => 'mt-5 btn btn-primary']) }}
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
    {{-- <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script> --}}
    <script>
        function getDistricts() {
            $('#art_district_id').attr('disabled', true);
            var id = $('#art_state_id').val(),
                district = $('#art_district_id').attr('data-district');
            $.ajax({
                url: "/district/getAll",
                method: 'GET',
                dataType: 'json',
                data: {
                    'state_code': id
                },
                success: function(data) {
                    var html = '<option selected hidden value="">---Select Center---</option>';
                    $.each(data.data, function(key, val) {
                        var select = district == val.id ? " selected" : "";
                        html += '<option value="' + val.id + '"' + select + '>' + val.district_name +
                            '</option>';
                    });
                    $('#art_district_id').empty();
                    $('#art_district_id').append(html);
                    $('#art_district_id').attr('disabled', false);
                }
            });
        }

        function getCenters() {
            $('#art_center_id').attr('disabled', true);
            $.ajax({
                url: "/getTestingCenters",
                method: "GET",
                dataType: "JSON",
                data: {
                    district: $('#art_district_id').val()
                },
                success: function(data) {
                    if (data.status == 200) {
                        var center = $('#art_center_id').attr('data-center');
                        var option = "<option hidden selected value=''>--- Select Testing Center ---</option>";
                        $(data.data).each(function(key, val) {
                            var name = val.name;
                            if (val.address != null) name += ', ' + val.address;
                            var select = center == val.id ? " selected" : "";
                            option += '<option value="' + val.id + '"' + select + '>' + name +
                                '</option>';
                        })
                        $('#art_center_id').empty();
                        $('#art_center_id').append(option);
                        $('#art_center_id').attr('disabled', false);
                    }
                }
            })
        }
        $(function() {
            if ($('#art_state_id').attr('data-state') != undefined) getDistricts();

            if ($('#art_district_id').attr('data-district') != undefined) {
                setTimeout(() => {
                    getCenters()
                }, 5000);
            }

            $('#art_state_id').on('change', function() {
                getDistricts()
            })
            $('#art_district_id').on('change', function() {
                getCenters()
            })
        })
    </script>
@endpush
