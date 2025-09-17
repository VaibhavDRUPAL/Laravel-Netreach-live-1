<?php $__env->startSection('content'); ?>

<style>
    .font7 {
        color: black;
    }

    .column {
        display: inline-block
    }
    .social-icons {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 20px;
}

.social-icons a {
    display: flex;
    justify-content: center;
    align-items: center;
}

.social-icons img {
    width: clamp(50px, 5vw, 60px);
    height: clamp(50px, 5vw, 60px);
    object-fit: contain;
    transition: transform 0.3s ease, opacity 0.3s ease;
}

/* Hover Effects */
.social-icons a:hover img {
    transform: scale(1.1);
    opacity: 0.8;
}
.collaboration-text {
    font-size: clamp(16px, 2vw, 22px); /* Min 16px, scales with viewport width, max 22px */
    text-align: center;
    color: black !important;
}
.email-text {
    font-size: clamp(14px, 1.8vw, 20px); /* Min 14px, scales with viewport width, max 20px */
    text-align: center;
    color: black !important;
    word-break: break-word; /* Ensures email breaks properly if needed */
}


</style>

<section class="landing-sec-1">
    <img src="<?php echo e(asset('assets/img/web/bg_blank.png')); ?>" class="main-banner">
    <div class="banner-caption">
        <div class="container mt-4 mb-4">
            <div class="row">
                <div class="col-md-1"> </div>
                <div class="col-md-5 text-center">
                    <h1 class="heading1"><a href="<?php echo e(URL::to('/our-team/')); ?>" style="color:black !important;"><?php echo e(__('contact.contactus')); ?> </a></h1>
                    <div class="p-4">
                        <h5><?php echo e(__('contact.collaboration')); ?> </h5>
                        
                            <p class="email-text" style="text-align: center;"><b><?php echo e(__('contact.email')); ?>

                                <a href="mailto:info.netreach@humsafar.org" style="color:black !important;"> info.netreach@humsafar.org</a></b></p>


                            <div class="container mt-5">
                                <h5 class="text-center mb-4 collaboration-text"><b> <?php echo e(__('contact.social')); ?></b></h5>
                                <div class="row align-items-center justify-content-center">
                                    <div class="social-icons">
                                        <a href="https://youtube.com/@netreachofficial/" target="_blank">
                                            <img src="<?php echo e(asset('assets/img/web/youtube2.png')); ?>">
                                        </a>
                                        <a href="https://www.instagram.com/netreachofficial/" target="_blank">
                                            <img src="<?php echo e(asset('assets/img/web/insta3.png')); ?>">
                                        </a>
                                        <a href="https://m.facebook.com/NETREACHofficial/" target="_blank">
                                            <img src="<?php echo e(asset('assets/img/web/fb2.png')); ?>">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                        
                    </div><!-- email-content -->
                </div><!-- col-md-6 -->
                <div class="col-md-2"> </div>
                <div class="col-md-4 text-center">
                    <img src="assets/img/web/contact_us.png" class="img-fluid">
                </div><!-- col-md-6 -->



                <!-- END OUR TEAm -->


            </div>
            <!--row-->




        </div>
        <!--container-->
    </div>
    <!--banner-caption-->
</section>
<!--landing-sec-1-->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.apphome', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/home/contact-us.blade.php ENDPATH**/ ?>