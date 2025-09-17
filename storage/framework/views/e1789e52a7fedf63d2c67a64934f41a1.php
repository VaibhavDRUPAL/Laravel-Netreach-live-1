<?php if($mediaType == PLAIN_TEXT || $mediaType == LINK || $mediaType == VIDEO): ?>
    <input type="text" class="form-control" name="<?php echo e($fieldType . UNDERSCORE . $mediaType . UNDERSCORE . $index); ?>" data-index="<?php echo e($index); ?>">
<?php elseif($mediaType == IMAGE || $mediaType == AUDIO): ?>
    <input type="file" accept="<?php echo e($mediaType == IMAGE ? '.jpg' : '.mp3'); ?>" class="form-control" name="<?php echo e($fieldType . UNDERSCORE . $mediaType . UNDERSCORE . $index); ?>" data-index="<?php echo e($index); ?>">
<?php elseif($mediaType == HTML): ?>
    <input type="text" class="form-control" name="<?php echo e($fieldType . UNDERSCORE . $mediaType . UNDERSCORE . $index); ?>" data-index="<?php echo e($index); ?>">
<?php endif; ?><?php /**PATH /var/www/netreach2/resources/views/chatbot/admin/ajax/media_type.blade.php ENDPATH**/ ?>