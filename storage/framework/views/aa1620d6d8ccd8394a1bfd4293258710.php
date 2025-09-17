<?php $__env->startPush('pg_btn'); ?>

<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-header bg-transparent">
                    <div class="row">
                        <div class="col-lg-8">
                            <h3 class="mb-0">All District</h3>
                        </div>
						
						<div class="col-lg-4">
							<?php echo Form::open(['route' => 'district.index', 'method'=>'get']); ?>

								<div class="form-group mb-0">
								<?php echo e(Form::text('search', request()->query('search'), ['class' => 'form-control form-control-sm', 'placeholder'=>'Search District'])); ?>

							</div>
							<?php echo Form::close(); ?>

						</div>
                       
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <div>
                            <table class="table table-hover align-items-center">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">Name</th>
                           
                                </tr>
                                </thead>
                                <tbody class="list">
                                <?php $__currentLoopData = $district; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <th scope="row">
                                            <?php echo e($val->district_name); ?>

                                        </th>
                                        
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                                <tfoot >
                                <tr>
                                    <td colspan="6">
                                        <?php echo e($district->links()); ?>

                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
   
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/district/index.blade.php ENDPATH**/ ?>