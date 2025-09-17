<?php $__env->startPush('pg_btn'); ?>
<a href="<?php echo e(route('blogs_all')); ?>" class="btn btn-sm btn-neutral">All Blogs</a>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card mb-5">
            <div class="card-body">
                <?php echo Form::open(['route' => 'blog_store', 'files' => true]); ?>

                <h6 class="heading-small text-muted mb-4">Add Blog</h6>
                <div class="pl-lg-4">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <?php echo e(Form::label('title', 'Title', ['class' => 'form-control-label'])); ?>

                                <?php echo e(Form::text('title', null, ['class' => 'form-control'])); ?>

                            </div>
                            <div class="form-group">
                                <?php echo e(Form::Label('blog_category_id', 'Blog Category', ['class' => 'form-control-label'])); ?>

                                <?php echo e(Form::select('blog_category_id', $blog_categories, null, [ 'class'=> 'selectpicker form-control', 'placeholder' => 'Select Blog Category'])); ?>

                            </div>
                            <div class="form-group">
                                <?php echo e(Form::label('description', 'Description', ['class' => 'form-control-label'])); ?>

                                <?php echo e(Form::textarea('description', null, ['class' => 'form-control','id'=>'description','rows'=> 15])); ?>

                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <?php echo e(Form::label('image', 'Photo', ['class' => 'form-control-label'])); ?>

                                
                                
                                <br>
                                <input id="thumbnail" class="form-control" type="file" name="image">
                                
                            </div>
                            <div class="form-group">
                                <?php echo e(Form::label('youtube_video_embed', 'Youtube Video Embed', ['class' => 'form-control-label'])); ?>

                                <?php echo e(Form::textarea('youtube_video_embed', null, ['class' => 'form-control','rows'=>7])); ?>

                                <small class="text-small text-muted">Paste youtube video embed code</small>
                            </div>
                            <div class="form-group">
                                <?php echo e(Form::label('tags', 'Tags', ['class' => 'form-control-label'])); ?>

                                <?php echo e(Form::textarea('tags', null, ['class' => 'form-control','rows'=>3])); ?>

                                <small class="text-small text-muted">Comma seperated words</small>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="my-4" />
                <!-- Address -->
                <h6 class="heading-small text-muted mb-4">SEO details</h6>
                <div class="pl-lg-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <?php echo e(Form::label('meta_title', 'Meta Title', ['class' => 'form-control-label'])); ?>

                                <?php echo e(Form::text('meta_title', null, ['class' => 'form-control'])); ?>

                            </div>
                            <div class="form-group">
                                <?php echo e(Form::label('meta_keywords', 'Meta Keywords', ['class' => 'form-control-label'])); ?>

                                <?php echo e(Form::text('meta_keywords', null, ['class' => 'form-control'])); ?>

                                <small class="text-small text-muted">Comma seperated words</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <?php echo e(Form::label('meta_description', 'Meta Description', ['class' => 'form-control-label'])); ?>

                                <?php echo e(Form::textarea('meta_description', null, ['class' => 'form-control','rows'=>6])); ?>

                            </div>
                        </div>
                    </div>
                </div>
                <hr class="my-4" />
                <h6 class="heading-small text-muted mb-4">Author details</h6>
                <div class="pl-lg-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <?php echo e(Form::label('author_name', 'Author name', ['class' => 'form-control-label'])); ?>

                                <?php echo e(Form::text('author_name', null, ['class' => 'form-control'])); ?>

                            </div>
                            <div class="form-group">
                                <?php echo e(Form::label('author_details', 'Author details', ['class' => 'form-control-label'])); ?>

                                <?php echo e(Form::textarea('author_details', null, ['class' => 'form-control','rows'=>6])); ?>

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <?php echo e(Form::label('facebook', 'Facebook link', ['class' => 'form-control-label'])); ?>

                                <?php echo e(Form::text('facebook', null, ['class' => 'form-control'])); ?>

                            </div>
                            <div class="form-group">
                                <?php echo e(Form::label('whatsapp', 'Whatsapp number', ['class' => 'form-control-label'])); ?>

                                <?php echo e(Form::text('whatsapp', null, ['class' => 'form-control'])); ?>

                            </div>
                            <div class="form-group">
                                <?php echo e(Form::label('instagram', 'Instagram link', ['class' => 'form-control-label'])); ?>

                                <?php echo e(Form::text('instagram', null, ['class' => 'form-control'])); ?>

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
                                <?php echo e(Form::label('status', 'Active', ['class' => 'custom-control-label'])); ?>

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
<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.tiny.cloud/1/c0vs94lg4ti05nbrgct6j7yufm7qky7t1js3ho1prudbt51h/tinymce/6/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: 'textarea#description',
        menubar: false,
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/blogs/createBlog.blade.php ENDPATH**/ ?>