@extends('layouts.app')
@push('pg_btn')
    <a href="{{ route('outreach.profile.index') }}" class="btn btn-sm btn-neutral">All Profiles</a>
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-body">

                    @if (isset($profile))
                        {{ Form::model($profile, ['route' => ['outreach.profile.update', $profile], 'method' => 'put']) }}
                    @else
                        {{ Form::open(['route' => 'outreach.profile.store']) }}
                    @endif
                    <h6 class="heading-small text-muted mb-4">Outreach information</h6>
                    <div class="pl-lg-4">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('profile_name', 'Profile Name', ['class' => 'form-control-label']) }}
                                    {{ Form::text('profile_name', null, ['class' => 'form-control', 'required' => false]) }}
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('registration_date', 'Registered Date', ['class' => 'form-control-label']) }}
                                    {{ Form::date('registration_date', null, ['class' => 'form-control', 'required' => false]) }}
                                </div>
                            </div>

                        </div>



                       
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="in_referral" class="form-control-label">In Referral</label>
                                    <select name="in_referral" id="in_referral" class="form-control">
                                        <option value="" selected hidden disabled>--- Select Referral ---
                                        </option>
                                        @foreach ($reffff as $index => $item)
                                            <option value="{{ $index }}" @selected((isset($profile) && $index == $profile?->in_referral) || old('in_referral') == $index)>
                                                {{ $item }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('referral_other', 'In Referral if other', ['class' => 'form-control-label']) }}
                                    {{ Form::text('referral_other', null, ['class' => 'form-control']) }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="platform_id" class="form-control-label">Medium of Engagement</label>
                                    <select name="platform_id" id="platform_id" class="form-control">
                                        <option value="" selected hidden disabled>--- Select Medium of Engagement ---
                                        </option>
                                        @foreach ($APPS as $item)
                                            {{-- <option value="{{ $index }}"> --}}
                                            <option value="{{ $item?->id }}" @selected((isset($profile) && $item?->id == $profile?->platform_id) || old('platform_id') == $item?->id)>
                                                {{ $item?->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('other_platform', 'Medium of Engagement if other', ['class' => 'form-control-label']) }}
                                    {{ Form::text('other_platform', null, ['class' => 'form-control']) }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="purpose_val" class="form-control-label">Primary Purpose</label>
                                    <select name="purpose_val" id="purpose_val" class="form-control">
                                        <option value="" selected hidden disabled>--- Select Main Purpose ---
                                        </option>
                                        @foreach ($purpose as $index => $item)
                                            <option value="{{ $index }}" @selected((isset($profile) && $index == $profile?->purpose_val) || old('purpose_val') == $index)>
                                                {{ $item }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('purpose_other', 'Purpose if other', ['class' => 'form-control-label']) }}
                                    {{ Form::text('purpose_other', null, ['class' => 'form-control']) }}
                                </div>
                            </div>
                        </div>




                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('shared_website_link', 'Did you share website link with the client?', ['class' => 'form-control-label']) }}
                                    {{ Form::select('shared_website_link', [1 => 'Yes', 2 => 'No'], null, ['class' => 'form-control', 'placeholder' => '--- Select choice ---']) }}
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
                                    {{ Form::label('state_id', 'State', ['class' => 'form-control-label']) }}
                                    {{ Form::select('state_id', $states, null, ['class' => 'form-control', 'placeholder' => 'Select state...', 'required' => true, 'data-state' => isset($profile) ? $profile['state_id'] : '']) }}
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    {{ Form::label('district_id', 'District', ['class' => 'form-control-label']) }}
                                    {{ Form::select('district_id', [], null, ['class' => 'form-control', 'placeholder' => 'Select district...', 'required' => true, 'disabled' => true, 'data-district' => isset($profile) ? $profile['district_id'] : old('district_id')]) }}
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
    <script>
        function getDistricts() {
            var id = $('#state_id').val(),
                district = $('#district_id').attr('data-district');
            $('#district_id').attr('disabled', true);
            $.ajax({
                url: "/district/getAll",
                method: 'GET',
                dataType: 'json',
                data: {
                    'state_code': id
                },
                success: function(data) {
                    var html = '<option selected hidden value="">---Select District---</option>';
                    $.each(data.data, function(key, val) {
                        var select = district == val.id ? " selected" : "";
                        html += '<option value="' + val.id + '"' + select + '>' + val.district_name +
                            '</option>';
                    });
                    $('#district_id').empty();
                    $('#district_id').append(html);
                    $('#district_id').attr('disabled', false);
                }
            });
        }
        let districts = [];
        jQuery(document).ready(function() {
            if ($('#state_id').attr('data-state') != undefined) getDistricts();

            updateOptionalEnablement('gender_id', 'other_gender', 5, '');
            updateOptionalEnablement('target_id', 'others_target_population', 99, '');
            updateOptionalEnablement('platform_id', 'other_platform', 99, '');
            updateOptionalEnablement('virtual_platform', 'please_mention', 1, '');
            updateOptionalEnablement('mention_platform_id', 'others_mentioned', 99, '');
            updateOptionalEnablement('in_referral', 'referral_other', 99, '');
            updateOptionalEnablement('purpose_val', 'purpose_other', 99, '');

            $('#state_id').on('change', function() {
                getDistricts();
            })

            $('#gender_id').on('change', function() {
                var gender = $('#gender_id').val();
                $('#target_id').find('option').each(function(key, val) {
                    if (gender == 1) {
                        if ($(val).val() == 2 || $(val).val() == 4) $(val).addClass('d-none')
                        else if ($(val).hasClass('d-none')) $(val).removeClass('d-none')
                    } else if (gender == 2) {
                        if ($(val).val() == 1 || $(val).val() == 3 || $(val).val() == 4) $(val)
                            .addClass('d-none')
                        else if ($(val).hasClass('d-none')) $(val).removeClass('d-none')
                    } else if (gender == 3) {
                        if ($(val).val() == 4) $(val).removeClass('d-none')
                        else if (!$(val).hasClass('d-none')) $(val).addClass('d-none')
                    } else if (gender == 4) {
                        if ($(val).val() > 4) $(val).removeClass('d-none')
                        else $(val).addClass('d-none')
                    } else $(val).removeClass('d-none')
                });
            })

            $('#age_not_disclosed').on('click', function() {
                if ($('#age_not_disclosed').prop('checked')) {
                    $('#age').removeAttr('required');
                    $('#age').val('');
                    $('#age').addClass('d-none');
                } else {
                    $('#age').removeClass('d-none');
                    $('#age').attr('required', true);
                }
            })

            $('#virtual_platform').on('change', function() {
                console.log($(this).val());
                if ($(this).val() == 1) $('div.please_mention').removeClass('d-none');
                else $('div.please_mention').addClass('d-none');
            })
        })
    </script>
@endpush
