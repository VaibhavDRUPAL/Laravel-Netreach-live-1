<?php
    use App\Models\ChatbotModule\{Greetings, Content};
?>
<li class="chat outgoing">
    <?php $__currentLoopData = $questionnaire; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <p class="question" name="question" data-id="<?php echo e($id); ?>" data-locale="<?php echo e($locale); ?>"><?php echo e(Str::squish($question[Greetings::body])); ?></p>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <div class="extra">
        <?php $__currentLoopData = $contentData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $content): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($content[Content::slug] == LOAD_MORE): ?>
                <?php
                    $flag = false;
                ?>
                <?php $__currentLoopData = $content[Content::content]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($key == $locale): ?>
                        <span class="load-more" data-offset="<?php echo e($offset); ?>" data-locale="<?php echo e($locale); ?>"><?php echo e($item); ?></span>
                        <?php
                            $flag = true;
                        ?>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if(!$flag): ?>
                    <span class="load-more" data-offset="<?php echo e($offset); ?>" data-locale="<?php echo e($locale); ?>"><?php echo e($content[Content::content][Config::get('app.fallback_locale')]); ?></span>
                <?php endif; ?>
            <?php endif; ?>
            <?php if($content[Content::slug] == BOOK_AN_APPOINTMENT): ?>
                <?php $__currentLoopData = $content[Content::content]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($key == $locale): ?>
                        <span class="book-an-appointment"><?php echo e($item); ?></span>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</li> <?php /**PATH /var/www/netreach2/resources/views/chatbot/ajax/questionnaire.blade.php ENDPATH**/ ?>