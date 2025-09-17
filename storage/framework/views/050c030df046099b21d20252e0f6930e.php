<?php $__env->startPush('pg_btn'); ?>
    <a href="<?php echo e(route('category.index')); ?>" class="btn btn-sm btn-neutral">All Categories</a>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-body">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update-category')): ?>
                    <?php echo Form::open(['route' => ['category.update', $category], 'method'=>'put']); ?>

                    <?php endif; ?>
                    <h6 class="heading-small text-muted mb-4">Category information</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <?php echo e(Form::label('category_name', 'Category Name', ['class' => 'form-control-label'])); ?>

                                        <?php echo e(Form::text('category_name', $category->category_name, ['class' => 'form-control'])); ?>

                                    </div>
                                </div>

                            </div>

                        </div>


                        <hr class="my-4" />
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="custom-control custom-checkbox">
                                        <?php echo Form::hidden('status', 0); ?>

                                        <input type="checkbox" name="status" value="1" <?php echo e($category->status ? 'checked' : ''); ?> class="custom-control-input" id="status">
                                        <?php echo e(Form::label('status', 'Status', ['class' => 'custom-control-label'])); ?>

                                    </div>
                                </div>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update-user')): ?>
                                <div class="col-md-12">
                                    <?php echo e(Form::submit('Submit', ['class'=> 'mt-5 btn btn-primary'])); ?>

                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update-category')): ?>
                    <?php echo Form::close(); ?>

                    <?php endif; ?>
                </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/district/edit.blade.php ENDPATH**/ ?>