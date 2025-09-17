<?php $__env->startPush('pg_btn'); ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create-vm')): ?>
    <a href="<?php echo e(route('user.vms.create')); ?>" class="btn btn-sm btn-neutral">Create New User VMS</a>
<?php endif; ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-header bg-transparent">
                    <div class="row">
                        <div class="col-lg-8">
                            <h3 class="mb-0">All PO/CO/VN</h3>
                        </div>
                        <div class="col-lg-4">
                    <?php echo Form::open(['route' => 'user.vms', 'method'=>'get']); ?>

                        <div class="form-group mb-0">
                        <?php echo e(Form::text('search', request()->query('search'), ['class' => 'form-control form-control-sm', 'placeholder'=>'Search VN'])); ?>

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
                                    <th scope="col">Last Name</th>
                                    <th scope="col">Email</th> 
									<th scope="col">VM Code</th>
									<th scope="col">Phone</th> 	
									<th scope="col">State</th> 									
									<th scope="col">Region</th>
									<th scope="col">Status</th>
									<th scope="col">Action</th>  									
                                    
                                </tr>
                                </thead>
                                <tbody class="list">
									<?php $__currentLoopData = $vms_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									
										<?php 
											$state_name='';
											if(!empty($list->state_code)){
												$state_codeArr = explode(",",$list->state_code);
												$results = App\Models\StateMaster::getStateName($state_codeArr);
												if($results->count() > 0){
													foreach($results as $key=>$val){
														$state_name.= $val->state_name." ,";
													}
												}
											}	
											?>
										<tr>
											<td ><?php echo e($list->name); ?></td>
											<td ><?php echo e($list->last_name); ?></td>
											<td ><?php echo e($list->email); ?></td>  
											<td ><?php echo e($list->vncode); ?></td>  											
											<td ><?php echo e($list->mobile_number); ?></td>  											
											<td ><?php echo e(rtrim($state_name,',')); ?></td>  											
											<td ><?php echo e(strtoupper($list->region)); ?></td>  											
											<td >
											<?php if($list->status==1): ?>
												<a href="javascript:;" class="btn btn-sm btn-info  mr-4 " onclick="return userStatus(<?php echo e($list->id); ?>,'DeActive');">Active</a>
											<?php else: ?> 
												<a href="javascript:;" class="btn btn-sm btn-danger  mr-4 " onclick="return userStatus(<?php echo e($list->id); ?>,'Active');">De-Active</a>
											<?php endif; ?>
											</td>  											
											<td >
											<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update-user')): ?>
                                            <a class="btn btn-info btn-sm m-1" data-toggle="tooltip" data-placement="top" title="Edit Vn details" href="<?php echo e(route('vn.edit',$list)); ?>">
                                                <i class="fa fa-edit" aria-hidden="true"></i>
                                            </a>
											
											<a class="btn btn-info btn-sm m-1" data-toggle="tooltip" data-placement="top" title="Password" href="<?php echo e(route('vn.pass',$list)); ?>">
                                                <i class="fa fa-key" aria-hidden="true"></i>
                                            </a>																						
											
                                            <?php endif; ?>
											</td>  											
											
										</tr>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                                <tfoot >
                                <tr>
                                    <td colspan="6">
                                        <?php echo e($vms_list->links()); ?>

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
    <script>
       
	  function userStatus(ursid, type){
		  
		   var con = confirm("Are you sure? you want to change status?");
		   if(!con)
			  return false;
		  
			var jsonData = {"_token": "<?php echo e(csrf_token()); ?>","ursid": ursid,"type":type}
				$.ajax({
					type:'POST',
					url: "<?php echo e(route('usr.staus.update')); ?>",
					data: jsonData,
					dataType:"json",
					success: (data) => {
						console.log(data);
						window.location.href=window.location.href;	
					},
					error: function(data){
						console.log(data);
					}
				});				
	  }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/users1/vms.blade.php ENDPATH**/ ?>