<?php $__env->startPush('pg_btn'); ?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create-vn-link-genrate')): ?>
    <a href="<?php echo e(route('genrate.create')); ?>" class="btn btn-sm btn-neutral">Create New Generate</a>
<?php endif; ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('styles'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-header bg-transparent"><h3 class="mb-0">All Generate</h3></div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <div>
                            <table class="table table-hover align-items-center">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">App/Platform Name</th>
                                    <th scope="col">Short Url</th>
                                    <th scope="col">Url</th>
									<th scope="col">Description</th>
                                </tr>
                                </thead>
                                <tbody class="list">
                                <?php $__currentLoopData = $genrate; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
										 <td scope="row">
                                            <?php echo e($plat->name); ?>

                                        </td>
                                        <td><?php echo e($plat->tinyurl); ?></td>
                                        <td scope="row">
                                            <input type="hidden" value="<?php echo e($plat->tinyurl); ?>" id="copy_text_<?php echo e($plat->id); ?>"> 
											<i class="fas fa-copy" onclick="copyUrl(<?php echo e($plat->id); ?>)" ></i>
											
                                        </td>
										<td><?php echo e($plat->detail); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                                <tfoot >
                                <tr>
                                    <td colspan="6">
                                        <?php echo e($genrate->links()); ?>

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
        function copyUrl(id) {
			
		  var $temp = $("<input>");
		  $("body").append($temp);
		  $temp.val($("#copy_text_"+id).val()).select();
		  document.execCommand("copy");
		  $temp.remove();
		  alert("Copy URL");
		}
		
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/genrate/index.blade.php ENDPATH**/ ?>