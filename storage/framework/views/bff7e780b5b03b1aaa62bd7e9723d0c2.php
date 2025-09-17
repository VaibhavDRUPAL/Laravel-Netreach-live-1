<div class="ml-3 dropdown show">
    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="action" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        Select Action
    </a>
    <div class="dropdown-menu" aria-labelledby="action">
        <?php if(
            (in_array(auth()->user()->getRoleNames()->first(), [SUPER_ADMIN, PO_PERMISSION]) && $statusID != 0) ||
                (in_array(auth()->user()->getRoleNames()->first(), [SUPER_ADMIN, VN_USER_PERMISSION]) &&
                    in_array($statusID, [0, 3]))): ?>
            <a class="dropdown-item" href="<?php echo e(route('outreach.profile.edit', $id)); ?>">Edit Profile</a>
        <?php endif; ?>
        <a class="dropdown-item"
            href="<?php echo e(route('outreach.referral-service.create', ['sno' => urlencode($unique_serial_number), 'profile' => $id])); ?>">Add
            Referral</a>
        <a class="dropdown-item"
            href="<?php echo e(route('outreach.referral-service.index', ['sno' => urlencode($unique_serial_number), 'profile' => $id])); ?>">Show
            Referral</a>
        
        <?php if(empty(!$referral)): ?>
            <?php if(!empty($referral) && $referral['outcome_of_the_service_sought'] == 1): ?>
                <?php if($referral['service_type_id'] == 1 || $referral['service_type_id'] == 5): ?>
                    <a class="dropdown-item"
                        href="<?php echo e(route('outreach.plhiv.create', ['sno' => urlencode($unique_serial_number), 'profile' => $id])); ?>">Add
                        PLHIV Test</a>
                    <a class="dropdown-item"
                        href="<?php echo e(route('outreach.plhiv.index', ['sno' => urlencode($unique_serial_number), 'profile' => $id])); ?>">Show
                        PLHIV Test</a>
                <?php endif; ?>
                <?php if($referral['service_type_id'] == 2 || $referral['service_type_id'] == 5): ?>
                    <a class="dropdown-item"
                        href="<?php echo e(route('outreach.sti.create', ['sno' => urlencode($unique_serial_number), 'profile' => $id, 'user_id' => $id])); ?>">Add
                        STI</a>
                    <a class="dropdown-item"
                        href="<?php echo e(route('outreach.sti.index', ['sno' => urlencode($unique_serial_number), 'profile' => $id])); ?>">Show
                        STI</a>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
<?php if(auth()->user()->getRoleNames()->first() == SUPER_ADMIN): ?>
    <a role="button" class="btn btn-danger text-white item-delete" data-id="<?php echo e($id); ?>">
        <i class="fas fa-trash"></i>
    </a>
<?php endif; ?>
<?php /**PATH /var/www/netreach2/resources/views/outreach/ajax/action.blade.php ENDPATH**/ ?>