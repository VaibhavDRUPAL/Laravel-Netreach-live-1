<?php
    use App\Models\ChatbotModule\Content;
?>

<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $content): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if($content[Content::slug] == CHAT_AGAIN): ?>
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
    <?php if($loop->first): ?>
        <div class="button-group">
    <?php endif; ?>
        <?php if($content[Content::slug] == CHAT_AGAIN_CANCEL): ?>
            <?php
                $flag = false;
            ?>
            <?php $__currentLoopData = $content[Content::content]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($key == $locale): ?>
                    <button class="btn cancel-btn"><?php echo e($item); ?></button>
                    <?php
                        $flag = true;
                    ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php if(!$flag): ?>
                <button class="btn cancel-btn"><?php echo e($content[Content::content][Config::get('app.fallback_locale')]); ?></button>
            <?php endif; ?>
        <?php endif; ?>
        <?php if($content[Content::slug] == CHAT_AGAIN_CONFIRM): ?>
            <?php
                $flag = false;
            ?>
            <?php $__currentLoopData = $content[Content::content]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($key == $locale): ?>
                    <button class="btn confirm-btn"><?php echo e($item); ?></button>
                    <?php
                        $flag = true;
                    ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php if(!$flag): ?>
                <button class="btn confirm-btn"><?php echo e($content[Content::content][Config::get('app.fallback_locale')]); ?></button>
            <?php endif; ?>
        <?php endif; ?>
    <?php if($loop->last): ?>
        </div>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH /var/www/netreach2/resources/views/chatbot/ajax/reset.blade.php ENDPATH**/ ?>