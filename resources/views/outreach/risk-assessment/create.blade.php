@extends('layouts.app')
@push('pg_btn')
    <a href="{{route('outreach.risk-assessment.index')}}" class="btn btn-sm btn-neutral">All Risk Assessments</a>
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5 main-form-card">
                <div class="card-body">
                    @if(isset($risk_assessment))
                        {{ Form::model($risk_assessment, ['route' => ['outreach.risk-assessment.update', $risk_assessment], 'method' => 'put']) }}
                    @else
                        {{ Form::open(['route' => 'outreach.risk-assessment.store']) }}
                    @endif
                        <div class="pl-lg-4">
                            <input type="hidden" name="profile_id" value="{{ $profileID }}">
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
                                        <select name="client_type_id" id="client_type_id" class="form-control" required>
                                            <option value="" selected hidden disabled>--- Select Client Type ---</option>
                                            @foreach ($CLIENT_TYPE as $item)
                                                <option value="{{ $item?->client_type_id }}" @selected((isset($exists) && $exists == $item?->client_type_id) || (isset($risk_assessment) && $item?->client_type_id == $risk_assessment?->client_type_id))>{{ $item?->client_type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <input type="hidden" name="profile_registration_date" value="{{ $profile['registration_date'] }}">
                                    <div class="form-group">
                                        {{ Form::label('date_of_risk_assessment', 'Date of risk assessment', ['class' => 'form-control-label']) }}
                                        {{ Form::date('date_of_risk_assessment', null, ['class' => 'form-control', 'required'=>true]) }}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('had_sex_without_a_condom', 'Had sex without a condom (high risk)', ['class' => 'form-control-label']) }}
                                        {{ Form::select('had_sex_without_a_condom', $CHOICES, null, [ 'class'=> 'form-control', 'placeholder' => '--- Select Option ---', 'required'=>true]) }}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('shared_needle_for_injecting_drugs', 'Shared needle for injecting drugs (high risk)', ['class' => 'form-control-label']) }}
                                        {{ Form::select('shared_needle_for_injecting_drugs', $CHOICES, null, [ 'class'=> 'form-control', 'placeholder' => '--- Select Option ---', 'required'=>true]) }}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('sexually_transmitted_infection', 'Having a sexually transmitted infection (STI) (high risk)', ['class' => 'form-control-label']) }}
                                        {{ Form::select('sexually_transmitted_infection', $CHOICES, null, [ 'class'=> 'form-control', 'placeholder' => '--- Select Option ---', 'required'=>true]) }}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('sex_with_more_than_one_partners', 'Sex with more than one partners (medium risk)', ['class' => 'form-control-label']) }}
                                        {{ Form::select('sex_with_more_than_one_partners', $CHOICES, null, [ 'class'=> 'form-control', 'placeholder' => '--- Select Option ---', 'required'=>true]) }}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('had_chemical_stimulantion_or_alcohol_before_sex', 'Had chemical stimulant or alcohol before sex (medium risk)', ['class' => 'form-control-label']) }}
                                        {{ Form::select('had_chemical_stimulantion_or_alcohol_before_sex', $CHOICES, null, [ 'class'=> 'form-control', 'placeholder' => '--- Select Option ---', 'required'=>true]) }}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('had_sex_in_exchange_of_goods_or_money', 'Had sex in exchange of goods or money (medium risk)', ['class' => 'form-control-label']) }}
                                        {{ Form::select('had_sex_in_exchange_of_goods_or_money', $CHOICES, null, [ 'class'=> 'form-control', 'placeholder' => '--- Select Option ---', 'required'=>true]) }}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('other_reason_for_hiv_test', 'Other reason for HIV test (please specify)', ['class' => 'form-control-label']) }}
                                        {{ Form::text('other_reason_for_hiv_test', null, ['class' => 'form-control']) }}
                                    </div>
                                </div>
                            </div>
                            @if (isset($risk_assessment) && isset($canTakeAction) && $canTakeAction)
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            {{ Form::label('status', 'Take action', ['class' => 'form-control-label']) }}
                                            {{ Form::select('status', [2 => 'Accept', 3 => 'Reject'], null, [ 'class'=> 'form-control', 'placeholder' => '--- Select Option ---']) }}
                                        </div>
                                    </div>
                                </div>
                            @endif
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