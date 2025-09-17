<?php $__env->startSection('content'); ?>
    <div class="row">
        <a class="btn btn-primary float-right w-2 m-2 text-white" role="button" id="btn-export-risk-assessment">Export</a>
        <button class="btn btn-primary w-2 m-2" id="filter-toggle-btn">Filter</button>
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-header bg-transparent">
                    <h3 class="mb-0"> All Self-Risk Assessments</h3>
                    <div class="row mb-1">
                        <div class="col-md-12">
                            <?php if(empty(!$selflink)): ?>
                                <span class="float-right">
                                    Your link: <?php echo e($selflink); ?>

                                </span>
                            <?php endif; ?>
                            <br>
                            <?php if(empty(!$oldSelflink)): ?>
                                <span class="float-right">
                                    Your Old link: <?php echo e($oldSelflink); ?>

                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div id="filter-form-container" style="display: none;">
                        <form action="<?php echo e(route('admin.self-risk-assessment.index')); ?>" method="post" id="frm-sra">
                            <div class="form-row">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="export" value="1">
                                <div class="col-md-4 mb-3">
                                    <label for="risk_assessment_id">Assessment No</label>
                                    <input type="text" class="form-control" id="risk_assessment_id"
                                        name="risk_assessment_id" placeholder="Assessments No" value="">
                                </div>
                                <?php if(Auth::user()->user_type != 2): ?>
                                    <!-- VN Name -->
                                    <div class="col-md-4 mb-3">
                                        <label for="vn_id">VN Name</label>
                                        <select id="vn_id" name="vn_id[]" class="form-control js-example-basic-multiple"
                                            multiple>
                                            <option value="">Choose...</option>
                                            <?php $__currentLoopData = $vn_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vn): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($vn->id); ?>"><?php echo e($vn->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                <?php endif; ?>
                                <!-- Risk Score -->
                                <div class="col-md-4 mb-3">
                                    <label for="risk_score">Risk Score</label>
                                    <select id="risk_score" name="risk_score" class="form-control">
                                        <option value="">Choose...</option>
                                        <?php for($i = 1; $i <= 100; $i += 10): ?>
                                            <option value="<?php echo e($i); ?>-<?php echo e($i + 9); ?>">
                                                <?php echo e($i); ?>-<?php echo e($i + 9); ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>

                                <!-- Mobile No -->
                                <div class="col-md-4 mb-3">
                                    <label for="mobile_no">Mobile No</label>
                                    <input type="text" class="form-control" id="mobile_no" name="mobile_no"
                                        placeholder="Mobile No" value="">
                                </div>

                                <!-- Services -->
                                <div class="col-md-4 mb-3">
                                    <label for="services">Services</label>
                                    <select id="services" name="services" class="form-control">
                                        <option value="">Choose...</option>
                                        <?php $__currentLoopData = SERVICES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($key); ?>"><?php echo e($item); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <!-- State -->
                                <div class="col-md-4 mb-3">
                                    <label for="inputStateget">State</label>
                                    <select id="input-state" name="state_id" class="form-control">
                                        <option value="">Choose...</option>
                                        <?php $__currentLoopData = $state_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($value->id); ?>"><?php echo e($value->state_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <!-- From Date -->
                                <div class="col-md-6 mb-3">
                                    <label for="from_date">From Date</label>
                                    <input type="date" id="from" name="from" class="form-control">
                                </div>
                                <!-- To Date -->
                                <div class="col-md-6 mb-3">
                                    <label for="to_date">To Date</label>
                                    <input type="date" id="to" name="to" class="form-control">
                                </div>
                            </div>
                        </form>
                        <input type="hidden" class="form-control" id="search" name="search" value="search">
                        <button class="btn btn-primary" type="button" id="btn_search">Submit</button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <div>
                            <table class="table table-hover align-items-center" id="self-risk-assessment-details">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" style="z-index: 2 !important;">Assessment No</th>
                                        <th scope="col" style="z-index: 2 !important;">Appointment No</th>
                                        <th scope="col" style="z-index: 2 !important;">Total Risk</th>
                                        <th scope="col">Meet Counsellor ID</th>
                                        <th scope="col" style="z-index: 2 !important;">VN Name</th>
                                        <th scope="col" style="z-index: 2 !important;">Has Appointment</th>
                                        <?php $__currentLoopData = $header; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $temp = $key;
                                            ?>
                                            <th scope="col" data-toggle="tooltip" data-placement="bottom"
                                                title="<?php echo e($header2[$key]); ?>"
                                                <?php if($loop->index == 0): ?> style="z-index: 2 !important;" <?php endif; ?>>
                                                <?php echo e(++$temp); ?></th>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <th scope="col">RA Date</th>
                                        <th scope="col">IP</th>
                                        <th scope="col">User Country</th>
                                        <th scope="col">User State</th>
                                        <th scope="col">User City</th>
                                        <th scope="col">Delete</th>
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
    <script
        src="<?php echo e(App::isProduction() ? secure_asset('assets/js/custom/self-risk-assessment.js') : asset('assets/js/custom/self-risk-assessment.js')); ?>">
    </script>
    <script
        src="<?php echo e(App::isProduction() ? secure_asset('assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js') : asset('assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js')); ?>">
    </script>
    <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
    <!-- Include Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Include Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#filter-toggle-btn').click(function() {
                $('#filter-form-container').toggle();
            });

            $('#vn_id').select2();
        });

        function confirmDeleteSubmit() {
            var userConfirmed = confirm("Are you sure you want to delete this record?");

            return userConfirmed ? true : false;
        }
    </script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.bootstrap.min.css">
    <style>
        th,
        td {
            white-space: nowrap;
        }

        div.dataTables_wrapper {
            width: 100%;
            margin: 0 auto;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/self/admin/index.blade.php ENDPATH**/ ?>