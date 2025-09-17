<?php $__env->startPush('pg_btn'); ?>
    <a href="<?php echo e(route('permissions.index')); ?>" class="btn btn-sm btn-neutral">All Permissions</a>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-body">
                    <?php echo Form::open(['route' => 'permissions.store']); ?>

                    <h6 class="heading-small text-muted mb-4">Permission information</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <?php echo e(Form::label('name', 'Name', ['class' => 'form-control-label'])); ?>

                                        <?php echo e(Form::text('name', null, ['class' => 'form-control'])); ?>

                                        <small class="text-small text-muted">You can add multiple permission using comma. ex add-user, edit-user, update-user</small>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/permissions/create.blade.php ENDPATH**/ ?>