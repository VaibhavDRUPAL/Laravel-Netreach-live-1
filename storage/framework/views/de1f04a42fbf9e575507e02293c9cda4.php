<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card mb-5">
            <div class="card-header bg-transparent">
                <h3 class="mb-0">Anonymous Visitors</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <div>
                        <table class="table table-hover align-items-center" id="anonymous-visitors">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">IP Address</th>
                                    <th scope="col">Country</th>
                                    <th scope="col">State</th>
                                    <th scope="col">City</th>
                                    <th scope="col">Zip Code</th>
                                    <th scope="col">Created At</th>
                                </tr>
                            </thead>
                            <tbody class="list"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<link rel="stylesheet" media="all" href="<?php echo e(asset('assets/css/jquery.dataTables.css')); ?>">
<script type="text/javascript" charset="utf8" src="<?php echo e(asset('assets/js/jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(App::isProduction() ? secure_asset('assets/js/custom/chatbot.js') : asset('assets/js/custom/chatbot.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/chatbot/visitor/anonymous.blade.php ENDPATH**/ ?>