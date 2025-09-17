@extends('layouts.apphome')

@section('title')
    Self Risk Assessment Tool
@endsection

@php
    use App\Models\SelfModule\{RiskAssessmentQuestionnaire, RiskAssessmentAnswer};
@endphp

@section('content')
    <div class="row p-5 mt-xl-5">
        <div class="col-md-8">
            {{-- @dd(app()->getLocale()) --}}
            @php
                $locale = app()->getLocale();
            @endphp
            <form class="w-100 mt-5"
                action="{{ url($locale !== 'en' ? $locale . '/survey-appointment' : 'survey-appointment') }}"
                {{-- <form class="w-100 mt-5" action="{{ route('survey.appointment', ['locale' => $locale !== 'en' ? $locale : null]) }}"> --}} {{-- <form class="w-100 mt-5" action="{{ route('survey.appointment', ['locale' => app()->getLocale()]) }}" --}} id="self-risk-assessment-form" method="post">
                @csrf

                @if (!empty($vn) || old('vn'))
                    <input type="hidden" name="vn" value="{{ old('vn') ? old('vn') : $vn }}">
                @endif
                <input type="hidden" name="mobile" value="{{ $mobileNo }}">
                <input type="hidden" name="state" value="{{ $state?->id }}">
                <input type="hidden" name="risk_assessment_id" id="risk_assessment_id" value="{{ $riskAssessmentID }}">

                @if ($questionnaire->isNotEmpty())
                    <h3 class="ml-1" id="tell_us">
                        {{ __('questionnaire.Tell us about Yourself') }} </h3>

                    @php
                        $questionNumber = 1;
                    @endphp

                    @foreach ($groupNo as $item)
                        <div class="section">
                            @if ($item == 2)
                                <div class="form-group">
                                    <label for="" class="h3">
                                        {{ __('questionnaire.KYR') }}
                                    </label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="I know my Risk"
                                            value="I know my Risk" onclick="getCheckedOption(this.value)">
                                        <label class="form-check-label h5" for="I know my Risk">
                                            {{ __('questionnaire.I know my Risk') }}
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="I want to know my Risk"
                                            value="I want to know my Risk" onclick="getCheckedOption(this.value)">
                                        <label class="form-check-label h5" for="I want to know my Risk">
                                            {{ __('questionnaire.I want to know my Risk') }}
                                        </label>
                                    </div>
                                </div>
                            @else
                                @php
                                    $questionnaireGroup = $questionnaire
                                        ->where(RiskAssessmentQuestionnaire::group_no, $item)
                                        ->sortBy(RiskAssessmentQuestionnaire::priority);
                                @endphp
                                @foreach ($questionnaireGroup as $question)
                                    @php
                                        $questionInputType = $question[RiskAssessmentQuestionnaire::answer_input_type];
                                    @endphp

                                    <label for="{{ $question->question_slug }}" class="mt-4">

                                        @if (true)
                                            {{ $questionNumber++ }}.
                                        @endif

                                        {{-- question --}}
                                        @if ($locale == 'mr')
                                            {{ $question->question_mr }}
                                        @elseif($locale == 'hi')
                                            {{ $question->question_hi }}
                                        @elseif($locale == 'ta')
                                            {{ $question->question_ta }}
                                        @elseif($locale == 'te')
                                            {{ $question->question_te }}
                                        @else
                                            {{ $question->question }}
                                        @endif

                                    </label>
                                    @if ($questionInputType == IN_SELECT)
                                        <select class="form-control question-attempted" name="state_id" id="input-state"
                                            data-question-id="{{ $question[RiskAssessmentQuestionnaire::question_id] }}">
                                            <option hidden selected>--- Select State ---</option>
                                        @empty(!$statez)
                                            @foreach ($statez as $value)
                                                <option value="{{ $value['id'] }}" @selected($value['id'] == $stateID)>
                                                    @if ($locale == 'mr')
                                                        {{ $value['state_name_mr'] }}
                                                    @elseif ($locale == 'hi')
                                                        {{ $value['state_name_hi'] }}
                                                    @elseif ($locale == 'ta')
                                                        {{ $value['state_name_ta'] }}
                                                    @elseif ($locale == 'te')
                                                        {{ $value['state_name_te'] }}
                                                    @else
                                                        {{ $value['state_name'] }}
                                                    @endif
                                                </option>
                                            @endforeach
                                        @endempty
                                    </select>
                                @endif


                                @if ($questionInputType == IN_TEXT)
                                    <input type="text" class="form-control question-attempt"
                                        value="{{ $mobileNo }}"
                                        data-question-id="{{ $question[RiskAssessmentQuestionnaire::question_id] }}"
                                        name="{{ $question[RiskAssessmentQuestionnaire::question_slug] }}"
                                        id="{{ $question[RiskAssessmentQuestionnaire::question_slug] }}" readonly>
                                @elseif ($questionInputType == IN_RADIO)
                                @empty(!$question['answers'])
                                    @foreach ($question['answers'] as $answer)
                                        <div class="form-check">
                                            <input class="form-check-input question-attempt question-attempted"
                                                type="{{ $questionInputType }}"
                                                data-question-id="{{ $question[RiskAssessmentQuestionnaire::question_id] }}"
                                                name="{{ $question[RiskAssessmentQuestionnaire::question_slug] }}"
                                                id="{{ $answer[RiskAssessmentAnswer::answer_id] }}"
                                                value="{{ $answer[RiskAssessmentAnswer::answer_id] }}"
                                                @checked(isset($rawData[$question[RiskAssessmentQuestionnaire::question_slug]]) &&
                                                        $rawData[$question[RiskAssessmentQuestionnaire::question_slug]] == $answer[RiskAssessmentAnswer::answer_id]
                                                )>
                                            <label class="form-check-label"
                                                for="{{ $answer[RiskAssessmentAnswer::answer_id] }}">
                                                @if ($locale == 'mr')
                                                    {{ $answer[RiskAssessmentAnswer::answer_mr] }}
                                                @elseif ($locale == 'hi')
                                                    {{ $answer[RiskAssessmentAnswer::answer_hi] }}
                                                @elseif ($locale == 'ta')
                                                    {{ $answer[RiskAssessmentAnswer::answer_ta] }}
                                                @elseif ($locale == 'te')
                                                    {{ $answer[RiskAssessmentAnswer::answer_te] }}
                                                @else
                                                    {{ $answer[RiskAssessmentAnswer::answer] }}
                                                @endif
                                            </label>
                                        </div>
                                    @endforeach
                                @endempty
                            @elseif ($questionInputType == IN_CHECKBOX)
                            @empty(!$question['answers'])
                                <div id="{{ $question[RiskAssessmentQuestionnaire::question_slug] }}">
                                    @foreach ($question['answers'] as $answer)
                                        <div class="form-check">
                                            <input class="form-check-input question-attempt question-attempted"
                                                type="{{ $questionInputType }}"
                                                data-slug="{{ $question[RiskAssessmentQuestionnaire::question_slug] }}"
                                                data-question-id="{{ $question[RiskAssessmentQuestionnaire::question_id] }}"
                                                name="{{ $question[RiskAssessmentQuestionnaire::question_slug] }}[]"
                                                id="{{ $answer[RiskAssessmentAnswer::answer_id] }}"
                                                value="{{ $answer[RiskAssessmentAnswer::answer_id] }}"
                                                @checked(isset($rawData[$question[RiskAssessmentQuestionnaire::question_slug]]) &&
                                                        in_array(
                                                            $answer[RiskAssessmentAnswer::answer_id],
                                                            $rawData[$question[RiskAssessmentQuestionnaire::question_slug]]))>
                                            <label class="form-check-label"
                                                for="{{ $answer[RiskAssessmentAnswer::answer_id] }}">
                                                @if ($locale == 'mr')
                                                    {{ $answer[RiskAssessmentAnswer::answer_mr] }}
                                                @elseif ($locale == 'hi')
                                                    {{ $answer[RiskAssessmentAnswer::answer_hi] }}
                                                @elseif ($locale == 'ta')
                                                    {{ $answer[RiskAssessmentAnswer::answer_ta] }}
                                                @elseif ($locale == 'te')
                                                    {{ $answer[RiskAssessmentAnswer::answer_te] }}
                                                @else
                                                    {{ $answer[RiskAssessmentAnswer::answer] }}
                                                @endif
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @endempty
                        @endif
                    @endforeach
                @endif
            </div>
        @endforeach
    @endif

    {{-- Skip and Next Button here  --}}
    <div class="btn-holder d-flex mt-2">
        @php
            $param = [
                'mobile' => Crypt::encryptString($mobileNo),
                'assessment' => null,
                'state' => null,
            ];

            if (!empty($vn)) {
                $param['key'] = $vn;
            }
        @endphp
        <input type="hidden" name="user_notification" id="user_notification" class="user_notification"
            value="0">
        <input type="hidden" name="last_msg_sent" id="last_msg_sent" class="last_msg_sent" value="">
        <div class="d-flex flex-col flex-wrap justify-content-center justify-content-md-end">
            <span id="skip_btn" class="btn btn-light bg-success text-white d-none"
                style="background:#1476A1 !important;">{{ __('questionnaire.Book Appointment') }}
            </span>
            <button type="button" value="prev"
                class="btn btn-light bg-primary text-white btn-action-previous mx-2" id="prev_btn"
                style="background:#1476A1 !important;">{{ __('questionnaire.Previous') }} </button>
            <button type="button" value="next"
                class="btn btn-light bg-primary text-white btn-action-next " id="next_btn"
                style="background:#1476A1 !important;">{{ __('questionnaire.Next') }} </button>
        </div>
    </div>
    <div class="card border-0 d-block d-sm-none text-right">
        <div class="row">
            <div class="col-3">
            </div>
            <div class="col-9">
                <img src="{{ asset('assets/img/web/bottom.png') }}" class="card-img-top rounded-0 d-none d-sm-block"
                    alt="...">
            </div>
        </div>
    </div>
