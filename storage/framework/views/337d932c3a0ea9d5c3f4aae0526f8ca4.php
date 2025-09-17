<?php $__env->startPush('pg_btn'); ?>
    <a href="<?php echo e(route('genrate.index')); ?>" class="btn btn-sm btn-neutral">All Genrate</a>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-body">
                    <?php echo Form::open(['route' => 'genrate.store']); ?>

                   
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <?php echo e(Form::label('name', 'App/Platform', ['class' => 'form-control-label'])); ?>

                                        <?php echo e(Form::select('unique_code_link', $genrate, null, [ 'class'=> 'selectpicker form-control', 'placeholder' => 'Select App/Platform...'])); ?>                                  
                                    </div>
                                </div>
								
								
                            </div>
							
							 <div class="row"><div class="col-lg-6">
                                    <div class="form-group">                                        
                                         
										<?php echo Form::textarea('detail',null,['class'=>'form-control', 'rows' => 2, 'cols' => 30]); ?>										
                                    </div>
                                </div></div>
								
                        <div class="pl-lg-1">
                            <div class="row">
                                <div class="col-md-12">
                                    <?php echo e(Form::submit('Submit', ['class'=> 'mt-3 btn btn-primary'])); ?>

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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/genrate/create.blade.php ENDPATH**/ ?>