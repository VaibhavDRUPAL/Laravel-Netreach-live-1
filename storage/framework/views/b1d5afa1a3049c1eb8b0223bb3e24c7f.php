<?php
    use App\Models\ChatbotModule\Questionnaire;
    use App\Models\LanguageModule\Language;
?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12 my-2">
            <button class="btn btn-primary float-right new-questionnaire" data-toggle="modal" data-target="#new-greetings">
                <i class="fa fa-plus"></i>
                Add Questionnaire
            </button>
        </div>
        <?php $__currentLoopData = $questionnaire; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2 my-2">
                                <div class="badge badge-pill badge-info">
                                    Used <?php echo e($value[Questionnaire::counter]); ?> times
                                </div>
                            </div>
                            <div class="col-md-10 my-2">
                                <button class="btn btn-sm btn-danger float-right mb-2 destroy-question" parent-id="<?php echo e($value[Questionnaire::question_id]); ?>">
                                    <i class="fa fa-trash"></i>
                                    Delete Questionnaire
                                </button>
                                <button class="btn btn-sm btn-primary float-right mb-2 mr-1 new-question" parent-id="<?php echo e($value[Questionnaire::question_id]); ?>">
                                    <i class="fa fa-plus"></i>
                                    Add More
                                </button>
                            </div>
                        </div>
                        <table class="table table-hover align-items-center">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Sr No.</th>
                                    <th scope="col">Language</th>
                                    <th scope="col">Question</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                <?php
                                    $count = 0;
                                ?>
                                <?php $__currentLoopData = $value[Questionnaire::question]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td scope="row" width="5%"><?php echo e(++$count); ?></td>
                                        <td scope="row" width="5%"><?php echo e($language->where(Questionnaire::locale, $question[Questionnaire::locale])->first()[Language::name]); ?></td>
                                        <td scope="row" width="80%"><?php echo e($question[Questionnaire::body]); ?></td>
                                        <td scope="row" width="10%">
                                            <a href="#" class="px-1 edit-question" data-body="<?php echo e($question[Questionnaire::body]); ?>" parent-id="<?php echo e($value[Questionnaire::question_id]); ?>" data-locale="<?php echo e($question[Questionnaire::locale]); ?>">
                                                <i class="fas text-primary fa-edit"></i>
                                            </a>
                                            <a href="#" class="px-1 edit-answer-sheet" data-body="<?php echo e($question[Questionnaire::body]); ?>" parent-id="<?php echo e($value[Questionnaire::question_id]); ?>" data-locale="<?php echo e($question[Questionnaire::locale]); ?>">
                                                <i class="fas fa-clipboard-list"></i>
                                            </a>
                                            <?php if(!$loop->first): ?>
                                                <a href="#" class="px-1 delete-question" parent-id="<?php echo e($value[Questionnaire::question_id]); ?>" data-locale="<?php echo e($question[Questionnaire::locale]); ?>">
                                                    <i class="fas text-danger fa-trash"></i>
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('modal'); ?>
    <div class="modal fade" id="new-question" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="question-title">Add Question</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <div class="card bg-secondary shadow border-0">
                        <div class="card-body px-lg-5 py-lg-5">
                            <form action="<?php echo e(route('chatbot.questionnaire.add')); ?>" method="post">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="question_id" id="parent_question_id">
                                <div id="question-field"></div>
                                <div class="float-right my-3">
                                    <button type="submit" class="btn btn-success float-right mr-0">
                                        Save
                                    </button>
                                    <button type="button" class="btn btn-primary float-right mr-2" id="add-question">
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
    <div class="modal fade" id="edit-question" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="question-title">Update Question</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <div class="card bg-secondary shadow border-0">
                        <div class="card-body px-lg-5 py-lg-5">
                            <form action="<?php echo e(route('chatbot.questionnaire.update')); ?>" method="post">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="question_id" id="self_question_id">
                                <input type="hidden" name="locale" id="self_locale">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" name="question" id="self_question" placeholder="Enter Question">
                                    </div>
                                </div>
                                <div class="float-right my-3">
                                    <button type="submit" class="btn btn-success float-right mr-0">
                                        Update
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="answer-sheet" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="questionnaire-title">Add Answers</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <div class="card bg-secondary shadow border-0">
                        <div class="card-body px-lg-5 py-lg-5">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <h6 class="modal-title" id="question"></h6>
                                </div>
                            </div>
                            <form action="<?php echo e(route('chatbot.questionnaire.update-answers')); ?>" method="post" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="question_id" id="question_id">
                                <input type="hidden" id="field-type" value="answer">
                                <input type="hidden" name="locale" id="locale">
                                <div id="answer-field"></div>
                                <div class="float-right my-3">
                                    <button type="submit" class="btn btn-success float-right mr-0">
                                        Save
                                    </button>
                                    <button type="button" class="btn btn-primary float-right mr-2" id="add-answer">
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
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(App::isProduction() ? secure_asset('assets/js/custom/chatbot.js') : asset('assets/js/custom/chatbot.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/chatbot/admin/questionnaire.blade.php ENDPATH**/ ?>