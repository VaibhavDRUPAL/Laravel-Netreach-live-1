@extends('layouts.app')

@push('pg_btn')
    <a href="{{route('outreach.sti.index')}}" class="btn btn-sm btn-neutral">All STI</a>
@endpush

@php
    use App\Models\Outreach\STIService;
@endphp

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5 main-form-card">
                <div class="card-body">
                    @if(isset($stiservices))
                        {{ Form::model($stiservices, ['route' => ['outreach.sti.update', $stiservices], 'method' => 'put']) }}
                    @else
                        {{ Form::open(['route' => 'outreach.sti.store']) }}
                    @endif
                        @csrf
                        <input type="hidden" name="profile_id" value="{{ $profileID }}">
                        @isset($stiservices)
                            <input type="hidden" name="id" id="sti_id" value="{{ $stiservices[STIService::sti_services_id] }}">
                        @endisset
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('unique_serial_number', 'Unique serial number', ['class' => 'form-control-label']) }}
                                        {{ Form::text('unique_serial_number', isset($unique_serial_number) ? urldecode($unique_serial_number) : '', ['class' => 'form-control', 'readonly'=>true]) }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="client_type_id" class="form-control-label">Client Type</label>
                                        <select name="client_type_id" id="client_type_id" class="form-control" aria-placeholder="Select Client Type..." required>
                                            <option value="" selected hidden disabled>--- Select Client Type ---</option>
                                            @foreach ($CLIENT_TYPE as $item)
                                                <option value="{{ $item?->client_type_id }}" @selected((isset($exists) && $exists == $item?->client_type_id) || (isset($stiservices) && $item?->client_type_id == $stiservices?->client_type_id) || (old('client_type_id') == $item?->client_type_id))>{{ $item?->client_type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        @php
                                            if(isset($stiservices)) $date = $stiservices['date_of_accessing_service'];
                                            else if(isset($referral)) $date = $referral['date_of_accessing_service'];
                                            else $date = old('date_of_accessing_service');
                                        @endphp
                                        {{ Form::label('date_of_sti', 'Date of STI', ['class' => 'form-control-label']) }}
                                        {{ Form::date('date_of_sti', $date , ['class' => 'form-control', 'readonly']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="div_pid_or_other_unique_id_of_the_client_provided_at_the_service_cen">
                                <div class="col-lg-6">
                                    @php
                                        if(old('pid_or_other_unique_id_of_the_service_center')) $pid = old('pid_or_other_unique_id_of_the_service_center');
                                        else if(isset($stiservices) && $stiservices[STIService::pid_or_other_unique_id_of_the_service_center]) $pid = $stiservices[STIService::pid_or_other_unique_id_of_the_service_center];
                                        else $pid = $referral['pid_or_other_unique_id_of_the_service_center'];
                                    @endphp
                                    <div class="form-group">
                                        {{ Form::label('pid_or_other_unique_id_of_the_service_center', 'PID or other unique ID of the client provided at the service centre', ['class' => 'form-control-label']) }}
                                        {{ Form::text('pid_or_other_unique_id_of_the_service_center', $pid , ['class' => 'form-control', 'readonly']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="sti_service_id" class="form-control-label">Type of STI service (applicable for STI service)</label>
                                        <select name="sti_service_id" id="sti_service_id" class="form-control" aria-placeholder="Select Type of STI service..." required>
                                            <option hidden selected value="">Select Option...</option>
                                            @foreach ($TYPE_STI_SERVICE as $item)
                                                <option value="{{ $item?->sti_service_id }}" @selected(isset($stiservices) && $item?->sti_service_id == $stiservices?->sti_service_id)>{{ $item?->sti_service }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div @class(['col-lg-6', 'd-none' => (old('applicable_for_syphillis') != 1) || (isset($stiservices) && $stiservices['applicable_for_syphillis'] != 1)]) id="div_applicable_for_syphillis">
                                    <div class="form-group">
                                        {{ Form::label('applicable_for_syphillis', 'Applicable for syphillis', ['class' => 'form-control-label']) }}
                                        {{ Form::text('applicable_for_syphillis', old('applicable_for_syphillis'), [ 'class'=> 'form-control']) }}
                                    </div>
                                </div>
                                <div @class(['col-lg-6', 'd-none' => (old('applicable_for_syphillis') != 99) || (isset($stiservices) && $stiservices['applicable_for_syphillis'] != 99)]) id="div_other_sti_service">
                                    <div class="form-group">
                                        {{ Form::label('other_sti_service', 'If others (specify)', ['class' => 'form-control-label']) }}
                                        {{ Form::text('other_sti_service', old('other_sti_service'), ['class' => 'form-control']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="is_treated" class="form-control-label">Treated</label>
                                        <select name="is_treated" id="is_treated" class="form-control" required>
                                            <option value="0" @selected(old('is_treated') == 0 || (isset($stiservices) && $stiservices[STIService::is_treated])) selected>No</option>
                                            <option value="1" @selected(old('is_treated') == 1 || (isset($stiservices) && $stiservices[STIService::is_treated]))>Yes</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @php
                                $flag = false;

                                if(old(STIService::is_treated, 0) && intval(old(STIService::is_treated, 0)) == 0) $flag = true;
                                else if (!isset($stiservices)) $flag = true;
                                else if (isset($stiservices) && $stiservices[STIService::is_treated] == 0) $flag = true;
                            @endphp
                            <div @class(['row', 'd-none' => $flag ]) id="div_is_treated">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="type_facility_where_treated" class="form-control-label">Type of Facility where treated</label>
                                        <select name="type_facility_where_treated" id="type_facility_where_treated" class="form-control">
                                            <option hidden selected value="">Select Option...</option>
                                            @foreach ($TYPE_FACILITY as $key => $item)
                                                <option value="{{ $key }}" @selected(old('type_facility_where_treated') == $key || (isset($stiservices) && $stiservices[STIService::type_facility_where_treated] == $key))>{{ $item }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="state_id" class="form-control-label">State</label>
                                        <select name="state_id" id="state_id" class="form-control" data-state="{{ isset($stiservices) ? $stiservices[STIService::state_id] : '' }}">
                                            <option hidden selected value="">--- Select State ---</option>
                                            @foreach ($states as $key => $item)
                                                <option value="{{ $key }}" @selected(old('state_id') == $key || (isset($stiservices) && $stiservices[STIService::state_id] == $key))>{{ $item }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('district_id', 'District', ['class' => 'form-control-label']) }}
                                        {{ Form::select('district_id', [], null, [ 'class'=> 'form-control', 'placeholder' => '--- Select district ---', 'disabled'=>true, 'data-district' => isset($stiservices) ? $stiservices[STIService::district_id] : '']) }}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('center_id', 'Name of centre where treatment done', ['class' => 'form-control-label']) }}
                                        {{ Form::select('center_id', [], null, ['class' => 'form-control', 'disabled'=> true, 'data-center' => isset($stiservices) ? $stiservices[STIService::center_id] : '']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('remarks', 'Remarks', ['class' => 'form-control-label']) }}
                                        {{ Form::text('remarks', isset($stiservices) ? $stiservices[STIService::remarks] : old('remarks'), ['class' => 'form-control']) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-md-12">
                                    {{ Form::submit('Save', ['class'=> 'mt-5 btn btn-primary']) }}
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
        function getDistricts() {
            $('#district_id').attr('disabled', true);
            $.ajax({
                url : "/district/getAll",
                method : 'GET',
                dataType : 'json',
                data : {
                    'state_code' : $('#state_id').val()
                },
                success : function(data) {
                    var district = $('#district_id').attr('data-district');
                    console.log(district);
                    var html = '<option selected hidden value="">---Select District---</option>';
                    $.each(data.data,function(key,val) {
                        var select = district != undefined && district == val.id ? " selected" : "";
                        html += '<option value="'+ val.id +'"'+ select +'>'+ val.district_name +'</option>';
                    });
                    $('#district_id').empty();
                    $('#district_id').append(html);
                    $('#district_id').attr('disabled', false);
                    $('#center_id').empty();
                }
            });
        }
        function getCenters() {
            var center = $('#center_id').attr('data-center') != undefined ? $('#center_id').attr('data-center') : $('#center_id').val(),
            district = $('#district_id').attr('data-district') == '' ? $('#district_id').val() : $('#district_id').attr('data-district');
            
            $('#center_id').attr('disabled', true);
            $.ajax({
                url : "/get-centres",
                method : 'GET',
                dataType : 'json',
                data : {
                    'district_id' : district
                },
                success : function(data) {
                    var html = '<option selected hidden value="">---Select Center---</option>';
                    $.each(data.data,function(key,val){
                        var select = center != undefined && center == val.id ? " selected" : "";
                        var name = val.name;
                        if(val.address != null) name += ', ' + val.address;
                        html += '<option value="'+ val.id +'"'+ select +'>'+ name +'</option>';
                    });
                    $('#center_id').empty();
                    $('#center_id').append(html);
                    $('#center_id').attr('disabled', false);
                }
            });
        }
        function setSTIService() {
            if($('#sti_service_id').val() == 1) $('#div_applicable_for_syphillis').removeClass('d-none');
            else $('#div_applicable_for_syphillis').addClass('d-none');
            
            if($('#sti_service_id').val() == 99) $('#div_other_sti_service').removeClass('d-none');
            else $('#div_other_sti_service').addClass('d-none');
        }
        $(function() {
            if($('#sti_id').val() != undefined) setSTIService();

            $('#state_id').on('change', function() {
                getDistricts();
            });
            $('#district_id').on('change', function() {
                getCenters();
            });
            $('#is_treated').on('change', function() {
                if($(this).val() == 1) $('#div_is_treated').removeClass('d-none');
                else $('#div_is_treated').addClass('d-none');
            });
            $('#sti_service_id').on('change', function() {
                setSTIService();
            });
            if($('#state_id').attr('data-state') != undefined) getDistricts();
            
            if($('#district_id').attr('data-district') != undefined) {
                setTimeout(() => {
                    getCenters();
                }, 5000);
            }
        })
    </script>
@endpush
