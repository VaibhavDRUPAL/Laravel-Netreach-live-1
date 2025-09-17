<?php $__env->startSection('content'); ?>

<section class="landing-sec-1 accordion-section">
        
        <div class="banner-caption">
            <div class="container">
                <div class="row" style="align-items: flex-start;">
                    <div class="col-md-12" style="height: inherit;">
                        <h1 class="heading1"><?php echo e(__('navbar.faq')); ?> </h1>
                        <?php echo $content; ?>

                    </div>

                </div><!--container-->
            </div><!--banner-caption-->
    </section><!--landing-sec-1-->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.apphome', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/home/faqs.blade.php ENDPATH**/ ?>