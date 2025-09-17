<?php $__env->startPush('styles'); ?>
    <style>
        .custom-control-inline {
            margin-right: 0rem !important;
        }

        form#another-element {
            padding: 15px;
            border: 1px solid #666;
            background: #fff;
            display: none;
            margin-top: 20px;
        }

        .required-field::before {
            content: "*";
            color: red;
            float: right;
        }


        .assessment_date {
            display: none;
        }

        .referral_date {
            display: none;
        }

        .acess_date {
            display: none;
        }
    </style>

    <?php $__env->startSection('content'); ?>
        <div class="row">
            <div class="col-md-12 my-2">
                <?php if(in_array(auth()->user()->getRoleNames()->first(), [SUPER_ADMIN, PO_PERMISSION])): ?>
                    <button class="btn btn-success float-right" id="accept" value="2">
                        <i class="fa fa-check"></i>
                        Accept
                    </button>
                    <button class="btn btn-danger float-right mx-2" id="reject" value="3">
                        <i class="fa fa-times"></i>
                        Reject
                    </button>
                <?php elseif(auth()->user()->getRoleNames()->first() == VN_USER_PERMISSION): ?>
                    <button class="btn btn-primary float-right" id="assign-now">
                        <i class="fa fa-plus"></i>
                        Submit to PO
                    </button>
                <?php endif; ?>
            </div>
            <div class="col-md-12">
                <div class="card mb-5">
                    <div class="card-header bg-transparent">
                        <div class="row">
                            <div class="col-lg-4">
                                <h3 class="mb-0">All Counsellings</h3>
                                <button class="btn btn-sm btn-info mb-0" type="button"  data-toggle="modal" data-target="#exampleModal">Upload Data</button>
                                <a href="<?php echo e(route('outreach.download')); ?>" class="btn btn-sm btn-info mb-0" role="button">Download Sample Sheet</a>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group mb-0">
                                    <?php echo e(Form::text('search', request()->query('search'), ['class' => 'form-control form-control-sm', 'placeholder' => 'Search by unique serial number', 'id'=>'search'])); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <div>

                                <table class="table table-hover align-items-center" id="survy_data_tbl_id">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">
                                                <input type="checkbox" name="select-all" id="select-all">
                                                Select
                                            </th>
                                            <th scope="col">Unique serial number</th>
                                            <th scope="col">Employee Name</th>
                                            <th scope="col">NETREACH UID Number</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Client type</th>
                                            <th scope="col">Referred from</th>
                                            <th scope="col">If Others (Specify)Referral Source</th>
                                            <th scope="col">Name of the client* </th>
                                            <th scope="col">Date of Counselling* </th>
                                            <th scope="col">Phone number</th>
                                            <th scope="col">Type of Counselling Offered*</th>
                                            <th scope="col">If Others, Please Specify</th>
                                            <th scope="col">Counselling Medium*</th>
                                            <th scope="col">Duration of Counselling*(In minutes)</th>
                                            <th scope="col">Key Concerns Discussed* </th>
                                            <th scope="col">Follow up date </th>                                    
                                            <th scope="col">Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>

                                </table>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php $__env->stopSection(); ?>

    <?php $__env->startPush('modal'); ?>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="<?php echo e(url('/ImportCounselling')); ?>" enctype="multipart/form-data"> <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Excel file upload</label>
                        <input type="file" name="efile" class="form-control" required="true">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Import Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopPush(); ?>

    <?php $__env->startPush('scripts'); ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/jquery-ui.css')); ?>">
        <script src="<?php echo e(asset('assets/js/jquery-ui.js')); ?>"></script>
        <script src="<?php echo e(asset('assets/vendor/custom_alert/bootbox.all.min.js')); ?>"></script>
        <link rel="stylesheet" media="all" href="<?php echo e(asset('assets/css/jquery.dataTables.css')); ?>">
        <script type="text/javascript" charset="utf8" src="<?php echo e(asset('assets/js/jquery.dataTables.min.js')); ?>"></script>

        <script>
           
           
            function refreshTable(search=''){

                $(document).ready(function() {

                    var dataTableObj = $('#survy_data_tbl_id').dataTable({
                        "processing": true,
                        "serverSide": true,
                        "bDestroy": true,
                        "searching": false,
                        "bPaginate": true,
                        "sDom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
                        "columnDefs": [
                            { "orderable": false, "targets": 0 }
                        ],
                        "ajax": {
                            "url": "<?php echo e(route('outreach.counselling.list')); ?>",
                            "type": "POST",
                            "data":  {
                                _token: "<?php echo csrf_token(); ?>",
                                unique_serial_number: "<?php echo e($unique_serial_number); ?>",
                                profile_id: "<?php echo e($profileID); ?>",
                                search,
                            }
                        }

                    });
                    $('#select-all').prop('checked', false);
                    $("#btn_serch").click(function() {
                        dataTableObj.fnDraw();
                    });
                });
            };
            $(document).on('click', '#assign-now', function() {
                var data = [];
                $('#survy_data_tbl_id').find('td.sorting_1 input[type=checkbox]').each(function (key, val){
                    if($(val).is(':checked')) data.push($(val).val());
                });
                $.ajax({
                    url : '/outreach/counselling/assign',
                    method : 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data : {
                        data: data
                    },
                    success : function () {
                        refreshTable();
                    }
                })
            })
            $(document).on('click', '#accept, #reject', function() {
                var data = [];
                var status = $(this).val();
                $('#survy_data_tbl_id').find('td.sorting_1 input[type=checkbox]').each(function (key, val){
                    if($(val).is(':checked')) data.push($(val).val());
                });
                $.ajax({
                    url : '/outreach/counselling/take-action',
                    method : 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data : {
                        data: data,
                        status : status
                    },
                    success : function () {
                        refreshTable();
                    }
                })
            })

            $(document).on('click', '#select-all', function () {
                var status = $(this).is(':checked') ? true : false;

                $('#survy_data_tbl_id').find('td.sorting_1 input[type=checkbox]').each(function (key, val){
                    $(val).prop('checked', status);
                });
            })
            $(document).ready(function() {
                refreshTable();
            });

            const debouncedRefresh = debounce(refreshTable, 500);
            $('#search').on('input',(e)=>{
                const val = e.target.value;
                debouncedRefresh(val);
            });
        </script>
    <?php $__env->stopPush(); ?>

    <?php $__env->startPush('modal'); ?>

    <?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/outreach/counselling/index.blade.php ENDPATH**/ ?>