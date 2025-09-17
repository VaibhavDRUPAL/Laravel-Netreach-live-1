<?php $__env->startPush('pg_btn'); ?>
    <a href="<?php echo e(route('user.vms')); ?>" class="btn btn-sm btn-neutral">All Users</a>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-body">
                    <?php echo Form::open(['route' => 'edit.store_vns', 'files' => true]); ?>

                    <h6 class="heading-small text-muted mb-4">User information</h6>
				
                        <div class="pl-lg-4">
							<div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <?php echo e(Form::label('parent Name', 'Parent VN', ['class' => 'form-control-label'])); ?>

                                        <?php echo e(Form::select('parent_id', $vms_list, $vns_results->parent_id, [ 'class'=> 'form-control', 'placeholder' => 'Select Parent...'])); ?>

                                   
                                    </div>
                                </div>
								
                                
                            </div>
						
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <?php echo e(Form::label('name', 'First Name', ['class' => 'form-control-label'])); ?>

                                        <?php echo e(Form::text('name', $vns_results->name, ['class' => 'form-control'])); ?>

                                    </div>
                                </div>
								
								<div class="col-lg-6">
                                    <div class="form-group">
                                        <?php echo e(Form::label('name', 'Last Name', ['class' => 'form-control-label'])); ?>

                                        <?php echo e(Form::text('last_name', $vns_results->last_name, ['class' => 'form-control'])); ?>

                                    </div>
                                </div>
                                
                            </div>
                            <div class="row">
							
								<div class="col-lg-6">
                                    <div class="form-group">
                                        <?php echo e(Form::label('email', 'E-mail', ['class' => 'form-control-label'])); ?>

                                        <?php echo e(Form::email('email',  $vns_results->email, ['class' => 'form-control'])); ?>

                                    </div>
                                </div>
								
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <?php echo e(Form::label('phone_number', 'Phone number', ['class' => 'form-control-label'])); ?>

                                        <?php echo e(Form::text('phone_number', $vns_results->mobile_number, ['class' => 'form-control'])); ?>

                                    </div>
                                </div>
								
								
                            </div>
							
							
							 <div class="row">
							
								
                                
								<div class="col-lg-6">
                                    <div class="form-group">
                                        <?php echo e(Form::label('region', 'Region', ['class' => 'form-control-label'])); ?>

                                        <?php echo e(Form::select('region', array("east"=>'East',"west"=>'West',"north"=>'North',"south"=>'South'), $vns_results->region, [ 'class'=> 'form-control', 'placeholder' => 'Select Region...'])); ?>

                                    </div>
                                </div>
                                
                                
                            </div>
							
							
							<div class="row">
							
								 <div class="col-lg-6">
                                    <div class="form-group">
                                        <?php echo e(Form::label('state', 'State', ['class' => 'form-control-label'])); ?>

										<?php
											$stateArr = explode(",",$vns_results->state_code);
										?>
									   <?php $__currentLoopData = $state; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" id="<?php echo e($key); ?>" name="state[]" value="<?php echo e($key); ?>" <?php echo e(in_array($key, $stateArr)? 'checked' : ''); ?>>
											<label class="custom-control-label" for="<?php echo e($key); ?>" ><?php echo e($val); ?></label>
										</div>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        
                                    </div>
                                </div>
																
                                								
                            </div>
							
							
							 
							
                        </div>
                        
                      
                        <!--<hr class="my-4" />-->
                        <div class="pl-lg-4">
                            <div class="row">
                                
                                <div class="col-md-12">
									<input type="hidden" value="<?php echo e($id); ?>" name="update_id" >
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/users1/edit_vms.blade.php ENDPATH**/ ?>