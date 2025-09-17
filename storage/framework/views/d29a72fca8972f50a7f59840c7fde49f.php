<?php
    use App\Models\SelfModule\Appointments;
    use App\Models\Outreach\ReferralService;
?>
<?php $__env->startPush('pg_btn'); ?>
    <a href="<?php echo e(route('outreach.referral-service.index')); ?>" class="btn btn-sm btn-neutral">All Referral Services</a>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    
    
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5 main-form-card">
                <div class="card-body">
                    <?php if(isset($referral_service)): ?>
                        <?php echo e(Form::model($referral_service, ['route' => ['outreach.referral-service.update', $referral_service], 'method' => 'put', 'files' => true])); ?>

                    <?php else: ?>
                        <?php echo e(Form::open(['route' => 'outreach.referral-service.store', 'files' => true])); ?>

                    <?php endif; ?>
                    <div class="pl-lg-4">
                        <input type="hidden" name="profile_id" value="<?php echo e($profileID); ?>">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <?php echo e(Form::label('unique_serial_number', 'Unique serial number', ['class' => 'form-control-label'])); ?>

                                    <?php echo e(Form::text('unique_serial_number', isset($unique_serial_number) ? urldecode($unique_serial_number) : '', ['class' => 'form-control', 'readonly' => true])); ?>

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <?php echo e(Form::label('profile_name', 'Profile Name', ['class' => 'form-control-label'])); ?>

                                    <?php echo e(Form::text('profile_name', $profile['profile_name'], ['class' => 'form-control', 'readonly' => true])); ?>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <?php echo e(Form::label('client_name', 'Client Name', ['class' => 'form-control-label'])); ?>

                                    <?php echo e(Form::text('client_name', isset($referral_service['client_name']) ? $referral_service['client_name'] : null, ['class' => 'form-control'])); ?>

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <?php echo e(Form::label('age_client', 'Age', ['class' => 'form-control-label'])); ?>

                                    <?php echo e(Form::text('age_client', isset($referral_service['age_client']) ? $referral_service['age_client'] : null, ['class' => 'form-control'])); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pl-lg-4">
                        <h6 class="heading-small text-muted mb-4">TI service</h6>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="target_id" class="form-control-label">Target Population</label>
                                    <select name="target_id" id="target_id" class="form-control" required>
                                        <option value="" selected hidden disabled>--- Select target population ---
                                        </option>
                                        <?php $__currentLoopData = $TARGET_POPULATION; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($item?->target_id); ?>" <?php if((isset($referral_service) && $item?->target_id == $referral_service?->target_id) || old('target_id') == $item?->target_id): echo 'selected'; endif; ?>>
                                                <?php echo e($item?->target_type); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <?php echo e(Form::label('others_target_population', 'Target population if other', ['class' => 'form-control-label'])); ?>

                                    <?php echo e(Form::text('others_target_population', old('others_target_population'), ['class' => 'form-control'])); ?>

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="service_type_id" class="form-control-label">Type of service</label>
                                    <select name="service_type_id" id="service_type_id" class="form-control" required>
                                        <option value="" selected hidden disabled>--- Select Type of service ---
                                        </option>
                                        <?php $__currentLoopData = $TYPE_SERVICE; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($item?->service_type_id); ?>" <?php if((isset($referral_service) && $item?->service_type_id == $referral_service?->service_type_id) || old('service_type_id') == $item?->service_type_id): echo 'selected'; endif; ?>>
                                                <?php echo e($item?->service_type); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <?php echo e(Form::label('other_service_type', 'Type of Service if Other', ['class' => 'form-control-label'])); ?>

                                    <?php echo e(Form::text('other_service_type', old('other_service_type'), ['class' => 'form-control'])); ?>

                                </div>
                            </div>
                        </div>




                    </div>

                    <hr class="my-4" />
                    <div class="pl-lg-4">
                        <h6 class="heading-small text-muted mb-4">Referral information</h6>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <?php echo e(Form::label('date_of_accessing_service', 'Date of referral', ['class' => 'form-control-label'])); ?>

                                    <?php echo e(Form::date('referral_date', null, ['class' => 'form-control'])); ?>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <?php echo e(Form::label('referred_state_id', 'Referred centre state', ['class' => 'form-control-label'])); ?>

                                    <?php echo e(Form::select('referred_state_id', $states, null, ['class' => 'form-control', 'placeholder' => '--- Select State ---', 'required' => true])); ?>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <?php echo e(Form::label('referred_district_id', 'Referred centre district', ['class' => 'form-control-label'])); ?>

                                    <?php echo e(Form::select('referred_district_id', [], null, ['class' => 'form-control', 'placeholder' => '--- Select District ---', 'required' => true, 'disabled' => true, 'data-id' => isset($referral_service) ? $referral_service?->referred_district_id : old('referred_district_id')])); ?>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <?php echo e(Form::label('referral_center_id', 'Name and address of referral centre', ['class' => 'form-control-label'])); ?>

                                    <?php echo e(Form::select('referral_center_id', [], null, ['class' => 'form-control', 'required' => true, 'disabled' => true, 'data-id' => isset($referral_service) ? $referral_service?->referral_center_id : old('referral_center_id')])); ?>

                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                        'my-4',
                        'd-none' =>
                            (isset($referral_service) && $referral_service?->access_service == 2) ||
                            (!is_null(old('access_service')) && old('access_service') == 2),
                    ]); ?>" id="hr_pid_other_unique_id_and_service_outcome" />
                    

                    
                    <div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="do_you_have_evidence" class='form-control-label'>Do you have
                                    evidence?</label>
                                <select name="do_you_have_evidence" class="selectpicker form-control"
                                    placeholder='Select choice...' id="do_you_have_evidence">
                                    <option value="">Select</option>
                                    <option value="Yes"
                                        <?php echo e(isset($referral_service) && !empty($referral_service['pid_or_other_unique_id_of_the_service_center']) ? 'selected' : ''); ?>>
                                        Yes</option>
                                    <option value="No"
                                        <?php echo e(isset($referral_service) && empty($referral_service['pid_or_other_unique_id_of_the_service_center']) ? 'selected' : ''); ?>>
                                        No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                        'row',
                        'd-flex' =>
                            !empty($referral_service['evidence_path']) ||
                            !empty($referral_service['evidence_path_2']) ||
                            !empty($referral_service['evidence_path_3']) ||
                            !empty($referral_service['evidence_path_4']) ||
                            !empty($referral_service['evidence_path_5']),
                        'd-none',
                    ]); ?>" id="div_applicable_for_sti_service">

                        <input type="hidden" name="existing_evidence_path">
                        <div class="col-12">
                            <div class="form-group row">

                                
                                <div class="col-12 col-md-6">
                                    <label for="">Evidence 1</label><br>
                                    <div class="row">
                                        <div class="col-lg-6">

                                            <input type="file" class="form-control w-35" accept=".jpg,.jpeg,.png,.pdf"
                                                name="evidence_path" id="evidence" onchange="checkFile()">

                                            <?php if(isset($referral_service['evidence_path'])): ?>
                                                <div class="actions_evidence d-flex my-4">

                                                    <a href="<?php echo e(asset('storage/' . $referral_service['evidence_path'])); ?>"
                                                        target="_blank" class="btn btn-info" role="button">
                                                        <i class="fas fa-eye"></i></a>
                                                    <button class="btn btn-danger delete_evidence_for_referral"
                                                        data-id="<?php echo e($referral_service['referral_service_id']); ?>"
                                                        data-evidence="<?php echo e(ReferralService::evidence_path); ?>"
                                                        type="button">
                                                        <i class="fas fa-trash"></i></button>
                                                </div>
                                            <?php endif; ?>

                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-12 col-md-6">
                                    <label for="">Evidence 2</label><br>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <input type="file" class="form-control w-35" accept=".jpg,.jpeg,.png,.pdf"
                                                name="evidence_path_2" id="evidence" onchange="checkFile()">

                                            <?php if(isset($referral_service['evidence_path_2'])): ?>
                                                <div class="actions_evidence d-flex my-4">
                                                    <a href="<?php echo e(asset('storage/' . $referral_service['evidence_path_2'])); ?>"
                                                        target="_blank" class="btn btn-info" role="button">
                                                        <i class="fas fa-eye"></i></a>
                                                    <button class="btn btn-danger delete_evidence_for_referral"
                                                        data-id="<?php echo e($referral_service['referral_service_id']); ?>"
                                                        data-evidence="<?php echo e(ReferralService::evidence_path_2); ?>"
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

                                            <input type="file" class="form-control w-35" accept=".jpg,.jpeg,.png,.pdf"
                                                name="evidence_path_3" id="evidence" onchange="checkFile()">

                                            <?php if(isset($referral_service['evidence_path_3'])): ?>
                                                <div class="actions_evidence d-flex my-4">
                                                    <a href="<?php echo e(asset('storage/' . $referral_service['evidence_path_3'])); ?>"
                                                        target="_blank" class="btn btn-info" role="button">
                                                        <i class="fas fa-eye"></i></a>
                                                    <button class="btn btn-danger delete_evidence_for_referral"
                                                        data-id="<?php echo e($referral_service['referral_service_id']); ?>"
                                                        data-evidence="<?php echo e(ReferralService::evidence_path_3); ?>"
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

                                            <input type="file" class="form-control w-35" accept=".jpg,.jpeg,.png,.pdf"
                                                name="evidence_path_4" id="evidence" onchange="checkFile()">

                                            <?php if(isset($referral_service['evidence_path_4'])): ?>
                                                <div class="actions_evidence d-flex my-4">
                                                    <a href="<?php echo e(asset('storage/' . $referral_service['evidence_path_4'])); ?>"
                                                        target="_blank" class="btn btn-info" role="button">
                                                        <i class="fas fa-eye"></i></a>
                                                    <button class="btn btn-danger delete_evidence_for_referral"
                                                        data-id="<?php echo e($referral_service['referral_service_id']); ?>"
                                                        data-evidence="<?php echo e(ReferralService::evidence_path_4); ?>"
                                                        type="button"> <i class="fas fa-trash"></i></button>
                                                </div>
                                            <?php endif; ?>

                                        </div>
                                    </div>
                                </div>

                                
                                <div class="col-12 col-md-6">
                                    <label for="">Evidence 5</label><br>
                                    <div class="row">
                                        <div class="col-lg-6">

                                            <input type="file" class="form-control w-35" accept=".jpg,.jpeg,.png,.pdf"
                                                name="evidence_path_5" id="evidence" onchange="checkFile()">

                                            <?php if(isset($referral_service['evidence_path_5'])): ?>
                                                <div class="actions_evidence d-flex my-4">
                                                    <a href="<?php echo e(asset('storage/' . $referral_service['evidence_path_5'])); ?>"
                                                        target="_blank" class="btn btn-info" role="button">
                                                        <i class="fas fa-eye"></i></a>
                                                    <button class="btn btn-danger delete_evidence_for_referral"
                                                        data-id="<?php echo e($referral_service['referral_service_id']); ?>"
                                                        data-evidence="<?php echo e(ReferralService::evidence_path_5); ?>"
                                                        type="button"> <i class="fas fa-trash"></i></button>
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
                    </div>

                    <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['row', 'd-none', 'col-12','mt-3']); ?>" id="div_other_form">
                        


                        
                        
                        <div class="col-lg-4">
                            <div class="form-group">
                                <?php echo e(Form::label('date_of_accessing_service', 'Date of accessing service', ['class' => 'form-control-label'])); ?>

                                <?php echo e(Form::date('date_of_accessing_service', null, ['class' => 'form-control'])); ?>

                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <?php echo e(Form::label('pid_or_other_unique_id_of_the_service_center', 'PID or other unique ID of the client provided at the service centre', ['class' => 'form-control-label'])); ?>

                                <?php echo e(Form::text('pid_or_other_unique_id_of_the_service_center', null, ['class' => 'form-control'])); ?>

                            </div>
                        </div>
                        
                        <div class="col-lg-4" id="div_type_of_test">
                            <div class="form-group">
                                <label for="type_of_test" class="form-control-label">Type of Test</label>
                                <select name="type_of_test" id="type_of_test" class="form-control">
                                    <option value="" selected hidden disabled>--- Select Type ---
                                    </option>
                                    <option value="1" <?php if(isset($referral_service) && 1 == $referral_service?->type_of_test): echo 'selected'; endif; ?>>Screening</option>
                                    <option value="2" <?php if(isset($referral_service) && 2 == $referral_service?->type_of_test): echo 'selected'; endif; ?>>Confirmatory Test
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <h3 id="div_center_title" class="<?php echo \Illuminate\Support\Arr::toCssClasses(['d-none']); ?>">If referred from a different service
                                center</h3>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <?php echo e(Form::label('test_centre_state_id', 'Centre state', ['class' => 'form-control-label'])); ?>

                                <?php echo e(Form::select('test_centre_state_id', $states, null, ['class' => 'form-control', 'placeholder' => '--- Select State ---'])); ?>

                            </div>
                        </div>
                        
                        
                        <div class="col-lg-4">
                            <div class="form-group">
                                <?php echo e(Form::label('test_centre_district_id', 'Centre district', ['class' => 'form-control-label'])); ?>

                                <?php echo e(Form::select('test_centre_district_id', [], null, ['class' => 'form-control', 'placeholder' => '--- Select District ---', 'disabled' => true, 'data-id' => isset($referral_service) ? $referral_service?->test_centre_district_id : old('test_centre_district_id')])); ?>

                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <?php echo e(Form::label('service_accessed_center_id', 'Name and address of centre', ['class' => 'form-control-label'])); ?>

                                <?php echo e(Form::select('service_accessed_center_id', [], null, ['class' => 'form-control', 'required' => true, 'disabled' => true, 'data-id' => isset($referral_service) ? $referral_service?->service_accessed_center_id : old('service_accessed_center_id ')])); ?>

                            </div>
                        </div>
                        

                    </div>
                    


                    
                    
                    

                    <div class="pl-lg-4">
                        <div class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                            'row',
                            'd-none' =>
                                isset($referral_service) &&
                                $referral_service['outcome_of_the_service_sought'] != 1,
                        ]); ?>" id="pre_art_section">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <?php echo e(Form::label('pre_art_no', 'Pre ART No', ['class' => 'form-control-label'])); ?>

                                    <?php echo e(Form::text('pre_art_no', !empty($referral_service['pre_art_no']) ? $referral_service['pre_art_no'] : null, ['class' => 'form-control'])); ?>

                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <?php echo e(Form::label('on_art_no', 'On ART No', ['class' => 'form-control-label'])); ?>

                                    <?php echo e(Form::text('on_art_no', !empty($referral_service['on_art_no']) ? $referral_service['on_art_no'] : null, ['class' => 'form-control'])); ?>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="<?php echo \Illuminate\Support\Arr::toCssClasses(['row', 'd-none', 'col-12']); ?>" id="outcome_remark">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="outcome_of_the_service_sought" class='form-control-label'>Outcome
                                    of
                                    the service sought</label>
                                <select name="outcome_of_the_service_sought" class="selectpicker form-control"
                                    placeholder='Select choice...' id="outcome_of_the_service_sought">
                                    <?php $__currentLoopData = $OUTCOME; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($key); ?>" <?php if((isset($referral_service) && $referral_service['outcome_of_the_service_sought'] == $key) || (empty($referral_service['outcome_of_the_service_sought']) && $loop->last)): echo 'selected'; endif; ?>>
                                            
                                            <?php echo e($item); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <?php echo e(Form::label('remarks', 'Remarks', ['class' => 'form-control-label'])); ?>

                                <?php echo e(Form::text('remarks', null, ['class' => 'form-control'])); ?>

                            </div>
                        </div>
                    </div>
                    

                    











                    

                    <div class="pl-lg-4">
                        <div class="row">
                            <div class="col-md-12">
                                <?php echo e(Form::submit('Save', ['class' => 'mt-5 btn btn-primary'])); ?>

                            </div>
                        </div>
                    </div>
                    <?php echo Form::close(); ?>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('vendor/laravel-filemanager/js/stand-alone-button.js')); ?>"></script>
    <script>
        $(document).ready(function() {
            $(".delete_evidence_for_referral").click(function() {
                let thisx = $(this);
                let confirmation = confirm("Are you sure you want to delete this evidence?");

                if (confirmation) {
                    $.ajax({
                        url: "/outreach/delete_evidence_for_referral",
                        method: 'GET',
                        dataType: 'json',
                        data: {
                            'referral_service_id': $(this).attr('data-id'),
                            'evidence': $(this).attr('data-evidence'),
                        },
                        success: function(data) {
                            $(thisx).parent().empty();
                        }
                    });
                } else {

                }
            });
        });



        function getDistricts(input, appendTo, center) {
            $(appendTo).attr('disabled', true);

            if ($(input).attr('id') == 'referred_state_id')
                $('#referral_center_id').attr('disabled', true);
            else if ($(input).attr('id') == 'test_centre_state_id')
                $('#service_accessed_center_id').attr('disabled', true);

            var id = $(input).val(),
                district = $(appendTo).attr('data-id');
            $.ajax({
                url: "/district/getAll",
                method: 'GET',
                dataType: 'json',
                data: {
                    'state_code': id
                },
                success: function(data) {
                    var html = '<option selected hidden value="">---Select District---</option>';
                    $.each(data.data, function(key, val) {
                        var select = district != undefined && district == val.id ? " selected" : "";
                        html += '<option value="' + val.id + '"' + select + '>' + val.district_name +
                            '</option>';
                    });
                    $(appendTo).empty();
                    $(appendTo).append(html);
                    $(appendTo).attr('disabled', false);
                    $(center).empty();
                }
            });
        }

        function setValidation(div, required) {
            $(div).find('input, select').each(function(key, val) {
                $(val).prop('required', required);
            });
        }
        jQuery(document).ready(function() {
            getDistricts('#referred_state_id', '#referred_district_id', '#referral_center_id');
            getDistricts('#test_centre_state_id', '#test_centre_district_id', '#service_accessed_center_id');

            // updateOptionalEnablement('service_type_id', 'other_ti_services', 99, '');
            updateOptionalEnablement('ti_service_id', 'other_referred_service', 99, '');
            updateOptionalEnablement('sti_service_id', 'other_sti_service', 99, '');
            updateOptionalEnablement('reason_id', 'other_not_access', 99, '');
            updateOptionalEnablement('occupation_id', 'other', 99, '');
            updateOptionalEnablement('target_id', 'others_target_population', 99, '');
            updateOptionalEnablement('service_type_id', 'other_service_type', 99, '');

            if ($('#referral_center_id').attr('data-id') != undefined) {
                setTimeout(() => {
                    $('#referred_district_id').trigger('change');
                }, 10000);
            }

            if ($('#service_accessed_center_id').attr('data-id') != undefined) {
                setTimeout(() => {
                    $('#test_centre_district_id').trigger('change');
                }, 15000);
            }

            $('#referred_state_id').on('change', function() {
                getDistricts(this, '#referred_district_id', '#referral_center_id');
            })
            $('#test_centre_state_id').on('change', function() {
                getDistricts(this, '#test_centre_district_id', '#service_accessed_center_id');
            })
            $('#referred_district_id, #test_centre_district_id').on('change', function() {
                var id = $(this).val(),
                    input = $(this);
                if ($(input).attr('id') == 'referred_district_id')
                    $('#referral_center_id').attr('disabled', true);
                else if ($(input).attr('id') == 'test_centre_district_id')
                    $('#service_accessed_center_id').attr('disabled', true);

                $.ajax({
                    url: "/get-centres",
                    method: 'GET',
                    dataType: 'json',
                    data: {
                        'district_id': id
                    },
                    success: function(data) {
                        var center = $('#referral_center_id').attr('data-id') != undefined ? $(
                            '#referral_center_id').attr('data-id') : $(
                            '#service_accessed_center_id').attr('data-id');
                        var html = '<option selected hidden>---Select Center---</option>';
                        $.each(data.data, function(key, val) {
                            var name = val.name;
                            var select = center != undefined && center == val.id ?
                                " selected" : "";
                            if (val.address != null) name += ', ' + val.address;
                            html += '<option value="' + val.id + '"' + select + '>' +
                                name + '</option>'
                        });
                        if ($(input).attr('id') == 'referred_district_id') {
                            $('#referral_center_id').empty();
                            $('#referral_center_id').append(html);
                            $('#referral_center_id').attr('disabled', false);
                        } else if ($(input).attr('id') == 'test_centre_district_id') {
                            $('#service_accessed_center_id').empty();
                            $('#service_accessed_center_id').append(html);
                            $('#service_accessed_center_id').attr('disabled', false);
                        }
                    }
                });
            })
            $('.client_access_service').on('click', function() {
                if ($(this).val() == 0) $('#div_testing_information_fields').removeClass('d-none');
                else $('#div_testing_information_fields').addClass('d-none');

                $('#div_testing_information_fields').find('div.row').each(function(key, val) {
                    $(val).find('select').each(function(iKey, iVal) {
                        if ($(iVal).attr('id') == 'test_centre_district_id' || $(iVal).attr(
                                'id') == 'service_accessed_center_id') $(iVal).empty().attr(
                            'disabled', true);

                        $(iVal).val('');
                    });
                })
            });

            $('.access_service').on('click', function() {
                $('#same_as_referred').prop('checked', true);
                $('#other_center').prop('checked', false);
                $('#div_testing_information_fields').addClass('d-none');
                $('#div_pid_other_unique_id_and_service_outcome, #div_testing_information_fields').find(
                    'div.row').each(function(key, val) {
                    $(val).find('input, select').each(function(iKey, iVal) {
                        if ($(iVal).attr('id') == 'test_centre_district_id' || $(iVal).attr(
                                'id') == 'service_accessed_center_id') $(iVal).empty().attr(
                            'disabled', true);

                        $(iVal).val('');
                    });
                })

                var id = $(this).val();

                if (id == 0) {
                    if (!$('#hr_testing_information').hasClass('d-none'))
                        $('#hr_testing_information').addClass('d-none');

                    if (!$('#div_testing_information').hasClass('d-none'))
                        $('#div_testing_information').addClass('d-none');

                    if ($('#hr_pid_other_unique_id_and_service_outcome').hasClass('d-none'))
                        $('#hr_pid_other_unique_id_and_service_outcome').removeClass('d-none');

                    if ($('#title_pid_other_unique_id_and_service_outcome').hasClass('d-none'))
                        $('#title_pid_other_unique_id_and_service_outcome').removeClass('d-none');

                    if ($('#div_pid_other_unique_id_and_service_outcome').hasClass('d-none'))
                        $('#div_pid_other_unique_id_and_service_outcome').removeClass('d-none');

                    $('#div_pid_other_unique_id_and_service_outcome').find('div.row').each(function(key,
                        val) {
                        if ($(val).attr('id') == 'div_not_access_the_service_referred') {
                            $(val).removeClass('d-none');
                            setValidation(val, true);
                        } else if (!$(val).hasClass('d-none')) {
                            $(val).addClass('d-none');
                            setValidation(val, false);
                        }
                    });
                } else if (id == 1) {
                    if ($('#hr_testing_information').hasClass('d-none'))
                        $('#hr_testing_information').removeClass('d-none');

                    if ($('#div_testing_information').hasClass('d-none'))
                        $('#div_testing_information').removeClass('d-none');

                    if ($('#hr_pid_other_unique_id_and_service_outcome').hasClass('d-none'))
                        $('#hr_pid_other_unique_id_and_service_outcome').removeClass('d-none');

                    if ($('#title_pid_other_unique_id_and_service_outcome').hasClass('d-none'))
                        $('#title_pid_other_unique_id_and_service_outcome').removeClass('d-none');

                    if ($('#div_pid_other_unique_id_and_service_outcome').hasClass('d-none'))
                        $('#div_pid_other_unique_id_and_service_outcome').removeClass('d-none');

                    $('#div_pid_other_unique_id_and_service_outcome').find('div.row').each(function(key,
                        val) {
                        if ($(val).attr('id') != 'div_applicable_for_hiv_test' && $(val).attr(
                                'id') != 'div_applicable_for_sti_service' && $(val).attr('id') !=
                            'div_not_access_the_service_referred') {
                            $(val).removeClass('d-none');
                            setValidation(val, true);
                        }
                    });

                    $('#div_not_access_the_service_referred').find('select').prop('required', false);
                    $('#div_not_access_the_service_referred').addClass('d-none');
                } else if (id == 2) {
                    if (!$('#hr_testing_information').hasClass('d-none'))
                        $('#hr_testing_information').addClass('d-none');

                    if (!$('#div_testing_information').hasClass('d-none'))
                        $('#div_testing_information').addClass('d-none');

                    if (!$('#hr_pid_other_unique_id_and_service_outcome').hasClass('d-none'))
                        $('#hr_pid_other_unique_id_and_service_outcome').addClass('d-none');

                    if (!$('#div_pid_other_unique_id_and_service_outcome').hasClass('d-none'))
                        $('#div_pid_other_unique_id_and_service_outcome').addClass('d-none');

                    $('#div_pid_other_unique_id_and_service_outcome').find('div.row').each(function(key,
                        val) {
                        $(val).addClass('d-none');
                        setValidation(val, false);
                    });
                }
            });
            $('#service_type_id').on('change', function() {
                var id = $(this).val();

                if (id == 1) {
                    $('#div_applicable_for_hiv_test').removeClass('d-none');
                    setValidation('#div_applicable_for_hiv_test', true);

                    $('#div_referred_for_ti_service, #div_applicable_for_sti_service').addClass('d-none');
                    setValidation('#div_referred_for_ti_service', false);
                    setValidation('#div_applicable_for_sti_service', false);
                } else if (id == 2) {
                    $('#div_applicable_for_sti_service').removeClass('d-none');
                    setValidation('#div_applicable_for_sti_service', true);

                    $('#div_applicable_for_hiv_test, #div_referred_for_ti_service').addClass('d-none');
                    setValidation('#div_applicable_for_hiv_test', false);
                    setValidation('#div_referred_for_ti_service', false);
                } else if (id == 8) {
                    $('#div_referred_for_ti_service').removeClass('d-none');
                    setValidation('#div_referred_for_ti_service', true);

                    $('#div_applicable_for_hiv_test, #div_applicable_for_sti_service').addClass('d-none');
                    setValidation('#div_applicable_for_hiv_test', false);
                    setValidation('#div_applicable_for_sti_service', false);
                } else {
                    $('#div_referred_for_ti_service, #div_applicable_for_hiv_test, #div_applicable_for_sti_service')
                        .addClass('d-none');
                    setValidation('#div_referred_for_ti_service', false);
                }
            });
        });

        // ------------------------do you have evidence scripts----------------------
        $(document).ready(function() {

            var temp = $("#outcome_of_the_service_sought").val();
            if (temp == 1) {
                $("#pre_art_section").removeClass("d-none");
                $("#on_art_section").removeClass("d-none");
            } else {
                $("#pre_art_section").addClass("d-none");
                $("#on_art_section").addClass("d-none");
            }
            var do_drop = $("#do_you_have_evidence").val();
            if (do_drop == "Yes") {
                $("#div_other_form").removeClass("d-none");
                $("#div_type_of_test").removeClass("d-none");
                $("#div_center_title").removeClass("d-none");
                $("#div_applicable_for_sti_service").removeClass("d-none")
                $("#outcome_remark").removeClass("d-none")
            } else {
                $("#div_other_form").addClass("d-none");
                $("#div_type_of_test").addClass("d-none");
                $("#div_center_title").addClass("d-none")
                $("#div_applicable_for_sti_service").addClass("d-none")
                $("#outcome_remark").addClass("d-none")

            }

            $("#do_you_have_evidence").change(function() {
                // Get the selected value from the <select>
                var selectedValue = $(this).val();
                if (selectedValue != "") {
                    // $("#dv_submit_button").removeClass("d-none");
                    if (selectedValue == "Yes") {
                        $("#div_other_form").removeClass("d-none");
                        $("#div_type_of_test").removeClass("d-none");
                        $("#div_center_title").removeClass("d-none");
                        // $("#div_center").removeClass("d-none");
                        $("#div_applicable_for_sti_service").removeClass("d-none")
                        $("#outcome_remark").removeClass("d-none")
                        $("#div_not_access_the_service_referred").addClass("d-none");
                    } else {
                        $("#div_other_form").addClass("d-none");
                        $("#div_type_of_test").addClass("d-none");
                        $("#div_center_title").addClass("d-none")
                        // $("#div_center").addClass("d-none")
                        $("#div_applicable_for_sti_service").addClass("d-none")
                        $("#outcome_remark").addClass("d-none")
                        $("#div_not_access_the_service_referred").removeClass("d-none");
                    }
                } else {
                    $("#div_other_form").addClass("d-none");
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
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/outreach/referral-service/create.blade.php ENDPATH**/ ?>