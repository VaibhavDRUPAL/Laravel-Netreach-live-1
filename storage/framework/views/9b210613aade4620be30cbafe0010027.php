<?php $__empty_1 = true; $__currentLoopData = $followups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $followup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="border p-2 mb-3">
        <p><strong>Date:</strong> <?php echo e(\Carbon\Carbon::parse($followup->created_at)->format('d-m-Y H:i')); ?></p>
        <p><strong>Contacted:</strong>
            <?php echo e($followup->contacted == 0 ? 'No' : 'Yes'); ?></p>
        <p><strong>Action Taken:</strong> <?php echo e($followup->action_taken); ?></p>
        <?php if($followup->follow_up_image): ?>
            <p><strong>Attachment:</strong></p>
            <img src="<?php echo e(asset('storage/' . $followup->follow_up_image)); ?>" alt="Attachment"
                style="max-width: 100%; border: 1px solid #ccc;">
        <?php endif; ?>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <p>No Follow Up entries found.</p>
<?php endif; ?>
<?php /**PATH /var/www/netreach2/resources/views/self/admin/ajax/viewFollowups.blade.php ENDPATH**/ ?>