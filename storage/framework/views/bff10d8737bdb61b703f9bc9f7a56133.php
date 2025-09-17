<?php $__env->startPush('pg_btn'); ?>
<a href="<?php echo e(route('web-center-appointments')); ?>" class="btn btn-sm btn-neutral">All Appointments</a>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card mb-5 main-form-card">
            <div class="card-body">
                <?php if(isset($appointment)): ?>
                    <?php echo e(Form::model($appointment, ['route' => ['web-center-appointments.update', $appointment], 'method' => 'put'])); ?>

                <?php else: ?>
                    <?php echo e(Form::open(['route' => 'web-center-appointments.store'])); ?>

                <?php endif; ?>
                <div class="pl-lg-4">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="client_type_id" class="form-control-label">Client Type</label>
                                <select name="client_type_id" id="client_type_id" class="selectpicker form-control" aria-placeholder="Select Client Type..." required>
                                    <?php $__currentLoopData = $CLIENT_TYPE; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($item?->client_type_id); ?>" <?php if((isset($exists) && $exists == $item?->client_type_id) || (isset($appointment) && $item?->client_type_id == $appointment?->client_type_id)): echo 'selected'; endif; ?>><?php echo e($item?->client_type); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pl-lg-4">
                    <h6 class="heading-small text-muted mb-4">TI service</h6>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="service_type_id" class="form-control-label">Type of service</label>
                                <select name="service_type_id" id="service_type_id" class="selectpicker form-control" aria-placeholder="Select Type of service..." required>
                                    <?php $__currentLoopData = $TYPE_SERVICE; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($item?->service_type_id); ?>" <?php if(isset($appointment) && $item?->service_type_id == $appointment?->service_type_id): echo 'selected'; endif; ?>><?php echo e($item?->service_type); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <?php echo e(Form::label('other_ti_services', 'If others (specify)', ['class' => 'form-control-label'])); ?>

                                <?php echo e(Form::text('other_ti_services', null, ['class' => 'form-control'])); ?>

                            </div>
                        </div>
                    </div>
                    <div class="row d-none" id="div_referred_for_ti_service">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="ti_service_id" class="form-control-label">If referred for TI service</label>
                                <select name="ti_service_id" id="ti_service_id" class="selectpicker form-control" aria-placeholder="Select TI service..." required>
                                    <?php $__currentLoopData = $REFERRED_FOR_TI_SERVICE; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($item?->ti_service_id); ?>" <?php if(isset($appointment) && $item?->ti_service_id == $appointment?->ti_service_id): echo 'selected'; endif; ?>><?php echo e($item?->ti_service); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <?php echo e(Form::label('other_referred_service', 'If others (specify)', ['class' => 'form-control-label'])); ?>

                                <?php echo e(Form::text('other_referred_service', null, ['class' => 'form-control'])); ?>

                            </div>
                        </div>
                    </div>
                    <div class="row d-none" id="div_applicable_for_hiv_test">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <?php echo e(Form::label('applicable_for_hiv_test', 'Type of test (applicable for HIV test)', ['class' => 'form-control-label'])); ?>

                                <?php echo e(Form::select('applicable_for_hiv_test', $TYPE_HIV_TEST, null, [ 'class'=> 'selectpicker form-control', 'placeholder' => 'Select choice...'])); ?>

                            </div>
                        </div>
                    </div>
                    <div class="row d-none" id="div_applicable_for_sti_service">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="sti_service_id" class="form-control-label">Type of STI service (applicable for STI service)</label>
                                <select name="sti_service_id" id="sti_service_id" class="selectpicker form-control" aria-placeholder="Select Type of STI service..." required>
                                    <?php $__currentLoopData = $TYPE_STI_SERVICE; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($item?->sti_service_id); ?>" <?php if(isset($appointment) && $item?->sti_service_id == $appointment?->sti_service_id): echo 'selected'; endif; ?>><?php echo e($item?->sti_service); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <?php echo e(Form::label('other_sti_service', 'If others (specify)', ['class' => 'form-control-label'])); ?>

                                <?php echo e(Form::text('other_sti_service', null, ['class' => 'form-control'])); ?>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <?php echo e(Form::label('counselling_service', 'If referred for counselling service', ['class' => 'form-control-label'])); ?>

                                <?php echo e(Form::select('counselling_service', $CHOICES, null, [ 'class'=> 'selectpicker form-control', 'placeholder' => 'Select choice...', 'required'=>true])); ?>

                            </div>
                        </div>
                    </div>
                </div>
                <hr class="my-4" />
                <div class="pl-lg-4">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <?php echo e(Form::label('prevention_programme', 'Ever had a HIV test as part of any Targeted Intervention programme or other HIV prevention programme?', ['class' => 'form-control-label'])); ?>

                                <?php echo e(Form::select('prevention_programme', $PREVENTION_PROGRAMME, null, [ 'class'=> 'selectpicker form-control', 'placeholder' => 'Select choice...', 'required'=>true])); ?>

                            </div>
                        </div>
                    </div>
                </div>
                <hr class="my-4" />
                <div class="pl-lg-4">
                    <h6 class="heading-small text-muted mb-4">Socio-demographic information</h6>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="educational_attainment_id" class="form-control-label">Education attained</label>
                                <select name="educational_attainment_id" id="educational_attainment_id" class="selectpicker form-control" aria-placeholder="Select Education attained..." required>
                                    <?php $__currentLoopData = $EDUCATION; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($item?->educational_attainment_id); ?>" <?php if(isset($appointment) && $item?->educational_attainment_id == $appointment?->educational_attainment_id): echo 'selected'; endif; ?>><?php echo e($item?->educational_attainment); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="occupation_id" class="form-control-label">Primary occupation</label>
                                <select name="occupation_id" id="occupation_id" class="selectpicker form-control" aria-placeholder="Select Primary occupation..." required>
                                    <?php $__currentLoopData = $OCCUPATION; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($item?->occupation_id); ?>" <?php if(isset($appointment) && $item?->occupation_id == $appointment?->occupation_id): echo 'selected'; endif; ?>><?php echo e($item?->occupation); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <?php echo e(Form::label('other', 'Others (specify)', ['class' => 'form-control-label'])); ?>

                                <?php echo e(Form::text('other', null, ['class' => 'form-control'])); ?>

                            </div>
                        </div>
                    </div>
                </div>
                <hr class="my-4" />
                <div class="pl-lg-4">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-control-label">Did the client access the service?</label>
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input access_service" name="access_service" value="1" id="access_service_yes" <?php if(isset($appointment) && $appointment->access_service == 1): echo 'checked'; endif; ?>>
                                    <label class="form-check-label" for="access_service_yes">
                                        Yes
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input access_service" name="access_service" value="0" id="access_service_no" <?php if(isset($appointment) && $appointment->access_service == 0): echo 'checked'; endif; ?>>
                                    <label class="form-check-label" for="access_service_no">
                                        No
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input access_service" name="access_service" value="2" id="access_service_scheduled" <?php if(!isset($appointment) || (isset($appointment) && $appointment->access_service == 2)): echo 'checked'; endif; ?>>
                                    <label class="form-check-label" for="access_service_scheduled">
                                        Scheduled
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                
                
                <hr class="my-4 d-none" id="hr_pid_other_unique_id_and_service_outcome" />
                <div class="pl-lg-4" id="div_pid_other_unique_id_and_service_outcome">
                    <h6 class="heading-small text-muted mb-4 d-none" id="title_pid_other_unique_id_and_service_outcome">PID/other unique ID and service outcome</h6>
                    <div class="row d-none" id="div_not_access_the_service_referred">
                       <div class="col-lg-6">
                            <div class="form-group">
                                <label for="reason_id" class="form-control-label">Reason for not accessing the service</label>
                                <select name="reason_id" id="reason_id" class="selectpicker form-control" aria-placeholder="Select Reason for not accessing the service..." required>
                                    <?php $__currentLoopData = $REASON_FOR_NOT_ACCESSING; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($item?->reason_id); ?>" <?php if(isset($appointment) && $item?->reason_id == $appointment?->reason_id): echo 'selected'; endif; ?>><?php echo e($item?->reason); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row d-none" id="div_date_of_accessing_service">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <?php echo e(Form::label('date_of_accessing_service', 'Date of accessing service', ['class' => 'form-control-label'])); ?>

                                <?php echo e(Form::date('date_of_accessing_service', null, ['class' => 'form-control'])); ?>

                            </div>
                        </div>
                    </div>
                    <div class="row d-none" id="div_pid_or_other_unique_id_of_the_client_provided_at_the_service_cen">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <?php echo e(Form::label('pid_or_other_unique_id_of_the_service_center', 'PID or other unique ID of the client provided at the service centre', ['class' => 'form-control-label'])); ?>

                                <?php echo e(Form::text('pid_or_other_unique_id_of_the_service_center', null, ['class' => 'form-control'])); ?>

                            </div>
                        </div>
                    </div>
                    <div class="row d-none" id="div_outcome_of_the_service_sought">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <?php echo e(Form::label('outcome_of_the_service_sought', 'Outcome of the service sought', ['class' => 'form-control-label'])); ?>

                                <?php echo e(Form::select('outcome_of_the_service_sought', $OUTCOME, null, [ 'class'=> 'selectpicker form-control', 'placeholder' => 'Select choice...'])); ?>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="pl-lg-4">
                    <?php if(isset($appointment) && isset($canTakeAction) && $canTakeAction): ?>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <?php echo e(Form::label('status', 'Take action', ['class' => 'form-control-label'])); ?>

                                    <?php echo e(Form::select('status', [2 => 'Accept', 3 => 'Reject'], null, [ 'class'=> 'selectpicker form-control', 'placeholder' => 'Select choice...'])); ?>

                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="pl-lg-4">
                    <div class="row">
                        <div class="col-md-12">
                            <?php echo e(Form::submit('Save', ['class'=> 'mt-5 btn btn-primary'])); ?>

                        </div>
                    </div>
                </div>
                <?php echo Form::close(); ?>

            </div>
        </div>
    </div>
