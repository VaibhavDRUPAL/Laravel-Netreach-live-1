<?php $__env->startPush('pg_btn'); ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create-user')): ?>
    <a href="<?php echo e(route('users.create')); ?>" class="btn btn-sm btn-neutral">Create New User</a>
<?php endif; ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-header bg-transparent">
                    <div class="row">
                        <div class="col-lg-8">
                            <h3 class="mb-0">All Users</h3>
                        </div>
                        <div class="col-lg-4">
                    <?php echo Form::open(['route' => 'users.index', 'method'=>'get']); ?>

                        <div class="form-group mb-0">
                        <?php echo e(Form::text('search', request()->query('search'), ['class' => 'form-control form-control-sm', 'placeholder'=>'Search users'])); ?>

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
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Verified at</th>
                                    <th scope="col">Photo</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody class="list">
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <th scope="row">
                                            <?php echo e($user->name); ?>

                                        </th>
                                        <td class="budget">
                                            <?php echo e($user->email); ?>

                                        </td>
                                        <td>
                                            <?php if($user->status): ?>
                                                <span class="badge badge-pill badge-lg badge-success">Active</span>
                                            <?php else: ?>
                                                <span class="badge badge-pill badge-lg badge-danger">Disabled</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php echo e($user->email_verified_at); ?>

                                        </td>
                                        <td>
                                            <div class="avatar-group">
                                                <?php if($user->profile_photo): ?>
                                                <img alt="Image placeholder"
                                                    class="avatar avatar-sm rounded-circle"
                                                    data-toggle="tooltip" data-original-title="<?php echo e($user->name); ?>"
                                                    src="<?php echo e(asset($user->profile_photo)); ?>">
                                                <?php else: ?>
                                                <i class="far avatar avatar-sm rounded-circle fa-user"></i>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('destroy-user')): ?>
                                            <?php echo Form::open(['route' => ['users.destroy', $user],'method' => 'delete',  'class'=>'d-inline-block dform']); ?>

                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-user')): ?>
                                            <a class="btn btn-primary btn-sm m-1" data-toggle="tooltip" data-placement="top" title="View and edit user details" href="<?php echo e(route('users.show', $user)); ?>">
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                            </a>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update-user')): ?>
                                            <a class="btn btn-info btn-sm m-1" data-toggle="tooltip" data-placement="top" title="Edit user details" href="<?php echo e(route('users.edit',$user)); ?>">
                                                <i class="fa fa-edit" aria-hidden="true"></i>
                                            </a>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('destroy-user')): ?>
                                                <button type="submit" class="btn delete btn-danger btn-sm m-1" data-toggle="tooltip" data-placement="top" title="Delete user" href="">
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
                                        <?php echo e($users->links()); ?>

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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/users1/index.blade.php ENDPATH**/ ?>