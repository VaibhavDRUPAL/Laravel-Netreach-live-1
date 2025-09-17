<?php
    use App\Models\ChatbotModule\Greetings;
    use App\Models\LanguageModule\Language;
    use App\Models\MediaModule\MediaType;
?>

<?php if(isset($existing) && !empty($existing[Greetings::greetings])): ?>
    <?php $__currentLoopData = $existing[Greetings::greetings]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $greeting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <section>
            <div class="row mb-2 greeting-row">
                <div class="col-md-2">
                    <select class="form-control language" name="locale[]" data-index="<?php echo e($key); ?>">
                        <option disabled selected hidden>Select Language</option>
                        <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($value[Language::locale]); ?>" <?php if($value[Language::locale] == $greeting[Language::locale]): echo 'selected'; endif; ?>><?php echo e($value[Language::name]); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-control media-type" name="media_type[]" data-index="<?php echo e($key); ?>">
                        <option disabled selected hidden>Select Media Type</option>
                        <?php $__currentLoopData = $mediaType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($value[MediaType::slug]); ?>" <?php if($greeting[MediaType::media_type] == $value[MediaType::slug]): echo 'selected'; endif; ?>><?php echo e($value[MediaType::type_name]); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['col-md-8' => !isset($isAjax), 'col-md-7' => $greeting[MediaType::media_type] != IMAGE && $greeting[MediaType::media_type] != AUDIO && isset($isAjax) && $isAjax, 'col-md-6' => $greeting[MediaType::media_type] == IMAGE || $greeting[MediaType::media_type] == AUDIO]); ?>">
                    <?php if($greeting[MediaType::media_type] == PLAIN_TEXT || $greeting[MediaType::media_type] == LINK || $greeting[MediaType::media_type] == VIDEO): ?>
                        <input type="text" class="form-control" name="<?php echo e(Greetings::greetings . UNDERSCORE . $greeting[MediaType::media_type] . UNDERSCORE . $key); ?>" value="<?php echo e($greeting[Greetings::body]); ?>" data-name="<?php echo e(Greetings::greetings . UNDERSCORE . $greeting[MediaType::media_type]); ?>" data-index="<?php echo e($key); ?>">
                    <?php elseif($greeting[MediaType::media_type] == IMAGE || $greeting[MediaType::media_type] == AUDIO): ?>
                        <input type="file" class="form-control" name="<?php echo e(Greetings::greetings . UNDERSCORE . $greeting[MediaType::media_type] . UNDERSCORE . $key); ?>" data-name="<?php echo e(Greetings::greetings . UNDERSCORE . $greeting[MediaType::media_type]); ?>" data-index="<?php echo e($key); ?>">
                        <input type="hidden" name="<?php echo e(Greetings::greetings . UNDERSCORE . $greeting[MediaType::media_type] . UNDERSCORE . $key . UNDERSCORE . 'old'); ?>" value="<?php echo e($greeting[Greetings::body]); ?>">
                    <?php elseif($greeting[MediaType::media_type] == HTML): ?>
                        <input type="text" class="form-control" name="<?php echo e(Greetings::greetings . UNDERSCORE . $greeting[MediaType::media_type] . UNDERSCORE . $key); ?>" value="<?php echo e($greeting[Greetings::body]); ?>" data-name="<?php echo e(Greetings::greetings . UNDERSCORE . $greeting[MediaType::media_type]); ?>" data-index="<?php echo e($key); ?>">    
                    <?php endif; ?>
                </div>
                <?php if($greeting[MediaType::media_type] == IMAGE || $greeting[MediaType::media_type] == AUDIO): ?>
                    <div class="col-md-1">
                        <a class="btn btn-primary float-right" target="_blank" href="<?php echo e(mediaOperations($greeting[Greetings::body], null, FL_CHECK_EXIST) ? mediaOperations($greeting[Greetings::body], null, FL_GET_URL) : '#'); ?>" role="button">
                            <i class="fa fa-eye"></i>
                        </a>
                    </div>
                <?php endif; ?>
                <?php if(isset($isAjax)): ?>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger float-right remove-greeting" data-index="<?php echo e($key); ?>">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php else: ?>
    <?php
        $key = isset($count) ? $count : 0;
    ?>
    <section>
        <div class="row mb-2 greeting-row">
            <div class="col-md-2">
                <select class="form-control language" name="locale[]" data-index="<?php echo e($key); ?>">
                    <option disabled selected hidden>Select Language</option>
                    <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($value[Language::locale]); ?>"><?php echo e($value[Language::name]); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-control media-type" name="media_type[]" data-index="<?php echo e($key); ?>">
                    <option disabled selected hidden>Select Media Type</option>
                    <?php $__currentLoopData = $mediaType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($value[MediaType::slug]); ?>"><?php echo e($value[MediaType::type_name]); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['col-md-8' => !isset($isAjax), 'col-md-7' => isset($isAjax) && $isAjax]); ?>">
                <input type="text" class="form-control" name="<?php echo e(Greetings::greetings . UNDERSCORE . PLAIN_TEXT . UNDERSCORE . $key); ?>" data-index="<?php echo e($key); ?>">
            </div>
            <?php if(isset($isAjax)): ?>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger float-right remove-greeting" data-index="<?php echo e($key); ?>">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?><?php /**PATH /var/www/netreach2/resources/views/chatbot/admin/ajax/greetings.blade.php ENDPATH**/ ?>