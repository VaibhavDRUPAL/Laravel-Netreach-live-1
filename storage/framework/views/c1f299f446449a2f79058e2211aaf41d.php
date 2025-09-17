<?php $__env->startSection('title'); ?>
    Self Risk Assessment Tool
<?php $__env->stopSection(); ?>

<?php
    use App\Models\SelfModule\{RiskAssessmentQuestionnaire, RiskAssessmentAnswer};
?>

<?php $__env->startSection('content'); ?>
    <div class="row p-5 mt-xl-5">
        <div class="col-md-8">
            
            <?php
                $locale = app()->getLocale();
            ?>
            <form class="w-100 mt-5"
                action="<?php echo e(url($locale !== 'en' ? $locale . '/survey-appointment' : 'survey-appointment')); ?>"
                  id="self-risk-assessment-form" method="post">
                <?php echo csrf_field(); ?>

                <?php if(!empty($vn) || old('vn')): ?>
                    <input type="hidden" name="vn" value="<?php echo e(old('vn') ? old('vn') : $vn); ?>">
                <?php endif; ?>
                <input type="hidden" name="mobile" value="<?php echo e($mobileNo); ?>">
                <input type="hidden" name="state" value="<?php echo e($state?->id); ?>">
                <input type="hidden" name="risk_assessment_id" id="risk_assessment_id" value="<?php echo e($riskAssessmentID); ?>">

                <?php if($questionnaire->isNotEmpty()): ?>
                    <h3 class="ml-1" id="tell_us">
                        <?php echo e(__('questionnaire.Tell us about Yourself')); ?> </h3>

                    <?php
                        $questionNumber = 1;
                    ?>

                    <?php $__currentLoopData = $groupNo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="section">
                            <?php if($item == 2): ?>
                                <div class="form-group">
                                    <label for="" class="h3">
                                        <?php echo e(__('questionnaire.KYR')); ?>

                                    </label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="I know my Risk"
                                            value="I know my Risk" onclick="getCheckedOption(this.value)">
                                        <label class="form-check-label h5" for="I know my Risk">
                                            <?php echo e(__('questionnaire.I know my Risk')); ?>

                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="I want to know my Risk"
                                            value="I want to know my Risk" onclick="getCheckedOption(this.value)">
                                        <label class="form-check-label h5" for="I want to know my Risk">
                                            <?php echo e(__('questionnaire.I want to know my Risk')); ?>

                                        </label>
                                    </div>
                                </div>
                            <?php else: ?>
                                <?php
                                    $questionnaireGroup = $questionnaire
                                        ->where(RiskAssessmentQuestionnaire::group_no, $item)
                                        ->sortBy(RiskAssessmentQuestionnaire::priority);
                                ?>
                                <?php $__currentLoopData = $questionnaireGroup; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $questionInputType = $question[RiskAssessmentQuestionnaire::answer_input_type];
                                    ?>

                                    <label for="<?php echo e($question->question_slug); ?>" class="mt-4">

                                        <?php if(true): ?>
                                            <?php echo e($questionNumber++); ?>.
                                        <?php endif; ?>

                                        
                                        <?php if($locale == 'mr'): ?>
                                            <?php echo e($question->question_mr); ?>

                                        <?php elseif($locale == 'hi'): ?>
                                            <?php echo e($question->question_hi); ?>

                                        <?php elseif($locale == 'ta'): ?>
                                            <?php echo e($question->question_ta); ?>

                                        <?php elseif($locale == 'te'): ?>
                                            <?php echo e($question->question_te); ?>

                                        <?php else: ?>
                                            <?php echo e($question->question); ?>

                                        <?php endif; ?>

                                    </label>
                                    <?php if($questionInputType == IN_SELECT): ?>
                                        <select class="form-control question-attempted" name="state_id" id="input-state"
                                            data-question-id="<?php echo e($question[RiskAssessmentQuestionnaire::question_id]); ?>">
                                            <option hidden selected>--- Select State ---</option>
                                        <?php if(empty(!$statez)): ?>
                                            <?php $__currentLoopData = $statez; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($value['id']); ?>" <?php if($value['id'] == $stateID): echo 'selected'; endif; ?>>
                                                    <?php if($locale == 'mr'): ?>
                                                        <?php echo e($value['state_name_mr']); ?>

                                                    <?php elseif($locale == 'hi'): ?>
                                                        <?php echo e($value['state_name_hi']); ?>

                                                    <?php elseif($locale == 'ta'): ?>
                                                        <?php echo e($value['state_name_ta']); ?>

                                                    <?php elseif($locale == 'te'): ?>
                                                        <?php echo e($value['state_name_te']); ?>

                                                    <?php else: ?>
                                                        <?php echo e($value['state_name']); ?>

                                                    <?php endif; ?>
                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </select>
                                <?php endif; ?>


                                <?php if($questionInputType == IN_TEXT): ?>
                                    <input type="text" class="form-control question-attempt"
                                        value="<?php echo e($mobileNo); ?>"
                                        data-question-id="<?php echo e($question[RiskAssessmentQuestionnaire::question_id]); ?>"
                                        name="<?php echo e($question[RiskAssessmentQuestionnaire::question_slug]); ?>"
                                        id="<?php echo e($question[RiskAssessmentQuestionnaire::question_slug]); ?>" readonly>
                                <?php elseif($questionInputType == IN_RADIO): ?>
                                <?php if(empty(!$question['answers'])): ?>
                                    <?php $__currentLoopData = $question['answers']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $answer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="form-check">
                                            <input class="form-check-input question-attempt question-attempted"
                                                type="<?php echo e($questionInputType); ?>"
                                                data-question-id="<?php echo e($question[RiskAssessmentQuestionnaire::question_id]); ?>"
                                                name="<?php echo e($question[RiskAssessmentQuestionnaire::question_slug]); ?>"
                                                id="<?php echo e($answer[RiskAssessmentAnswer::answer_id]); ?>"
                                                value="<?php echo e($answer[RiskAssessmentAnswer::answer_id]); ?>"
                                                <?php if(isset($rawData[$question[RiskAssessmentQuestionnaire::question_slug]]) &&
                                                        $rawData[$question[RiskAssessmentQuestionnaire::question_slug]] == $answer[RiskAssessmentAnswer::answer_id]
                                                ): echo 'checked'; endif; ?>>
                                            <label class="form-check-label"
                                                for="<?php echo e($answer[RiskAssessmentAnswer::answer_id]); ?>">
                                                <?php if($locale == 'mr'): ?>
                                                    <?php echo e($answer[RiskAssessmentAnswer::answer_mr]); ?>

                                                <?php elseif($locale == 'hi'): ?>
                                                    <?php echo e($answer[RiskAssessmentAnswer::answer_hi]); ?>

                                                <?php elseif($locale == 'ta'): ?>
                                                    <?php echo e($answer[RiskAssessmentAnswer::answer_ta]); ?>

                                                <?php elseif($locale == 'te'): ?>
                                                    <?php echo e($answer[RiskAssessmentAnswer::answer_te]); ?>

                                                <?php else: ?>
                                                    <?php echo e($answer[RiskAssessmentAnswer::answer]); ?>

                                                <?php endif; ?>
                                            </label>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            <?php elseif($questionInputType == IN_CHECKBOX): ?>
                            <?php if(empty(!$question['answers'])): ?>
                                <div id="<?php echo e($question[RiskAssessmentQuestionnaire::question_slug]); ?>">
                                    <?php $__currentLoopData = $question['answers']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $answer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="form-check">
                                            <input class="form-check-input question-attempt question-attempted"
                                                type="<?php echo e($questionInputType); ?>"
                                                data-slug="<?php echo e($question[RiskAssessmentQuestionnaire::question_slug]); ?>"
                                                data-question-id="<?php echo e($question[RiskAssessmentQuestionnaire::question_id]); ?>"
                                                name="<?php echo e($question[RiskAssessmentQuestionnaire::question_slug]); ?>[]"
                                                id="<?php echo e($answer[RiskAssessmentAnswer::answer_id]); ?>"
                                                value="<?php echo e($answer[RiskAssessmentAnswer::answer_id]); ?>"
                                                <?php if(isset($rawData[$question[RiskAssessmentQuestionnaire::question_slug]]) &&
                                                        in_array(
                                                            $answer[RiskAssessmentAnswer::answer_id],
                                                            $rawData[$question[RiskAssessmentQuestionnaire::question_slug]])): echo 'checked'; endif; ?>>
                                            <label class="form-check-label"
                                                for="<?php echo e($answer[RiskAssessmentAnswer::answer_id]); ?>">
                                                <?php if($locale == 'mr'): ?>
                                                    <?php echo e($answer[RiskAssessmentAnswer::answer_mr]); ?>

                                                <?php elseif($locale == 'hi'): ?>
                                                    <?php echo e($answer[RiskAssessmentAnswer::answer_hi]); ?>

                                                <?php elseif($locale == 'ta'): ?>
                                                    <?php echo e($answer[RiskAssessmentAnswer::answer_ta]); ?>

                                                <?php elseif($locale == 'te'): ?>
                                                    <?php echo e($answer[RiskAssessmentAnswer::answer_te]); ?>

                                                <?php else: ?>
                                                    <?php echo e($answer[RiskAssessmentAnswer::answer]); ?>

                                                <?php endif; ?>
                                            </label>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>

    
    <div class="btn-holder d-flex mt-2">
        <?php
            $param = [
                'mobile' => Crypt::encryptString($mobileNo),
                'assessment' => null,
                'state' => null,
            ];

            if (!empty($vn)) {
                $param['key'] = $vn;
            }
        ?>
        <input type="hidden" name="user_notification" id="user_notification" class="user_notification"
            value="0">
        <input type="hidden" name="last_msg_sent" id="last_msg_sent" class="last_msg_sent" value="">
        <div class="d-flex flex-col flex-wrap justify-content-center justify-content-md-end">
            <span id="skip_btn" class="btn btn-light bg-success text-white d-none"
                style="background:#1476A1 !important;"><?php echo e(__('questionnaire.Book Appointment')); ?>

            </span>
            <button type="button" value="prev"
                class="btn btn-light bg-primary text-white btn-action-previous mx-2" id="prev_btn"
                style="background:#1476A1 !important;"><?php echo e(__('questionnaire.Previous')); ?> </button>
            <button type="button" value="next"
                class="btn btn-light bg-primary text-white btn-action-next " id="next_btn"
                style="background:#1476A1 !important;"><?php echo e(__('questionnaire.Next')); ?> </button>
        </div>
    </div>
    <div class="card border-0 d-block d-sm-none text-right">
        <div class="row">
            <div class="col-3">
            </div>
            <div class="col-9">
                <img src="<?php echo e(asset('assets/img/web/bottom.png')); ?>" class="card-img-top rounded-0 d-none d-sm-block"
                    alt="...">
            </div>
        </div>
    </div>
</form>
</div>
<div class="col-md-4 d-none d-md-inline-block">
<img src="<?php echo e(asset('assets/img/web/bottom.png')); ?>" class="card-img-top rounded-0" alt="...">
</div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.apphome', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/home/survey/questionnaire.blade.php ENDPATH**/ ?>