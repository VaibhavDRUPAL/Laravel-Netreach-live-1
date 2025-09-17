<?php $__env->startPush('pg_btn'); ?>
    <a href="<?php echo e(route('user.vms')); ?>" class="btn btn-sm btn-neutral">All Users</a>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-body">
                    <?php echo Form::open(['route' => 'user.store_vms', 'files' => true]); ?>

                    <h6 class="heading-small text-muted mb-4">User information</h6>
                        <div class="pl-lg-4">
							<div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <?php echo e(Form::label('parent Name', 'Parent VN', ['class' => 'form-control-label'])); ?>

                                        <?php echo e(Form::select('parent_id', $vms_list, null, [ 'class'=> 'selectpicker form-control', 'placeholder' => 'Select Parent...'])); ?>

                                   
                                    </div>
                                </div>
								
                                
                            </div>
						
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <?php echo e(Form::label('name', 'First Name', ['class' => 'form-control-label'])); ?>

                                        <?php echo e(Form::text('name', null, ['class' => 'form-control'])); ?>

                                    </div>
                                </div>
								
								<div class="col-lg-6">
                                    <div class="form-group">
                                        <?php echo e(Form::label('name', 'Last Name', ['class' => 'form-control-label'])); ?>

                                        <?php echo e(Form::text('last_name', null, ['class' => 'form-control'])); ?>

                                    </div>
                                </div>
                                
                            </div>
                            <div class="row">
							
								<div class="col-lg-6">
                                    <div class="form-group">
                                        <?php echo e(Form::label('email', 'E-mail', ['class' => 'form-control-label'])); ?>

                                        <?php echo e(Form::email('email', null, ['class' => 'form-control'])); ?>

                                    </div>
                                </div>
								
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <?php echo e(Form::label('phone_number', 'Phone number', ['class' => 'form-control-label'])); ?>

                                        <?php echo e(Form::text('phone_number', null, ['class' => 'form-control'])); ?>

                                    </div>
                                </div>
								
								
                            </div>
							
							
							 <div class="row">
							
								 <div class="col-lg-6">
                                    <div class="form-group">
                                        <?php echo e(Form::label('username', 'VNCODE', ['class' => 'form-control-label'])); ?>

                                        <?php echo e(Form::text('username', null, ['class' => 'form-control'])); ?>

                                    </div>
                                </div>
                                
								<div class="col-lg-6">
                                    <div class="form-group">
                                        <?php echo e(Form::label('region', 'Region', ['class' => 'form-control-label'])); ?>

                                        <?php echo e(Form::select('region', array("east"=>'East',"west"=>'West',"north"=>'North',"south"=>'South'), null, [ 'class'=> 'selectpicker form-control', 'placeholder' => 'Select Region...'])); ?>

                                    </div>
                                </div>
                                
                                
                            </div>
							
							
							<div class="row">
							
								 <div class="col-lg-6">
                                    <div class="form-group">
                                        <?php echo e(Form::label('state', 'State', ['class' => 'form-control-label'])); ?>

                                        <?php echo e(Form::select('state', $state, null, [ 'class'=> 'selectpicker form-control', 'placeholder' => 'Select Region...'])); ?>

                                    </div>
                                </div>
								
								<div class="col-lg-6">
									<div class="form-group">
									<?php echo e(Form::label('role', 'Select Role', ['class' => 'form-control-label'])); ?>

									<?php echo e(Form::select('role', $roles, null, [ 'class'=> 'selectpicker form-control', 'placeholder' => 'Select role...'])); ?>

									</div>
								</div>
                                								
                            </div>
							
							
							 
							
                        </div>
                        <hr class="my-4" />
                        <!-- Address -->
                        <h6 class="heading-small text-muted mb-4">Password information</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php echo e(Form::label('password', 'Password', ['class' => 'form-control-label'])); ?>

                                        <?php echo e(Form::password('password', ['class' => 'form-control'])); ?>

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php echo e(Form::label('password_confirmation', 'Confirm password', ['class' => 'form-control-label'])); ?>

                                        <?php echo e(Form::password('password_confirmation', ['class' => 'form-control'])); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--<hr class="my-4" />-->
                        <div class="pl-lg-4">
                            <div class="row">
                                
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
    <script src="<?php echo e(asset('vendor/laravel-filemanager/js/stand-alone-button.js')); ?>"></script>
    <script>
        jQuery(document).ready(function(){
            jQuery('#uploadFile').filemanager('file');
        })
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/users1/create_vms.blade.php ENDPATH**/ ?>