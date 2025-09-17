<?php if($media): ?>
    <a href="<?php echo e($media); ?>" target="_blank" role="button" class="text-default">
        <strong>Download</strong>
    </a>
<?php endif; ?>
<?php if($media): ?>
    <?php if($evidence): ?>
        | <a href="<?php echo e(asset('storage/' . $evidence)); ?>" target="_blank" role="button" class="text-default">
            <strong>Show Evidence</strong>
        </a>
    <?php endif; ?>
<?php else: ?>
    <a href="<?php echo e(asset('storage/' . $evidence)); ?>" target="_blank" role="button" class="text-default">
        <strong>Show Evidence</strong>
    </a>
<?php endif; ?>
<?php if($evidence2): ?>
    | <a href="<?php echo e(asset('storage/' . $evidence2)); ?>" target="_blank" role="button" class="text-default">
        <strong>Show Evidence</strong>
    </a>
<?php endif; ?>
<?php if($evidence3): ?>
    | <a href="<?php echo e(asset('storage/' . $evidence3)); ?>" target="_blank" role="button" class="text-default">
        <strong>Show Evidence</strong>
    </a>
<?php endif; ?>
<?php if($evidence4): ?>
    | <a href="<?php echo e(asset('storage/' . $evidence4)); ?>" target="_blank" role="button" class="text-default">
        <strong>Show Evidence</strong>
    </a>
<?php endif; ?>
<?php if($evidence5): ?>
    | <a href="<?php echo e(asset('storage/' . $evidence5)); ?>" target="_blank" role="button" class="text-default">
        <strong>Show Evidence</strong>
    </a>
<?php endif; ?>
<?php /**PATH /var/www/netreach2/resources/views/self/admin/ajax/invoice-btn.blade.php ENDPATH**/ ?>