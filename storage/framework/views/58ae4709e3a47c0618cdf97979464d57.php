<!DOCTYPE HTML>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Laravel')); ?></title>

    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/stylesheet.css')); ?>">
    <!-- Icons -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/vendor/nucleo/css/nucleo.css')); ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo e(asset('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css')); ?>"
        type="text/css">
    <!-- Page plugins -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/vendor/fullcalendar/dist/fullcalendar.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/vendor/sweetalert2/dist/sweetalert2.min.css')); ?>">

    <link rel="stylesheet" href="<?php echo e(asset('assets/css/bootstrap-select.min.css')); ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/jquery-confirm.min.css')); ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/dashboard.css')); ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/custom.css')); ?>" type="text/css">

    
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo e(env('GOOGLE_MEASUREMENT_ID')); ?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', '<?php echo e(env('GOOGLE_MEASUREMENT_ID')); ?>');
    </script>

    <style>
        .topfooter .footer-disclaimer {
            display: none;
        }

        .chcek_box_valid {
            border: 1px solid red;
        }


        .font1 {
            color: #1E57BE !important;
        }


        .font2 {
            color: #726b6b !important;
        }

        .font3 {
            color: black !important;
            font-style: bold !important
        }

        .right1 {
            text-align: right;
        }

        .btn1 {
            background-color: #00A79D !important;
        }

        /*  Social Media CSS Start  */

        .float1 {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 30px;
            right: 20px;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            z-index: 100;
        }


        .float2 {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 80px;
            right: 20px;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            z-index: 100;
        }


        .float3 {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 130px;
            right: 20px;
            border-radius: 50px;
            text-align: center;
            font-size: 30px;
            z-index: 100;
        }


        .my-float {
            margin-top: 16px;
        }


        /*Social Media CSS End*/
    </style>

    <?php echo $__env->yieldPushContent('styles'); ?>

</head>

<body>


    <?php echo $__env->make('includes.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="main-content" id="panel">
        <?php echo $__env->make('includes.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('includes.page-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="container-fluid mt--6">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
        <script src="<?php echo e(asset('assets/vendor/jquery/dist/jquery.min.js')); ?>"></script>
        <script src="<?php echo e(asset('assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js')); ?>"></script>
        <script src="<?php echo e(asset('assets/vendor/js-cookie/js.cookie.js')); ?>"></script>
        <script src="<?php echo e(asset('assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js')); ?>"></script>
        <script src="<?php echo e(asset('assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js')); ?>"></script>

        <script src="<?php echo e(asset('assets/js/bootstrap-select.min.js')); ?>"></script>
        <script src="<?php echo e(asset('assets/js/jquery-confirm.min.js')); ?>"></script>
        <script src="<?php echo e(asset('assets/js/dashboard.js')); ?>"></script>
        <script src="<?php echo e(asset('assets/js/chart/Chart.bundle.min.js')); ?>"></script>

        <script>
            function debounce(func, timeout = 300) {
                let timer;
                return (...args) => {
                    clearTimeout(timer);
                    console.log(args);
                    timer = setTimeout(() => {
                        func.apply(this, args);
                    }, timeout);
                };
            }
            // use this function to control the enable/disable state of optional fields
            const changeEventRegister = {};

            function updateOptionalEnablement(dependentFieldId, optionalFieldId, enableVal, defaultVal) {
                if ($(`#${dependentFieldId}`).val() == enableVal) {
                    $(`#${optionalFieldId}`).prop("disabled", false);
                } else {
                    $(`#${optionalFieldId}`).val(defaultVal);
                    $(`#${optionalFieldId}`).prop("disabled", true);
                }
                $('.selectpicker').selectpicker('refresh');
                if (changeEventRegister[`${dependentFieldId}_${optionalFieldId}`])
                    return;
                $(`#${dependentFieldId}`).on('change', () => updateOptionalEnablement(dependentFieldId, optionalFieldId,
                    enableVal));
                changeEventRegister[`${dependentFieldId}_${optionalFieldId}`] = true;
            }
        </script>
        <?php echo $__env->yieldPushContent('scripts'); ?>

        <?php echo $__env->yieldPushContent('modal'); ?>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\netreach_live\resources\views/layouts/app.blade.php ENDPATH**/ ?>