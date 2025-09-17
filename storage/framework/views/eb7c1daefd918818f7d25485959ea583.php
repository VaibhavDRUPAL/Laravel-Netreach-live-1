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
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-header bg-transparent">
                    <div class="row">
                        <div class="headingdiv">
                            <h3 class="mb-0">All Survey</h3>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <div>


                                <input type="button" id="myelement" class="btn btn-warning" value="Advanced"></input>
                                <a class="btn btn-warning" href="<?php echo e(route('survey.export')); ?>">Export User Data</a>

                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('po-mult-action')): ?>
                                    <button type="button" class="btn btn-info" id=""
                                        onclick="return multipoaction();">Multi PO Action</button>
                                <?php endif; ?>
                                <!--<form id="another-element">-->
                                <?php echo e(Form::open(['url' => '/survey/filter', 'id' => 'another-element'])); ?>

                                <div class="form-row">

                                    <div class="col-md-3 mb-3">
                                        <label for="inputState">Date Type</label>
                                        <select id="date_type" class="form-control"
                                            onchange="return DateTypeExportUserData(this.value);">
                                            <option value="">Choose...</option>
                                            <option value="assessment_date">Assessment Date</option>
                                            <option value="referral_date">Referral Date</option>
                                            <option value="acess_date">Access Date</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3 mb-3 assessment_date">
                                        <label for="validationCustom01">Assessment Date From</label>
                                        <input type="date" class="form-control" id="assessment_date_from" value="">
                                    </div>

                                    <div class="col-md-3 mb-3 assessment_date">
                                        <label for="validationCustom01">Assessment Date To</label>
                                        <input type="date" class="form-control" id="assessment_date_to" value="">
                                    </div>




                                    <div class="col-md-3 mb-3 referral_date">
                                        <label for="validationCustom02">Referral Date From</label>
                                        <input type="Date" class="form-control" id="referral_date_from"
                                            placeholder="Referral Date">
                                    </div>

                                    <div class="col-md-3 mb-3 referral_date">
                                        <label for="validationCustom02">Referral Date To</label>
                                        <input type="Date" class="form-control" id="referral_date_to"
                                            placeholder="Referral Date To">
                                    </div>


                                    <div class="col-md-3 mb-3 acess_date">
                                        <label for="validationCustom02">Acess Date From</label>
                                        <input type="Date" class="form-control" id="acess_date_from"
                                            placeholder="Acess Date">
                                    </div>

                                    <div class="col-md-3 mb-3 acess_date">
                                        <label for="validationCustom02">Acess Date To</label>
                                        <input type="Date" class="form-control" id="acess_date_to"
                                            placeholder="Acess Date">
                                    </div>


                                    <?php if(
                                        !Auth::user()->hasRole('VN User Permission') &&
                                            !Auth::user()->hasRole('Counsellor-Permission') &&
                                            !Auth::user()->hasRole('PO-Permission')): ?>
                                        <div class="col-md-3 mb-3">
                                            <label for="inputState">Region</label>
                                            <select id="inputState" class="form-control"
                                                onchange="return getRegion(this.value);">
                                                <option value="">Choose...</option>
                                                <option value='1'>North</option>
                                                <option value="2">South</option>
                                                <option value="3">East</option>
                                                <option value="4">West</option>
                                            </select>
                                        </div>
                                    <?php endif; ?>
                                    <div class="col-md-3 mb-3">
                                        <label for="inputStateget">State</label>
                                        <select id="inputStateget" name="state_id" class="form-control">
                                            <option value="">Choose...</option>
                                            <?php $__currentLoopData = $state_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($value->id); ?>"><?php echo e($value->state_name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>;
                                        </select>
                                    </div>
                                    <?php if(
                                        !Auth::user()->hasRole('VN User Permission') &&
                                            !Auth::user()->hasRole('Counsellor-Permission') &&
                                            !Auth::user()->hasRole('PO-Permission')): ?>
                                        <div class="col-md-3 mb-3">
                                            <label for="inputDistrict">District</label>
                                            <select id="inputDistrict" class="form-control"
                                                onchange="return getDistrict(this.value);">
                                                <option value="">Choose...</option>
                                            </select>
                                        </div>
                                    <?php endif; ?>
                                    <?php if(
                                        !Auth::user()->hasRole('VN User Permission') &&
                                            !Auth::user()->hasRole('Counsellor-Permission') &&
                                            !Auth::user()->hasRole('PO-Permission')): ?>
                                        <div class="col-md-3 mb-3">
                                            <label for="vninputState">VN</label>
                                            <select id="vninputState" name="vninputState" class="form-control">
                                                <option value="">Choose...</option>
                                            </select>
                                        </div>
                                    <?php endif; ?>
                                    <div class="col-md-3 mb-3">
                                        <label for="inputState">Services</label>
                                        <select id="services" name="services" class="form-control">
                                            <option value="">Choose...</option>
                                            <option value='1'>HIV Test</option>
                                            <option value="2">STI Services</option>
                                            <option value="3">Pre-Exposure Prophylaxis (PrEP)</option>
                                            <option value="5">Counselling</option>
                                            <option value="6">Referral to TI / CBO / NGO services</option>
                                            <option value="7">ART Linkages</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="inputState">Target Populations</label>
                                        <select id="target_pop" name="target_pop" class="form-control">
                                            <option value="">Choose...</option>
                                            <option value="MSM">MSM</option>
                                            <option value="TG">TG</option>
                                            <option value="MSW">MSW</option>
                                            <option value="FSW">FSW</option>
                                            <option value="PWID">PWID</option>
                                            <option value="Adolescents and Youths (18-24)">Adolescents and Youths (18-24)
                                            </option>
                                            <option value="Men and Women (above 24 yrs)">Men and Women (above 24 yrs)
                                            </option>
                                            <option value="Adolescents and Youths (18-24)">Adolescents and Youths (18-24)
                                            </option>
                                            <option value="Men and Women (above 24 yrs)">Men and Women (above 24 yrs)
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="inputState">Facility Type</label>
                                        <select id="facility_type" name="facility_type" class="form-control">
                                            <option selected>Choose...</option>
                                            <option value="1">ICTC</option>
                                            <option value="2">FICTC</option>
                                            <option value="3">ART</option>
                                            <option value="4">TI</option>
                                            <option value="5">Private lab</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="validationCustom02">PID</label>
                                        <input type="text" class="form-control" id="pid_survey" name="pid_survey"
                                            placeholder="PID" value="">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="validationCustom02">Outcome</label>
                                        <select id="outcome" name="outcome" class="form-control">
                                            <option selected>Choose...</option>
                                            <option value="1">Positive</option>
                                            <option value="2">Negative</option>
                                            <option value="3">Non Reactive</option>
                                            <option value="4">Not Shared</option>
                                        </select>
                                    </div>
                                </div>

                                <input type="hidden" class="form-control" id="search" name="search"
                                    value="search">
                                <button class="btn btn-primary" type="button" id="btn_serch">Submit</button>

                                </form>
                            </div><!-- myelement -->
                        </div>

                        <!-- <div class="col-lg-2 mt-4">
           <a class="btn btn-warning" href="<?php echo e(route('survey.export')); ?>">Export User Data</a>
          </div> -->
                        <div class=" mt-4">

                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <div>

                            <table class="table table-hover align-items-center" id="survy_data_tbl_id">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col">Client Type</th>
                                        <th scope="col">Sexually Attracted</th>
                                        <th scope="col">Increase the Risk of HIV</th>
                                        <th scope="col">IP Address</th>
                                        <th scope="col">IP Address</th>
                                        <th scope="col">IP Address</th>
                                        <th scope="col">IP Address</th>
                                        <th scope="col">PO Action</th>
                                        <th scope="col">Assessment Date </th>
                                        <th scope="col">State</th>
                                        <th scope="col">District</th>
                                        <th scope="col">Platform</th>
                                        <th scope="col">Age</th>
                                        <th scope="col">Gender</th>
                                        <th scope="col">Target POP</th>
                                        <th scope="col">Mobile</th>
                                        <th scope="col">Risk</th>
                                        <th scope="col">UID</th>
                                        <th scope="col">Services</th>
                                        <th scope="col">TI</th>
                                        <th scope="col">Facility Type</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Referral Date</th>
                                        <th scope="col">Centre</th>
                                        <th scope="col">Acess Date</th>
                                        <th scope="col">PID</th>
                                        <th scope="col">Outcome</th>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('vn-upload-doc')): ?>
                                            <th scope="col">Action</th>
                                        <?php endif; ?>
                                        <th scope="col">Need Counseling</th>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('po-apporve-reject-action')): ?>
                                            <th scope="col">Action</th>
                                        <?php endif; ?>
                                        <th>File Upload</th>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('vn-delete-user')): ?>
                                            <th>Delete</th>
                                        <?php endif; ?>
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
    <?php
    $hivinfectionArr = [];
    if (Session::has('hivinfection')) {
        $hivinfectionArr = Session::get('hivinfection');
    }
    ?>
    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading">Select the Counselling session conducted by you</h4>

                </div>
                <div class="modal-body">
                    <form id="productForm" name="productForm" class="form-horizontal">
                        <?php echo e(csrf_field()); ?>

                        <div class="space-20"></div>
                        <input type="checkbox" id="vehicle1" name="hivinfection[]" value="1">
                        <label for="vehicle1"> HIV Counselling </label><br>
                        <input type="checkbox" id="vehicle2" name="hivinfection[]" value="2">
                        <label for="vehicle2"> STI Counselling</label><br>
                        <input type="checkbox" id="vehicle3" name="hivinfection[]" value="3">
                        <label for="vehicle3"> Positive living Counselling</label><br>
                        <input type="checkbox" id="vehicle4" name="hivinfection[]" value="4">
                        <label for="vehicle1"> Family Counselling</label><br>
                        <input type="checkbox" id="vehicle5" name="hivinfection[]" value="5">
                        <label for="vehicle2"> Mental Health Counselling</label><br>
                        <input type="checkbox" id="vehicle6" name="hivinfection[]" value="6">
                        <label for="vehicle3"> Trauma and Violence Counselling</label><br>
                        <input type="checkbox" id="vehicle7" name="hivinfection[]" value="7">
                        <label for="vehicle3"> Others</label><br><br>
                        <button class="go-aheadbtn" type="button" id="submit">SUBMIT</button>

                        <input type="hidden" id="surveyId" name="surveyId" value="surveyId">
                        <p><span id="infection_err"></span>
                        <p>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/jquery-ui.css')); ?>">
    <script src="<?php echo e(asset('assets/js/jquery-ui.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/vendor/custom_alert/bootbox.all.min.js')); ?>"></script>
    <link rel="stylesheet" media="all" href="<?php echo e(asset('assets/css/jquery.dataTables.css')); ?>">
    <script type="text/javascript" charset="utf8" src="<?php echo e(asset('assets/js/jquery.dataTables.min.js')); ?>"></script>

    <script>
        $(document).ready(function() {

            var dataTableObj = $('#survy_data_tbl_id').dataTable({
                "processing": true,
                "serverSide": true,
                "bDestroy": true,
                "searching": false,
                "bPaginate": true,
                "sDom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
                "ajax": {
                    "url": "<?php echo e(route('all.survey.report')); ?>",
                    "type": "POST",
                    "data": function(d) {



                        d._token = "<?php echo csrf_token(); ?>",
                            d.region = $("#inputState").val(),
                            d.state_id = $("select[name=state_id]").val(),
                            d.facility_type = $("select[name=facility_type]").val(),
                            d.target_pop = $("select[name=target_pop]").val(),
                            d.pid_survey = $("input[name=pid_survey]").val(),
                            d.outcome = $("select[name=outcome]").val(),
                            d.date_type = $("#date_type").val(),

                            d.asset_date_to = $("#assessment_date_to").val(),
                            d.asset_date_from = $("#assessment_date_from").val(),

                            d.refer_date_to = $("#referral_date_to").val(),
                            d.refer_date_from = $("#referral_date_from").val(),

                            d.acess_date_to = $("#acess_date_to").val(),
                            d.acess_date_from = $("#acess_date_from").val(),
                            d.services = $("select[name=services]").val();



                    }
                },
                columns: [{
                        data: 'checkbox',
                        bSortable: false,
                        title: '<input type="checkbox" id="checkAll" name="all" onclick="return checkAllCheck();" >'
                    },
                    {
                        data: 'htmlAction',
                        title: 'Survey Action'
                    },
                    {
                        data: 'client_type',
                        title: 'CLIENT TYPE'
                    },
                    {
                        data: 'sexually_attracted',
                        title: 'Sexually Attracted'
                    },
                    {
                        data: 'increase_risk_hiv',
                        title: 'Increase the Risk of HIV'
                    },
                    {
                        data: 'ip_address',
                        title: 'IP Address'
                    },
                    {
                        data: 'user_country_name',
                        title: 'User Country'
                    }, {
                        data: 'user_state',
                        title: 'User State'
                    }, {
                        data: 'user_city',
                        title: 'User City'
                    },
                    {
                        data: 'book_date',
                        title: 'ASSESSMENT DATE'
                    }, {
                        data: "state_name",
                        title: 'State Name'
                    }, {
                        data: 'district_name',
                        title: 'District Name'
                    }, {
                        data: 'platforms_name',
                        title: 'Platforms Name'
                    }, {
                        data: 'your_age',
                        title: 'Age'
                    }, {
                        data: 'identify_yourself',
                        title: 'Gender'
                    }, {
                        data: 'target_population',
                        title: 'TARGET POP'
                    }, {
                        data: 'client_phone_number',
                        title: 'MOBILE'
                    }, {
                        data: 'risk_level',
                        title: 'RISK'
                    }, {
                        data: 'uid',
                        title: 'UID'
                    }, {
                        data: 'service_required',
                        title: 'SERVICES'
                    }, {
                        data: 'hiv_test',
                        title: 'IT'
                    }, {
                        data: 'services_avail',
                        title: 'FACILITY TYPE'
                    }, {
                        data: 'client_name',
                        title: 'NAME'
                    }, {
                        data: 'appoint_date',
                        title: 'REFERRAL DATE'
                    }, {
                        data: 'center_name',
                        title: 'CENTRE'
                    }, {
                        data: 'acess_date',
                        title: 'Acess Date'
                    }, {
                        data: 'pid',
                        title: 'PID'
                    }, {
                        data: 'outcome',
                        title: 'Outcome'
                    }
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('vn-upload-doc')): ?>
                        , {
                            data: 'flag',
                            title: 'Action'
                        }
                    <?php endif; ?> ,
                    {
                        data: 'survey_co_flag',
                        title: 'Need Counseling'
                    }
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('po-apporve-reject-action')): ?>
                        , {
                            data: 'po_status',
                            title: 'PO Action'
                        }
                    <?php endif; ?> , {
                        data: 'vn_view_upload_files',
                        title: 'view files'
                    }
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('vn-delete-user')): ?>
                        , {
                            data: 'vn_delete',
                            title: 'Delete User'
                        }
                    <?php endif; ?>
                ]

            });

            $("#btn_serch").click(function() {
                dataTableObj.fnDraw();
            });


        });


        $(function() {
            var date = new Date();
            var minDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() + 14);
            $("#acess_date").datepicker({
                showOn: "button",
                buttonImage: "<?php echo e(asset('assets/img/web/calendar.gif')); ?>",
                buttonImageOnly: true,
                buttonText: "Select date",
                dateFormat: 'yy-mm-dd'
            });
        });

        function counseling(s_id) {

            jQuery.confirm({
                icon: 'fas fa-wind-warning',
                closeIcon: true,
                title: 'Are you sure!',
                //content: 'You want to counseling? ', 
                type: 'red',
                typeAnimated: true,
                buttons: {
                    confirm: function() {
                        ajax_counseling(s_id);
                    },
                    cancel: function() {
                        //alert("cancel");
                    }
                }
            });
        }



        function counseling_new(s_id) {

            $('#ajaxModel').modal('show');
            $(document).ready(function() {
                $('#submit').click(function() {
                    var one = $('#vehicle1').val();
                    var two = $('#vehicle2').val();
                    var three = $('#vehicle3').val();
                    var four = $('#vehicle4').val();
                    var five = $('#vehicle5').val();
                    var six = $('#vehicle6').val();
                    var seven = $('#surveyIdvehicle7').val();
                    var surveyId = $('#surveyId').val();
                    // alert(surveyId);	
                    // console.log(s_id);
                    var id = document.getElementById('surveyId').value = s_id;
                    // alert(a);
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "POST",
                        url: '/abc',
                        data: {
                            one: one,
                            two: two,
                            three: three,
                            four: four,
                            five: five,
                            six: six,
                            seven: seven,
                            sid: id,
                        },
                        success: function(data) {
                            console.log(data); // show response from the php script.
                            $('#ajaxModel').modal('hide');
                            $("#div_con_btn_" + id).text('Complete Counseling');
                        }
                    });

                });
            });
        }

        function counseling_(s_id) {

            console.log(s_id);
            document.getElementById('surveyId').value = s_id;

            $('#ajaxModel').modal('show');

        }

        function deleteVnReport(sid) {

            $.ajax({
                type: 'POST',
                url: "/deleteuser/" + sid,
                data: {
                    "id": sid,
                    _token: '<?php echo e(csrf_token()); ?>'
                },
                success: function(response) {
                    if (response) {
                        location.reload();
                    }
                }
            });

        }

        function deleteVnReportConfirm(sid) {

            jQuery.confirm({
                icon: 'fas fa-wind-warning',
                closeIcon: true,
                title: 'Are you sure  !',
                //content: 'You want to counseling? ', 
                type: 'red',
                typeAnimated: true,
                buttons: {
                    confirm: function() {
                        deleteVnReport(sid);
                    },
                    cancel: function() {
                        // alert("confirm  deleted");
                    }
                }
            });
        }

        function ajax_counseling(sid) {

            $.ajax({
                type: "POST",
                url: "<?php echo e(route('flag.counseling')); ?>",
                data: {
                    "_token": "<?php echo e(csrf_token()); ?>",
                    "sid": sid
                },
                dataType: "json",
                success: function(data) {

                    if (data.results == "Success")
                        $("#div_con_btn_" + sid).text('Assign Counseling');


                }
            });

        }


        function uploadReport(id) {

            $("#survey_id").val(id);
            $('#modal-form').modal('show');

        }
        $(document).ready(function(e) {

            $('#multi-file-upload').submit(function(e) {
                e.preventDefault();



                var conf = confirm("Are You sure?You want to save Data?");
                if (!conf)
                    return false;

                var formData = new FormData(this);
                let detail = $("#detail_upload").val();
                let acess_date = $("#acess_date").val();
                let user_pid = $("#user_pid").val();
                let survey_id = $("#survey_id").val();
                let TotalImages = $('#files')[0].files.length; //Total Images
                let images = $('#files')[0];
                let outcome = $('input[name="outcome"]:checked').val();
                let dontshare = 0;
                for (let i = 0; i < TotalImages; i++) {
                    formData.append('images' + i, images.files[i]);
                }
                formData.append('detail', detail);
                formData.append('acess_date', acess_date);
                formData.append('user_pid', user_pid);
                formData.append('totalImages', TotalImages);
                formData.append('survey_id', survey_id);
                formData.append('dontshare', dontshare);
                formData.append('outcome', outcome);
                $.ajax({
                    type: 'POST',
                    url: "<?php echo e(route('vn.upload')); ?>",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: (data) => {
                        //this.reset();
                        //$("#acess_date_err").html(data.error.acess_date[0]);


                        if (data.message == "Success") {
                            $("#survey_id_" + survey_id).remove();
                            this.reset();
                            $('#modal-form').modal('hide');
                            $('#modal-notification').modal('show');

                        } else {

                            if (data.error.acess_date == '') {
                                $("#acess_date_err").html('');
                                $("#acess_date_err").removeClass("alert alert-danger");
                            } else {
                                $("#acess_date_err").html(data.error.acess_date);
                                $("#acess_date_err").addClass("alert alert-danger");
                            }

                            if (data.error.user_pid == '') {
                                $("#user_pid_err").html('');
                                $("#user_pid_err").removeClass("alert alert-danger");
                            } else {
                                $("#user_pid_err").html(data.error.user_pid);
                                $("#user_pid_err").addClass("alert alert-danger");
                            }

                            if (data.error.detail == '') {
                                $("#detail_err").html('');
                                $("#detail_err").removeClass("alert alert-danger");
                            } else {
                                $("#detail_err").html(data.error.user_pid);
                                $("#detail_err").addClass("alert alert-danger");
                            }

                            if (data.error.files == '') {
                                $("#file_err").html('');
                                $("#file_err").removeClass("alert alert-danger");
                            } else {
                                $("#file_err").html(data.error.user_pid);
                                $("#file_err").addClass("alert alert-danger");
                            }

                            if (data.error.outcome == '') {
                                $("#outcome_err").html('');
                                $("#outcome_err").removeClass("alert alert-danger");
                            } else {
                                $("#outcome_err").html(data.error.user_pid);
                                $("#outcome_err").addClass("alert alert-danger");
                            }


                        }
                        //alert('Images has been uploaded using jQuery ajax with preview');
                        //$('.show-multiple-image-preview').html("")
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            });



            $('#po-upload').submit(function(e) {
                e.preventDefault();

                var conf = confirm("Are You sure?You want to save Data?");
                if (!conf)
                    return false;

                let detail = $("#detail").val();
                let action = $("#action").val();
                let survey_po_id = $("#survey_po_id").val();
                var formData = new FormData(this);
                formData.append('detail', detail);
                formData.append('action', action);
                formData.append('survey_po_id', survey_po_id);

                $.ajax({
                    type: 'POST',
                    url: "<?php echo e(route('po.action')); ?>",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: (data) => {
                        //this.reset();	
                        if (data.message == "Success") {
                            this.reset();
                            if (data.action == 1)
                                $("#div_po_btn_" + survey_po_id).html(
                                    '<span class="badge badge-success">Approve</span>');
                            else
                                $("#div_po_btn_" + survey_po_id).html(
                                    '<span class="badge badge-danger">Rejected</span>');

                            $('#modal-po-action-form').modal('hide');
                        } else {

                            if (data.error.detail == '') {
                                $("#detail_err").html('');
                                $("#detail_err").removeClass("alert alert-danger");
                            } else {
                                $("#detail_err").html(data.error.detail);
                                $("#detail_err").addClass("alert alert-danger");
                            }


                            if (data.error.action == '') {
                                $("#action_err").html('');
                                $("#action_err").removeClass("alert alert-danger");
                            } else {
                                $("#action_err").html(data.error.action);
                                $("#action_err").addClass("alert alert-danger");
                            }


                        }

                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            });




            $('#inputStateget').change(function() {

                let state_code = $("#inputStateget").val();
                console.log("state code= " + state_code);
                //formData.append('state_code', state_code);
                //formData.append('_token', '<?php echo e(csrf_token()); ?>');

                var jsonData = {
                    "_token": "<?php echo e(csrf_token()); ?>",
                    "state_code": state_code
                }
                $.ajax({
                    type: 'POST',
                    url: "<?php echo e(route('usr.district')); ?>",
                    data: jsonData,
                    dataType: "json",
                    success: (data) => {
                        console.log(data);
                        $('#inputDistrict').html(data.district_list);

                    },
                    error: function(data) {
                        console.log(data);
                    }
                });

            });


        });

        function getRegion(id) {

            var jsonData = {
                "_token": "<?php echo e(csrf_token()); ?>",
                "city_id": id
            }
            $.ajax({
                type: 'POST',
                url: "<?php echo e(route('usr.region')); ?>",
                data: jsonData,
                dataType: "json",
                success: (data) => {
                    console.log(data);
                    $('#inputStateget').html(data.state_list);

                },
                error: function(data) {
                    console.log(data);
                }
            });

        }

        function getDistrict(id) {

            var state_code = $("select#inputStateget").val();
            var jsonData = {
                "_token": "<?php echo e(csrf_token()); ?>",
                "state_code": state_code
            }
            $.ajax({
                type: 'POST',
                url: "<?php echo e(route('usr.statebydistrict')); ?>",
                data: jsonData,
                dataType: "json",
                success: (data) => {
                    console.log(data);
                    $('#vninputState').html(data.user_list);

                },
                error: function(data) {
                    console.log(data);
                }
            });


        }


        function po_action(id) {

            $('#modal-po-action-form').modal('show');
            $("#survey_po_id").val(id);
            //alert(id);

        }


        $(document).ready(function(e) {
            $("#myelement").click(function() {
                $('#another-element').toggle("slide", {
                    direction: "right"
                }, 1000);
                if (this.value == "Advanced") this.value = "Filter";
                else this.value = "Advanced";
            });

        });

        function DateTypeExportUserData(val) {

            $(".assessment_date,.referral_date,.acess_date").hide();
            $("." + val).show();

        }

        // Multiple Checkbox html

        function submit_action() {


            var conf = confirm("Are You sure?You want to save Data?");
            if (!conf)
                return false;

            let detail = $("#mul_detail").val();
            let action = $("#mul_action").val();
            let survey_po_id = $("#survey_mul_po_id").val();
            var formData = new FormData();
            formData.append('detail', detail);
            formData.append('action', action);
            formData.append('survey_po_id', survey_po_id);
            formData.append('_token', "<?php echo e(csrf_token()); ?>");

            $.ajax({
                type: 'POST',
                url: "<?php echo e(route('mul.po.action')); ?>",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: (data) => {

                    console.log(data.ids);

                    if (data.message == "Success") {

                        $.each(data.ids, function(k, v) {
                            if (data.action == 1)
                                $("#div_po_btn_" + v).html(
                                    '<span class="badge badge-success">Approve</span>');
                            else
                                $("#div_po_btn_" + v).html(
                                    '<span class="badge badge-danger">Rejected</span>');
                        });


                        $('#multiple-po-action-form').modal('hide');
                    } else {

                        if (data.error.detail == '') {
                            $("#mul_detail_err").html('');
                            $("#mul_detail_err").removeClass("alert alert-danger");
                        } else {
                            $("#mul_detail_err").html(data.error.detail);
                            $("#mul_detail_err").addClass("alert alert-danger");
                        }


                        if (data.error.action == '') {
                            $("#mul_action_err").html('');
                            $("#mul_action_err").removeClass("alert alert-danger");
                        } else {
                            $("#mul_action_err").html(data.error.action);
                            $("#mul_action_err").addClass("alert alert-danger");
                        }

                    }

                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        function checkAllCheck() {

            if ($("#checkAll").prop('checked') == true) {
                $('input.multi_approve:checkbox').attr("checked", true);
            } else {
                $('input.multi_approve:checkbox').attr("checked", false);
            }
        }

        function multipoaction() {
            var ids = '';
            var searchIDs = $("input.multi_approve:checkbox:checked").map(function() {
                return $(this).val();
            }).get(); // <----    
            if (searchIDs.length > 0) {
                $('#multiple-po-action-form').modal('show');
                let ids = searchIDs.join("_");
                console.log(ids);
                $("#survey_mul_po_id").val(ids);
            } else {
                $("#survey_mul_po_id").val(ids);
            }
        }


        function viewUploadedFiles(id) {
            $("#detail_msg").html('');
            $("#files_detail_msg").html('');
            var i = 1;
            var files = '';
            $.ajax({
                type: "POST",
                url: "<?php echo e(route('usr.file.upload')); ?>",
                data: {
                    "_token": "<?php echo e(csrf_token()); ?>",
                    "fid": id
                },
                dataType: "json",
                success: function(data) {

                    //console.log(data);
                    $("#detail_msg").html(data.detail);
                    $.each(data.file_upload, function(k, v) {
                        /// do stuff
                        files += i + ' <a href="/storage/uploads/reports/' + v + '"  target="_blank">' +
                            v + '</a><br/>';
                        i++;
                        //console.log(k+" "+v);
                    });
                    $("#files_detail_msg").html(files);
                    $("#vn_file_upload_form").modal('show');


                }
            });

        }
    </script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('modal'); ?>
    <div class="modal fade" id="vn_file_upload_form" tabindex="-1" role="dialog" aria-labelledby="modal-form"
        aria-hidden="true">
        <div class="modal-dialog modal- modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="modal-title-default">File Attachment</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <div class="card bg-secondary shadow border-0">
                        <div class="card-body px-lg-5 py-lg-5">
                            <div class="form-group">
                                <label>Report File </label>
                                <div class="" id="files_detail_msg"></div>
                            </div>
                            <div class="form-group">
                                <label>Detail </label>
                                <div class="" id="detail_msg"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="multiple-po-action-form" tabindex="-1" role="dialog" aria-labelledby="modal-form"
        aria-hidden="true">
        <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="card bg-secondary shadow border-0">

                        <div class="card-body px-lg-5 py-lg-5">

                            <form id="po-mul-upload" method="POST" action="javascript:void(0)" accept-charset="utf-8"
                                enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>

                                <div class="form-group">
                                    <label>Detail</label>
                                    <textarea id="mul_detail" name="mul_detail" class="required form-control" rows="4" cols="30"></textarea>
                                    <div class="" id="mul_detail_err"></div>
                                </div>

                                <div class="form-group">
                                    <label>Action</label>
                                    <select name="mul_action" id="mul_action" class="form-control required">
                                        <option value=''>--Select--</option>
                                        <option value="1">Approve</option>
                                        <option value="2">Rejected</option>
                                    </select>
                                    <div class="" id="mul_action_err"></div>
                                </div>

                                <div class="text-center">
                                    <input type="hidden" id="survey_mul_po_id" name="survey_mul_po_id"
                                        class="custom-control-input">
                                    <button type="button" class="btn btn-primary my-4"
                                        onclick="return submit_action();">Submit</button>
                                </div>
                                <?php echo Form::close(); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-po-action-form" tabindex="-1" role="dialog" aria-labelledby="modal-form"
        aria-hidden="true">
        <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="card bg-secondary shadow border-0">

                        <div class="card-body px-lg-5 py-lg-5">

                            <form id="po-upload" method="POST" action="javascript:void(0)" accept-charset="utf-8"
                                enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>

                                <div class="form-group">
                                    <label>Detail</label>
                                    <textarea id="detail" name="detail" class="required form-control" rows="4" cols="30"></textarea>
                                    <div class="" id="detail_err"></div>
                                </div>

                                <div class="form-group">
                                    <label>Action</label>
                                    <select name="action" id="action" class="form-control required">
                                        <option value=''>--Select--</option>
                                        <option value="1">Approve</option>
                                        <option value="2">Rejected</option>
                                    </select>
                                    <div class="" id="action_err"></div>
                                </div>

                                <div class="text-center">
                                    <input type="hidden" id="survey_po_id" name="survey_po_id"
                                        class="custom-control-input">
                                    <button type="submit" class="btn btn-primary my-4">Submit</button>
                                </div>
                                <?php echo Form::close(); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form"
        aria-hidden="true">
        <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="card bg-secondary shadow border-0">
                        <!--<div class="card-header bg-white pb-5">
                                                    <div class="text-muted text-center mb-3"><small>Sign in with</small>
                                                    </div>
                                                </div>-->

                        <div class="card-body px-lg-5 py-lg-5">

                            <form id="multi-file-upload" method="POST" action="javascript:void(0)"
                                accept-charset="utf-8" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div class="form-group mb-3">
                                    <label>Access Date <span class="feedback-star">*</span></label>
                                    <input class="form-control required" placeholder="" type="text" id="acess_date"
                                        name="acess_date" readonly>

                                    <div class="" id="acess_date_err"></div>

                                </div>
                                <div class="form-group">
                                    <label>PID <span class="feedback-star">*</span></label>
                                    <input class="form-control required" placeholder="PID" type="text"
                                        name="user_pid" id="user_pid">
                                    <div id="user_pid_err"></div>
                                </div>

                                <div class="form-group">
                                    <label>Detail</label>
                                    <textarea id="detail_upload" name="detail_upload" class="required" rows="4" cols="30"></textarea>
                                    <div id="detail_err"></div>
                                </div>

                                <div class="form-group">
                                    <label>File Upload</label>
                                    <input class="form-control required" type="file" name="files[]" id="files"
                                        multiple>
                                    <div id="file_err"></div>
                                </div>


                                <div class="form-group">
                                    <label>Status <span class="feedback-star">*</span></label><br />
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="negative" name="outcome"
                                            class="custom-control-input " value="1">
                                        <label class="custom-control-label" for="negative">Negative</label>
                                    </div>

                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="positive" name="outcome" class="custom-control-input"
                                            value="2">
                                        <label class="custom-control-label" for="positive">Positive</label>
                                    </div>

                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="non_reactive" name="outcome"
                                            class="custom-control-input" value="3">
                                        <label class="custom-control-label" for="non_reactive">Non-reactive </label>
                                    </div>
                                    <div id="outcome_err"></div>

                                    <!-- not share -->
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="dontshare_id" name="outcome"
                                            class="custom-control-input" value="4" checked>
                                        <label class="custom-control-label" for="dontshare_id"> Did not shared </label>
                                    </div>
                                    <div id="dontshare_err"></div>
                                </div>

                                <div class="text-center">
                                    <input type="hidden" id="survey_id" name="survey_id" class="custom-control-input">
                                    <button type="submit" class="btn btn-primary my-4">Save</button>
                                </div>
                                <?php echo Form::close(); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modal-notification" tabindex="-1" role="dialog" aria-labelledby="modal-notification"
        aria-hidden="true">
        <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
            <div class="modal-content bg-gradient-danger">
                <div class="modal-header">
                    <h6 class="modal-title" id="modal-title-notification">Your Data Save </h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="py-3 text-center">
                        <i class="ni ni-bell-55 ni-3x"></i>
                        <h4 class="heading mt-4">You should read this!</h4>
                        <p>Your have been Successfully! Save </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white">Ok, Got it</button>
                    <button type="button" class="btn btn-link text-white ml-auto" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/survey/list_second.blade.php ENDPATH**/ ?>