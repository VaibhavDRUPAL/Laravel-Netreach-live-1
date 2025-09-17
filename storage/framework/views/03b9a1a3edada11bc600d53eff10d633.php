<?php $__env->startSection('content'); ?>
<section class="landing-sec-1 thanku-page">
    <img src="<?php echo e(asset('assets/img/web/slider-bg.jpg')); ?>" class="main-banner">
    <div class="banner-caption">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center">
                    <h1 class="heading1">Thank You</h1>
                    <?php if(isset($uid)): ?>
                        <p>Your appointment is <strong>CONFIRMED.</strong></p>
                        <p>You will receive an SMS shortly.</p>
                        <p>Your NETREACH Unique ID is <strong><?php echo e($uid); ?></strong></p>
                        
                    <?php else: ?>
                        <p>Self Risk Assessment submitted <strong>SUCCESSFULLY.</strong></p>
                    <?php endif; ?>
                    <?php if(isset($book_pdf)): ?>
                        <div class="thanku-btn-ab">
                            <a href="/storage/pdf/<?php echo e($book_pdf); ?>" target="_blank"><button>Download</button></a>
                        </div><!--thanku-btn-ab-->
                    <?php endif; ?>
                </div><!--col-md-6-->
                <div class="col-md-6 text-right">
                    <img src="<?php echo e(asset('assets/img/web/thanku-banner.png')); ?>">
                </div><!--col-md-6-->
            </div><!--row-->
        </div><!--container-->
    </div><!--banner-caption-->
</section><!--landing-sec-1-->
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
    $(document).ready(function() {
        $(document).prop('title','Appointment Confirmed|NETREACH');
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.apphome', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/home/survey/appointment-confirmed.blade.php ENDPATH**/ ?>