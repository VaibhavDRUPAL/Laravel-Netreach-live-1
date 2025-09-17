<?php $__env->startPush('pg_btn'); ?>
    <a href="<?php echo e(route('outreach.counselling.index')); ?>" class="btn btn-sm btn-neutral">All Counsellings</a>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-body main-form-card">
                    <?php if(isset($counselling)): ?>
                        <?php echo e(Form::model($counselling, ['route' => ['outreach.counselling.update', $counselling], 'method' => 'put'])); ?>

                    <?php else: ?>
                        <?php echo e(Form::open(['route' => 'outreach.counselling.store'])); ?>

                    <?php endif; ?>
                        <input type="hidden" name="profile_id" value="<?php echo e($profileID); ?>">
                        <div class="pl-lg-4">
                            <h6 class="heading-small text-muted mb-4">Preliminary information</h6>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <?php echo e(Form::label('unique_serial_number', 'Unique serial number', ['class' => 'form-control-label'])); ?>

                                        <?php echo e(Form::text('unique_serial_number', isset($unique_serial_number) ? urldecode($unique_serial_number) : '', ['class' => 'form-control', 'readonly'=>true])); ?>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="client_type_id" class="form-control-label">Client Type</label>
                                        <select name="client_type_id" id="client_type_id" class="form-control" required>
                                            <option value="" selected hidden disabled>--- Select Client Type ---</option>
                                            <?php $__currentLoopData = $CLIENT_TYPE; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($item?->client_type_id); ?>" <?php if((isset($exists) && $exists == $item?->client_type_id) || (isset($counselling) && $item?->client_type_id == $counselling?->client_type_id) || (old('client_type_id') == $item?->client_type_id)): echo 'selected'; endif; ?>><?php echo e($item?->client_type); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <?php echo e(Form::label('name_the_client', 'Client name', ['class' => 'form-control-label'])); ?>

                                        <?php echo e(Form::text('name_the_client', $profile['profile_name'], ['class' => 'form-control', 'required'=>true,'readonly'])); ?>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <?php echo e(Form::label('referred_from', 'Referred from', ['class' => 'form-control-label'])); ?>

                                        <?php echo e(Form::select('referred_from', $REFERRED_FROM, null, [ 'class'=> 'form-control', 'placeholder' => '--- Select choice ---', 'required'=>true])); ?>

                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <?php echo e(Form::label('referral_source', 'If others(specify) referral source', ['class' => 'form-control-label'])); ?>

                                        <?php echo e(Form::text('referral_source', null, ['class' => 'form-control'])); ?>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <?php if(empty(!$profile)): ?>
                                            <input type="hidden" name="profile_registration_date" value="<?php echo e($profile['registration_date']); ?>">
                                        <?php endif; ?>
                                        <?php echo e(Form::label('date_of_counselling', 'Date of counselling', ['class' => 'form-control-label'])); ?>

                                        <?php echo e(Form::date('date_of_counselling', null, ['class' => 'form-control', 'required'=>true])); ?>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <?php echo e(Form::label('phone_number', 'Phone number', ['class' => 'form-control-label'])); ?>

                                        <?php echo e(Form::text('phone_number', null, ['class' => 'form-control'])); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-4" />
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="type_of_counselling_offered" class="form-control-label">Type of counselling offered</label>
                                        <select name="type_of_counselling_offered" id="type_of_counselling_offered" class="form-control" required>
                                            <option value="" selected hidden disabled>--- Select Type of counselling ---</option>
                                            <?php $__currentLoopData = $COUNSELLING_TYPE; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($key); ?>" <?php if((isset($counselling) && $key == $counselling?->type_of_counselling_offered) || (old('type_of_counselling_offered') == $key)): echo 'selected'; endif; ?>><?php echo e($item); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <?php echo e(Form::label('type_of_counselling_offered_other', 'If others (specify)', ['class' => 'form-control-label'])); ?>

                                        <?php echo e(Form::text('type_of_counselling_offered_other', null, ['class' => 'form-control'])); ?>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <?php echo e(Form::label('counselling_medium', 'Counselling medium', ['class' => 'form-control-label'])); ?>

                                        <?php echo e(Form::select('counselling_medium', $TYPE_OF_COUNSELLING, null, [ 'class'=> 'form-control', 'placeholder' => '--- Select medium of counselling ---', 'required'=>true])); ?>

                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <?php echo e(Form::label('other_counselling_medium', 'If others (specify)', ['class' => 'form-control-label'])); ?>

                                        <?php echo e(Form::text('other_counselling_medium', null, ['class' => 'form-control'])); ?>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <?php echo e(Form::label('duration_of_counselling', 'Duration of counselling (in minutes)', ['class' => 'form-control-label'])); ?>

                                        <?php echo e(Form::number('duration_of_counselling', null, ['class' => 'form-control'])); ?>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <?php echo e(Form::label('key_concerns_discussed', 'Key concerns discussed', ['class' => 'form-control-label'])); ?>

                                        <?php echo e(Form::text('key_concerns_discussed', null, ['class' => 'form-control'])); ?>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <?php echo e(Form::label('follow_up_date', 'Follow-up date', ['class' => 'form-control-label'])); ?>

                                        <?php echo e(Form::date('follow_up_date', null, ['class' => 'form-control'])); ?>

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
                            <?php if(isset($counselling) && isset($canTakeAction) && $canTakeAction): ?>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <?php echo e(Form::label('status', 'Take action', ['class' => 'form-control-label'])); ?>

                                            <?php echo e(Form::select('status', [2 => 'Accept', 3 => 'Reject'], null, [ 'class'=> 'form-control', 'placeholder' => 'Select choice...'])); ?>

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
        jQuery(document).ready(function(){
            updateOptionalEnablement('referred_from', 'referral_source', 99, '');
            updateOptionalEnablement('gender', 'gender_other', 5, '');
            updateOptionalEnablement('type_target_population', 'other_target_pop', 99, '');
            updateOptionalEnablement('type_of_counselling_offered', 'type_of_counselling_offered_other', 99, '');
            updateOptionalEnablement('counselling_medium', 'other_counselling_medium', 99, '');
        })
        $('#state_id').on('change',function() {
            var id = $(this).val(), input = $(this);
            $.ajax({
                url : "/district/getAll",
                method : 'GET',
                dataType : 'json',
                data : {
                    'state_code' : id
                },
                success : function(data) {
                    var html = null;
                    $.each(data.data,function(key,val){
                        html += '<option value="'+ val.id +'">'+val.district_name+'</option>'
                    });
                    $('#district_id').empty();
                    $('#district_id').append(html);
                }
            });
        })
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/outreach/counselling/create.blade.php ENDPATH**/ ?>