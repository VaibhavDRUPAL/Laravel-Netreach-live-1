<?php $__env->startPush('pg_btn'); ?>
    <a href="<?php echo e(route('roles.index')); ?>" class="btn btn-sm btn-neutral">All Roles</a>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-body">
                    <?php echo Form::open(['route' => 'roles.store']); ?>

                    <h6 class="heading-small text-muted mb-4">Role information</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <?php echo e(Form::label('name', 'Name', ['class' => 'form-control-label'])); ?>

                                        <?php echo e(Form::text('name', null, ['class' => 'form-control'])); ?>

                                    </div>
                                </div>
                            </div>
                        <hr class="my-4" />
                        <div class="pl-lg-1">
                            <div class="row">
                                    <div class="col-lg-6">
                                        <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="form-group p-2 d-inline-block">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="permissions[]" value="<?php echo e($key); ?>" class="custom-control-input" id="<?php echo e($permission); ?>">
                                                <?php echo e(Form::label($permission, $permission, ['class' => 'custom-control-label'])); ?>

                                            </div>
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                            </div>
                        </div>
                        <div class="pl-lg-1">
                            <div class="row">
                                <div class="col-md-12">
                                    <?php echo e(Form::submit('Submit', ['class'=> 'mt-3 btn btn-primary'])); ?>

                                </div>
                            </div>
                        </div>
                    <?php echo Form::close(); ?>

                </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/roles/create.blade.php ENDPATH**/ ?>