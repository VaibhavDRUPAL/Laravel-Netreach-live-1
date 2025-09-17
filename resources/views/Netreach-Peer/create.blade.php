@extends('layouts.app')
@push('pg_btn')
<a href="{{route('Netreach-Peer')}}" class="btn btn-sm btn-neutral">All NETREACH PEER</a>
@endpush
@section('content')
<div class="row">
    <div class="col-md-12">
        {{-- @if(!isset($referral_service))
                @include('includes.select-profile')
            @endif --}}
        <div class="card mb-5 main-form-card">
            <div class="card-body">
                @if(isset($netreach_peer->id))
                {{ Form::model($netreach_peer, ['route' => ['Netreach-Peer.update', $netreach_peer->id], 'method' => 'put']) }}
                @else
                {{ Form::open(['route' => 'Netreach-Peer.store']) }}
                @endif
                <div class="pl-lg-4">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('netreach_peer_Code', 'NETREACH Peer Code', ['class' => 'form-control-label']) }}
                                {{ Form::text('netreach_peer_Code', $netreach_peer_Code, ['class' => 'form-control', 'readonly'=>true]) }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('Serial_Number_of_Client', 'Serial Number of the Client', ['class' => 'form-control-label']) }}
                                {{ Form::text('serial_number_of_client', $netreach_peer->serial_number_of_client, ['class' => 'form-control', 'required'=>true]) }}
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('date_of_outreach', 'Date of Outreach', ['class' => 'form-control-label']) }}
                                {{ Form::date('date_of_outreach', $netreach_peer->date_of_outreach, ['class' => 'form-control', 'required'=>true]) }}
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('location_of_client', 'Location of the client', ['class' => 'form-control-label', 'disabled'=>true]) }}
                                {{ Form::text('location_of_client', $netreach_peer->location_of_client, ['class' => 'form-control']) }}
                            </div>
                        </div>

                        <!-- <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('name_of_appplatform_client', 'Name of App/Platform where client is approached', ['class' => 'form-control-label', 'disabled'=>true]) }}
                                {{ Form::text('name_of_appplatform_client', null, ['class' => 'form-control']) }}
                            </div>
                        </div> -->

                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('name_of_appplatform_client', 'Name of application', ['class' => 'form-control-label']) }}
                                {{ Form::select('name_of_appplatform_client', $APPS, $netreach_peer->name_of_appplatform_client, [ 'class'=> 'selectpicker form-control', 'placeholder' => 'Select app...', 'required'=>true]) }}
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('name_of_client', 'Full name of the client', ['class' => 'form-control-label', 'disabled'=>true]) }}
                                {{ Form::text('name_of_client', $netreach_peer->name_of_client, ['class' => 'form-control']) }}
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('clients_age', 'Clients Age', ['class' => 'form-control-label', 'disabled'=>true]) }}
                                {{ Form::text('clients_age', $netreach_peer->clients_Age, ['class' => 'form-control']) }}
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('gender', 'Gender', ['class' => 'form-control-label']) }}
                                {{ Form::select('gender', $Gender, $netreach_peer->gender, [ 'class'=> 'selectpicker form-control', 'placeholder' => 'Select type...', 'required'=>true]) }}
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('type_of_target_population', 'Type of Target Population', ['class' => 'form-control-label']) }}
                                {{ Form::select('type_of_target_population', $Type_of_Target_Population, $netreach_peer->type_of_target_population, [ 'class'=> 'selectpicker form-control', 'placeholder' => 'Select type...', 'required'=>true]) }}
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                {{ Form::label('phone_number', 'Phone number (WhatsAap number)', ['class' => 'form-control-label', 'disabled'=>true]) }}
                                {{ Form::text('phone_number', $netreach_peer->phone_number, ['class' => 'form-control']) }}
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
<script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
<script>
    jQuery(document).ready(function() {
        updateOptionalEnablement('type_service', 'other_services', 99, '');
        updateOptionalEnablement('referred_for_ti_service', 'others_referred_service', 99, '');
        updateOptionalEnablement('applicable_for_sti_service', 'other_sti_service', 2, '');
        updateOptionalEnablement('not_access_the_service_referred', 'other_not_access', 99, '');
        updateOptionalEnablement('primary_occupation_client', 'other', 99, '');

        $('#referred_centre_state, #test_centre_state').on('change', function() {
            var id = $(this).val(),
                input = $(this);
            $.ajax({
                url: "/district/getAll",
                method: 'GET',
                dataType: 'json',
                data: {
                    'state_code': id
                },
                success: function(data) {
                    var html = null;
                    $.each(data.data, function(key, val) {
                        html += '<option val="' + val.district_code + '">' + val.district_name + '</option>'
                    });

                    if ($(input).attr('id') == 'referred_centre_state') {
                        $('#referred_centre_district').empty();
                        $('#referred_centre_district').append(html);
                        $('#referred_centre_district').selectpicker('refresh');
                    } else if ($(input).attr('id') == 'test_centre_state') {
                        $('#test_centre_district').empty();
                        $('#test_centre_district').append(html);
                        $('#test_centre_district').selectpicker('refresh');
                    }
                }
            });
        })
    })
</script>
@endpush