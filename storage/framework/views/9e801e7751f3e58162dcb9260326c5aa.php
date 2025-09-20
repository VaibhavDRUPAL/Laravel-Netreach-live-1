<?php $__env->startSection('content'); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dashboard-view')): ?>
        <div class="row dashboard-ab">

            <div class="col-xl-4 col-md-4 col-sm-6 col-xs-12" onclick="return dashboard(1);">
                <div class="card-stats ab-blue">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="indicate"><?php echo e($book->count()); ?></div>
                                <h5 class="card-title mb-0">Total No. of Clients Booked Appointment</h5>
                            </div>
                            <div class="col-auto">
                                <div class="ab-icon-info ab-light-blue">
                                    <img src="<?php echo e(asset('assets/img/icons/dashboard-icon/appointment-icon.png')); ?>">
                                </div>
                            </div>
                        </div><!-- row -->
                    </div><!-- card-body -->
                </div><!-- card-stats -->
            </div><!-- col-xl-4 -->

            <div class="col-xl-4 col-md-4 col-sm-6 col-xs-12" onclick="return dashboard_sra(2);">
                <div class="card-stats ab-sky">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="indicate"><?php echo e($newlyAddedCountVar->count()); ?></div>
                                <h5 class="card-title mb-0">Newly Added</h5>
                            </div>
                            <div class="col-auto">
                                <div class="ab-icon-info ab-light-sky">
                                    <img src="<?php echo e(asset('assets/img/icons/dashboard-icon/add-icon.png')); ?>">
                                </div>
                            </div>
                        </div><!-- row -->
                    </div><!-- card-body -->
                </div><!-- card-stats -->
            </div><!-- col-xl-4 -->

            <div class="col-xl-4 col-md-4 col-sm-6 col-xs-12" onclick="return dashboard(3);">
                <div class="card-stats ab-green">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="indicate"><?php echo e($client_take_test->count()); ?></div>
                                <h5 class="card-title mb-0">Total No. of Clients Taken Test</h5>
                            </div>
                            <div class="col-auto">
                                <div class="ab-icon-info ab-light-green">
                                    <img src="<?php echo e(asset('assets/img/icons/dashboard-icon/total-icon.png')); ?>">
                                </div>
                            </div>
                        </div><!-- row -->
                    </div><!-- card-body -->
                </div><!-- card-stats -->
            </div><!-- col-xl-4 -->

            <div class="col-xl-4 col-md-4 col-sm-6 col-xs-12" onclick="return dashboard(4);">
                <div class="card-stats ab-white">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="indicate ab-dark-blue-font"><?php echo e($report_results->count()); ?></div>
                                <h5 class="card-title mb-0">Total No. of Clients Identified +VE</h5>
                            </div>
                            <div class="col-auto">
                                <div class="ab-icon-info ab-dark-blue">
                                    <img src="<?php echo e(asset('assets/img/icons/dashboard-icon/identified-icon.png')); ?>">
                                </div>
                            </div>
                        </div><!-- row -->
                    </div><!-- card-body -->
                </div><!-- card-stats -->
            </div><!-- col-xl-4 -->

            <div class="col-xl-4 col-md-4 col-sm-6 col-xs-12" onclick="return dashboard(5);">
                <div class="card-stats ab-white">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="indicate ab-blue-font"><?php echo e($today_book->count()); ?></div>
                                <h5 class="card-title mb-0">Today's Appointments</h5>
                            </div>
                            <div class="col-auto">
                                <div class="ab-icon-info ab-blue">
                                    <img src="<?php echo e(asset('assets/img/icons/dashboard-icon/appointment-icon.png')); ?>">
                                </div>
                            </div>
                        </div><!-- row -->
                    </div><!-- card-body -->
                </div><!-- card-stats -->
            </div><!-- col-xl-4 -->

            

            

            <div class="col-xl-4 col-md-4 col-sm-6 col-xs-12" onclick="return dashboard_outreach(8);">
                <div class="card-stats ab-white">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="indicate ab-blue-font"><?php echo e($man_cre_app->count()); ?></div>
                                <h5 class="card-title mb-0">Manually Create Appoinments</h5>
                            </div>
                            <div class="col-auto">
                                <div class="ab-icon-info ab-blue">
                                    <img src="<?php echo e(asset('assets/img/icons/dashboard-icon/calander-icon.png')); ?>">
                                </div>
                            </div>
                        </div><!-- row -->
                    </div><!-- card-body -->
                </div><!-- card-stats -->
            </div><!-- col-xl-4 -->


            <div class="col-xl-4 col-md-4 col-sm-6 col-xs-12" onclick="return dashboard(9);">
                <div class="card-stats ab-white">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="indicate ab-dark-blue-font"><?php echo e($total_no_of_clients_not_taken_test->count()); ?>

                                </div>
                                <h5 class="card-title mb-0">Total No. of Clients not Taken Test</h5>
                            </div>
                            <div class="col-auto">
                                <div class="ab-icon-info ab-dark-blue">
                                    <img src="<?php echo e(asset('assets/img/icons/dashboard-icon/total-icon.png')); ?>">
                                </div>
                            </div>
                        </div><!-- row -->
                    </div><!-- card-body -->
                </div><!-- card-stats -->
            </div><!-- col-xl-4 -->

            <div class="col-xl-4 col-md-4 col-sm-6 col-xs-12">
                <div class="card-stats ab-white">
                    <div class="card-body">
                        <a href="/analytics/<?php echo e($totalPageViews); ?>">
                            <div class="row">
                                <div class="col">
                                    <div class="indicate ab-dark-blue-font"><?php echo e(number_format($totalPageViews)); ?>

                                    </div>
                                    <h5 class="card-title mb-0">Total Page Views</h5>
                                </div>
                                <div class="col-auto">
                                    <div class="ab-icon-info ab-dark-blue">
                                        <img height="50" src="<?php echo e(asset('assets/img/icons/dashboard-icon/eye.png')); ?>">
                                    </div>
                                </div>
                            </div><!-- row -->
                        </a>
                    </div><!-- card-body -->
                </div><!-- card-stats -->
            </div>

            <div class="col-md-12">
                <div class="card mt-12 mb-12">
                    <div class="card-header">Last seven days client register</div>
                    <div class="card-body">
                        <div class="chart-container pie-chart">
                            <canvas id="bar_chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- row -->


    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('modal'); ?>
    <div class="modal fade" id="tbl_show" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="title_heading"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" id="tbl_dashboard_report">

                    <div class="table-responsive">
                        
                        
                        <a id="btn-export" href="<?php echo e(route('dashboard.report', ['export' => true])); ?>"
                            data-target="<?php echo e(route('dashboard.report', ['export' => true])); ?>"
                            class="btn btn-primary float-right w-2 m-2" role="button"
                            id="btn-export-risk-assessment">Export</a>
                        

                        <div>

                            <table class="table align-items-center" id="tblCustomers">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Sr No</th>
                                        <th scope="col">Assessment No</th>
                                        <th scope="col">RA Date</th>
                                        <th scope="col">Risk Score</th>
                                        <th scope="col">Appointment Date</th>
                                        <th scope="col">Date of Accessing Service</th>
                                        <th scope="col">Not Accessed the Service Referred</th>
                                        <th scope="col">PID Provided at the Service Center</th>
                                        <th scope="col">VN Name</th>
                                        <th scope="col">Full Name</th>
                                        <th scope="col">Mobile No</th>
                                        <th scope="col">Services</th>
                                        <th scope="col">State</th>
                                        <th scope="col">District</th>
                                        <th scope="col">Center</th>
                                        <th scope="col">Referral No</th>
                                        <th scope="col">Unique ID</th>
                                        <th scope="col">Type of Test</th>
                                        <th scope="col">Treated State ID</th>
                                        <th scope="col">Treated District ID</th>
                                        <th scope="col">Treated Center ID</th>
                                        <th scope="col">Outcome of the Service Sought</th>
                                        <th scope="col">Remark</th>
                                        <th scope="col">Pre ART No</th>
                                        <th scope="col">On ART No</th>
                                        <th scope="col">Updated By</th>
                                        <th scope="col">Updated At</th>
                                    </tr>


                                </thead>
                                <tbody class="list" id="tbl_dashboard_report_html">

                                </tbody>
                            </table>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>




    <div class="modal fade" id="tbl_show_sra" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="title_heading_sra"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" id="tbl_dashboard_report_sra">

                    <div class="table-responsive">

                        <div>

                            <table class="table align-items-center" id="tblCustomers_sra">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Risk Assessment ID</th>
                                        <th scope="col">Mobile No</th>
                                        <th scope="col">VN ID</th>
                                        <th scope="col">Risk Score</th>
                                        <th scope="col">Unique ID</th>
                                    </tr>


                                </thead>
                                <tbody class="list" id="tbl_dashboard_report_html">

                                </tbody>
                            </table>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>










    <div class="modal fade" id="tbl_show_outreach" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="title_heading_outreach"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" id="tbl_dashboard_report_outreach">

                    <div class="table-responsive">

                        <div>
                            <table class="table align-items-center" id="tblCustomers_outreach">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Profile ID</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Comment</th>
                                        <th scope="col">UID</th>
                                        <th scope="col">User ID</th>
                                        <th scope="col">Unique Serial Number</th>
                                        <th scope="col">Registration Date</th>
                                        <th scope="col">State ID</th>
                                        <th scope="col">District ID</th>
                                        <th scope="col">Platform ID</th>
                                        <th scope="col">Other Platform</th>
                                        <th scope="col">Profile Name</th>
                                        <th scope="col">Phone Number</th>
                                        <th scope="col">Remarks</th>
                                        <th scope="col">Age</th>
                                    </tr>



                                </thead>
                                <tbody class="list" id="tbl_dashboard_report_html">

                                </tbody>
                            </table>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <link rel="stylesheet" media="all" href="<?php echo e(asset('assets/css/jquery.dataTables.css')); ?>">
    <script type="text/javascript" charset="utf8" src="<?php echo e(asset('assets/js/jquery.dataTables.min.js')); ?>"></script>
    <script
        src="<?php echo e(App::isProduction() ? secure_asset('assets/js/custom/self-risk-assessment.js') : asset('assets/js/custom/self-risk-assessment.js')); ?>">
    </script>
    <script
        src="<?php echo e(App::isProduction() ? secure_asset('assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js') : asset('assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js')); ?>">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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

    <style>
        .exp-btn {
            width: 100%;
            text-align: right;
            padding: 0 0 8px 0px;
            display: none;
        }
    </style>
    <script>
        makechart();

        function makechart() {


            /*var data = [{"language":"Node.js","total":"4","color":"#234472"},{"language":"PHP","total":"6","color":"#904084"},{"language":"Python","total":"2","color":"#433620"},{"language":"Dot Net","total":"2","color":"#433620"}];
            		var language = [];
            		var total = [];
            		var color = [];

            		for(var count = 0; count < data.length; count++)
            		{
            			language.push(data[count].language);
            			total.push(data[count].total);
            			color.push(data[count].color);
            		}

            		var chart_data = {
            			labels:language,
            			datasets:[
            				{
            					label:'Vote',
            					backgroundColor:color,
            					color:'#fff',
            					data:total
            				}
            			]
            		};

            		var options = {
            			responsive:true,
            			scales:{
            				yAxes:[{
            					ticks:{
            						min:0
            					}
            				}]
            			}
            		};*/

            /*var group_chart1 = $('#pie_chart');

            var graph1 = new Chart(group_chart1, {
            	type:"pie",
            	data:chart_data
            });

            var group_chart2 = $('#doughnut_chart');

            var graph2 = new Chart(group_chart2, {
            	type:"doughnut",
            	data:chart_data
            });*/

            /*var group_chart3 = $('#bar_chart');

            var graph3 = new Chart(group_chart3, {
            	type:'bar',
            	data:chart_data,
            	options:options
            });*/

            var DataJson = {
                "_token": "<?php echo e(csrf_token()); ?>",
                "book": "booking"
            }
            $.ajax({
                url: "<?php echo e(route('dashboard.report.chart')); ?>",
                method: "POST",
                data: DataJson,
                dataType: "JSON",
                success: function(data) {
                    var language = [];
                    var total = [];
                    var color = [];

                    for (var count = 0; count < data.length; count++) {
                        language.push(data[count].language);
                        total.push(data[count].total);
                        color.push(data[count].color);
                    }

                    var chart_data = {
                        labels: language,
                        datasets: [{
                            label: 'Report',
                            backgroundColor: color,
                            color: '#fff',
                            data: total
                        }]
                    };

                    var options = {
                        responsive: true,
                        scales: {
                            yAxes: [{
                                ticks: {
                                    min: 0
                                }
                            }]
                        },
                        legend: {
                            display: false
                        },
                        tooltips: {
                            enabled: true
                        }
                    };

                    var group_chart3 = $('#bar_chart');

                    var graph3 = new Chart(group_chart3, {
                        type: 'bar',
                        data: chart_data,
                        options: options
                    });
                }
            });
        }
    </script>

    <script src="https://www.aspsnippets.com/demos/scripts/table2excel.js" type="text/javascript"></script>
    <script type="text/javascript">
        function Export() {
            var filename = $("#title_heading").text();
            $("#tblCustomers").table2excel({
                filename: filename + ".xls"
            });
        }








        function dashboard(report_pos) {
            $("#btn-export").attr(
                "href",
                $("#btn-export").attr("data-target") + "&report_pos=" + report_pos
            );
            $("#tblCustomers").dataTable({
                autoWidth: true,
                processing: true,
                serverSide: true,
                bDestroy: true,
                searching: false,
                bPaginate: true,

                scrollX: true,
                buttons: ["excel"],
                ajax: {
                    url: "<?php echo e(route('dashboard.report')); ?>",
                    type: "GET",
                    data: {
                        report_pos,
                    },
                },
                columns: [{
                        data: "sr_no"
                    },
                    {
                        data: "assessment_no"
                    },
                    {
                        data: "ra_date"
                    },
                    {
                        data: "risk_score"
                    },
                    {
                        data: "appointment_date"
                    },
                    {
                        data: "date_of_accessing_service"
                    },
                    {
                        data: "not_access_the_service_referred"
                    },
                    {
                        data: "pid_provided_at_the_service_center"
                    },
                    {
                        data: "vn_name"
                    },
                    {
                        data: "full_name"
                    },
                    {
                        data: "mobile_no"
                    },
                    {
                        data: "services"
                    },
                    {
                        data: "state"
                    },
                    {
                        data: "district"
                    },
                    {
                        data: "center"
                    },
                    {
                        data: "referral_no"
                    },
                    {
                        data: "uid"
                    },
                    {
                        data: "type_of_test"
                    },
                    {
                        data: "treated_state_id"
                    },
                    {
                        data: "treated_district_id"
                    },
                    {
                        data: "treated_center_id"
                    },
                    {
                        data: "outcome_of_the_service_sought"
                    },
                    {
                        data: "remark"
                    },
                    {
                        data: "pre_art_no"
                    },
                    {
                        data: "on_art_no"
                    },
                    {
                        data: "updated_by"
                    },
                    {
                        data: "updated_at"
                    },
                ],
                initComplete: function(settings, json) {
                    $("#tblCustomers").DataTable().columns.adjust().draw();
                    $('#tbl_show').modal(); // Show modal when DataTable is fully loaded
                }
            });
        }


        function dashboard_sra(report_pos) {
            $("#tblCustomers_sra").dataTable({
                autoWidth: true,
                processing: true,
                serverSide: true,
                bDestroy: true,
                searching: false,
                bPaginate: true,

                scrollX: true,
                buttons: ["excel"],
                ajax: {
                    url: "<?php echo e(route('dashboard.report')); ?>",
                    type: "GET",
                    data: {
                        report_pos,
                    },
                },
                columns: [{
                        data: "risk_assessment_id"
                    },
                    {
                        data: "mobile_no"
                    },
                    {
                        data: "vn_id"
                    },
                    {
                        data: "risk_score"
                    },
                    {
                        data: "unique_id"
                    },

                ],
                initComplete: function(settings, json) {
                    $("#tblCustomers_sra").DataTable().columns.adjust().draw();
                    $('#tbl_show_sra').modal(); // Show modal when DataTable is fully loaded
                }
            });
        }


        function dashboard_outreach(report_pos) {
            $("#tblCustomers_outreach").dataTable({
                autoWidth: true,
                processing: true,
                serverSide: true,
                bDestroy: true,
                searching: false,
                bPaginate: true,

                scrollX: true,
                buttons: ["excel"],
                ajax: {
                    url: "<?php echo e(route('dashboard.report')); ?>",
                    type: "GET",
                    data: {
                        report_pos,
                    },
                },
                columns: [{
                        data: "profile_id"
                    },
                    {
                        data: "status_text"
                    },
                    {
                        data: "comment"
                    },
                    {
                        data: "uid"
                    },
                    {
                        data: "user_name"
                    },
                    {
                        data: "unique_serial_number"
                    },
                    {
                        data: "registration_date"
                    },
                    {
                        data: "state_name"
                    },
                    {
                        data: "district_name"
                    },
                    {
                        data: "platform_name"
                    },
                    {
                        data: "other_platform"
                    },
                    {
                        data: "profile_name"
                    },
                    {
                        data: "phone_number"
                    },
                    {
                        data: "remarks"
                    },
                    {
                        data: "age"
                    },


                ],
                initComplete: function(settings, json) {
                    $("#tblCustomers_outreach").DataTable().columns.adjust().draw();
                    $('#tbl_show_outreach').modal(); // Show modal when DataTable is fully loaded
                }
            });
        }










        // function dashboard(report_pos) {
        //     $.ajax({
        //         url: "<?php echo e(route('dashboard.report')); ?>",
        //         type: "GET",
        //         data: {
        //             report_pos,
        //         },
        //         success: function(response) {
        //             $('#tbl_show').modal(); // Show modal on success

        //             $("#tblCustomers").dataTable({
        //                 processing: true,
        //                 serverSide: true,
        //                 bDestroy: true,
        //                 searching: false,
        //                 bPaginate: true,
        //                 columnDefs: [{
        //                     orderable: false,
        //                     targets: [0, 1, 2, 3, 4],
        //                     sorting: false,
        //                     createdCell: function(td, cellData, rowData, row, col) {
        //                         // Add style attribute to <td> elements
        //                         if (row % 2 != 0) {
        //                             $(td).attr("style",
        //                                 "background-color: white !important;");
        //                         } else {
        //                             $(td).attr("style",
        //                                 "background-color: #E2E4FF !important;");
        //                         }
        //                     },
        //                 }, ],
        //                 fixedColumns: {
        //                     left: 5,
        //                 },
        //                 scrollX: true,
        //                 buttons: ["excel"],
        //                 ajax: {
        //                     url: "<?php echo e(route('dashboard.report')); ?>",
        //                     type: "GET",
        //                     data: {
        //                         report_pos,
        //                     },
        //                 },
        //                 columns: [{
        //                         data: "appointment_id"
        //                     },
        //                     {
        //                         data: "assessment_id"
        //                     },
        //                     {
        //                         data: "vn_id"
        //                     },
        //                     {
        //                         data: "risk_score"
        //                     },
        //                     {
        //                         data: "full_name"
        //                     },
        //                     {
        //                         data: "mobile_no"
        //                     },
        //                     {
        //                         data: "services"
        //                     },
        //                     {
        //                         data: "state_id"
        //                     },
        //                     {
        //                         data: "district_id"
        //                     },
        //                     {
        //                         data: "center_id"
        //                     },
        //                     {
        //                         data: "referral_no"
        //                     },
        //                     {
        //                         data: "uid"
        //                     },
        //                     {
        //                         data: "appointment_date"
        //                     },
        //                     {
        //                         data: "date_of_accessing_service"
        //                     },
        //                     {
        //                         data: "pid_provided_at_the_service_center"
        //                     },
        //                     {
        //                         data: "outcome_of_the_service_sought"
        //                     },
        //                     {
        //                         data: "not_access_the_service_referred"
        //                     },
        //                     {
        //                         data: "remark"
        //                     },
        //                     {
        //                         data: "pre_art_no"
        //                     },
        //                     {
        //                         data: "on_art_no"
        //                     },
        //                     {
        //                         data: "updated_by"
        //                     },
        //                     {
        //                         data: "updated_at"
        //                     },
        //                     {
        //                         data: "media_path"
        //                     }
        //                 ],
        //             });
        //         }
        //     });

        // }


        // function dashboard(report_pos) {
        //     $("#tblCustomers").dataTable({
        //         processing: true,
        //         serverSide: true,
        //         bDestroy: true,
        //         searching: false,
        //         bPaginate: true,
        //         columnDefs: [{
        //             orderable: false,
        //             targets: [0, 1, 2, 3, 4],
        //             sorting: false,
        //             createdCell: function(td, cellData, rowData, row, col) {
        //                 // Add style attribute to <td> elements
        //                 if (row % 2 != 0) {
        //                     $(td).attr("style", "background-color: white !important;");
        //                 } else {
        //                     $(td).attr("style", "background-color: #E2E4FF !important;");
        //                 }
        //             },
        //         }, ],
        //         fixedColumns: {
        //             left: 5,
        //         },
        //         scrollX: true,
        //         buttons: ["excel"],
        //         ajax: {
        //             url: "<?php echo e(route('dashboard.report')); ?>",
        //             type: "GET",
        //             data: {
        //                 report_pos,
        //             },
        //         },
        //         columns: [{
        //                 data: "appointment_id",
        //             },
        //             {
        //                 data: "assessment_id",
        //             },
        //             {
        //                 data: "vn_id",
        //             },
        //             {
        //                 data: "risk_score",
        //             },
        //             {
        //                 data: "full_name",
        //             },
        //             {
        //                 data: "mobile_no",
        //             },
        //             {
        //                 data: "services",
        //             },
        //             {
        //                 data: "state_id",
        //             },
        //             {
        //                 data: "district_id",
        //             },
        //             {
        //                 data: "center_id",
        //             },
        //             {
        //                 data: "referral_no",
        //             },
        //             {
        //                 data: "uid",
        //             },
        //             // {
        //             //     data: "ra_date",
        //             // },
        //             {
        //                 data: "appointment_date",
        //             },
        //             {
        //                 data: "date_of_accessing_service",
        //             },
        //             {
        //                 data: "pid_provided_at_the_service_center",
        //             },
        //             {
        //                 data: "outcome_of_the_service_sought",
        //             },
        //             {
        //                 data: "not_access_the_service_referred",
        //             },
        //             {
        //                 data: "remark",
        //             },
        //             {
        //                 data: "pre_art_no",
        //             },
        //             {
        //                 data: "on_art_no",
        //             },
        //             {
        //                 data: "updated_by",
        //             },
        //             {
        //                 data: "updated_at",
        //             },
        //             {
        //                 data: "media_path",
        //             },
        //             // {
        //             //     data: "html",
        //             // },
        //         ],
        //     });
        // }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\netreach_live\resources\views/home.blade.php ENDPATH**/ ?>