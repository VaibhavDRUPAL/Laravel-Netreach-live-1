<?php $__env->startSection('content'); ?>

<?php
    use App\Models\SelfModule\RiskAssessmentQuestionnaire;
?>

<div class="row">
	<a href="<?php echo e(route('admin.self-risk-assessment.questionnaire', ['export' => true])); ?>" class="btn btn-primary float-right w-2 m-2" role="button" id="btn-export-risk-assessment">Export</a>
    <div class="col-md-12">
        <div class="card mb-5">
            <div class="card-header bg-transparent">
                <h3 class="mb-0">Self-Risk Assessment Questionnaire</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <div>
                        <?php
                            $count = 0;
                        ?>
                        <table class="table table-hover align-items-center">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Sr. No</th>
                                    <th scope="col">Question</th>
                                    <th scope="col">Count</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($value[RiskAssessmentQuestionnaire::question_slug] != 'mobile-number'): ?>
                                        <tr>
                                            <td scope="col"><?php echo e(++$count); ?></td>
                                            <td scope="col"><?php echo e($value[RiskAssessmentQuestionnaire::question]); ?></td>
                                            <td scope="col"><?php echo e($value[RiskAssessmentQuestionnaire::counter]); ?></td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/self/admin/questionnaire.blade.php ENDPATH**/ ?>