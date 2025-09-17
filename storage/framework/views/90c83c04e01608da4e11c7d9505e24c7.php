<?php $__env->startSection('title'); ?>
    Self Risk Assessment Tool
<?php $__env->stopSection(); ?>

<?php $__env->startSection('body'); ?>
    <?php
        use App\Models\SelfModule\{RiskAssessmentQuestionnaire, RiskAssessmentAnswer};
    ?>
    <?php if(!$verify): ?>
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
                        <form action="<?php echo e(url('verifyOTP')); ?>" method="post">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="mobile-no" id="mobile-no">
                            <?php if(empty(!$vn)): ?>
                                <input type="hidden" name="vn" value="<?php echo e($vn); ?>">
                            <?php endif; ?>
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
    <?php endif; ?>
    <?php if($verify): ?>
        <div class="row">
            <div class="alert alert-success">
                Mobile number is verified successfully. Your mobile number is: <?php echo e($mobileNo); ?>

            </div>
            <input type="hidden" id="status" value="<?php echo e(old($verify) ? old($verify) : $verify); ?>">
            <form class="w-100" action="<?php echo e(url('self-risk-assessment')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <?php
                    $count = 1;
                ?>
                <?php if(!empty($vn) || old('vn')): ?>
                    <input type="hidden" name="vn" value="<?php echo e(old('vn') ? old('vn') : $vn); ?>">
                <?php endif; ?>
                <?php $__currentLoopData = $questionnaire; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $questionInputType = $question[RiskAssessmentQuestionnaire::answer_input_type];
                    ?>
                    <div class="col-md-12">
                        <div class="form-group">
                            <?php if($questionInputType != IN_SELECT): ?>
                                <label for="<?php echo e($question[RiskAssessmentQuestionnaire::question_slug]); ?>"><?php echo e($count++); ?>. <?php echo e($question[RiskAssessmentQuestionnaire::question]); ?></label>
                            <?php endif; ?>
                            <?php if($questionInputType == IN_TEXT): ?>
                                <input type="text" class="form-control attempt" value="<?php echo e($mobileNo); ?>" data-question-id="<?php echo e($question[RiskAssessmentQuestionnaire::question_id]); ?>" name="<?php echo e($question[RiskAssessmentQuestionnaire::question_slug]); ?>" id="<?php echo e($question[RiskAssessmentQuestionnaire::question_slug]); ?>" readonly>
                            <?php elseif($questionInputType == IN_SELECT): ?>
                                <input type="hidden" name="<?php echo e($question[RiskAssessmentQuestionnaire::question_slug]); ?>" id="<?php echo e($question[RiskAssessmentQuestionnaire::question_slug]); ?>" value="<?php echo e($state['id']); ?>">
                            <?php elseif($questionInputType == IN_RADIO): ?>
                                <?php if(empty(!$question['answers'])): ?>
                                    <?php $__currentLoopData = $question['answers']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $answer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="form-check">
                                            <input class="form-check-input attempt" type="<?php echo e($questionInputType); ?>" data-question-id="<?php echo e($question[RiskAssessmentQuestionnaire::question_id]); ?>" name="<?php echo e($question[RiskAssessmentQuestionnaire::question_slug]); ?>" id="<?php echo e($answer[RiskAssessmentAnswer::answer_id]); ?>" value="<?php echo e($answer[RiskAssessmentAnswer::answer_id]); ?>" <?php if(old($question[RiskAssessmentQuestionnaire::question_slug]) == $answer[RiskAssessmentAnswer::answer_id]): echo 'checked'; endif; ?>>
                                            <label class="form-check-label" for="<?php echo e($answer[RiskAssessmentAnswer::answer_id]); ?>">
                                                <?php echo e($answer[RiskAssessmentAnswer::answer]); ?>

                                            </label>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            <?php elseif($questionInputType == IN_CHECKBOX): ?>
                                <?php if(empty(!$question['answers'])): ?>
                                    <?php $__currentLoopData = $question['answers']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $answer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="form-check">
                                            <input class="form-check-input attempt" type="<?php echo e($questionInputType); ?>" data-question-id="<?php echo e($question[RiskAssessmentQuestionnaire::question_id]); ?>" name="<?php echo e($question[RiskAssessmentQuestionnaire::question_slug]); ?>[]" id="<?php echo e($answer[RiskAssessmentAnswer::answer_id]); ?>" value="<?php echo e($answer[RiskAssessmentAnswer::answer_id]); ?>" <?php if(old($question[RiskAssessmentQuestionnaire::question_slug]) && in_array($answer[RiskAssessmentAnswer::answer_id], old($question[RiskAssessmentQuestionnaire::question_slug]))): echo 'checked'; endif; ?>>
                                            <label class="form-check-label" for="<?php echo e($answer[RiskAssessmentAnswer::answer_id]); ?>">
                                                <?php echo e($answer[RiskAssessmentAnswer::answer]); ?>

                                            </label>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-12">
                    <input type="submit" class="btn btn-success float-right w-25" value="Save">
                </div>
            </form>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('self.layout.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/self/risk-assessment.blade.php ENDPATH**/ ?>