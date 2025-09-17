<?php $__env->startSection('title'); ?>
    Meet Counsellor
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <div class="container mt-5 pt-5 mb-5 d-flex justify-content-center">
        <div class="card px-1 py-4">
            <div class="card-body">
                <h3 class="card-title mb-3 text-center" style="font-weight: bold;font-size:clamp(1.25rem,2.5vw,1.75rem)">
                    <?php echo e(__('meetCounsellor.Contact_Counsellor_Form')); ?></h3>

                <?php if(session('success')): ?>
                    <div class="alert alert-success">
                        <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>

                <?php if($errors->any()): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="<?php echo e(route('counsellorForm.submit')); ?>" method="post" id="meet-counsellor-form">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="<?php echo e(__('meetCounsellor.Name')); ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <select class="form-control" name="state_id" id="input-state" required>
                                    <option hidden selected><?php echo e(__('meetCounsellor.Select_Counsellor')); ?> </option>
                                    <?php if(empty(!$statez)): ?>
                                        <?php $__currentLoopData = $statez; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($value['id']); ?>">
                                                <?php if($locale == 'mr'): ?>
                                                    <?php echo e($value['state_name_mr']); ?>

                                                <?php elseif($locale == 'hi'): ?>
                                                    <?php echo e($value['state_name_hi']); ?>

                                                <?php elseif($locale == 'ta'): ?>
                                                    <?php echo e($value['state_name_ta']); ?>

                                                <?php elseif($locale == 'te'): ?>
                                                    <?php echo e($value['state_name_te']); ?>

                                                <?php else: ?>
                                                    <?php echo e($value['state_name']); ?>

                                                <?php endif; ?>
                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <input type="text" class="form-control" name="mobile_no" id="mobile_no"
                                    placeholder="<?php echo e(__('meetCounsellor.Mobile_Number')); ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <textarea name="message" id="message" rows="" class="form-control"
                                    placeholder="<?php echo e(__('meetCounsellor.Message_Query')); ?>" required></textarea>
                            </div>
                        </div>
                    </div>

                    <button type="submit" value="submit" class="btn btn-block confirm-button" style="background-color: #1476A1; color: #fff; border-radius: 10px;">
                        <?php echo e(__('meetCounsellor.Submit')); ?></button>

                    <div class="d-flex flex-column text-center mt-3 mb-3">
                        <small class="agree-text">*<?php echo e(__('meetCounsellor.note')); ?>.</small>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<style>
    body {
        background-color: #FFEBEE;
    }

    .card {
        width: 400px;
        background-color: #fff;
        border: none;
        border-radius: 12px;
    }

    .form-control {
        margin-top: 10px;
        height: 48px;
        border: 2px solid #eee;
        border-radius: 10px;
    }

    .form-control:focus {
        box-shadow: none;
        border: 2px solid #039BE5;
    }

    .confirm-button {
        height: 50px;
        border-radius: 10px;
    }

    .agree-text {
        font-size: 12px;
    }
</style>

<?php echo $__env->make('layouts.apphome', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/home/survey/meet-counsellor.blade.php ENDPATH**/ ?>