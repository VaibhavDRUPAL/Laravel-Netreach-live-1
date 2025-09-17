<?php
    use App\Models\ChatbotModule\Content;
    use App\Models\LanguageModule\Language;
?>

<?php if(isset($data) && !empty($data[Content::content])): ?>
    <?php
        $index = 0;
    ?>
    <?php $__currentLoopData = $data[Content::content]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $content): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <section data-section="<?php echo e($index); ?>">
            <div class="row mb-2 content-row">
                <div class="col-md-3">
                    <select class="form-control content-language" name="locale[]" data-index="<?php echo e($index); ?>">
                        <option disabled selected hidden>Select Language</option>
                        <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($value[Language::locale]); ?>" <?php if($value[Language::locale] == $key): echo 'selected'; endif; ?>><?php echo e($value[Language::name]); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="content[]" id="content_<?php echo e($index); ?>" value="<?php echo e($content); ?>" data-index="<?php echo e($index); ?>">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger float-right remove-content" data-locale="<?php echo e($key); ?>" data-index="<?php echo e($index); ?>">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            </div>
        </section>
        <?php
            $index++;
        ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php else: ?>
    <section data-section="en">
        <div class="row mb-2 content-row">
            <div class="col-md-3">
                <select class="form-control content-language" name="locale[]">
                    <option disabled selected hidden>Select Language</option>
                    <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($value[Language::locale]); ?>"><?php echo e($value[Language::name]); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-8">
                <input type="text" class="form-control" name="content[]">
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-danger float-right remove-content" data-locale="en">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        </div>
    </section>
<?php endif; ?><?php /**PATH /var/www/netreach2/resources/views/chatbot/admin/ajax/content.blade.php ENDPATH**/ ?>