<?php $__env->startPush('meta_data'); ?>
    <title>Netreach Blogs</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    <style>
        .font7 {
            color: black;
        }

        .column {
            display: inline-block
        }

        .jumbotron {
            padding: 2rem 0rem;
        }

        .jb_bg {
            background-color: #D7F3FF;

        }

        .jumbotron {
            padding: 1rem 0rem 0rem 0rem;
        }

        .search_btn {
            background-color: #1476A1;
            border-color: #1476A1;
            color: #fff;
        }

        .page-item.active .page-link {
            background-color: #1476A1;
            border-color: #1476A1;
        }

        .page-link {
            color: #1476A1;
            font-size: 20px;
        }
    </style>




    <div class="jumbotron w-100 jb_bg rounded-0" style="margin-top: 100px;">
        <div class="container">
            <h1 class="font-weight-bold"><?php echo e(__('blog.2')); ?></h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb jb_bg">
                    <li class="breadcrumb-item"><a href="#">
                            <h5><?php echo e(__('blog.1')); ?></h5>
                        </a></li>
                    <li class="breadcrumb-item text-primary" aria-current="page">
                        <h5><?php echo e(__('blog.2')); ?></h5>
                    </li>
                </ol>
            </nav>
        </div>
    </div>


    <div class="container">





        <div class="row mb-5">
            <div class="col-md-3 d-none d-sm-block">

            </div>
            <div class="col-md-6">
                <form action="">
                    <div class="input-group input-group-lg">
                        <input name="search" type="search" class="form-control bg-light btn-lg"
                            aria-describedby="button-addon2">
                        <div class="input-group-append">
                            <button class="btn search_btn" type="submit" id="button-addon2"><?php echo e(__('blog.11')); ?></button>
                        </div>
                    </div>

                </form>
            </div>
            <div class="col-md-3 d-none d-sm-block">

            </div>
        </div>

        
        <?php
            $locale = app()->getLocale();
        ?>
        

        <div class="row">
            <?php if($blogs->isNotEmpty()): ?>
                <?php $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-sm-4 mb-5">
                        
                        <a
                            href="<?php echo e($locale != 'en' ? URL::to('/' . $locale . '/blog-details/' . $blog->blog_id . '/' . createSlug($blog->title, '-')) : URL::to('/blog-details/' . $blog->blog_id . '/' . createSlug($blog->title, '-'))); ?>">
                            <div class="card shadow">
                                <img src="<?php echo e(asset('storage/blog/' . $blog->image)); ?>" class="card-img-top">
                                <div class="card-body">
                                    <a
                                        href="<?php echo e($locale != 'en' ? URL::to('/' . $locale . '/blog-details/' . $blog->blog_id . '/' . createSlug($blog->title, '-')) : URL::to('/blog-details/' . $blog->blog_id . '/' . createSlug($blog->title, '-'))); ?>">
                                        <?php if($locale == 'mr'): ?>
                                            <h4 class="card-title font-weight-bold text-dark"><?php echo e($blog->title_mr); ?></h4>
                                        <?php elseif($locale == 'hi'): ?>
                                            <h4 class="card-title font-weight-bold text-dark"><?php echo e($blog->title_hi); ?></h4>
                                        <?php elseif($locale == 'te'): ?>
                                            <h4 class="card-title font-weight-bold text-dark"><?php echo e($blog->title_te); ?></h4>
                                        <?php elseif($locale == 'ta'): ?>
                                            <h4 class="card-title font-weight-bold text-dark"><?php echo e($blog->title_ta); ?></h4>
                                        <?php else: ?>
                                            <h4 class="card-title font-weight-bold text-dark"><?php echo e($blog->title); ?></h4>
                                        <?php endif; ?>
                                    </a>
                                    <p class="text-secondary mb-2"><i class="fas text-secondary fa-calendar-alt mr-2"></i>
                                        <?php echo e(parseDateTime($blog->created_at, 'M d, Y')); ?> </p>
                                    <u><a href="<?php echo e(URL::to('/blog-details/' . $blog->blog_id . '/' . createSlug($blog->title, '-'))); ?>"
                                            class="text-secondary"><?php echo e(__('blog.12')); ?></a></u>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <div class="row justify-content-center mb-5">
                    <h5> <?php echo e(__('blog.8')); ?></h5>
                </div>
            <?php endif; ?>
        </div>

        <div class="row justify-content-center mb-5">
            <?php echo e($blogs->onEachSide(2)->links('home.pagination')); ?>

        </div>



    </div>


    <!--container-->
    <section style="background-color:#F2FBFF;" class="d-none d-sm-block">
        <div class="container pt-4 pb-1">
            <div class="font-weight-bold" style="font-size: 18px;">
                <div class="row mb-3">
                    <div class="col">
                        <a class="mr-5" href="<?php echo e(URL::to('https://humsafar.org/')); ?>"><img
                                src="<?php echo e(asset('assets/img/web/humsafar-logo.png')); ?>" style="width: 125px"></a>
                        <a href="<?php echo e(URL::to('https://allianceindia.org/')); ?>"><img
                                src="<?php echo e(asset('assets/img/web/alliance-india.png')); ?>"></a>
                    </div>
                    <div class="col-9">
                        <?php echo e(__('blog.9')); ?>

                    </div>
                </div>
            </div>
            <!--row-->
        </div>

    </section>

    <section style="background-color:#1476A1;margin-bottom:-50px" class="d-none d-sm-block">
        <div class="container">
            <div class="py-3 text-white" style="font-size: 18px;">
                <p><?php echo e(__('blog.10')); ?></p>
            </div>
            <!--row-->
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.apphome', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/home/blog.blade.php ENDPATH**/ ?>