<?php $__env->startSection('content'); ?>


    <style>
        @media (max-width: 768px) {
            .w-sm-100 {
                width: 100% !important;
            }
        }
    </style>
    <section class="landing-sec-1">
        <img src="<?php echo e(asset('assets/img/web/bg_two.jpeg')); ?>" class="main-banner d-none d-sm-block">
        <div class="banner-caption">
            <div class="container">
                <div class="row">

                    <div class="col-lg-1"> </div>
                    <div class="col-md-5 mb-5">
                        <h1 class="font4"> <b> Lets Get Going </b> </h1>
                        <h4 class="font5" style=""> Help Us Get To Know You Better Question Part</h4>


                        <?php echo csrf_field(); ?>

                        <?php if(!empty($vn) || old('vn')): ?>
                            <input type="hidden" name="vn" value="<?php echo e(old('vn') ? old('vn') : $vn); ?>">
                        <?php endif; ?>

                        <?php if($questionnaire->isNotEmpty()): ?>
                            <?php
                                $questionNumber = 1;
                            ?>

                            <?php $__currentLoopData = $questionnaire; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sectionIndex => $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php echo e($section->question_slug); ?>


                                <input value="<?php echo e($stateDetails->state_name ?? 'Unknown'); ?>" readonly class="form-control" />
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <p>No questions available.</p>
                        <?php endif; ?>
                    </div>


                    <div class="col-md-5 px-0 d-block d-sm-none">
                        <div class="card border-0">
                            <img src="<?php echo e(asset('assets/img/web/q1.png')); ?>" class="card-img-top rounded-0" alt="...">
                        </div>
                    </div>
                </div>
                <!--row-->


            </div>
            <!--container-->
        </div>
        <!--banner-caption-->
    </section>
    <!--landing-sec-1-->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.apphome', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/home/survey/questionarie.blade.php ENDPATH**/ ?>