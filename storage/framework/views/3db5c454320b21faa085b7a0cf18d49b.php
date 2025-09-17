<?php $__env->startPush('pg_btn'); ?>
<a href="<?php echo e(route('blog_categories_all')); ?>" class="btn btn-sm btn-neutral">All Blog Categories</a>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-8">
        <div class="card mb-5">
            <div class="card-body">
                <?php echo Form::open(); ?>

                <?php echo method_field('PUT'); ?>
                <h6 class="heading-small text-muted mb-4">Edit Blog</h6>
                <div class="pl-lg-4">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <?php echo e(Form::label('blog_category_name', 'Category Name', ['class' => 'form-control-label'])); ?>

                                <?php echo e(Form::text('blog_category_name', $blog_categories->blog_category_name, ['class' => 'form-control'])); ?>

                            </div>

                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="status" value="1" class="custom-control-input" id="status" <?php if($blog_categories->status): echo 'checked'; endif; ?>>
                                <?php echo e(Form::label('status', 'Active', ['class' => 'custom-control-label'])); ?>

                            </div>
                        </div>
                    </div>
                </div>
                <hr class="my-4" />

                <div class="pl-lg-4">
                    <div class="row">

                        <div class="col-lg-6">
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/blogCategories/editBlogCategories.blade.php ENDPATH**/ ?>