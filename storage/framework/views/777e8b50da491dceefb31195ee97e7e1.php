<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo e(config('app.name', 'Laravel')); ?></title>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/dashboard.css')); ?>" type="text/css">
        <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/stylesheet.css')); ?>">
        <style>
            *{
                margin: 0;
                padding: 0;
                font-family: Source Sans Pro, sans-serif;
            }
            body{
                display: flex;
                align-content: center;
                align-items: center;
                justify-content: center;
                height: 100vh;
                width: 100%;
            }

        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <?php if(Route::has('login')): ?>
                <div class="top-right links">
                    <?php if(auth()->guard()->check()): ?>
                        <a class="btn btn-lg btn-info" href="<?php echo e(url('/home')); ?>">Home</a>
                    <?php else: ?>
                        <a class="btn btn-lg  btn-info" href="<?php echo e(route('login')); ?>">Login</a>

                        <?php if(Route::has('register')): ?>
                            <a class="btn btn-lg btn-info" href="<?php echo e(route('register')); ?>">Register</a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </body>
</html>
<?php /**PATH /var/www/netreach2/resources/views/welcome.blade.php ENDPATH**/ ?>