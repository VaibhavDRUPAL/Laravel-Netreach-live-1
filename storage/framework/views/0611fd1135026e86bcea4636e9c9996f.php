<?php $__env->startPush('pg_btn'); ?> 
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card mb-5">
            <div class="card-header bg-transparent">
                <div class="row">
                    <div class="col-lg-8">
                        <h3 class="mb-0">All Blog Categories</h3>
                    </div>
                    <div class="col-lg-4">
                         <a href="<?php echo e(route('blog_categories_create')); ?>" class="btn btn-primary float-right"><i class="fa fa-plus"></i> Add Blog Category</a>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <div>
                        <table class="table table-hover align-items-center">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Category Name</th>  
                                    <th scope="col">Status</th> 
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                <?php if($blog_categories): ?>
                                    <?php $__currentLoopData = $blog_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog_category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <th scope="row">
                                            <?php echo e($blog_category->blog_category_name); ?>

                                        </th> 
                                        <td>
                                            <?php if($blog_category->status): ?>
                                            <span class="badge badge-pill badge-lg badge-primary">Active</span>
                                            <?php else: ?>
                                            <span class="badge badge-pill badge-lg badge-danger">Disabled</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <a href="<?php echo e(route('blog_categories_edit',$blog_category->blog_category_id)); ?>" class="px-1 edit-greeting">
                                                <i class="fas text-primary fa-edit"></i>
                                            </a>
                                            <a href="<?php echo e(route('blog_categories_destroy',$blog_category->blog_category_id)); ?>" class="px-1">
                                                <i class="fas text-danger fa-trash delete-greeting"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                <?php else: ?>  
                                    <td colspan="4" class="text-center">
                                        No Data Found
                                    </td>
                                <?php endif; ?>
                                
                            </tbody>
                             
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/blogCategories/allBlogCategories.blade.php ENDPATH**/ ?>