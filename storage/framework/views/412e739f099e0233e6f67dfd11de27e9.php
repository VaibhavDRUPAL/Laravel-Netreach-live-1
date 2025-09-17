<?php $__env->startPush('pg_btn'); ?>
    <a href="<?php echo e(route('outreach.profile.index')); ?>" class="btn btn-sm btn-neutral">All Profiles</a>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-body">

                    <?php if(isset($profile)): ?>
                        <?php echo e(Form::model($profile, ['route' => ['outreach.profile.update', $profile], 'method' => 'put'])); ?>

                    <?php else: ?>
                        <?php echo e(Form::open(['route' => 'outreach.profile.store'])); ?>

                    <?php endif; ?>
                    <h6 class="heading-small text-muted mb-4">Outreach information</h6>
                    <div class="pl-lg-4">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <?php echo e(Form::label('profile_name', 'Profile Name', ['class' => 'form-control-label'])); ?>

                                    <?php echo e(Form::text('profile_name', null, ['class' => 'form-control', 'required' => false])); ?>

                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <?php echo e(Form::label('registration_date', 'Registered Date', ['class' => 'form-control-label'])); ?>

                                    <?php echo e(Form::date('registration_date', null, ['class' => 'form-control', 'required' => false])); ?>

                                </div>
                            </div>

                        </div>



                       
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="in_referral" class="form-control-label">In Referral</label>
                                    <select name="in_referral" id="in_referral" class="form-control">
                                        <option value="" selected hidden disabled>--- Select Referral ---
                                        </option>
                                        <?php $__currentLoopData = $reffff; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($index); ?>" <?php if((isset($profile) && $index == $profile?->in_referral) || old('in_referral') == $index): echo 'selected'; endif; ?>>
                                                <?php echo e($item); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <?php echo e(Form::label('referral_other', 'In Referral if other', ['class' => 'form-control-label'])); ?>

                                    <?php echo e(Form::text('referral_other', null, ['class' => 'form-control'])); ?>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="platform_id" class="form-control-label">Medium of Engagement</label>
                                    <select name="platform_id" id="platform_id" class="form-control">
                                        <option value="" selected hidden disabled>--- Select Medium of Engagement ---
                                        </option>
                                        <?php $__currentLoopData = $APPS; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            
                                            <option value="<?php echo e($item?->id); ?>" <?php if((isset($profile) && $item?->id == $profile?->platform_id) || old('platform_id') == $item?->id): echo 'selected'; endif; ?>>
                                                <?php echo e($item?->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <?php echo e(Form::label('other_platform', 'Medium of Engagement if other', ['class' => 'form-control-label'])); ?>

                                    <?php echo e(Form::text('other_platform', null, ['class' => 'form-control'])); ?>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="purpose_val" class="form-control-label">Primary Purpose</label>
                                    <select name="purpose_val" id="purpose_val" class="form-control">
                                        <option value="" selected hidden disabled>--- Select Main Purpose ---
                                        </option>
                                        <?php $__currentLoopData = $purpose; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($index); ?>" <?php if((isset($profile) && $index == $profile?->purpose_val) || old('purpose_val') == $index): echo 'selected'; endif; ?>>
                                                <?php echo e($item); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <?php echo e(Form::label('purpose_other', 'Purpose if other', ['class' => 'form-control-label'])); ?>

                                    <?php echo e(Form::text('purpose_other', null, ['class' => 'form-control'])); ?>

                                </div>
                            </div>
                        </div>




                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <?php echo e(Form::label('shared_website_link', 'Did you share website link with the client?', ['class' => 'form-control-label'])); ?>

                                    <?php echo e(Form::select('shared_website_link', [1 => 'Yes', 2 => 'No'], null, ['class' => 'form-control', 'placeholder' => '--- Select choice ---'])); ?>

                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <?php echo e(Form::label('phone_number', 'Phone number', ['class' => 'form-control-label'])); ?>

                                    <?php echo e(Form::text('phone_number', null, ['class' => 'form-control'])); ?>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <?php echo e(Form::label('state_id', 'State', ['class' => 'form-control-label'])); ?>

                                    <?php echo e(Form::select('state_id', $states, null, ['class' => 'form-control', 'placeholder' => 'Select state...', 'required' => true, 'data-state' => isset($profile) ? $profile['state_id'] : ''])); ?>

                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <?php echo e(Form::label('district_id', 'District', ['class' => 'form-control-label'])); ?>

                                    <?php echo e(Form::select('district_id', [], null, ['class' => 'form-control', 'placeholder' => 'Select district...', 'required' => true, 'disabled' => true, 'data-district' => isset($profile) ? $profile['district_id'] : old('district_id')])); ?>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <?php echo e(Form::label('remarks', 'Remarks', ['class' => 'form-control-label'])); ?>

                                    <?php echo e(Form::text('remarks', null, ['class' => 'form-control'])); ?>

                                </div>
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
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script>
        function getDistricts() {
            var id = $('#state_id').val(),
                district = $('#district_id').attr('data-district');
            $('#district_id').attr('disabled', true);
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
                        var select = district == val.id ? " selected" : "";
                        html += '<option value="' + val.id + '"' + select + '>' + val.district_name +
                            '</option>';
                    });
                    $('#district_id').empty();
                    $('#district_id').append(html);
                    $('#district_id').attr('disabled', false);
                }
            });
        }
        let districts = [];
        jQuery(document).ready(function() {
            if ($('#state_id').attr('data-state') != undefined) getDistricts();

            updateOptionalEnablement('gender_id', 'other_gender', 5, '');
            updateOptionalEnablement('target_id', 'others_target_population', 99, '');
            updateOptionalEnablement('platform_id', 'other_platform', 99, '');
            updateOptionalEnablement('virtual_platform', 'please_mention', 1, '');
            updateOptionalEnablement('mention_platform_id', 'others_mentioned', 99, '');
            updateOptionalEnablement('in_referral', 'referral_other', 99, '');
            updateOptionalEnablement('purpose_val', 'purpose_other', 99, '');

            $('#state_id').on('change', function() {
                getDistricts();
            })

            $('#gender_id').on('change', function() {
                var gender = $('#gender_id').val();
                $('#target_id').find('option').each(function(key, val) {
                    if (gender == 1) {
                        if ($(val).val() == 2 || $(val).val() == 4) $(val).addClass('d-none')
                        else if ($(val).hasClass('d-none')) $(val).removeClass('d-none')
                    } else if (gender == 2) {
                        if ($(val).val() == 1 || $(val).val() == 3 || $(val).val() == 4) $(val)
                            .addClass('d-none')
                        else if ($(val).hasClass('d-none')) $(val).removeClass('d-none')
                    } else if (gender == 3) {
                        if ($(val).val() == 4) $(val).removeClass('d-none')
                        else if (!$(val).hasClass('d-none')) $(val).addClass('d-none')
                    } else if (gender == 4) {
                        if ($(val).val() > 4) $(val).removeClass('d-none')
                        else $(val).addClass('d-none')
                    } else $(val).removeClass('d-none')
                });
            })

            $('#age_not_disclosed').on('click', function() {
                if ($('#age_not_disclosed').prop('checked')) {
                    $('#age').removeAttr('required');
                    $('#age').val('');
                    $('#age').addClass('d-none');
                } else {
                    $('#age').removeClass('d-none');
                    $('#age').attr('required', true);
                }
            })

            $('#virtual_platform').on('change', function() {
                console.log($(this).val());
                if ($(this).val() == 1) $('div.please_mention').removeClass('d-none');
                else $('div.please_mention').addClass('d-none');
            })
        })
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/outreach/profile/create.blade.php ENDPATH**/ ?>