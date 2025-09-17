<?php $__env->startPush('pg_btn'); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update-user')): ?>
        <a class="btn btn-info btn-sm m-1" data-toggle="tooltip" data-placement="top" title="Edit user details" href="<?php echo e(route('users.edit',$user)); ?>">
            <i class="fa fa-edit" aria-hidden="true"></i> Edit User
        </a>
    <?php endif; ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-1">
                            Name
                        </div>
                        <div class="col-sm-3">
                            <strong><?php echo e($user->name); ?></strong>
                        </div>
                        <div class="col-sm-8 text-right">
                            <?php if($user->profile_photo): ?>
                                <a href="<?php echo e(asset($user->profile_photo)); ?>" target="_blank">
                                    <img width="100" height="100" class="img-fluid rounded-pill" src="<?php echo e(asset($user->profile_photo)); ?>" alt="">
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-1">
                            Email
                        </div>
                        <div class="col-sm-3">
                            <strong><?php echo e($user->email); ?></strong>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-1">
                            Phone
                        </div>
                        <div class="col-sm-3">
                            <strong><?php echo e($user->phone_number); ?></strong>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-1">
                            Role
                        </div>
                        <div class="col-sm-3">
                            <?php $__currentLoopData = $user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <strong><?php echo e($role->name); ?></strong>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-1">
                            Status
                        </div>
                        <div class="col-sm-3">
                            <?php echo e($user->status ? 'Active' : 'Disable'); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/users/show.blade.php ENDPATH**/ ?>