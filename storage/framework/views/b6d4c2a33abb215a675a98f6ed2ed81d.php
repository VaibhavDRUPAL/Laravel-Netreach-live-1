<?php
    use App\Models\ChatbotModule\LanguageCounter;
    use App\Models\LanguageModule\Language;
?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card mb-5">
            <div class="card-header bg-transparent">
                <h3 class="mb-0">Language Counter</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <div>
                        <table class="table table-hover align-items-center">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Sr. No</th>
                                    <th scope="col">Language Name</th>
                                    <th scope="col">Language Counter</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                <?php
                                    $count = 0;
                                ?>
                                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $counter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td scope="row" width="5%"><?php echo e(++$count); ?></td>
                                        <td scope="row" width="5%"><?php echo e($counter[LanguageCounter::RL_LANGUAGE][Language::name]); ?></td>
                                        <td scope="row" width="80%"><?php echo e($counter[LanguageCounter::counter]); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/chatbot/language/counter.blade.php ENDPATH**/ ?>