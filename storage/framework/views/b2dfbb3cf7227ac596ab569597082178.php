<?php $__env->startPush('pg_btn'); ?>
    <a href="<?php echo e(route('category.index')); ?>" class="btn btn-sm btn-neutral">All category</a>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-body">
                    <?php echo Form::open(['route' => 'category.store']); ?>

                    <h6 class="heading-small text-muted mb-4">Category information</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <?php echo e(Form::label('category_name', 'Category Name', ['class' => 'form-control-label'])); ?>

                                        <?php echo e(Form::text('category_name', null, ['class' => 'form-control'])); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="status" value="1" class="custom-control-input" id="status">
                                        <?php echo e(Form::label('status', 'Status', ['class' => 'custom-control-label'])); ?>

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <?php echo e(Form::submit('Submit', ['class'=> 'mt-5 btn btn-primary'])); ?>

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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/district/create.blade.php ENDPATH**/ ?>