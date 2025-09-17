<?php
use App\Models\ChatbotModule\Greetings;
use App\Models\MediaModule\MediaType;
?>
<li class="chat">
    <img style="width: 40px;margin-left:5px;margin-right:5px;margin-bottom:10px;" src="<?php echo e(App::isProduction() ? secure_asset('assets/img/chatbot/chatbot.gif') : asset('assets/img/chatbot/chatbot.gif')); ?>" alt="Chatbot Image" class="chatbot-image">
    <div class="incoming">
        <?php $__currentLoopData = $greetings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $greeting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($greeting[MediaType::media_type] == PLAIN_TEXT): ?>
        <p><?php echo e(Str::squish($greeting[Greetings::body])); ?></p>
        <?php elseif($greeting[MediaType::media_type] == IMAGE): ?>
        <img src="<?php echo e(mediaOperations($greeting[Greetings::body], null, FL_CHECK_EXIST) ? mediaOperations($greeting[Greetings::body], null, FL_GET_URL) : '#'); ?>" alt="">
        <?php elseif($greeting[MediaType::media_type] == VIDEO): ?>
        <iframe width="400" height="250" src="<?php echo e($greeting[Greetings::body]); ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
        <?php elseif($greeting[MediaType::media_type] == LINK): ?>
        <a target="_blank" href="<?php echo e($greeting[Greetings::body]); ?>"><?php echo e($greeting[Greetings::body]); ?></a>
        <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</li>
<?php /**PATH /var/www/netreach2/resources/views/chatbot/ajax/greetings.blade.php ENDPATH**/ ?>