<?php
    use App\Models\SelfModule\Appointments;
?>

<?php $__env->startPush('pg_btn'); ?>
    <a href="<?php echo e(route('admin.self-risk-assessment.appointment')); ?>" class="btn btn-sm btn-neutral">All Appointments</a>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5 main-form-card">
                <div class="card-body">
                    <form action="<?php echo e(route('admin.self-risk-assessment.appointment.update')); ?>" method="post"
                        enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="appointment_id" id="appointment_id"
                            value="<?php echo e($appointment[Appointments::appointment_id]); ?>">
                        <div class="pl-lg-4">
                            <div class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                'row',
                                'd-none' =>
                                    !empty($appointment[Appointments::evidence_path]) ||
                                    !empty($appointment[Appointments::evidence_path_2]) ||
                                    !empty($appointment[Appointments::evidence_path_3]) ||
                                    !empty($appointment[Appointments::evidence_path_4]) ||
                                    !empty($appointment[Appointments::evidence_path_5]),
                            ]); ?>">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="do_you_have_evidence" class='form-control-label'>Do you have
                                            evidence?</label>
                                        <select name="do_you_have_evidence" class="selectpicker form-control"
                                            placeholder='Select choice...' id="do_you_have_evidence">
                                            <option value="">Select</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                'row',
                                'd-flex' =>
                                    !empty($appointment[Appointments::evidence_path]) ||
                                    !empty($appointment[Appointments::evidence_path_2]) ||
                                    !empty($appointment[Appointments::evidence_path_3]) ||
                                    !empty($appointment[Appointments::evidence_path_4]) ||
                                    !empty($appointment[Appointments::evidence_path_5]),
                                'd-none',
                            ]); ?>" id="div_applicable_for_sti_service">

                                

                                <input type="hidden" name="existing_evidence_path">
                                <div class="col-12">
                                    <div class="form-group row">


                                        <div class="col-12 col-md-6">
                                            <label for="">Evidence 1</label><br>
                                            <div class="row">
                                                <div class="col-lg-6">

                                                    <input type="file" class="form-control w-35"
                                                        accept=".jpg,.jpeg,.png,.pdf" name="evidence_path" id="evidence"
                                                        onchange="checkFile()">

                                                    <?php if(isset($appointment[Appointments::evidence_path])): ?>
                                                        <div class="actions_evidence d-flex my-4">
                                                            <a href="<?php echo e(asset('storage/' .$appointment[Appointments::evidence_path])); ?>"
                                                                target="_blank" class="btn btn-info" role="button">
                                                                <i class="fas fa-eye"></i></a>
                                                            <button class="btn btn-danger delete_evidence"
                                                                data-id="<?php echo e($appointment[Appointments::appointment_id]); ?>"
                                                                data-evidence="<?php echo e(Appointments::evidence_path); ?>"
                                                                type="button"> <i class="fas fa-trash"></i></button>
                                                        </div>
                                                    <?php endif; ?>

                                                </div>
                                            </div>
                                        </div>

                                        
                                        <div class="col-12 col-md-6">
                                            <label for="">Evidence 2</label><br>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <input type="file" class="form-control w-35"
                                                        accept=".jpg,.jpeg,.png,.pdf" name="evidence_path_2" id="evidence"
                                                        onchange="checkFile()">

                                                    <?php if(isset($appointment[Appointments::evidence_path_2])): ?>
                                                        <div class="actions_evidence d-flex my-4">
                                                            <a href="<?php echo e(asset('storage/' . $appointment[Appointments::evidence_path_2])); ?>"
                                                                target="_blank" class="btn btn-info" role="button">
                                                                <i class="fas fa-eye"></i></a>
                                                            <button class="btn btn-danger delete_evidence"
                                                                data-id="<?php echo e($appointment[Appointments::appointment_id]); ?>"
                                                                data-evidence="<?php echo e(Appointments::evidence_path_2); ?>"
                                                                type="button"> <i class="fas fa-trash"></i></button>
                                                        </div>
                                                    <?php endif; ?>

                                                </div>
                                            </div>
                                        </div>

                                        
                                        <div class="col-12 col-md-6">
                                            <label for="">Evidence 3</label><br>
                                            <div class="row">
                                                <div class="col-lg-6">

                                                    <input type="file" class="form-control w-35"
                                                        accept=".jpg,.jpeg,.png,.pdf" name="evidence_path_3" id="evidence"
                                                        multiple onchange="checkFile()">

                                                    <?php if(isset($appointment[Appointments::evidence_path_3])): ?>
                                                        <div class="actions_evidence d-flex my-4">
                                                            <a href="<?php echo e(asset('storage/' . $appointment[Appointments::evidence_path_3])); ?>"
                                                                target="_blank" class="btn btn-info" role="button">
                                                                <i class="fas fa-eye"></i></a>
                                                            <button class="btn btn-danger delete_evidence"
                                                                data-id="<?php echo e($appointment[Appointments::appointment_id]); ?>"
                                                                data-evidence="<?php echo e(Appointments::evidence_path_3); ?>"
                                                                type="button"> <i class="fas fa-trash"></i></button>
                                                        </div>
                                                    <?php endif; ?>

                                                </div>
                                            </div>
                                        </div>

                                        
                                        <div class="col-12 col-md-6">
                                            <label for="">Evidence 4</label><br>
                                            <div class="row">
                                                <div class="col-lg-6">

                                                    <input type="file" class="form-control w-35"
                                                        accept=".jpg,.jpeg,.png,.pdf" name="evidence_path_4"
                                                        id="evidence" multiple onchange="checkFile()">

                                                    <?php if(isset($appointment[Appointments::evidence_path_4])): ?>
                                                        <div class="actions_evidence d-flex my-4">
                                                            <a href="" target="_blank" class="btn btn-info"
                                                                role="button">
                                                                <i class="fas fa-eye"></i></a>
                                                            <button class="btn btn-danger delete_evidence"
                                                                data-id="<?php echo e(asset('storage/' . $appointment[Appointments::appointment_id])); ?>"
                                                                data-evidence="<?php echo e(Appointments::evidence_path_4); ?>"
                                                                type="button">
                                                                <i class="fas fa-trash"></i></button>
                                                        </div>
                                                    <?php endif; ?>

                                                </div>
                                            </div>
                                        </div>

                                        
                                        <div class="col-12 col-md-6">
                                            <label for="">Evidence 5</label><br>
                                            <div class="row">
                                                <div class="col-lg-6">

                                                    <input type="file" class="form-control w-35"
                                                        accept=".jpg,.jpeg,.png,.pdf" name="evidence_path_5"
                                                        id="evidence" multiple onchange="checkFile()">

                                                    <?php if(isset($appointment[Appointments::evidence_path_5])): ?>
                                                        <div class="actions_evidence d-flex my-4">
                                                            <a href="<?php echo e(asset('storage/' . $appointment[Appointments::evidence_path_5])); ?>"
                                                                target="_blank" class="btn btn-info" role="button">
                                                                <i class="fas fa-eye"></i></a>
                                                            <button class="btn btn-danger delete_evidence"
                                                                data-id="<?php echo e($appointment[Appointments::appointment_id]); ?>"
                                                                data-evidence="<?php echo e(Appointments::evidence_path_5); ?>"
                                                                type="button">
                                                                <i class="fas fa-trash"></i></button>
                                                        </div>
                                                    <?php endif; ?>

                                                </div>
                                            </div>
                                        </div>




                                    </div>

                                    <div>
                                        <small>Note: Can only upload JPG,PNG,PDF and can upload maximum of 5 files of
                                            size 5MB each.</small>
                                    </div>
                                </div>
                                <div class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                    'row',
                                    'd-none' => empty($appointment[Appointments::evidence_path]),
                                ]); ?>" id="div_other_form">
                                    <div class="col-lg-4" id="div_not_access_the_service_referred">
                                        <div class="form-group">
                                            <label for="not_access_the_service_referred" class='form-control-label'>Reason
                                                for
                                                not accessing the service</label>
                                            <select name="not_access_the_service_referred"
                                                class="selectpicker form-control" placeholder='Select choice...'
                                                id="not_access_the_service_referred">
                                                <option value="" hidden selected>---Select Reason---</option>
                                                <?php $__currentLoopData = $REASON_FOR_NOT_ACCESSING; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($key); ?>" <?php if($appointment[Appointments::not_access_the_service_referred] == $key): echo 'selected'; endif; ?>>
                                                        <?php echo e($item); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <?php echo e(Form::label('date_of_accessing_service', 'Date of accessing service', ['class' => 'form-control-label'])); ?>

                                            <?php echo e(Form::date('date_of_accessing_service', !empty($appointment[Appointments::date_of_accessing_service]) ? $appointment[Appointments::date_of_accessing_service] : null, ['class' => 'form-control'])); ?>

                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <?php echo e(Form::label('pid_provided_at_the_service_center', 'PID or other unique ID of the client provided at the service centre', ['class' => 'form-control-label'])); ?>

                                            <?php echo e(Form::text('pid_provided_at_the_service_center', !empty($appointment[Appointments::pid_provided_at_the_service_center]) ? $appointment[Appointments::pid_provided_at_the_service_center] : null, ['class' => 'form-control'])); ?>

                                        </div>
                                    </div>
                                    <div class="col-lg-4" id="div_type_of_test">
                                        <div class="form-group">
                                            <label for="type_of_test" class="form-control-label">Type of Test</label>
                                            <select name="type_of_test" id="type_of_test" class="form-control">
                                                <option value="" selected hidden disabled>--- Select Type ---
                                                </option>
                                                <option value="1" <?php if(isset($appointment) && 1 == $appointment?->type_of_test): echo 'selected'; endif; ?>>Screening</option>
                                                <option value="2" <?php if(isset($appointment) && 2 == $appointment?->type_of_test): echo 'selected'; endif; ?>>Confirmatory Test
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pl-lg-4">
                                <h3 id="div_center_title" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['d-none' => empty($appointment[Appointments::evidence_path])]); ?>">If referred from a different service
                                    center</h3>
                                <div class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                    'row',
                                    'd-none' => empty($appointment[Appointments::evidence_path]),
                                ]); ?>" id="div_center">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="treated_state_id" class="form-control-label">Center State</label>
                                            <select name="treated_state_id" id="treated_state_id" class="form-control"
                                                data-id="<?php echo e(isset($appointment) ? $appointment?->treated_state_id : old('treated_state_id')); ?>">
                                                <option value="" selected hidden disabled>--- Select Center State ---
                                                </option>
                                                <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($key); ?>" <?php if(isset($appointment) && $key == $appointment?->treated_state_id): echo 'selected'; endif; ?>>
                                                        <?php echo e($item); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <?php echo e(Form::label('treated_district_id', 'Center district', ['class' => 'form-control-label'])); ?>

                                            <?php echo e(Form::select('treated_district_id', [], null, ['class' => 'form-control', 'placeholder' => '--- Select District ---', 'disabled' => true, 'data-id' => isset($appointment) ? $appointment?->treated_district_id : old('treated_district_id')])); ?>

                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <?php echo e(Form::label('treated_center_id', 'Name and address of Center', ['class' => 'form-control-label'])); ?>

                                            <?php echo e(Form::select('treated_center_id', [], null, ['class' => 'form-control', 'placeholder' => '--- Select Center ---', 'disabled' => true, 'data-id' => isset($appointment) ? $appointment?->treated_center_id : old('treated_center_id')])); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pl-lg-4">
                                <div class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                    'row',
                                    'd-none' => $appointment[Appointments::outcome_of_the_service_sought] != 1,
                                ]); ?>" id="pre_art_section">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <?php echo e(Form::label('pre_art_no', 'Pre ART No', ['class' => 'form-control-label'])); ?>

                                            <?php echo e(Form::text('pre_art_no', !empty($appointment[Appointments::pre_art_no]) ? $appointment[Appointments::pre_art_no] : null, ['class' => 'form-control'])); ?>

                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <?php echo e(Form::label('on_art_no', 'On ART No', ['class' => 'form-control-label'])); ?>

                                            <?php echo e(Form::text('on_art_no', !empty($appointment[Appointments::on_art_no]) ? $appointment[Appointments::on_art_no] : null, ['class' => 'form-control'])); ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pl-lg-4">
                                <div class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                    'row',
                                    'd-none' => empty($appointment[Appointments::evidence_path]),
                                ]); ?>" id="dv_submit_button">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="outcome_of_the_service_sought" class='form-control-label'>Outcome
                                                of
                                                the service sought</label>
                                            <select name="outcome_of_the_service_sought" class="selectpicker form-control"
                                                placeholder='Select choice...' id="outcome_of_the_service_sought">
                                                <?php $__currentLoopData = $OUTCOME; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($key); ?>" <?php if($appointment[Appointments::outcome_of_the_service_sought] == $key || (empty($appointment[Appointments::outcome_of_the_service_sought]) && $loop->last)): echo 'selected'; endif; ?>>
                                                        <?php echo e($item); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <?php echo e(Form::label('remark', 'Remark', ['class' => 'form-control-label'])); ?>

                                            <?php echo e(Form::text('remark', !empty($appointment[Appointments::remark]) ? $appointment[Appointments::remark] : null, ['class' => 'form-control'])); ?>

                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <?php echo e(Form::submit('Update', ['class' => 'mt-5 btn btn-primary'])); ?>

                                    </div>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        $(document).ready(function() {
            $(".delete_evidence").click(function() {
                let thisx = $(this);
                let confirmation = confirm("Are you sure you want to delete this evidence?");

                if (confirmation) {
                    $.ajax({
                        url: "/outreach/delete_evidence",
                        method: 'GET',
                        dataType: 'json',
                        data: {
                            'appointment_id': $(this).attr('data-id'),
                            'evidence': $(this).attr('data-evidence'),
                        },
                        success: function(data) {
                            $(thisx).parent().empty();
                        }
                    });
                } else {

                }
            });

            $("#do_you_have_evidence").change(function() {
                // Get the selected value from the <select>
                var selectedValue = $(this).val();
                if (selectedValue != "") {
                    $("#dv_submit_button").removeClass("d-none");
                    if (selectedValue == "Yes") {
                        $("#div_other_form").removeClass("d-none");
                        $("#div_type_of_test").removeClass("d-none");
                        $("#div_center_title").removeClass("d-none");
                        $("#div_center").removeClass("d-none");
                        $("#div_not_access_the_service_referred").addClass("d-none");
                        $("#div_applicable_for_sti_service").removeClass("d-none")
                    } else {
                        $("#div_other_form").removeClass("d-none");
                        $("#div_type_of_test").addClass("d-none");
                        $("#div_not_access_the_service_referred").removeClass("d-none");
                        $("#div_center_title").addClass("d-none")
                        $("#div_center").addClass("d-none")
                        $("#div_applicable_for_sti_service").addClass("d-none")
                    }
                } else {
                    $("#dv_submit_button").addClass("d-none");
                    $("#div_other_form").addClass("d-none");
                    $("#div_applicable_for_sti_service").addClass("d-none")
                }
            });

            $("#outcome_of_the_service_sought").change(function() {
                var selectedValue = $(this).val();

                if (selectedValue == 1)
                    $("#pre_art_section").removeClass("d-none");
                else
                    $("#pre_art_section").addClass("d-none");
            });
        });
    </script>

    <script>
        function checkFile() {
            var fileInput = document.getElementById('evidence');
            var resetButton = document.getElementById('resetButton');
            var maxFiles = 5; // Limit to 5 files
            var maxFileSize = 5 * 1024 * 1024; // 2MB in bytes
            var files = fileInput.files;

            // Check if there are files selected
            if (files.length > 0) {
                resetButton.style.display = 'block';
            } else {
                resetButton.style.display = 'none';
            }

            // Validate file count
            if (files.length > maxFiles) {
                alert(`You can only upload a maximum of ${maxFiles} files.`);
                fileInput.value = ''; // Clear the input
                resetButton.style.display = 'none'; // Hide reset button
                return;
            }

            // Validate each file's size
            for (var i = 0; i < files.length; i++) {
                if (files[i].size > maxFileSize) {
                    alert(`${files[i].name} exceeds the maximum size of 2MB.`);
                    fileInput.value = ''; // Clear the input
                    resetButton.style.display = 'none'; // Hide reset button
                    return;
                }
            }

            // alert('All files are valid!');
        }


        function resetFileInput() {
            var fileInput = document.getElementById('evidence');

            var newFileInput = document.createElement('input');
            newFileInput.type = 'file';
            newFileInput.accept = '.jpg,.jpeg,.png,.pdf';
            newFileInput.name = 'evidence_path';
            newFileInput.id = 'evidence';
            newFileInput.className = "form-control";
            newFileInput.onchange = fileInput.onchange;
            fileInput.parentNode.replaceChild(newFileInput, fileInput);

            document.getElementById('resetButton').style.display = 'none';
        }

        function getDistricts() {
            $('#treated_district_id').attr('disabled', true);

            $.ajax({
                url: "/district/getAll",
                method: 'GET',
                dataType: 'json',
                data: {
                    'state_code': $('#treated_state_id').val()
                },
                success: function(data) {
                    var district = $('#treated_district_id').attr('data-id');
                    var html = '<option selected hidden value="">---Select District---</option>';
                    $.each(data.data, function(key, val) {
                        var select = district != undefined && district == val.id ? " selected" : "";
                        html += '<option value="' + val.id + '"' + select + '>' + val.district_name +
                            '</option>';
                    });
                    $('#treated_district_id').empty();
                    $('#treated_district_id').append(html);
                    $('#treated_district_id').attr('disabled', false);
                    $('#treated_center_id').empty();
                }
            });
        }

        function getCenters() {
            $.ajax({
                url: "/get-centres",
                method: 'GET',
                dataType: 'json',
                data: {
                    'district_id': $('#treated_district_id').val()
                },
                success: function(data) {
                    var center = $('#treated_center_id').attr('data-id'),
                        html = '<option selected hidden value="">---Select Center---</option>';

                    $.each(data.data, function(key, val) {
                        var name = val.name;
                        var select = center != undefined && center == val.id ? " selected" : "";
                        if (val.address != null) name += ', ' + val.address;
                        html += '<option value="' + val.id + '"' + select + '>' + name + '</option>'
                    });

                    $('#treated_center_id').empty();
                    $('#treated_center_id').append(html);
                    $('#treated_center_id').attr('disabled', false);
                }
            });
        }

        $(function() {
            if ($('#treated_state_id').attr('data-id') != undefined) {
                getDistricts()
                setTimeout(() => {
                    getCenters()
                }, 2500);
            }

            $('#treated_state_id').on('change', function() {
                getDistricts()
            });

            $('#treated_district_id').on('change', function() {
                getCenters()
            });
        })
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/self/admin/appointment-edit.blade.php ENDPATH**/ ?>