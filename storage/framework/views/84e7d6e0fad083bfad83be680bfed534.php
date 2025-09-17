<?php $__env->startPush('pg_btn'); ?>
    <a href="<?php echo e(route('outreach.plhiv.index')); ?>" class="btn btn-sm btn-neutral">All PLHIV Tests</a>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-body main-form-card">
                    <?php if(isset($plhiv)): ?>
                        <?php echo e(Form::model($plhiv, ['route' => ['outreach.plhiv.update', $plhiv], 'method' => 'put'])); ?>

                    <?php else: ?>
                        <?php echo e(Form::open(['route' => 'outreach.plhiv.store'])); ?>

                    <?php endif; ?>
                    <div class="pl-lg-4">
                        <input type="hidden" name="profile_id" value="<?php echo e($profileID); ?>">
                        <?php if(isset($referral)): ?>
                            <input type="hidden" name="referral_service_id" value="<?php echo e($referral['referral_service_id']); ?>">
                        <?php endif; ?>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <?php echo e(Form::label('unique_serial_number', 'Unique serial number', ['class' => 'form-control-label'])); ?>

                                    <?php echo e(Form::text('unique_serial_number', isset($unique_serial_number) ? urldecode($unique_serial_number) : '', ['class' => 'form-control', 'readonly' => true])); ?>

                                </div>
                            </div>
                        </div>

                        
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <?php echo e(Form::label('pid_or_other_unique_id_of_the_service_center', 'PID Number', ['class' => 'form-control-label'])); ?>

                                    <?php echo e(Form::text('pid_or_other_unique_id_of_the_service_center', isset($referral['pid_or_other_unique_id_of_the_service_center']) ? $referral['pid_or_other_unique_id_of_the_service_center'] : null, ['class' => 'form-control', 'readonly'])); ?>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <?php echo e(Form::label('name_of_the_client', 'Name of client', ['class' => 'form-control-label'])); ?>

                                    <?php echo e(Form::text('name_of_the_client', $profile['profile_name'], ['class' => 'form-control', 'readonly' => true])); ?>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <?php
                                        if (isset($plhiv)) {
                                            $date = $plhiv['date_of_accessing_service'];
                                        } elseif (isset($referral)) {
                                            $date = $referral['date_of_accessing_service'];
                                        } else {
                                            $date = old('date_of_accessing_service');
                                        }
                                    ?>
                                    
                                    
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <?php if(empty(!$profile)): ?>
                                    <input type="hidden" name="profile_registration_date"
                                        value="<?php echo e($profile['registration_date']); ?>">
                                <?php endif; ?>
                                <div class="form-group">
                                    <?php echo e(Form::label('date_of_art_reg', 'Date of ART registration', ['class' => 'form-control-label'])); ?>

                                    <?php echo e(Form::date('date_of_art_reg', null, ['class' => 'form-control'])); ?>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <?php echo e(Form::label('pre_art_reg_number', 'Pre-ART Registration Number', ['class' => 'form-control-label'])); ?>

                                    <?php echo e(Form::text('pre_art_reg_number', null, ['class' => 'form-control'])); ?>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <?php echo e(Form::label('date_of_on_art', 'Date of ON ART', ['class' => 'form-control-label'])); ?>

                                    <?php echo e(Form::date('date_of_on_art', null, ['class' => 'form-control'])); ?>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <?php echo e(Form::label('on_art_reg_number', 'ON ART Registration Number', ['class' => 'form-control-label'])); ?>

                                    <?php echo e(Form::text('on_art_reg_number', null, ['class' => 'form-control'])); ?>

                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <?php echo e(Form::label('art_state_id', 'ART Centre State', ['class' => 'form-control-label'])); ?>

                                    <?php echo e(Form::select('art_state_id', $states, null, ['class' => 'form-control', 'placeholder' => 'Select state...', 'required' => true, 'data-state' => isset($plhiv) ? $plhiv['art_state_id'] : old('art_state_id')])); ?>

                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <?php echo e(Form::label('art_district_id', 'ART Centre District', ['class' => 'form-control-label'])); ?>

                                    <?php echo e(Form::select('art_district_id', [], null, ['class' => 'form-control', 'placeholder' => 'Select district...', 'required' => true, 'disabled' => true, 'data-district' => isset($plhiv) ? $plhiv['art_district_id'] : old('art_district_id')])); ?>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <?php echo e(Form::label('art_center_id', 'ART Centre Name', ['class' => 'form-control-label'])); ?>

                                    <?php echo e(Form::select('art_center_id', [], null, ['class' => 'form-control', 'required' => true, 'disabled' => true, 'data-center' => isset($plhiv) ? $plhiv['art_center_id'] : old('art_center_id')])); ?>

                                </div>
                            </div>
                        </div>
                        
                        <?php if(isset($plhiv) && isset($canTakeAction) && $canTakeAction): ?>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <?php echo e(Form::label('status', 'Take action', ['class' => 'form-control-label'])); ?>

                                        <?php echo e(Form::select('status', [2 => 'Accept', 3 => 'Reject'], null, ['class' => 'form-control', 'placeholder' => 'Select choice...'])); ?>

                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
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
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    
    <script>
        function getDistricts() {
            $('#art_district_id').attr('disabled', true);
            var id = $('#art_state_id').val(),
                district = $('#art_district_id').attr('data-district');
            $.ajax({
                url: "/district/getAll",
                method: 'GET',
                dataType: 'json',
                data: {
                    'state_code': id
                },
                success: function(data) {
                    var html = '<option selected hidden value="">---Select Center---</option>';
                    $.each(data.data, function(key, val) {
                        var select = district == val.id ? " selected" : "";
                        html += '<option value="' + val.id + '"' + select + '>' + val.district_name +
                            '</option>';
                    });
                    $('#art_district_id').empty();
                    $('#art_district_id').append(html);
                    $('#art_district_id').attr('disabled', false);
                }
            });
        }

        function getCenters() {
            $('#art_center_id').attr('disabled', true);
            $.ajax({
                url: "/getTestingCenters",
                method: "GET",
                dataType: "JSON",
                data: {
                    district: $('#art_district_id').val()
                },
                success: function(data) {
                    if (data.status == 200) {
                        var center = $('#art_center_id').attr('data-center');
                        var option = "<option hidden selected value=''>--- Select Testing Center ---</option>";
                        $(data.data).each(function(key, val) {
                            var name = val.name;
                            if (val.address != null) name += ', ' + val.address;
                            var select = center == val.id ? " selected" : "";
                            option += '<option value="' + val.id + '"' + select + '>' + name +
                                '</option>';
                        })
                        $('#art_center_id').empty();
                        $('#art_center_id').append(option);
                        $('#art_center_id').attr('disabled', false);
                    }
                }
            })
        }
        $(function() {
            if ($('#art_state_id').attr('data-state') != undefined) getDistricts();

            if ($('#art_district_id').attr('data-district') != undefined) {
                setTimeout(() => {
                    getCenters()
                }, 5000);
            }

            $('#art_state_id').on('change', function() {
                getDistricts()
            })
            $('#art_district_id').on('change', function() {
                getCenters()
            })
        })
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/outreach/plhiv/create.blade.php ENDPATH**/ ?>