<?php $__env->startPush('pg_btn'); ?>
    <a href="<?php echo e(route('announcements.index')); ?>" class="btn btn-sm btn-neutral">All Announcements</a>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card mb-5">
            <div class="card-body">
                <?php echo Form::open(['route' => 'announcements.store', 'method' => 'POST', 'files' => true]); ?>

                <h6 class="heading-small text-muted mb-4">Create Announcement</h6>
                <div class="pl-lg-4">
                    <div class="row">
                        
                        <div class="col-lg-6">
                            <div class="form-group">
                                <?php echo e(Form::label('title', 'Title', ['class' => 'form-control-label'])); ?>

                                <?php echo e(Form::text('title', null, ['class' => 'form-control', 'required'])); ?>

                            </div>
                        </div>

                        
                        <div class="col-lg-12">
                            <div class="form-group">
                                <?php echo e(Form::label('content', 'Content', ['class' => 'form-control-label'])); ?>

                                <?php echo e(Form::textarea('content', null, ['class' => 'form-control', 'rows'=>3, 'required'])); ?>

                            </div>
                        </div>

                        
                        <div class="col-lg-6">
                            <div class="form-group">
                                <?php echo e(Form::label('start_date', 'Start Date & Time', ['class' => 'form-control-label'])); ?>

                                <?php echo e(Form::datetimeLocal('start_date', null, ['class' => 'form-control', 'required'])); ?>

                            </div>
                        </div>

                        
                        <div class="col-lg-6">
                            <div class="form-group">
                                <?php echo e(Form::label('end_date', 'End Date & Time', ['class' => 'form-control-label'])); ?>

                                <?php echo e(Form::datetimeLocal('end_date', null, ['class' => 'form-control', 'required'])); ?>

                            </div>
                        </div>

                        
                        <div class="col-lg-6">
                            <div class="custom-control custom-checkbox mt-4">
                                <?php echo e(Form::checkbox('is_active', 1, false, ['class' => 'custom-control-input', 'id' => 'is_active'])); ?>

                                <?php echo e(Form::label('is_active', 'Active', ['class' => 'custom-control-label'])); ?>

                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4" />

                <div class="pl-lg-4">
                    <div class="row">
                        <div class="col-md-12">
                            <?php echo e(Form::submit('Create', ['class'=> 'mt-3 btn btn-primary'])); ?>

                        </div>
                    </div>
                </div>
                <?php echo Form::close(); ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\netreach_live\resources\views/announcement/create.blade.php ENDPATH**/ ?>