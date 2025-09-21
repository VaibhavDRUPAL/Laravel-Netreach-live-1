<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(config('app.name', 'Laravel')); ?></title>
    <!-- Fonts -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/stylesheet.css')); ?>">
    <!-- Icons -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/vendor/nucleo/css/nucleo.css')); ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo e(asset('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css')); ?>" type="text/css">
    <!-- Page plugins -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/vendor/fullcalendar/dist/fullcalendar.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/vendor/sweetalert2/dist/sweetalert2.min.css')); ?>">
    <!-- Argon CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/dashboard.css')); ?>" type="text/css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body class="bg-white">
    <div class="main-content">
        <?php echo $__env->yieldContent('content'); ?>
    </div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="<?php echo e(asset('assets/vendor/jquery/dist/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/vendor/js-cookie/js.cookie.js')); ?>"></script>
<script src="<?php echo e(asset('assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js')); ?>"></script>

<script src="<?php echo e(asset('assets/js/dashboard.js')); ?>"></script>
<script>
    function enableBtn() {
        $("#loginbtn").attr("disabled", false);
    }
</script>
<?php echo $__env->yieldPushContent('captcha'); ?>

</body>
</html>
<?php /**PATH C:\xampp\htdocs\netreach_live\resources\views/layouts/auth.blade.php ENDPATH**/ ?>