</form>
</div>
<div class="col-md-4 d-none d-md-inline-block">
<img src="{{ asset('assets/img/web/bottom.png') }}" class="card-img-top rounded-0" alt="...">
</div>
</div>
@endsection

@push('scripts')
<script>
    const getCheckedOption = (value) => {
        if (value === "I know my Risk") {
            $("#skip_btn").removeClass('d-none');
            if (!$("#next_btn").hasClass('d-none')) $("#next_btn").addClass('d-none');
            document.getElementById('I want to know my Risk').checked = false
        } else if (value === "I want to know my Risk") {
            document.getElementById('I know my Risk').checked = false
            $("#skip_btn").addClass('d-none');
            $("#next_btn").removeClass('d-none');
        }
    }

    document.querySelector("#skip_btn").addEventListener('click', function() {
        // $("#user_notification").val(1);
        document.querySelector('form').submit();
    })
    document.addEventListener('DOMContentLoaded', function() {
        const sections = document.querySelectorAll('.section');
        let currentSectionIndex = 0;
        let isFormSubmitted = false; // Declare this variable

        function showSection(index) {
            if (index === 1) {
                $('#next_btn').addClass('d-none');
            } else if (index > 1) {
                $('#next_btn').removeClass('d-none');
                $('#skip_btn').removeClass('d-none');
                $('.direct-booking').hide();
                $('.btn-action-previous').show();
            } else {
                $('#next_btn').removeClass('d-none');
                $('#skip_btn').addClass('d-none');
                $('.direct-booking').show();
                $('.btn-action-previous').hide();
            }

            sections.forEach((section, i) => {
                section.style.display = i === index ? 'block' : 'none';
            });
        }

        document.querySelectorAll('.btn-action-next').forEach(button => {
            button.addEventListener('click', function(event) {
                if (validateCurrentSection()) {
                    if (currentSectionIndex == 0) {
                        $.ajax({
                            url: "/updateNotificationStage",
                            dataType: "JSON",
                            method: "GET",
                            data: {
                                risk_assessment_id: $('#risk_assessment_id').val(),
                                notification_stage: 1
                            }
                        });
                    }
                    if (currentSectionIndex == (sections.length - 1)) {
                        // $("#user_notification").val(1);
                        document.querySelector('form').submit();
                        return;
                    }
                    currentSectionIndex++;
                    document.getElementById("tell_us").style.display = "none"
                    document.getElementById("next_btn").style.display = "block";
                    document.getElementById("skip_btn").style.display = "block";
                    showSection(currentSectionIndex);
                }
            });
        });

        document.querySelectorAll('.btn-action-previous').forEach(button => {
            button.addEventListener('click', function(event) {
                currentSectionIndex--;

                showSection(currentSectionIndex);
            });
        });

        function validateCurrentSection() {
            const sec = $(sections[0]);
            let isValid = true;
            let arr = ['age', 'gender', 'have-you-ever-tested-for-hiv-before']
            let final = []
            let input = $(sec).find('.form-check input[type="radio"]');
            $(input).each((i, ele) => {
                if ($(ele).is(":checked")) {
                    final.push($(ele).attr('name'))
                }

            });
            if (final.length == 3) {
                isValid = true
            } else {
                alert('Please select at least one option.');
                isValid = false
            }



            return isValid;
        }

        document.querySelector('form').addEventListener('submit', function() {
            isFormSubmitted = true;
        });

        showSection(currentSectionIndex);
    });

    $(function() {
        $('.question-attempt').on('click', function() {
            $.ajax({
                url: "/addCounter",
                dataType: "JSON",
                method: "GET",
                data: {
                    question_id: $(this).attr('data-question-id')
                }
            });
        });
        $('.question-attempted').on('change', function() {
            console.log($(this).val());
            let answer_id = $(this).val();

            if ($(this).attr('type') == 'checkbox') {
                let checkedData = [];
                $('#' + $(this).attr('data-slug')).find('input[type=checkbox]').each(function(key,
                    val) {
                    if ($(val).is(':checked'))
                        checkedData.push($(val).val());
                })
                answer_id = checkedData;
            }

            $.ajax({
                url: "/add-answer",
                dataType: "JSON",
                method: "GET",
                data: {
                    risk_assessment_id: $('#risk_assessment_id').val(),
                    question_id: $(this).attr('data-question-id'),
                    answer_id: answer_id
                }
            });
        });
    })
</script>
@endpush
