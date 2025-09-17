@extends('layouts.app')
@push('pg_btn')
    <a href="{{route('outreach.counselling.index')}}" class="btn btn-sm btn-neutral">All Counsellings</a>
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-body main-form-card">
                    @if(isset($counselling))
                        {{ Form::model($counselling, ['route' => ['outreach.counselling.update', $counselling], 'method' => 'put']) }}
                    @else
                        {{ Form::open(['route' => 'outreach.counselling.store']) }}
                    @endif
                        <input type="hidden" name="profile_id" value="{{ $profileID }}">
                        <div class="pl-lg-4">
                            <h6 class="heading-small text-muted mb-4">Preliminary information</h6>
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
                                                <option value="{{ $item?->client_type_id }}" @selected((isset($exists) && $exists == $item?->client_type_id) || (isset($counselling) && $item?->client_type_id == $counselling?->client_type_id) || (old('client_type_id') == $item?->client_type_id))>{{ $item?->client_type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('name_the_client', 'Client name', ['class' => 'form-control-label']) }}
                                        {{ Form::text('name_the_client', $profile['profile_name'], ['class' => 'form-control', 'required'=>true,'readonly']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('referred_from', 'Referred from', ['class' => 'form-control-label']) }}
                                        {{ Form::select('referred_from', $REFERRED_FROM, null, [ 'class'=> 'form-control', 'placeholder' => '--- Select choice ---', 'required'=>true]) }}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('referral_source', 'If others(specify) referral source', ['class' => 'form-control-label']) }}
                                        {{ Form::text('referral_source', null, ['class' => 'form-control']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        @empty(!$profile)
                                            <input type="hidden" name="profile_registration_date" value="{{ $profile['registration_date'] }}">
                                        @endempty
                                        {{ Form::label('date_of_counselling', 'Date of counselling', ['class' => 'form-control-label']) }}
                                        {{ Form::date('date_of_counselling', null, ['class' => 'form-control', 'required'=>true]) }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('phone_number', 'Phone number', ['class' => 'form-control-label']) }}
                                        {{ Form::text('phone_number', null, ['class' => 'form-control']) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-4" />
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="type_of_counselling_offered" class="form-control-label">Type of counselling offered</label>
                                        <select name="type_of_counselling_offered" id="type_of_counselling_offered" class="form-control" required>
                                            <option value="" selected hidden disabled>--- Select Type of counselling ---</option>
                                            @foreach ($COUNSELLING_TYPE as $key => $item)
                                                <option value="{{ $key }}" @selected((isset($counselling) && $key == $counselling?->type_of_counselling_offered) || (old('type_of_counselling_offered') == $key))>{{ $item }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('type_of_counselling_offered_other', 'If others (specify)', ['class' => 'form-control-label']) }}
                                        {{ Form::text('type_of_counselling_offered_other', null, ['class' => 'form-control']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('counselling_medium', 'Counselling medium', ['class' => 'form-control-label']) }}
                                        {{ Form::select('counselling_medium', $TYPE_OF_COUNSELLING, null, [ 'class'=> 'form-control', 'placeholder' => '--- Select medium of counselling ---', 'required'=>true]) }}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('other_counselling_medium', 'If others (specify)', ['class' => 'form-control-label']) }}
                                        {{ Form::text('other_counselling_medium', null, ['class' => 'form-control']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('duration_of_counselling', 'Duration of counselling (in minutes)', ['class' => 'form-control-label']) }}
                                        {{ Form::number('duration_of_counselling', null, ['class' => 'form-control']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('key_concerns_discussed', 'Key concerns discussed', ['class' => 'form-control-label']) }}
                                        {{ Form::text('key_concerns_discussed', null, ['class' => 'form-control']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('follow_up_date', 'Follow-up date', ['class' => 'form-control-label']) }}
                                        {{ Form::date('follow_up_date', null, ['class' => 'form-control']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('remarks', 'Remarks', ['class' => 'form-control-label']) }}
                                        {{ Form::text('remarks', null, ['class' => 'form-control']) }}
                                    </div>
                                </div>
                            </div>
                            @if (isset($counselling) && isset($canTakeAction) && $canTakeAction)
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            {{ Form::label('status', 'Take action', ['class' => 'form-control-label']) }}
                                            {{ Form::select('status', [2 => 'Accept', 3 => 'Reject'], null, [ 'class'=> 'form-control', 'placeholder' => 'Select choice...']) }}
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
@push('scripts')
    <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
    <script>
        jQuery(document).ready(function(){
            updateOptionalEnablement('referred_from', 'referral_source', 99, '');
            updateOptionalEnablement('gender', 'gender_other', 5, '');
            updateOptionalEnablement('type_target_population', 'other_target_pop', 99, '');
            updateOptionalEnablement('type_of_counselling_offered', 'type_of_counselling_offered_other', 99, '');
            updateOptionalEnablement('counselling_medium', 'other_counselling_medium', 99, '');
        })
        $('#state_id').on('change',function() {
            var id = $(this).val(), input = $(this);
            $.ajax({
                url : "/district/getAll",
                method : 'GET',
                dataType : 'json',
                data : {
                    'state_code' : id
                },
                success : function(data) {
                    var html = null;
                    $.each(data.data,function(key,val){
                        html += '<option value="'+ val.id +'">'+val.district_name+'</option>'
                    });
                    $('#district_id').empty();
                    $('#district_id').append(html);
                }
            });
        })
    </script>
@endpush
