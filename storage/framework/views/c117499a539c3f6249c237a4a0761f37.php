<?php $__env->startSection('content'); ?>
    <style>
        @media (max-width: 768px) {
            .w-sm-100 {
                width: 100% !important;
            }
        }
    </style>
    <section class="landing-sec-1">
        <img src="<?php echo e(asset('assets/img/web/bg_two.jpeg')); ?>" class="main-banner d-none d-sm-block">
        <div class="banner-caption">
            <div class="container">
                <div class="row">

                    <div class="col-lg-1"> </div>
                    <div class="col-md-5 mb-5">
                        
                        <h1 class="mt-4" style="font-size: clamp(2rem, 2.5vw,2.5rem)"><b><?php echo e(__('verifyOtp.mob')); ?> </b></h1>
                        <input type="text" placeholder=<?php echo e(__('verifyOtp.PhoneNumber')); ?> name="mobilenumber" id="mobilenumber"
                            style="background: none; height: 70px; width: auto; min-width: 240px; max-width: 100%;"
                            pattern="[6-9][0-9]{9}" class="required" data-bind="number">


                        <div class="row">
                            <div class="col-6 col-md-4">
                                <button type="submit" name="verify_otp" id="verify_otp" class="btn text-center"
                                    style="width:150px;height:50px;background:#1476A1;margin-top:-5px; color: #fff; border-radius: 10px;">
                                    <strong><?php echo e(__('verifyOtp.Verify')); ?> </strong> </button>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-5 px-0 d-block d-sm-none">
                        <div class="card border-0">
                            <img src="<?php echo e(asset('assets/img/web/q1.png')); ?>" class="card-img-top rounded-0" alt="...">
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="verify-otp" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-body">

                                

                                <form
                                    action="<?php echo e(route('verifyMobileOTP', ['locale' => app()->getLocale()])); ?>"
                                    method="post">
                                    
                            
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="mobile-no" id="mobile-no">
                                    <input type="hidden" name="name-vn" id="name-vn" value="<?php echo $vnname; ?>">
                                    <input type="hidden" name="vn" value="<?php echo e(!empty($vn) ? $vn : ''); ?>">

                                    <div class="form-group">
                                        <h5 class="modal-title"><?php echo e(__('verifyOtp.verifymn')); ?> </h5>
                                        <h6 class="mt-1" for="otp"><?php echo e(__('verifyOtp.otp')); ?> </h6>
                                        <small><?php echo e(__('verifyOtp.sentotp')); ?> </small><br>
                                        <small><?php echo e(__('verifyOtp.sentotp2')); ?> </small>
                                        <small for="otp" id="otp-small-text" class="form-text text-muted"></small>
                                        <input type="text" class="form-control" name="otp" id="otp"
                                            style="background:none" placeholder=<?php echo e(__('verifyOtp.placeholder')); ?> required>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-success float-right" style="background:#1476A1;" value=<?php echo e(__('verifyOtp.Verify')); ?> >
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!--container-->
            </div>
            <!--banner-caption-->
    </section>
    <!--landing-sec-1-->
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('verify_otp').addEventListener('click', function(event) {
                var mobilenumber = document.getElementById('mobilenumber').value;

                if (mobilenumber === '' || mobilenumber.length !== 10 || !/^[6-9]\d{9}$/.test(
                        mobilenumber)) {
                    alert('Please enter a valid 10-digit mobile number.');
                } else {
                    document.getElementById('mobile-no').value = mobilenumber;
                    $('#verify-otp').modal('show');

                    fetch('<?php echo e(url('sendOTP')); ?>', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                            },
                            body: JSON.stringify({
                                mobile_number: mobilenumber
                            })
                        })
                        .then(response => response.json());

                    event.preventDefault();
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.apphome', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/home/survey/verify_otp.blade.php ENDPATH**/ ?>