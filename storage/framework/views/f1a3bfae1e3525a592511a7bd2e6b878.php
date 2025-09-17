<?php $__env->startPush('meta_data'); ?>
    <title><?php echo e($blog->meta_title); ?></title>
    <meta name="description" content="<?php echo e($blog->meta_description); ?>">
    <meta name="keywords" content="<?php echo e($blog->meta_keywords); ?>">
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
            padding: 1rem 0rem 0rem 0rem;
        }

        .fsize {
            font-size: 20px;
        }

        .fsize_desc {
            font-size: 20px;
        }

        .jb_bg {
            background-color: #D7F3FF;

        }
    </style>



    <div class="jumbotron w-100 jb_bg" style="margin-top: 100px;">
        <div class="container">
            <h1 class="font-weight-bold"><?php echo e($blog->title); ?></h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" style="background-color:#D7F3FF">
                    <li class="breadcrumb-item"><a href="<?php echo e(URL::to('/')); ?>">
                            <h5><?php echo e(__('blog.1')); ?> </h5>
                        </a></li>
                    <li class="breadcrumb-item" aria-current="page"><a href="<?php echo e(URL::to('/blog')); ?>">
                            <h5><?php echo e(__('blog.2')); ?></h5>
                        </a></li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container">



        <div class="row">
            <div class="col-sm-12 mb-5">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card border-0">
                            <div class="card-body">
                                <?php if($blog->youtube_video_embed): ?>
                                    <div class="embed-responsive embed-responsive-16by9 rounded">
                                        <?php echo $blog->youtube_video_embed; ?>

                                    </div>
                                <?php else: ?>
                                    <img src="<?php echo e(asset('storage/blog/' . $blog->image)); ?>" class="card-img-top">
                                <?php endif; ?>
                                <h3 class="card-title mt-4 font-weight-bold">
                                    <?php if($locale == 'mr'): ?>
                                        <?php echo e($blog->title_mr); ?>

                                    <?php elseif($locale == 'hi'): ?>
                                        <?php echo e($blog->title_hi); ?>

                                    <?php elseif($locale == 'ta'): ?>
                                        <?php echo e($blog->title_ta); ?>

                                    <?php elseif($locale == 'te'): ?>
                                        <?php echo e($blog->title_te); ?>

                                    <?php else: ?>
                                        <?php echo e($blog->title); ?>

                                    <?php endif; ?>
                                </h3>
                                <p class="mb-2">
                                    <span class="mr-2 fsize"><?php echo e(parseDateTime($blog->created_at, 'M d, Y')); ?></span> |
                                    <span class="ml-2 mr-2 text-capitalize fsize">
                                        <?php if($locale == 'mr'): ?>
                                            <?php echo e($blog->author_name_mr); ?>

                                        <?php elseif($locale == 'hi'): ?>
                                            <?php echo e($blog->author_name_hi); ?>

                                        <?php elseif($locale == 'ta'): ?>
                                            <?php echo e($blog->author_name_ta); ?>

                                        <?php elseif($locale == 'te'): ?>
                                            <?php echo e($blog->author_name_te); ?>

                                        <?php else: ?>
                                            <?php echo e($blog->author_name); ?>

                                        <?php endif; ?>
                                    </span>
                                    <?php if($blog->blogCategories->deleted_at): ?>
                                    <?php else: ?>
                                        | <span
                                            class="ml-2 mr-2 fsize"><?php echo e($blog->blogCategories->blog_category_name); ?></span>
                                    <?php endif; ?>
                                </p>
                                <p class="mb-4">
                                <h4 class="text-muted fsize_desc">
                                    <?php if($locale == 'mr'): ?>
                                        <?php echo $blog->description_mr; ?>

                                    <?php elseif($locale == 'hi'): ?>
                                        <?php echo $blog->description_hi; ?>

                                    <?php elseif($locale == 'ta'): ?>
                                        <?php echo $blog->description_ta; ?>

                                    <?php elseif($locale == 'te'): ?>
                                        <?php echo $blog->description_te; ?>

                                    <?php else: ?>
                                        <?php echo $blog->description; ?>

                                    <?php endif; ?>
                                </h4>
                                </p>
                                <h5 class="mt-4 font-weight-bold"><?php echo e(__('blog.3')); ?></h5>
                                <div class="main-content">
                                    <div class="column ml-4 mb-2">
                                        <a href="https://wa.me/?text=<?php echo e(url()->current()); ?>"
                                            class="btn btn-sm btn-success"><i class="fa-brands fa-whatsapp"
                                                aria-hidden="true"></i> WhatsApp</a>
                                    </div>

                                    <div class="column ml-4 mb-2">
                                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo e(url()->current()); ?>&quote=<?php echo e(createSlug($blog->title, '-')); ?>"
                                            class="btn btn-sm btn-primary"><i class="fa-brands fa-facebook"></i>
                                            Facebook</a>
                                    </div>

                                    <div class="column ml-4 mb-2">
                                        <button type="button"
                                            onclick="navigator.clipboard.writeText(window.location.href);"
                                            class="btn btn-sm btn-info"><i class="fa fa-link" aria-hidden="true"></i> Copy
                                            Link</button>
                                    </div>

                                    <div class="column ml-4 mb-2">
                                        <a href="mailto:?body=<?php echo e(url()->current()); ?>" class="btn btn-sm btn-warning"><i
                                                class="fa fa-envelope" aria-hidden="true"></i> Email</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 d-none d-sm-block">
                        <div class="card border-0">
                            <div class="card-body">
                                <h4 class="font-weight-bold"><?php echo e(__('blog.4')); ?></h4>
                                <?php if($blog->tags): ?>
                                    <?php
                                        $tags = explode(',', $blog->tags);
                                    ?>
                                    <?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <a href="<?php echo e(URL::to('/blog?search=' . $tag)); ?>"
                                            class="btn btn-sm btn-outline-secondary mr-2 mb-2"><?php echo e($tag); ?></a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card text-white mb-4 mt-3">
                        <div class="card-header text-capitalize" style="background-color: #1476A1;">
                            <h4 class="font-weight-bold"><?php echo e(__('blog.5')); ?>

                                <?php echo e($blog->author_name); ?></h4>
                        </div>
                        <?php if(!empty($blog->author_details)): ?>
                            <div class="card-body text-dark" style="background-color: #F2FBFF;">
                                <span class="fsize text-dark"> <?php echo e($blog->author_details); ?> </span>

                                <div class="main-content mt-3">
                                    <?php if($blog->facebook): ?>
                                        <div class="column p-0">
                                            <a href="<?php echo e($blog->facebook); ?>" target="_BLANK"><img
                                                    src="<?php echo e(asset('assets/img/web/fbbk.png')); ?>" /></a>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($blog->whatsapp): ?>
                                        <div class="column p-0">
                                            <a href="https://wa.me/+91<?php echo e($blog->whatsapp); ?>" target="_BLANK"><img
                                                    src="<?php echo e(asset('assets/img/web/whatsappbk.png')); ?>" /></a>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($blog->instagram): ?>
                                        <div class="column p-0">
                                            <a href="<?php echo e($blog->instagram); ?>" target="_BLANK"><img
                                                    src="<?php echo e(asset('assets/img/web/instabk.png')); ?>" /></a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-md-12 d-block d-sm-none">
                    <div class="card border-0">
                        <div class="card-body p-0">
                            <h5><?php echo e(__('blog.6')); ?></h5>
                            <?php if($blog->tags): ?>
                                <?php
                                    $tags = explode(',', $blog->tags);
                                ?>
                                <?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a href="<?php echo e(URL::to('/blog?search=' . $tag)); ?>"
                                        class="btn btn-sm btn-outline-secondary mr-2 mb-2"><?php echo e($tag); ?></a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>


                <div class="d-flex justify-content-center mt-5 mb-5">
                    <h3 class="float-center font-weight-bold"><?php echo e(__('blog.7')); ?></h3>
                </div>


                
                <div class="col-sm-12">
                    <div class="row">
                        <?php if($related_blogs->isNotEmpty()): ?>
                            <?php $__currentLoopData = $related_blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-sm-4 mb-5">
                                    
                                    <a href="<?php echo e($locale != 'en' ? URL::to('/' . $locale . '/blog-details/' . $blog->blog_id . '/' . createSlug($blog->title, '-')) : URL::to('/blog-details/' . $blog->blog_id . '/' . createSlug($blog->title, '-'))); ?>">
                                        <div class="card shadow">
                                            <img src="<?php echo e(asset('storage/blog/' . $blog->image)); ?>" class="card-img-top">
                                            <div class="card-body">
                                                <a
                                                    href="<?php echo e(URL::to('/blog-details/' . $blog->blog_id . '/' . createSlug($blog->title, '-'))); ?>">
                                                    <h4 class="card-title font-weight-bold text-dark">
                                                        <?php if($locale=='mr'): ?>
                                                            <?php echo e($blog->title_mr); ?></h4>
                                                        <?php elseif($locale=='hi'): ?>
                                                         <?php echo e($blog->title_hi); ?></h4>
                                                        <?php elseif($locale=='ta'): ?>
                                                            <?php echo e($blog->title_ta); ?></h4>
                                                        <?php elseif($locale=='te'): ?>
                                                            <?php echo e($blog->title_te); ?></h4>
                                                        <?php else: ?> 
                                                            <?php echo e($blog->title); ?></h4>
                                                        <?php endif; ?>
                                                    </h4>
                                                </a>
                                                <p class="text-secondary mb-2"><i
                                                        class="fas text-secondary fa-calendar-alt mr-2"></i>
                                                    <?php echo e(parseDateTime($blog->created_at, 'M d, Y')); ?> </p>
                                                <u>
                                                    
                                                        <a href="<?php echo e($locale != 'en' ? URL::to('/' . $locale . '/blog-details/' . $blog->blog_id . '/' . createSlug($blog->title, '-')) : URL::to('/blog-details/' . $blog->blog_id . '/' . createSlug($blog->title, '-'))); ?>"><?php echo e(__('blog.12')); ?></a>
                                                    </u>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <div class="row justify-content-center mt-5 mb-5">
                                <h5><?php echo e(__('blog.8')); ?></h5>
                            </div>
                        <?php endif; ?>



                    </div>

                </div>








            </div>
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

<?php echo $__env->make('layouts.apphome', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/home/blog_details.blade.php ENDPATH**/ ?>