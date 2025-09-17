<?php
    use App\Models\ChatbotModule\{Content, Questionnaire};
    use App\Models\MediaModule\MediaType;
?>
<li class="chat">
    <img style="width: 40px;margin-left:5px;margin-right:5px;margin-bottom:10px;" src="<?php echo e(App::isProduction() ? secure_asset('assets/img/chatbot/chatbot.gif') : asset('assets/img/chatbot/chatbot.gif')); ?>" alt="Chatbot Image" class="chatbot-image">
    <div class="incoming">
        <?php $__currentLoopData = $data[Questionnaire::body]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $answer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($answer[MediaType::media_type] == PLAIN_TEXT): ?>
                <p><?php echo e(Str::squish($answer[Questionnaire::content])); ?></p>
            <?php elseif($answer[MediaType::media_type] == IMAGE): ?>
                <img src="<?php echo e(mediaOperations($answer[Questionnaire::content], null, FL_GET_URL)); ?>" alt="">
            <?php elseif($answer[MediaType::media_type] == VIDEO): ?>
                <iframe width="400" height="250" src="<?php echo e($answer[Questionnaire::content]); ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            <?php elseif($answer[MediaType::media_type] == LINK): ?>
                <a target="_blank" href="<?php echo e($answer[Questionnaire::content]); ?>"><?php echo e($answer[Questionnaire::title]); ?></a>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php $__currentLoopData = $contentData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $content): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($content[Content::slug] == ASK_ANOTHER_QUESTION): ?>
                <?php
                    $flag = false;
                ?>
                <?php $__currentLoopData = $content[Content::content]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($key == $locale): ?>
                        <p><?php echo e($item); ?></p>
                        <?php
                            $flag = true;
                        ?>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if(!$flag): ?>
                    <p><?php echo e($content[Content::content][Config::get('app.fallback_locale')]); ?></p>
                <?php endif; ?>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</li>
<li class="chat outgoing">
    <?php $__currentLoopData = $contentData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $content): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($content[Content::slug] == ASK_ANOTHER_QUESTION_YES): ?>
            <?php
                $flag = false;
            ?>
            <?php $__currentLoopData = $content[Content::content]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($key == $locale): ?>
                    <p class="show-more" data-id="<?php echo e($questionID); ?>" data-locale="<?php echo e($locale); ?>"><?php echo e($item); ?></p>
                    <?php
                        $flag = true;
                    ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php if(!$flag): ?>
                <p class="show-more" data-id="<?php echo e($questionID); ?>" data-locale="<?php echo e($locale); ?>"><?php echo e($content[Content::content][Config::get('app.fallback_locale')]); ?></p>
            <?php endif; ?>
        <?php endif; ?>
        <?php if($content[Content::slug] == ASK_ANOTHER_QUESTION_NO): ?>
            <?php
                $flag = false;
            ?>
            <?php $__currentLoopData = $content[Content::content]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($key == $locale): ?>
                    <p class="no-thats-all"><?php echo e($item); ?></p>
                    <?php
                        $flag = true;
                    ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php if(!$flag): ?>
                <p class="no-thats-all"><?php echo e($content[Content::content][Config::get('app.fallback_locale')]); ?></p>
            <?php endif; ?>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</li>
<?php /**PATH /var/www/netreach2/resources/views/chatbot/ajax/answers.blade.php ENDPATH**/ ?>