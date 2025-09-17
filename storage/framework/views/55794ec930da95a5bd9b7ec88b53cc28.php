<?php $__env->startPush('pg_btn'); ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create-post')): ?>
    <a href="<?php echo e(route('post.create')); ?>" class="btn btn-sm btn-neutral">Create New CMS</a>
<?php endif; ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-header bg-transparent">
                    <div class="row">
                        <div class="col-lg-8">
                            <h3 class="mb-0">All CMS</h3>
                        </div>
                        <div class="col-lg-4">
                    <?php echo Form::open(['route' => 'post.index', 'method'=>'get']); ?>

                        <div class="form-group mb-0">
                        <?php echo e(Form::text('search', request()->query('search'), ['class' => 'form-control form-control-sm', 'placeholder'=>'Search post'])); ?>

                    </div>

                    <?php echo Form::close(); ?>

                </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <div>
                            <table class="table table-hover align-items-center">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">Title</th>
                                    <th scope="col">Category </th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Create By</th>                                   
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody class="list">
                                <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <th scope="row">
                                            <div class="mx-w-440 d-flex flex-wrap">
                                                <?php echo e($post->post_title); ?>

                                            </div>
                                        </th>
                                        <td class="budget">
                                            <?php echo e($post->category->category_name); ?>

                                        </td>
                                        <td>
                                            <?php if($post->status): ?>
                                                <span class="badge badge-pill badge-lg badge-success">Active</span>
                                            <?php else: ?>
                                                <span class="badge badge-pill badge-lg badge-danger">Disabled</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php echo e($post->user->name); ?>

                                        </td>
                                       
                                        <td class="text-center">
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('destroy-post')): ?>
                                            <?php echo Form::open(['route' => ['post.destroy', $post],'method' => 'delete',  'class'=>'d-inline-block dform']); ?>

                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-post')): ?>
                                            <a class="btn btn-primary btn-sm m-1" data-toggle="tooltip" data-placement="top" title="View and edit post details" href="<?php echo e(route('post.show', $post)); ?>">
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                            </a>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update-post')): ?>
                                            <a class="btn btn-info btn-sm m-1" data-toggle="tooltip" data-placement="top" title="Edit post details" href="<?php echo e(route('post.edit',$post)); ?>">
                                                <i class="fa fa-edit" aria-hidden="true"></i>
                                            </a>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('destroy-post')): ?>
                                                <button type="submit" class="btn delete btn-danger btn-sm m-1" data-toggle="tooltip" data-placement="top" title="Delete post" href="">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            <?php echo Form::close(); ?>

                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                                <tfoot >
                                <tr>
                                    <td colspan="6">
                                        <?php echo e($posts->links()); ?>

                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script>
        jQuery(document).ready(function(){
            $('.delete').on('click', function(e){
                e.preventDefault();
                let that = jQuery(this);
                jQuery.confirm({
                    icon: 'fas fa-wind-warning',
                    closeIcon: true,
                    title: 'Are you sure!',
                    content: 'You can not undo this action.!',
                    type: 'red',
                    typeAnimated: true,
                    buttons: {
                        confirm: function () {
                            that.parent('form').submit();
                            //$.alert('Confirmed!');
                        },
                        cancel: function () {
                            //$.alert('Canceled!');
                        }
                    }
                });
            })
        })

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/post/index.blade.php ENDPATH**/ ?>