@extends('layouts.apphome')

@section('title')
    Meet Counsellor
@endsection

@section('content')

    <div class="container mt-5 pt-5 mb-5 d-flex justify-content-center">
        <div class="card px-1 py-4">
            <div class="card-body">
                <h3 class="card-title mb-3 text-center" style="font-weight: bold;font-size:clamp(1.25rem,2.5vw,1.75rem)">
                    {{ __('meetCounsellor.Contact_Counsellor_Form') }}</h3>

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('counsellorForm.submit') }}" method="post" id="meet-counsellor-form">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="{{ __('meetCounsellor.Name') }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <select class="form-control" name="state_id" id="input-state" required>
                                    <option hidden selected>{{ __('meetCounsellor.Select_Counsellor') }} </option>
                                    @empty(!$statez)
                                        @foreach ($statez as $value)
                                            <option value="{{ $value['id'] }}">
                                                @if ($locale == 'mr')
                                                    {{ $value['state_name_mr'] }}
                                                @elseif($locale == 'hi')
                                                    {{ $value['state_name_hi'] }}
                                                @elseif($locale == 'ta')
                                                    {{ $value['state_name_ta'] }}
                                                @elseif($locale == 'te')
                                                    {{ $value['state_name_te'] }}
                                                @else
                                                    {{ $value['state_name'] }}
                                                @endif
                                            </option>
                                        @endforeach
                                    @endempty
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <input type="text" class="form-control" name="mobile_no" id="mobile_no"
                                    placeholder="{{ __('meetCounsellor.Mobile_Number') }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <textarea name="message" id="message" rows="" class="form-control"
                                    placeholder="{{ __('meetCounsellor.Message_Query') }}" required></textarea>
                            </div>
                        </div>
                    </div>

                    <button type="submit" value="submit" class="btn btn-block confirm-button" style="background-color: #1476A1; color: #fff; border-radius: 10px;">
                        {{ __('meetCounsellor.Submit') }}</button>

                    <div class="d-flex flex-column text-center mt-3 mb-3">
                        <small class="agree-text">*{{ __('meetCounsellor.note') }}.</small>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

<style>
    body {
        background-color: #FFEBEE;
    }

    .card {
        width: 400px;
        background-color: #fff;
        border: none;
        border-radius: 12px;
    }

    .form-control {
        margin-top: 10px;
        height: 48px;
        border: 2px solid #eee;
        border-radius: 10px;
    }

    .form-control:focus {
        box-shadow: none;
        border: 2px solid #039BE5;
    }

    .confirm-button {
        height: 50px;
        border-radius: 10px;
    }

    .agree-text {
        font-size: 12px;
    }
</style>
