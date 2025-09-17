<?php
    use App\Models\MediaModule\MediaType;
    use App\Models\ChatbotModule\Questionnaire;

    $flag = true;
?>

<?php if(isset($existing) && !empty($existing[Questionnaire::answer_sheet])): ?>
    <?php $__currentLoopData = $existing[Questionnaire::answer_sheet]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $answer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($answer[Questionnaire::locale] == $locale): ?>
            <?php
                $flag = false;
            ?>
            <?php $__currentLoopData = $answer[Questionnaire::body]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $body): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <section>
                    <div class="row mb-2 answer-row">
                        <div class="col-md-2">
                            <select class="form-control media-type" name="media_type[]" data-index="<?php echo e($key); ?>">
                                <option disabled selected hidden>Select Media Type</option>
                                <?php $__currentLoopData = $mediaType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($value[MediaType::slug]); ?>" <?php if($body[MediaType::media_type] == $value[MediaType::slug]): echo 'selected'; endif; ?>><?php echo e($value[MediaType::type_name]); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <?php if($body[MediaType::media_type] == LINK): ?>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="<?php echo e(Questionnaire::answer . UNDERSCORE . $body[MediaType::media_type] . UNDERSCORE . $key . UNDERSCORE . Questionnaire::title); ?>" value="<?php echo e($body[Questionnaire::title]); ?>" data-name="<?php echo e(Questionnaire::answer . UNDERSCORE . $body[MediaType::media_type]); ?>" data-index="<?php echo e($key); ?>" placeholder="Enter Link Title">
                            </div>
                        <?php endif; ?>
                        <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['col-md-6' => $body[MediaType::media_type] == LINK , 'col-md-8' => $body[MediaType::media_type] == IMAGE || $body[MediaType::media_type] == AUDIO, 'col-md-9' => $body[MediaType::media_type] != LINK && $body[MediaType::media_type] != IMAGE && $body[MediaType::media_type] != AUDIO && isset($isAjax) && $isAjax]); ?>">
                            <?php if($body[MediaType::media_type] == PLAIN_TEXT || $body[MediaType::media_type] == LINK || $body[MediaType::media_type] == VIDEO): ?>
                                <input type="text" class="form-control" name="<?php echo e(Questionnaire::answer . UNDERSCORE . $body[MediaType::media_type] . UNDERSCORE . $key); ?>" value="<?php echo e($body[Questionnaire::content]); ?>" data-name="<?php echo e(Questionnaire::answer . UNDERSCORE . $body[MediaType::media_type]); ?>" data-index="<?php echo e($key); ?>" placeholder="Enter Answer">
                            <?php elseif($body[MediaType::media_type] == IMAGE || $body[MediaType::media_type] == AUDIO): ?>
                                <input type="file" class="form-control" name="<?php echo e(Questionnaire::answer . UNDERSCORE . $body[MediaType::media_type] . UNDERSCORE . $key); ?>" data-name="<?php echo e(Questionnaire::answer . UNDERSCORE . $body[MediaType::media_type]); ?>" data-index="<?php echo e($key); ?>" placeholder="Enter Answer">
                                <input type="hidden" name="<?php echo e(Questionnaire::answer . UNDERSCORE . $body[MediaType::media_type] . UNDERSCORE . $key . UNDERSCORE . 'old'); ?>" value="<?php echo e($body[Questionnaire::content]); ?>">
                            <?php elseif($body[MediaType::media_type] == HTML): ?>
                                <input type="text" class="form-control" name="<?php echo e(Questionnaire::answer . UNDERSCORE . $body[MediaType::media_type] . UNDERSCORE . $key); ?>" value="<?php echo e($body[Questionnaire::content]); ?>" data-name="<?php echo e(Questionnaire::answer . UNDERSCORE . $body[MediaType::media_type]); ?>" data-index="<?php echo e($key); ?>" placeholder="Enter Answer">    
                            <?php endif; ?>
                        </div>
                        <?php if($body[MediaType::media_type] == IMAGE || $body[MediaType::media_type] == AUDIO): ?>
                            <div class="col-md-1">
                                <a class="btn btn-primary float-right" target="_blank" href="<?php echo e(mediaOperations($body[Questionnaire::content], null, FL_GET_URL)); ?>" role="button">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </div>
                        <?php endif; ?>
                        <?php if(isset($isAjax)): ?>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-danger float-right remove-answer">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>    

<?php if($flag): ?>
    <?php
        $key = isset($count) ? $count : 0;
    ?>
    <section>
        <div class="row mb-2 answer-row">
            <div class="col-md-2">
                <select class="form-control media-type" name="media_type[]" data-index="<?php echo e($key); ?>">
                    <?php $__currentLoopData = $mediaType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($value[MediaType::slug]); ?>" <?php if($value[MediaType::slug] == PLAIN_TEXT): echo 'selected'; endif; ?>><?php echo e($value[MediaType::type_name]); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-9">
                <input type="text" class="form-control" name="<?php echo e(Questionnaire::answer . UNDERSCORE . PLAIN_TEXT . UNDERSCORE . $count); ?>" data-name="<?php echo e(Questionnaire::answer . UNDERSCORE . PLAIN_TEXT); ?>" data-index="<?php echo e($count); ?>" placeholder="Enter Answer">
            </div>
            <?php if(isset($isAjax)): ?>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger float-right remove-answer">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?><?php /**PATH /var/www/netreach2/resources/views/chatbot/admin/ajax/answer.blade.php ENDPATH**/ ?>