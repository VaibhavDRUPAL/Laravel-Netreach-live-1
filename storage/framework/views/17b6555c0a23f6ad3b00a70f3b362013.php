<?php $__env->startPush('pg_btn'); ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create-announcement')): ?>
    <a href="<?php echo e(route('announcements.create')); ?>" class="btn btn-sm btn-neutral">Create New Announcement</a>
<?php endif; ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-header bg-transparent">
                    <div class="row">
                        <div class="col-lg-8">
                            <h3 class="mb-0">All Announcements</h3>
                        </div>
                        <div class="col-lg-4">
                            <?php echo Form::open(['route' => 'announcements.index', 'method'=>'get']); ?>

                            <div class="form-group mb-0">
                                <?php echo e(Form::text('search', request()->query('search'), ['class' => 'form-control form-control-sm', 'placeholder'=>'Search announcements'])); ?>

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
                                    <th scope="col">Content</th>
                                    <th scope="col">Start Date</th>
                                    <th scope="col">End Date</th>
                                    <th scope="col">Status</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody class="list">
                                <?php $__currentLoopData = $announcements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $announcement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                             
                                    <tr>
                                        <td scope="row">
                                            <?php echo e($announcement->title); ?>

                                        </td>
                                        <td class="budget">
                                            <?php echo e(Str::limit($announcement->content, 50)); ?>

                                        </td>
                                        <td>
                                            <?php echo e($announcement->start_date); ?>

                                        </td>
                                        <td>
                                            <?php echo e($announcement->end_date); ?>

                                        </td>
                                        <td>
                                            <?php if($announcement->is_active): ?>
                                                <span class="badge badge-pill badge-lg badge-success">Active</span>
                                            <?php else: ?>
                                                <span class="badge badge-pill badge-lg badge-danger">Inactive</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('destroy-announcement')): ?>
                                            <?php echo Form::open(['route' => ['announcements.destroy', $announcement],'method' => 'delete',  'class'=>'d-inline-block dform']); ?>

                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-announcement')): ?>
                                            <a class="btn btn-primary btn-sm m-1" data-toggle="tooltip" data-placement="top" title="View details" href="<?php echo e(route('announcements.show', $announcement)); ?>">
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                            </a>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update-announcement')): ?>
                                            <a class="btn btn-info btn-sm m-1" data-toggle="tooltip" data-placement="top" title="Edit details" href="<?php echo e(route('announcements.edit',$announcement)); ?>">
                                                <i class="fa fa-edit" aria-hidden="true"></i>
                                            </a>
                                            <?php endif; ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('destroy-announcement')): ?>
                                                <button type="submit" class="btn delete btn-danger btn-sm m-1" data-toggle="tooltip" data-placement="top" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            <?php echo Form::close(); ?>

                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="6">
                                        
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
                        },
                        cancel: function () {}
                    }
                });
            })
        })
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\netreach_live\resources\views/announcement/index.blade.php ENDPATH**/ ?>