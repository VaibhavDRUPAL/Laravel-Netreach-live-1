<?php $__env->startSection('content'); ?>
    <section class="landing-sec-1">
        <style>
            span {
                color: #1457A1
            }
        </style>
        
        <div class="banner-caption">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h1 class="heading1"><?php echo e(__('aboutus.aboutus')); ?></h1>
                        <p>
                            
                        <p><span style="color: rgb(7, 85, 120); font-family: Lato; font-size: 18px; text-align: justify;">
                                <?php echo e(__('aboutus.about_content')); ?><br><br>
                                <?php echo e(__('aboutus.about_content2')); ?>

                            </span>

                    </div>
                    <div class="col-md-6">
                        <img src="<?php echo e(asset('assets/img/web/about2.png')); ?>" class="img-fluid" alt="Book Your Appointment">
                    </div>
                    <div class="m-3 mx-lg-3">

                        <span>
                            <h1 class="heading1"><?php echo e(__('aboutus.mission')); ?></h1>
                            <span style="color: rgb(7, 85, 120); font-family: Lato; font-size: 18px; text-align: justify;">
                                <?php echo e(__('aboutus.mission_content')); ?>

                            </span></p>
                            

                    </div>
                </div><!--row-->
            </div><!--container-->
        </div><!--banner-caption-->
    </section><!--landing-sec-1-->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.apphome', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/home/about-us.blade.php ENDPATH**/ ?>