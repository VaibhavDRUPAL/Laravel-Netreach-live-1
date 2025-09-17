<?php
use App\Models\LanguageModule\Language;
?>
<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <span class="locale" data-key="<?php echo e($key); ?>" data-value="<?php echo e($language[Language::locale]); ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo e($language[Language::label_as]); ?>"><?php echo e($language[Language::name]); ?></span>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH /var/www/netreach2/resources/views/chatbot/ajax/language.blade.php ENDPATH**/ ?>