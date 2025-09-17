@extends('self.layout.layout')

@section('title')
    Self Risk Assessment Appointment
@endsection

@section('body')
    <form action="{{ url('bookAppointment') }}" method="post">
        @csrf
        <input type="hidden" name="mobile_no" value="{{ old('mobile_no') ? old('mobile_no') : $mobileNo }}">
        @empty(!$vn)
            <input type="hidden" name="vn" value="{{ old('vn') ? old('vn') : $vn }}">
        @endempty
        <input type="hidden" name="assessment_id" value="{{ old('assessment') ? old('assessment') : $assessment }}">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="state">Full name</label>
                    <input type="text" class="form-control" name="full_name" id="full-name"
                        value="{{ old('full_name') }}">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="state">State</label>
                    <select class="form-control" name="state_id" id="input-state">
                        <option hidden selected>--- Select State ---</option>
                        @empty(!$states)
                            @foreach ($states as $value)
                                <option value="{{ $value['id'] }}" @selected($stateID == $value['id'] || old('state_id') == $value['id'])>{{ $value['state_name'] }}
                                </option>
                            @endforeach
                        @endempty
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="district">District</label>
                    <input type="hidden" name="hdn_district_id" value="{{ old('district_id') }}">
                    <select class="form-control" name="district_id" id="input-district" disabled>
                        <option hidden selected>--- Select District ---</option>
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="state">Select Services You Need:</label>
                    @foreach (SERVICES as $key => $item)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="services[]" id="{{ $key }}"
                                value="{{ $key }}" @checked($loop->first)>
                            <label class="form-check-label" for="{{ $key }}">
                                {{ $item }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="district">Testing Center</label>
                    <input type="hidden" name="hdn_center_id" value="{{ old('center_id') }}">
                    <select class="form-control" name="center_id" id="input-testing-centers" disabled>
                        <option hidden selected value="">--- Select Testing Center ---</option>
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="district">Appointment Date</label>
                    <input type="date" class="form-control" name="appointment_date" id="appointment-date"
                        value="{{ old('appointment_date') }}" min="{{ currentDateTime(DEFAULT_DATE_FORMAT) }}"
                        max="{{ getFutureDate(MONTHLY, 1, false, DEFAULT_DATE_FORMAT) }}">
                </div>
            </div>
            <div class="col-md-12">
                <input type="submit" class="btn btn-success float-right w-25" value="Book Now">
            </div>
        </div>
    </form>
@endsection
