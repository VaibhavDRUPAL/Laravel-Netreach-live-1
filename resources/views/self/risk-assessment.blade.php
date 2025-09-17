@extends('self.layout.layout')

@section('title')
    Self Risk Assessment Tool
@endsection

@section('body')
    @php
        use App\Models\SelfModule\{RiskAssessmentQuestionnaire, RiskAssessmentAnswer};
    @endphp
    @if(!$verify)
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="mob-no">Mobile No</label>
                    <input type="text" class="form-control" id="mob-no">
                </div>
            </div>
            <div class="col-md-4">
				<label for="">&nbsp;</label><br>
                <button class="btn btn-primary w-25" id="btn-verify-mob" data-toggle="modal">
                    Verify
                </button>
            </div>
        </div>
        <div class="modal fade" id="verify-otp" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Verify Mobile Number</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('verifyOTP') }}" method="post">
                            @csrf
                            <input type="hidden" name="mobile-no" id="mobile-no">
                            @empty(!$vn)
                                <input type="hidden" name="vn" value="{{ $vn }}">
                            @endempty
                            <div class="form-group">
                                <label for="otp">OTP</label>
                                <small for="otp" id="otp-small-text" class="form-text text-muted"></small>
                                <input type="text" class="form-control" name="otp" id="otp" placeholder="Enter OTP">
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-success float-right" value="Verify OTP">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endisset
    @if ($verify)
        <div class="row">
            <div class="alert alert-success">
                Mobile number is verified successfully. Your mobile number is: {{ $mobileNo }}
            </div>
            <input type="hidden" id="status" value="{{ old($verify) ? old($verify) : $verify }}">
            <form class="w-100" action="{{ url('self-risk-assessment') }}" method="post">
                @csrf
                @php
                    $count = 1;
                @endphp
                @if (!empty($vn) || old('vn'))
                    <input type="hidden" name="vn" value="{{ old('vn') ? old('vn') : $vn }}">
                @endif
                @foreach ($questionnaire as $question)
                    @php
                        $questionInputType = $question[RiskAssessmentQuestionnaire::answer_input_type];
                    @endphp
                    <div class="col-md-12">
                        <div class="form-group">
                            @if ($questionInputType != IN_SELECT)
                                <label for="{{ $question[RiskAssessmentQuestionnaire::question_slug] }}">{{ $count++ }}. {{ $question[RiskAssessmentQuestionnaire::question] }}</label>
                            @endif
                            @if ($questionInputType == IN_TEXT)
                                <input type="text" class="form-control attempt" value="{{ $mobileNo }}" data-question-id="{{ $question[RiskAssessmentQuestionnaire::question_id] }}" name="{{ $question[RiskAssessmentQuestionnaire::question_slug] }}" id="{{ $question[RiskAssessmentQuestionnaire::question_slug] }}" readonly>
                            @elseif ($questionInputType == IN_SELECT)
                                <input type="hidden" name="{{ $question[RiskAssessmentQuestionnaire::question_slug] }}" id="{{ $question[RiskAssessmentQuestionnaire::question_slug] }}" value="{{ $state['id'] }}">
                            @elseif ($questionInputType == IN_RADIO)
                                @empty(!$question['answers'])
                                    @foreach ($question['answers'] as $answer)
                                        <div class="form-check">
                                            <input class="form-check-input attempt" type="{{ $questionInputType }}" data-question-id="{{ $question[RiskAssessmentQuestionnaire::question_id] }}" name="{{ $question[RiskAssessmentQuestionnaire::question_slug] }}" id="{{ $answer[RiskAssessmentAnswer::answer_id] }}" value="{{ $answer[RiskAssessmentAnswer::answer_id] }}" @checked(old($question[RiskAssessmentQuestionnaire::question_slug]) == $answer[RiskAssessmentAnswer::answer_id])>
                                            <label class="form-check-label" for="{{ $answer[RiskAssessmentAnswer::answer_id] }}">
                                                {{ $answer[RiskAssessmentAnswer::answer] }}
                                            </label>
                                        </div>
                                    @endforeach
                                @endempty
                            @elseif ($questionInputType == IN_CHECKBOX)
                                @empty(!$question['answers'])
                                    @foreach ($question['answers'] as $answer)
                                        <div class="form-check">
                                            <input class="form-check-input attempt" type="{{ $questionInputType }}" data-question-id="{{ $question[RiskAssessmentQuestionnaire::question_id] }}" name="{{ $question[RiskAssessmentQuestionnaire::question_slug] }}[]" id="{{ $answer[RiskAssessmentAnswer::answer_id] }}" value="{{ $answer[RiskAssessmentAnswer::answer_id] }}" @checked(old($question[RiskAssessmentQuestionnaire::question_slug]) && in_array($answer[RiskAssessmentAnswer::answer_id], old($question[RiskAssessmentQuestionnaire::question_slug])))>
                                            <label class="form-check-label" for="{{ $answer[RiskAssessmentAnswer::answer_id] }}">
                                                {{ $answer[RiskAssessmentAnswer::answer] }}
                                            </label>
                                        </div>
                                    @endforeach
                                @endempty
                            @endif
                        </div>
                    </div>
                @endforeach
                <div class="col-md-12">
                    <input type="submit" class="btn btn-success float-right w-25" value="Save">
                </div>
            </form>
        </div>
    @endif
@endsection