<?php
    $extend = $isLanding ? 'layouts.apphome' : 'self.layout.layout';
    $section = $isLanding ? 'content' : 'body';
?>



<?php $__env->startSection('title'); ?>
    Self Risk Assessment Appointment Booked
<?php $__env->stopSection(); ?>

<?php $__env->startSection($section); ?>
    <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['row' => !$isLanding, 'p-1 mt-xl-5' => $isLanding]); ?>" style="margin-top:100px">
        <div class="col-12 col-sm-7 mx-auto text-center mt-5">
            <h1 class="" style="font-weight: bold; color: #1476A1 !important"><?php echo e(__('surveyAppointment.b1')); ?></h1>
            <br />
            <p style="font-size:25px">
                <?php echo e(__('surveyAppointment.b2')); ?><br />
                <?php echo e(__('surveyAppointment.b3')); ?><br />
                <?php echo e(__('surveyAppointment.b4')); ?><br />
                
            </p>
            <div style="min-height: 40px;display:flex; justify-content: center;">
                <span class="my-5" style="font-weight:600;">
                    <?php echo e($uid); ?>

                </span>
            </div>
           
            <div class="text-center">
                <?php if(isset($path)): ?>
                    <?php if(empty(!$path)): ?>
                        <a href="<?php echo e(Storage::disk('public')->url($path)); ?>" role="button" class="btn btn-lg" style="background-color: #1476A1; color: #fff;">
                            <?php echo e(__('surveyAppointment.b5')); ?>

                        </a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($extend, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/self/booked.blade.php ENDPATH**/ ?>