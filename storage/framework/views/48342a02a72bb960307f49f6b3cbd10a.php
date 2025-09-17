<?php
    use App\Models\SelfModule\RiskAssessment;
?>

<?php $__env->startSection('title'); ?>
    Self Risk Assessment Appointment
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <style>
        .heading__ {
            /* color: #1476A1; */
            margin-bottom: 20px;
            /* font-weight: bold */
            /* font-size: clamp(1.5rem, 2.5vw, 2.5rem); */
        }

        .btn-lets-go {
            background: #00A79D;
            color: white;
            margin-top: 15px !important;
        }

        .services-section {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }

        h2 {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
        }

        .service-item {
            display: flex;
            align-items: center;
            background-color: #eaf7ff;
            border-radius: 5px;
            padding: 10px;
            padding-left: 30px;
            margin-bottom: 10px;
        }

        .service-item input[type="checkbox"] {
            margin-right: 15px;
            width: 18px;
            height: 18px;
            accent-color: #007bff;
        }

        .service-item label {
            flex-grow: 1;
            font-size: 16px;
            color: #333;
        }

        .info-icon {
            background-color: #007bff;
            color: #ffffff;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            cursor: pointer;
        }

        .screen-2 {
            padding: 40px 60px !important;
            border-radius: 10px;
            margin: auto;
        }

        h2 {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
        }

        .btn-group-toggle {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .btn-schedule-type {
            flex: 1;
            background-color: hsl(0, 0%, 100%);
            border: 2px solid #2089B8;
            color: #2089B8;
            text-align: center;
            border-radius: 5px;
            padding: 10px;
            margin: 0 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-schedule-type.active {
            /* background: #2089B8; */
            background: #1476A1;
            color: white;
        }

        .form-container {
            padding: 15px;
            border: 1px solid #000000;
            border-radius: 5px;
            background-color: #f7f9fc;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            /* font-weight: bold; */
            /* color: #333; */
            color:#A7A7A7;
        }

        .form-control {
            background-color: #ffffff;
            border-radius: 5px;
            height: 40px;
            padding: 10px;
        }

        .form-control:disabled {
            background-color: #e9ecef;
            cursor: not-allowed;
        }

        .btn-primary {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #000000;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
        }

        .btn-primary:hover {
            background-color: #e0a800;
            border-color: #d39e00;
        }

        .form-container {
            padding: 15px;
            border-radius: 5px;
            background-color: #f9f9f9;
            box-shadow: 5px 10px 0 #000000;
        }
    </style>
    <form action="<?php echo e(url(app()->getLocale() != 'en' ? app()->getLocale() . '/bookAppointment' : 'bookAppointment')); ?>"
        method="post" style="margin-top: 100px">
        
        
        
        <?php echo csrf_field(); ?>
        <input type="hidden" name="mobile_no" value="<?php echo e($mobileNo); ?>">
        <input type="hidden" name="landing" value="1">
        <input type="hidden" name="user_notification" id="user_notification" class="user_notification" value="1">

        <input type="hidden" name="user_notification" id="user_notification" class="user_notification" value="1">

        <?php if(empty(!$assessment)): ?>
            <input type="hidden" name="vn" value="<?php echo e($vn); ?>">
            <input type="hidden" name="vn" value="<?php echo e($vn); ?>">
            <input type="hidden" name="assessment_id" value="<?php echo e($assessment[RiskAssessment::risk_assessment_id]); ?>">
        <?php endif; ?>

        <div class="row">
            <div class="col-12 col-sm-8 mx-auto section screen-1">
                <div class="row">
                    <div class="col-12 col-md-6 my-auto">
                        <h3 class="heading__"><?php echo e(__('surveyAppointment.Share Your Information')); ?> </h3>
                        <div class="form-group">
                            <div class="input-group px-3 px-md-0">
                                <div class="input-group-prepend">
                                    <span class="input-group-text icon-bg-white">

                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                        </svg>
                                    </span>
                                </div>
                                <input type="text" class="form-control" name="full_name" id="full-name"
                                    value="<?php echo e(old('full_name')); ?>" placeholder=<?php echo e(__('surveyAppointment.NAME*')); ?>>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row px-3 px-md-0">
                    <div class="col-12 my-auto col-md-6">
                        <h5 class="heading__ text-center" style="color: #1476A1">
                            <?php echo e(__('surveyAppointment.Services Required')); ?></h5>
                        <input type="hidden" name="vn" value="<?php echo e($vn); ?>">

                        <?php $__currentLoopData = SERVICES_VIEW; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(session('buttonUse') == 'prep'): ?>
                                <?php if($key == 3): ?>
                                    <div class="service-item">
                                        <input class="form-check-input services" type="checkbox" name="services[]"
                                            id="<?php echo e($key); ?>" value="<?php echo e($key); ?>" checked>
                                        <label class="form-check-label pl-2"
                                            for="<?php echo e($key); ?>"><?php echo e(__($item)); ?></label>
                                        <span class="info-icon bg-dark"
                                            title="<?php echo e(__(SERVICES_DESCRIPTION[$key])); ?>">i</span>
                                    </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <?php if($key != 3): ?>
                                    <div class="service-item">
                                        <input class="form-check-input services" type="checkbox" name="services[]"
                                            id="<?php echo e($key); ?>" value="<?php echo e($key); ?>">
                                        <label class="form-check-label pl-2"
                                            for="<?php echo e($key); ?>"><?php echo e(__($item)); ?></label>
                                        <span class="info-icon bg-dark"
                                            title="<?php echo e(__(SERVICES_DESCRIPTION[$key])); ?>">i</span>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                        
                        
                        <div class="text-center">
                            <button type="button" class="btn btn-lets-go mt-3"
                                style="background-color: #1476A1"><?php echo e(__('surveyAppointment.Lets Go')); ?> &nbsp;
                                <img src="<?php echo e(asset('assets/img/web/arrow.png')); ?>" height="16" /> </button>
                            <br />
                        </div>
                    </div>
                    <div class="col-12 mx-auto my-auto col-md-4">
                        <div class="text-center">
                            <img src="<?php echo e(asset('assets/img/web/services_required.png')); ?>" class="img-fluid pt-4" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-10 p-0 section screen-2">
                <div class="row">
                    <div class="col-12 col-md-6 mx-auto my-auto">
                        <h2 class="heading__" style="color: #000000 !important;"><?php echo e(__('surveyAppointment.Schedule Appointment')); ?></h2>
                        <div class="btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-schedule-type active lets-go-button" id="by-district">
                                <input type="radio" name="scheduleType" value="district" checked>
                                <?php echo e(__('surveyAppointment.By District')); ?>

                            </label>
                            <label class="btn btn-schedule-type" id="by-pin-code">
                                <input type="radio" name="scheduleType" value="pin-code">
                                <?php echo e(__('surveyAppointment.By Pin Code')); ?>

                            </label>
                        </div>
                        
                        <div class="form-container">
                            
                                
                                    <div class="form-group" id="state-group">
                                        <label for="state"><?php echo e(__('surveyAppointment.State')); ?> </label>
                                        <select class="form-control" name="state_id" id="input-state">
                                            <option hidden selected><?php echo e(__('surveyAppointment.Select State')); ?></option>
                                            <?php if(empty(!$states)): ?>
                                            <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($value['id']); ?>" <?php if($ipState == $value['st_cd'] || old('state_id') == $value['id']): echo 'selected'; endif; ?>>
                                                <?php if(app()->getLocale() == 'en'): ?>
                                                <?php echo e($value['state_name']); ?>

                                                <?php else: ?>
                                                <?php echo e($value['state_name_' . app()->getLocale()]); ?>

                                                <?php endif; ?>
                                            </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </select>
                                    
                                </div>
                                
                                
                                    <div class="form-group" id="district-group">
                                        <label for="district"><?php echo e(__('surveyAppointment.District')); ?></label>
                                        <input type="hidden" name="hdn_district_id" value="<?php echo e(old('district_id')); ?>">
                                        <select class="form-control" name="district_id" id="input-district" disabled>
                                            <option hidden selected><?php echo e(__('surveyAppointment.Select District')); ?></option>
                                        </select>
                                    </div>
                                
                            
                            <div class="form-group" id="pincode-group" style="display: none;">
                                <label for="pincode">Pin Code</label>
                                <input type="text" class="form-control" name="pin_code" id="input-pincode">
                            </div>
                            <div class="form-group">
                                <label for="testing-center">Testing Center</label>
                                <input type="hidden" name="hdn_center_id" value="<?php echo e(old('center_id')); ?>">
                                <select class="form-control" name="center_id" id="input-testing-centers" disabled>
                                    <option hidden selected value="">
                                        <?php echo e(__('surveyAppointment.Select Testing Center')); ?></option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="appointment-date"><?php echo e(__('surveyAppointment.Appointment Date')); ?> </label>
                                <input type="date" class="form-control" name="appointment_date" id="appointment-date"
                                    value="<?php echo e(old('appointment_date')); ?>"
                                    min="<?php echo e(currentDateTime(DEFAULT_DATE_FORMAT)); ?>"
                                    max="<?php echo e(getFutureDate(MONTHLY, 1, false, DEFAULT_DATE_FORMAT)); ?>">
                            </div>
                            <div class="form-group text-center">
                                <input type="submit" class="btn w-100" style="background-color: #1476A1; color: #fff;"
                                    value="<?php echo e(__('surveyAppointment.generateReceipt')); ?>">
                            </div>
                        </div>


                        
                        
                    </div>
                    <div class="col-12 col-md-6 mx-auto my-auto text-center">
                        <img src="<?php echo e(asset('assets/img/web/appointment.png')); ?>" class="img-fluid mt-4" />
                    </div>
                </div>
                <div class="container">
                    <br />
                    <h1 class="text-center mt-3">
                        Speak With Virtual Navigators
                    </h1>
                    <?php echo $__env->make('includes.team', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </div>

        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sections = document.querySelectorAll('.section');
            let currentSectionIndex = 0;

            sections.forEach((section, i) => {
                section.style.display = 'none';
            });

            showSection(currentSectionIndex);

            function showSection(index) {
                sections.forEach((section, i) => {
                    section.style.display = i === index ? 'block' : 'none';
                });
            }

            document.querySelectorAll('.btn-schedule-type').forEach(button => {
                button.addEventListener('click', function() {
                    const scheduleType = this.querySelector('input').value;

                    if (scheduleType === 'pin-code') {
                        document.getElementById('state-group').style.display = 'none';
                        document.getElementById('district-group').style.display = 'none';
                        document.getElementById('pincode-group').style.display = 'block';
                        document.getElementById('input-district').value = '';
                        document.getElementById('input-testing-centers').innerHTML =
                            '<option hidden selected value="">--- Select Testing Center ---</option>';
                        document.getElementById('input-testing-centers').innerHTML =
                            '<option hidden selected value="">--- Select Testing Center ---</option>';
                        document.getElementById('input-testing-centers').disabled = true;
                    } else {
                        document.getElementById('state-group').style.display = 'block';
                        document.getElementById('district-group').style.display = 'block';
                        document.getElementById('pincode-group').style.display = 'none';
                    }
                });
            });

            document.querySelectorAll('.btn-lets-go').forEach(button => {
                button.addEventListener('click', function(event) {
                    if (currentSectionIndex === 0) {
                        // Validate screen 1 fields
                        const fullName = document.getElementById("full-name").value;

                        if (!fullName) return alert("Full name is required");
                    } else if (currentSectionIndex === 1) {
                        // Validate screen 2 fields
                        const servicesSelected = document.querySelectorAll(
                            'input[name="services[]"]:checked');
                        if (servicesSelected.length === 0) return alert(
                            "Please select at least one service.");
                    }

                    currentSectionIndex++;
                    showSection(currentSectionIndex);
                });
            });

            document.querySelector('input[type="submit"]').addEventListener('click', function(event) {
                const stateID = document.querySelector('select[name="state_id"]').value;
                const districtID = document.querySelector('select[name="district_id"]').value;
                const centerID = document.querySelector('select[name="center_id"]').value;
                const appointmentDate = document.querySelector('input[name="appointment_date"]').value;
                const pinCode = document.querySelector('input[name="pin_code"]').value;

                if (document.querySelector('input[name="scheduleType"]:checked').value === 'district') {
                    if (!stateID) {
                        event.preventDefault();
                        return alert("Please select a state.");
                    }
                    if (!districtID) {
                        event.preventDefault();
                        return alert("Please select a district.");
                    }
                } else {
                    if (!pinCode) {
                        event.preventDefault();
                        return alert("Please enter a pin code.");
                    }
                }

                if (!centerID) {
                    event.preventDefault();
                    return alert("Please select a testing center.");
                }

                if (!appointmentDate) {
                    event.preventDefault();
                    return alert("Please select an appointment date.");
                }
            });
        });

        function getServices() {
            var services = [];

            $('.services').each(function(key, val) {
                if ($(val).is(':checked'))
                    services.push(parseInt($(val).val()));
            })
            return services;
        }

        function getDistrict() {
            $('#input-district').attr('disabled', true);




            $.ajax({
                url: "/district/getAll",
                method: 'GET',
                dataType: 'json',
                data: {
                    'state_code': $('#input-state').val(),
                    'services': getServices()

                },
                success: function(data) {

                    if (data.data.length == 0) return;

                    var district = $('#input-district').attr('data-id');
                    var html =
                        '<option selected hidden value=""><?php echo e(__('surveyAppointment.Select District')); ?></option>';
                    // '<option selected hidden value="">---Select District---</option>';


                    $.each(data.data, function(key, val) {
                        var select = district != undefined && district == val
                            .id ? " selected" : "";
                        html += '<option value="' + val.id + '"' + select +
                            '>' +
                            <?php
                            if (app()->getLocale() != 'en') {
                                echo 'val.district_name_' . app()->getLocale();
                            } else {
                                echo 'val.district_name';
                            }
                            ?> +
                            '</option>';
                    });
                    $('#input-district').empty();
                    $('#input-district').append(html);
                    $('#input-district').attr('disabled', false);
                    $('#input-testing-centers').empty();
                }
            });
        }

        function getCenters() {
            $.ajax({
                url: "/get-centres",
                method: 'GET',
                dataType: 'json',
                data: {
                    'district_id': $('#input-district').val(),
                    'services': getServices()
                },
                success: function(data) {
                    if (data.data.length == 0) return;
                    var center = $('#input-testing-centers').attr('data-id'),
                        html =
                        '<option selected hidden><?php echo e(__('surveyAppointment.Select Testing Center')); ?></option>';
                    // html = '<option selected hidden>---Select Center---</option>';
                    $.each(data.data, function(key, val) {

                        // var name = val.name;
                        // var address = val.address;
                        <?php if(app()->getLocale() != 'en'): ?>
                            var name = <?php echo e('val.name_' . app()->getLocale()); ?>;
                            var address = <?php echo e('val.address_' . app()->getLocale()); ?>;
                        <?php else: ?>
                            var name = val.name;
                            var address = val.address;
                        <?php endif; ?>
                        /*
                            <?php
                                if (app()->getLocale() != 'en') {
                                    // dd(app()->getLocale());
                                    // dd('name = val.name_' . app()->getLocale(), 'address = val.address_' . app()->getLocale());
                                    echo 'name = val.name_' . app()->getLocale();
                                    echo 'address = val.address_' . app()->getLocale();
                                    // echo 'address = val.address';
                                } else {
                                    echo 'name = val.name';
                                    echo 'address = val.address';
                                }

                            ?>
                            */
                        var select = center != undefined &&
                            center == val.id ? " selected" : "";
                        // console.log(address);
                        if (address != null)
                            name += ', ' + address;
                        html += '<option value="' + val.id + '"' + select + '>' + name + '</option>'
                        // if (address != null) name += ', ' + address;
                        // html += '<option value="' + val.id + '"' +
                        //     select + '>' + name + '</option>'
                    });
                    $('#input-testing-centers').empty();
                    $('#input-testing-centers').append(html);
                    $('#input-testing-centers').attr('disabled', false);
                }
            });
        }


        $(function() {
            setTimeout(() => {
                $('#input-state').trigger('change');
            }, 2000);
            $('.services').on('click', function() {
                getDistrict();
                getCenters();
            })
            $('#input-state').on('change',
                function() {
                    getDistrict();
                })

            $('#input-district').on(
                'change',
                function() {
                    getCenters();
                })

            $('#input-pincode').on('blur', function() {
                if ($('#input-pincode').val().length > 5) {
                    $("#input-testing-centers")
                        .attr(
                            'disabled',
                            true
                        );
                    var htmlOption =
                        '<option selected hidden value="">--- Select Testing Center ---</option>';

                    $.ajax({
                        type: "POST",
                        url: "/pincode",
                        data: {
                            "_token": "<?php echo e(csrf_token()); ?>",
                            "pin_code": $('#input-pincode').val()
                        },
                        dataType: "json",
                        success: function(data) {
                            var json = data.results;
                            if (json.length > 0) {
                                $.each(json, function(index, object) {
                                    htmlOption += '<option value="' + object.id +
                                        '">' +
                                        object.name + '</option>';
                                });


                                $("#input-testing-centers").attr('disabled', false);
                                $("#input-testing-centers").empty();
                                $("#input-testing-centers").html(htmlOption);
                            }
                        }
                    });
                }
            })
        })
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.apphome', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/home/survey/book-appointment.blade.php ENDPATH**/ ?>