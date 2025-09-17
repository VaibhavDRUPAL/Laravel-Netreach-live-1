<?php $__env->startPush('pg_btn'); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update-post')): ?>
        <a class="btn btn-info btn-sm m-1" data-toggle="tooltip" data-placement="top" title="Edit post details" href="<?php echo e(route('post.edit',$post)); ?>">
            <i class="fa fa-edit" aria-hidden="true"></i> Edit Post
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
                            Title
                        </div>
                        <div class="col-sm-3">
                            <strong><?php echo e($post->post_title); ?></strong>
                        </div>
                        <div class="col-sm-4">
                            <?php if($post->featured_image): ?>
                                <a href="<?php echo e(asset('storage/'.$post->featured_image)); ?>" target="_blank">
                                    <img width="150" height="150" class="img-fluid" src="<?php echo e(asset('storage/'.$post->featured_image)); ?>" alt="">
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-1">
                            Category
                        </div>
                        <div class="col-sm-3">
                            <strong><?php echo e($post->category->category_name); ?></strong>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-1">
                            Created By
                        </div>
                        <div class="col-sm-3">
                            <strong><?php echo e($post->user->name); ?></strong>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-1">
                            Body
                        </div>
                        <div class="col-sm-3">
                            <strong><?php echo $post->post_body; ?></strong>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-1">
                            Status
                        </div>
                        <div class="col-sm-3">
                            <?php echo e($post->status ? 'Active' : 'Disable'); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/post/show.blade.php ENDPATH**/ ?>