</div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('vendor/laravel-filemanager/js/stand-alone-button.js')); ?>"></script>
<script>
function getDistricts(input, appendTo, center) {
    $(appendTo).attr('disabled', true);
    
    if($(input).attr('id') == 'referred_state_id')
            $('#referral_center_id').attr('disabled', true);
    else if($(input).attr('id') == 'test_centre_state_id')
        $('#service_accessed_center_id').attr('disabled', true);

    var id = $(input).val(), district = $(appendTo).attr('data-district');
    $.ajax({
        url : "/district/getAll",
        method : 'GET',
        dataType : 'json',
        data : {
            'state_code' : id
        },
        success : function(data) {
            var html = '<option selected hidden value="">---Select District---</option>';
            $.each(data.data,function(key,val) {
                var select = district != undefined && district == val.id ? " selected" : "";
                html += '<option value="'+ val.id +'"'+ select +'>'+ val.district_name +'</option>';
            });
            $(appendTo).empty();
            $(appendTo).append(html);
            $(appendTo).attr('disabled', false);
            $(center).empty();
        }
    });
}
function setValidation(div, required) {
    $(div).find('input, select').each(function (key, val) {
        $(val).prop('required', required);
    });
}
jQuery(document).ready(function() {
    getDistricts($('#referred_state_id'));
    updateOptionalEnablement('service_type_id', 'other_ti_services', 99, '');
    updateOptionalEnablement('ti_service_id', 'other_referred_service', 99, '');
    updateOptionalEnablement('sti_service_id', 'other_sti_service', 99, '');
    updateOptionalEnablement('reason_id', 'other_not_access', 99, '');
    updateOptionalEnablement('occupation_id', 'other', 99, '');
    $('#referred_state_id').on('change', function() {
        getDistricts(this, '#referred_district_id', '#referral_center_id');
    })
    $('#test_centre_state_id').on('change', function() {
        getDistricts(this, '#test_centre_district_id', '#service_accessed_center_id');
    })
    $('#referred_district_id, #test_centre_district_id').on('change',function() {
        var id = $(this).val(), input = $(this);
        if($(input).attr('id') == 'referred_district_id')
            $('#referral_center_id').attr('disabled', true);
        else if($(input).attr('id') == 'test_centre_district_id')
            $('#service_accessed_center_id').attr('disabled', true);

        $.ajax({
            url : "/get-centres",
            method : 'GET',
            dataType : 'json',
            data : {
                'district_id' : id
            },
            success : function(data) {
                var html = '<option selected hidden>---Select Center---</option>';
                $.each(data.data,function(key,val) {
                    var name = val.name;
                    if(val.address != null) name += ', ' + val.address;
                    html += '<option value="'+val.id+'">'+ name + '</option>'
                });
                if($(input).attr('id') == 'referred_district_id') {
                    $('#referral_center_id').empty();
                    $('#referral_center_id').append(html);
                    $('#referral_center_id').attr('disabled', false);
                } else if($(input).attr('id') == 'test_centre_district_id') {
                    $('#service_accessed_center_id').empty();
                    $('#service_accessed_center_id').append(html);
                    $('#service_accessed_center_id').attr('disabled', false);
                }
            }
        });
    })
    $('.client_access_service').on('click', function() {
        if($(this).val() == 0) $('#div_testing_information_fields').removeClass('d-none');
        else $('#div_testing_information_fields').addClass('d-none');
    });
    $('.access_service').on('click', function() {
        var id = $(this).val();
        
        if(id == 0) {
            if(!$('#hr_testing_information').hasClass('d-none'))
                $('#hr_testing_information').addClass('d-none');
            
            if(!$('#div_testing_information').hasClass('d-none'))
                $('#div_testing_information').addClass('d-none');

            if($('#hr_pid_other_unique_id_and_service_outcome').hasClass('d-none'))
                $('#hr_pid_other_unique_id_and_service_outcome').removeClass('d-none');
            
            if($('#title_pid_other_unique_id_and_service_outcome').hasClass('d-none'))
                $('#title_pid_other_unique_id_and_service_outcome').removeClass('d-none');
            
            if($('#div_pid_other_unique_id_and_service_outcome').hasClass('d-none'))
                $('#div_pid_other_unique_id_and_service_outcome').removeClass('d-none');

            $('#div_pid_other_unique_id_and_service_outcome').find('div.row').each(function (key, val){
                if($(val).attr('id') == 'div_not_access_the_service_referred') {
                    $(val).removeClass('d-none');
                    setValidation(val, true);
                } else if (!$(val).hasClass('d-none')) {
                    $(val).addClass('d-none');
                    setValidation(val, false);
                }
            });
        } else if(id == 1) {
            if($('#hr_testing_information').hasClass('d-none'))
                $('#hr_testing_information').removeClass('d-none');
            
            if($('#div_testing_information').hasClass('d-none'))
                $('#div_testing_information').removeClass('d-none');

            if($('#hr_pid_other_unique_id_and_service_outcome').hasClass('d-none'))
                $('#hr_pid_other_unique_id_and_service_outcome').removeClass('d-none');
            
            if($('#title_pid_other_unique_id_and_service_outcome').hasClass('d-none'))
                $('#title_pid_other_unique_id_and_service_outcome').removeClass('d-none');
            
            if($('#div_pid_other_unique_id_and_service_outcome').hasClass('d-none'))
                $('#div_pid_other_unique_id_and_service_outcome').removeClass('d-none');

            $('#div_pid_other_unique_id_and_service_outcome').find('div.row').each(function (key, val){
                if($(val).attr('id') != 'div_applicable_for_hiv_test' && $(val).attr('id') != 'div_applicable_for_sti_service') {
                    $(val).removeClass('d-none');
                    setValidation(val, true);
                }
            });
        } else if(id == 2) {
            if(!$('#hr_testing_information').hasClass('d-none'))
                $('#hr_testing_information').addClass('d-none');
            
            if(!$('#div_testing_information').hasClass('d-none'))
                $('#div_testing_information').addClass('d-none');

            if(!$('#hr_pid_other_unique_id_and_service_outcome').hasClass('d-none')) 
                $('#hr_pid_other_unique_id_and_service_outcome').addClass('d-none');
            
            if(!$('#div_pid_other_unique_id_and_service_outcome').hasClass('d-none')) 
                $('#div_pid_other_unique_id_and_service_outcome').addClass('d-none');
            
            $('#div_pid_other_unique_id_and_service_outcome').find('div.row').each(function (key, val) {
                $(val).addClass('d-none');
                setValidation(val, false);
            });
        }
    });
    $('#service_type_id').on('change', function() {
        var id = $(this).val();
        
        if(id == 1) {
            $('#div_applicable_for_hiv_test').removeClass('d-none');
            setValidation('#div_applicable_for_hiv_test', true);
            
            $('#div_referred_for_ti_service, #div_applicable_for_sti_service').addClass('d-none');
            setValidation('#div_referred_for_ti_service', false);
            setValidation('#div_applicable_for_sti_service', false);
        } else if(id == 2) {
            $('#div_applicable_for_sti_service').removeClass('d-none');
            setValidation('#div_applicable_for_sti_service', true);
            
            $('#div_applicable_for_hiv_test, #div_referred_for_ti_service').addClass('d-none');
            setValidation('#div_applicable_for_hiv_test', false);
            setValidation('#div_referred_for_ti_service', false);
        } else if(id == 8) {
            $('#div_referred_for_ti_service').removeClass('d-none');
            setValidation('#div_referred_for_ti_service', true);
            
            $('#div_applicable_for_hiv_test, #div_applicable_for_sti_service').addClass('d-none');
            setValidation('#div_applicable_for_hiv_test', false);
            setValidation('#div_applicable_for_sti_service', false);
        } else {
            $('#div_referred_for_ti_service, #div_applicable_for_hiv_test, #div_applicable_for_sti_service').addClass('d-none');
            setValidation('#div_referred_for_ti_service', false);
        }
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/web-appointment/edit.blade.php ENDPATH**/ ?>