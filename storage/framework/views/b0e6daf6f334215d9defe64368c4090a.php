<?php
    use App\Models\ChatbotModule\Greetings;
?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12 my-2">
            <button class="btn btn-primary float-right" data-toggle="modal" data-target="#new-greetings">
                <i class="fa fa-plus"></i>
                Add Greetings
            </button>
        </div>
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-header bg-transparent"><h3 class="mb-0">All Greetings</h3></div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <div>
                            <table class="table table-hover align-items-center">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Sr No.</th>
                                        <th scope="col">Greeting Title</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    <?php
                                        $count = 0;
                                    ?>
                                    <?php if($data->isNotEmpty()): ?>
                                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $greeting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td scope="row"><?php echo e(++$count); ?></td>
                                                <td scope="row"><?php echo e($greeting[Greetings::greeting_title]); ?></td>
                                                <td scope="row">
                                                    <a href="#" class="px-1 edit-greeting" data-id="<?php echo e($greeting[Greetings::greeting_id]); ?>">
                                                        <i class="fas text-primary fa-edit"></i>
                                                    </a>
                                                    <a href="#" class="px-1">
                                                        <i class="fas text-danger fa-trash delete-greeting" data-id="<?php echo e($greeting[Greetings::greeting_id]); ?>"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <tr>
                                            <td scope="row" colspan="3">No data found!</td>
                                        </tr>
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

<?php $__env->startPush('modal'); ?>
    <div class="modal fade" id="greetings" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="greetings-title">Add Greetings</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <div class="card bg-secondary shadow border-0">
                        <div class="card-body px-lg-5 py-lg-5">
                            <form action="<?php echo e(route('chatbot.greetings.save')); ?>" method="post" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="greeting_id" id="greeting_id">
                                <input type="hidden" id="field-type" value="<?php echo e(Greetings::greetings); ?>">
                                <div class="greeting-fields" id="greetings-field"></div>
                                <div class="float-right my-3">
                                    <button type="submit" class="btn btn-success float-right mr-0">
                                        Save
                                    </button>
                                    <button type="button" class="btn btn-primary float-right mr-2" id="add-greetings">
                                        <i class="fa fa-plus"></i>
                                        Add More
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="new-greetings" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="greetings-title">Add Greetings</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <div class="card bg-secondary shadow border-0">
                        <div class="card-body px-lg-5 py-lg-5">
                            <form action="<?php echo e(route('chatbot.greetings.save')); ?>" method="post">
                                <?php echo csrf_field(); ?>
                                <div class="form-group">
                                    <label for="greeting_title">Greeting Title</label>
                                    <input type="text" class="form-control" name="greeting_title" id="greeting_title">
                                </div>
                                <div class="float-right my-3">
                                    <button type="submit" class="btn btn-success float-right mr-0">
                                        Save
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(App::isProduction() ? secure_asset('assets/js/custom/chatbot.js') : asset('assets/js/custom/chatbot.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/chatbot/admin/index.blade.php ENDPATH**/ ?>