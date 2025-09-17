<?php $__env->startSection('content'); ?>
    <div class="row">
        <a class="btn btn-primary float-right w-2 m-2 text-white" role="button"
            id="btn-export-risk-assessment-appointment">Export</a>
        <button class="btn btn-primary float-right w-2 m-2" role="button" id="btn-toggle-filter">Filter</button>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div id="filter-container" style="display: none;">
                <form action="<?php echo e(route('admin.self-risk-assessment.appointment')); ?>" method="post"
                    id="frm-sra-appointment">
                    <div class="form-row">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="export" value="1">
                        <div class="col-md-4 mb-3">
                            <label for="appointment_id">Appointment No</label>
                            <input type="text" class="form-control" id="appointment_id" name="appointment_id"
                                placeholder="Appointment No">
                        </div>
                        <!-- VN Name -->
                        <?php if(Auth::user()->user_type != 2): ?>
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
                                placeholder="Mobile No">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="fullName">Full Name</label>
                            <input type="text" class="form-control" id="full_name" name="fullname"
                                placeholder="Full Name">
                        </div>

                        <!-- Services -->
                        <div class="col-md-6 mb-3">
                            <label for="services">Services</label>
                            <select id="services" name="services" class="form-control">
                                <option value="">Choose...</option>
                                <?php $__currentLoopData = SERVICES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($key); ?>"><?php echo e($item); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <!-- State -->
                        <div class="col-md-4">
                            <label for="inputStateget">State</label>
                            <select id="input-state" name="state_id" class="form-control">
                                <option value="">Choose...</option>
                                <?php $__currentLoopData = $state_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($value->id); ?>"><?php echo e($value->state_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <!-- District -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="center">District</label>
                                <select class="form-control" name="district_id" id="input-district"></select>
                            </div>
                        </div>

                        <!-- Center -->
                        <div class="col-md-4">
                            <label for="center">Center</label>
                            <select id="input-testing-centers" name="center_id" class="form-control"></select>
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
                <button class="btn btn-primary" type="button" id="btn_appointment_search">Submit</button>
            </div>

            <div class="card mb-5">
                <div class="card-header bg-transparent">
                    <h3 class="mb-0">All Appointments</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <div>
                            <table class="table table-hover align-items-center" id="self-appointment-details">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" style="z-index: 2 !important;">Appointment No</th>
                                        <th scope="col" style="z-index: 2 !important;">Assessment No</th>
                                        <th scope="col" style="z-index: 2 !important;">VN Name</th>
                                        <th scope="col" style="z-index: 2 !important;">Risk Score</th>
                                        <th scope="col" style="z-index: 2 !important;">Full name</th>
                                        <th scope="col" style="z-index: 2 !important;">Mobile No</th>
                                        <th scope="col">Services</th>
                                        <th scope="col">State</th>
                                        <th scope="col">District</th>
                                        <th scope="col">Center</th>
                                        <th scope="col">Referral No</th>
                                        <th scope="col">UID</th>
                                        <th scope="col">RA Date</th>
                                        <th scope="col">Appointment Date</th>
                                        <th scope="col">Date of accessing service</th>
                                        <th scope="col">PID provided at the service center</th>
                                        <th scope="col">Outcome of the service sought</th>
                                        <th scope="col">Reason (Not access the service referred)</th>
                                        <th scope="col">Remark</th>
                                        <th scope="col">Pre ART No</th>
                                        <th scope="col">On ART No</th>
                                        <th scope="col">Updated By</th>
                                        <th scope="col">Updated At</th>
                                        <th scope="col">e-Referral Slip</th>
                                        <th scope="col">Action</th>
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
            $('#vn_id').select2();

            $('#btn-toggle-filter').on('click', function() {
                $('#filter-container').toggle();
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.bootstrap.min..css">
    <style>
        th,
        td {
            white-space: nowrap;
        }

        div.dataTables_wrapper {
            width: 100%;
            margin: 0 auto;
        }

        select2-container--default .select2-selection--multiple .select2-selection__clear {
            cursor: pointer;
            font-weight: bold;
            /* background: red; */
            height: 20px;
            margin-right: 10px;
            /* margin-top: 5px; */
            position: absolute;
            right: 0;
            padding: 1px;
        }

        .filter-container {
            padding: 20px;
            background: #f8f9fa;
            border: 1px solid #ddd;
            margin-bottom: 20px;
        }

        .show-select2 .select2-dropdown {
            display: block !important;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/self/admin/appointments.blade.php ENDPATH**/ ?>