<?php $__env->startSection('title'); ?>
    Self Risk Assessment Appointment
<?php $__env->stopSection(); ?>

<?php $__env->startSection('body'); ?>
    <form action="<?php echo e(url('bookAppointment')); ?>" method="post">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="mobile_no" value="<?php echo e(old('mobile_no') ? old('mobile_no') : $mobileNo); ?>">
        <?php if(empty(!$vn)): ?>
            <input type="hidden" name="vn" value="<?php echo e(old('vn') ? old('vn') : $vn); ?>">
        <?php endif; ?>
        <input type="hidden" name="assessment_id" value="<?php echo e(old('assessment') ? old('assessment') : $assessment); ?>">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="state">Full name</label>
                    <input type="text" class="form-control" name="full_name" id="full-name"
                        value="<?php echo e(old('full_name')); ?>">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="state">State</label>
                    <select class="form-control" name="state_id" id="input-state">
                        <option hidden selected>--- Select State ---</option>
                        <?php if(empty(!$states)): ?>
                            <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($value['id']); ?>" <?php if($stateID == $value['id'] || old('state_id') == $value['id']): echo 'selected'; endif; ?>><?php echo e($value['state_name']); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="district">District</label>
                    <input type="hidden" name="hdn_district_id" value="<?php echo e(old('district_id')); ?>">
                    <select class="form-control" name="district_id" id="input-district" disabled>
                        <option hidden selected>--- Select District ---</option>
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="state">Select Services You Need:</label>
                    <?php $__currentLoopData = SERVICES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="services[]" id="<?php echo e($key); ?>"
                                value="<?php echo e($key); ?>" <?php if($loop->first): echo 'checked'; endif; ?>>
                            <label class="form-check-label" for="<?php echo e($key); ?>">
                                <?php echo e($item); ?>

                            </label>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="district">Testing Center</label>
                    <input type="hidden" name="hdn_center_id" value="<?php echo e(old('center_id')); ?>">
                    <select class="form-control" name="center_id" id="input-testing-centers" disabled>
                        <option hidden selected value="">--- Select Testing Center ---</option>
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="district">Appointment Date</label>
                    <input type="date" class="form-control" name="appointment_date" id="appointment-date"
                        value="<?php echo e(old('appointment_date')); ?>" min="<?php echo e(currentDateTime(DEFAULT_DATE_FORMAT)); ?>"
                        max="<?php echo e(getFutureDate(MONTHLY, 1, false, DEFAULT_DATE_FORMAT)); ?>">
                </div>
            </div>
            <div class="col-md-12">
                <input type="submit" class="btn btn-success float-right w-25" value="Book Now">
            </div>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('self.layout.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/self/book-appointment.blade.php ENDPATH**/ ?>