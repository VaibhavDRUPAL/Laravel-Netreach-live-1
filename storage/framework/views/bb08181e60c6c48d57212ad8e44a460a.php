<?php $__env->startSection('content'); ?>
<style>
    .font7 {
        color: black;
    }

    .column {
        display: inline-block;
    }

    .text-primary {
        color: #1476A1 !important;
    }
</style>

<section class="landing-sec-1">
    <img src="<?php echo e(asset('assets/img/web/bg_blank.png')); ?>" class="main-banner">
    <div class="banner-caption">
        <div class="container mt-4 mb-4">
            <h3 class="text-center" style="font-weight: bold">
                <?php echo e(__('team.Team')); ?>

            </h3>
            <?php echo $__env->make('includes.team', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <!--row-->
    </div>
    <!--container-->
    </div>
    <!--banner-caption-->
</section>
<!--landing-sec-1-->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.apphome', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/home/our-team.blade.php ENDPATH**/ ?>