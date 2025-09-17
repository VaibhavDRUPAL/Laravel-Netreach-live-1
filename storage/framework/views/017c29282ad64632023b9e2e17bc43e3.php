<?php $__env->startSection('title'); ?>
    Self Risk Assessment Calculation
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="p-5 mt-xl-5 mt-5">
        <h2 class="text-center">
            <?php echo e(__('surveyAppointment.Assessment Complete')); ?>

        </h2>
        <div class="row">
            <div class="col-12 col-sm-10 col-md-5 text-center mx-auto mt-3"
                style="border: 2px solid black; border-bottom-width: 7px; border-right-width: 7px; border-radius:10px">
                <?php if($score < 20): ?>
                    <img src="<?php echo e(asset('assets/img/sra/low.jpeg')); ?>" height="200px" />
                <?php elseif($score >= 20 && $score < 40): ?>
                    <img src="<?php echo e(asset('assets/img/sra/medium.jpeg')); ?>" height="200px" />
                <?php elseif($score >= 40 && $score < 60): ?>
                    <img src="<?php echo e(asset('assets/img/sra/high.jpeg')); ?>" height="200px" />
                <?php elseif($score >= 60 && $score < 80): ?>
                    <img src="<?php echo e(asset('assets/img/sra/max.jpeg')); ?>" height="200px" />
                <?php elseif($score >= 80): ?>
                    <img src="<?php echo e(asset('assets/img/sra/max.jpeg')); ?>" height="200px" />
                <?php endif; ?>
            </div>
            
            <div class="col-12 col-sm-10 col-md-5 text-center mx-auto mt-3"
                style="border: 2px solid black; border-bottom-width: 7px; border-right-width: 7px; border-radius:10px">
                <p class="mt-5">
                    <?php echo e(__('surveyAppointment.quote')); ?>

                </p>
                <br />
                <?php
                    $locale = app()->getlocale();
                    if ($locale && $locale!='en') {
                        $href = isset($isLanding) ? route('survey.book-appoinment',compact('locale')) : route('self.book-appointment');
                    } elseif($locale=='en') {
                        $href = isset($isLanding) ? url('/book-appoinment') : route('self.book-appointment');
                    } else {
                        $href = isset($isLanding) ? route('survey.book-appoinment') : route('self.book-appointment');
                    }
                ?>
                <a href="<?php echo e($href); ?>" role="button" class="btn mb-3" style="background:#1476A1; color:white ">
                    <?php echo e(__('surveyAppointment.Book an Appointment')); ?>

                </a>
            </div>
        </div>
        <h3 class="text-center my-5" style="font-weight: bold">
            <?php echo e(__('surveyAppointment.speak')); ?>

        </h3>
        <?php echo $__env->make('includes.team', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.apphome', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/home/survey/success.blade.php ENDPATH**/ ?>