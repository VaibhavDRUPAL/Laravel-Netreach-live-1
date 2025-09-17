<?php $__env->startPush('pg_btn'); ?>
    <a href="<?php echo e(route('post.index')); ?>" class="btn btn-sm btn-neutral">All CMS</a>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-body">
                    <?php echo Form::open(['route' => 'post.store', 'files' => true]); ?>

                    <h6 class="heading-small text-muted mb-4">CMS information</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <?php echo e(Form::label('CMS_title', 'CMS title', ['class' => 'form-control-label'])); ?>

                                        <?php echo e(Form::text('cms_title', null, ['class' => 'form-control'])); ?>

                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <?php echo e(Form::label('category_id', 'Select Category', ['class' => 'form-control-label'])); ?>

                                        <?php echo e(Form::select('category_id', $categories, null, [ 'class'=> 'selectpicker form-control', 'placeholder' => 'Select category...'])); ?>

                                    </div>
                                </div>

                                
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <?php echo e(Form::label('CMS_body', 'CMS Body', ['class' => 'form-control-label'])); ?>

                                        <?php echo Form::textarea('cms_body', null, ['id'=>"summernote", 'class'=> 'form-control',]); ?>

                                    </div>
                                </div>

                            </div>
                        </div>

                        <hr class="my-4" />
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="status" value="1" class="custom-control-input" id="status">
                                        <?php echo e(Form::label('status', 'Status', ['class' => 'custom-control-label'])); ?>

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <?php echo e(Form::submit('Submit', ['class'=> 'mt-5 btn btn-primary'])); ?>

                                </div>
                            </div>
                        </div>
                    <?php echo Form::close(); ?>

                </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/summernote-bs4.min.css')); ?>">
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('assets/js/summernote-bs4.min.js')); ?>"></script>
<script src="<?php echo e(asset('vendor/laravel-filemanager/js/stand-alone-button.js')); ?>"></script>
<script>
    jQuery(document).ready(function() {
        jQuery('#summernote').summernote({
            height: 150,
            toolbar: [
               // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']]
              ]

        });
        jQuery('#uploadFile').filemanager('file');
    });
  </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/post/create.blade.php ENDPATH**/ ?>