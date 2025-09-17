<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <?php echo e(Form::open(['route' => 'settings.update', 'files'=>true])); ?>

            <div class="card mb-5">
                <div class="card-header bg-transparent"><h3 class="mb-0">General Settings</h3></div>
                <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php echo e(Form::label('company_name', 'Company Name', ['class' => 'form-control-label'])); ?>

                                    <?php echo e(Form::text('company_name', setting('company_name'), ['class'=>"form-control"])); ?>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php echo e(Form::label('company_email', 'Company Email', ['class' => 'form-control-label'])); ?>

                                    <?php echo e(Form::text('company_email', setting('company_email'), ['class'=>"form-control"])); ?>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php echo e(Form::label('company_phone', 'Company Phone', ['class' => 'form-control-label'])); ?>

                                    <?php echo e(Form::text('company_phone', setting('company_phone'), ['class'=>"form-control"])); ?>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php echo e(Form::label('company_address', 'Company Address', ['class' => 'form-control-label'])); ?>

                                    <?php echo e(Form::text('company_address', setting('company_address'), ['class'=>"form-control"])); ?>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?php echo e(Form::label('company_city', 'City', ['class' => 'form-control-label'])); ?>

                                    <?php echo e(Form::text('company_city', setting('company_city'), ['class'=>"form-control"])); ?>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <?php echo e(Form::label('company_logo', 'Company Logo', ['class' => 'form-control-label'])); ?>

                                    <div class="input-group">
                                        <span class="input-group-btn">
                                          <a id="uploadFile" data-input="thumbnail" data-preview="holder" class="btn btn-secondary">
                                            <i class="fa fa-picture-o"></i> Choose Logo
                                          </a>
                                        </span>
                                        <?php if(setting('company_logo')): ?>
                                            <input id="thumbnail" class="form-control d-none" type="text" value="<?php echo e(setting('company_logo')); ?>" name="company_logo">
                                        <?php else: ?>
                                            <input id="thumbnail" class="form-control d-none" type="text" name="company_logo">
                                        <?php endif; ?>
                                    </div>
                            </div>
                            <div class="col-md-2 text-right">
                                <?php if(setting('company_logo')): ?>
                                <img alt="Image placeholder"
                                    class="avatar avatar-xl  rounded-circle"
                                    data-toggle="tooltip" data-original-title="<?php echo e(setting('company_name')); ?> Logo"
                                    src="<?php echo e(asset(setting('company_logo'))); ?>">
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="card mb-5">
                <div class="card-header bg-transparent"><h4 class="mb-0">Display Settings</h4></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <?php echo e(Form::label('record_per_page', 'Record Per Page', ['class' => 'form-control-label'])); ?>

                                <?php echo e(Form::text('record_per_page', setting('record_per_page'), ['class'=>"form-control"])); ?>

                            </div>
                        </div>

                        <div class="col-md-6" style="display:none;">
                            <div class="form-group">
                                <?php echo e(Form::label('company_currency_symbol', 'Currency Symbol', ['class' => 'form-control-label'])); ?>

                                <?php echo e(Form::text('company_currency_symbol', setting('company_currency_symbol'), ['class'=>"form-control"])); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-5">
                <div class="card-header bg-transparent"><h4 class="mb-0">Other Settings</h4></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <?php echo e(Form::label('default_role', 'User Registration Admin Notification Email', ['class' => 'form-control-label'])); ?>

                            <div class="custom-control custom-checkbox">
                                <?php echo Form::hidden('register_notification_email', 0); ?>

                                <input type="checkbox" name="register_notification_email" value="1" <?php echo e(setting('register_notification_email') ? 'checked' : ''); ?> class="custom-control-input" id="register_notification_email">
                                <?php echo e(Form::label('register_notification_email', 'Activate', ['class' => 'custom-control-label form-control-label'])); ?>

                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <?php echo e(Form::label('default_role', 'Select default register role', ['class' => 'form-control-label'])); ?>

                                <?php echo e(Form::select('default_role', $roles, setting('default_role', null), [ 'class'=> 'selectpicker form-control', 'placeholder' => 'Select role...'])); ?>

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <?php echo e(Form::label('max_login_attempts', 'Maximum invaild login attempts', ['class' => 'form-control-label'])); ?>

                                <?php echo e(Form::text('max_login_attempts', setting('max_login_attempts'), ['class'=>"form-control"])); ?>

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <?php echo e(Form::label('lockout_delay', 'Lockout delay (minutes)', ['class' => 'form-control-label'])); ?>

                                <?php echo e(Form::text('lockout_delay', setting('lockout_delay'), ['class'=>"form-control"])); ?>

                            </div>
                        </div>
                        <div class="col-md-12 mt-4">
                            <?php echo Form::submit('Update Settings', ['class'=> 'btn btn-primary']); ?>

                        </div>
                    </div>
                </div>
            </div>
            <?php echo e(Form::close()); ?>


        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('vendor/laravel-filemanager/js/stand-alone-button.js')); ?>"></script>
    <script>
        jQuery(document).ready(function(){
            jQuery('#uploadFile').filemanager('file');
        })
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/settings/edit.blade.php ENDPATH**/ ?>