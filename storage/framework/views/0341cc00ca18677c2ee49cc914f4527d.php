<?php
    use App\Models\LanguageModule\Language;
?>

<section>
    <div class="row mb-2 question-row">
        <div class="col-md-2">
            <select class="form-control" name="locale[]">
                <?php $__currentLoopData = $language; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(empty($existingLocale)): ?>
                        <option value="<?php echo e($value[Language::locale]); ?>"><?php echo e($value[Language::name]); ?></option>
                    <?php else: ?>
                        <?php if(!$existingLocale->contains($value[Language::locale])): ?>
                            <option value="<?php echo e($value[Language::locale]); ?>"><?php echo e($value[Language::name]); ?></option>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-md-9">
            <input type="text" class="form-control" name="question[]" placeholder="Enter Question">
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-danger float-right remove-question">
                <i class="fa fa-times"></i>
            </button>
        </div>
    </div>
</section><?php /**PATH /var/www/netreach2/resources/views/chatbot/admin/ajax/question.blade.php ENDPATH**/ ?>