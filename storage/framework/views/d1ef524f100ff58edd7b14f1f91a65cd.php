<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('assets/css/jquery.passwordRequirements.css')); ?>" />
<?php $__env->stopPush(); ?>
<?php $__env->startPush('pg_btn'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-header bg-transparent">
                    <div class="row">
                        <div class="col-lg-8">
                            <h3 class="mb-0">Reset Password</h3>
                        </div>
                        <div class="col-lg-4"></div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
					
					<div class="row">
					<div class="col-md-12">
						<div class="card mb-5">
					
                        <div>
                            <form method="post" action="<?php echo e(route('vn.updpass')); ?> " id="myfrmId"> <?php echo csrf_field(); ?>
                            Code : <?php echo e($vmd->vncode); ?> <br>
                            Name : <?php echo e($vmd->name); ?> <br>
                            Email : <?php echo e($vmd->email); ?> <br>
							
							<div class="form-group">
								<label for="example-text-input" class="form-control-label">New Password :</label>								
								<input type="password" name="new_pass" id="new_pass" class="form-control pr-password" required />
							</div> 

							<div class="form-group">
								<label for="example-text-input" class="form-control-label">Confirm New Password :</label>
								<input type="password" name="password_confirmation" id="new_pass2" class="form-control"  required />
							</div>                             
                              <br>
                            <div style="display:none;" id="frmError" class="alert-danger"></div>
                            <input type="hidden" name="vmid" value="<?php echo e($vmd->id); ?>">
                            <button type="button" id="changePass"  class="btn btn-primary">Change Password</button>							
                            </form>
                            
                        </div>
					</div>
					</div>
					</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('assets/js/jquery.passwordRequirements.min.js')); ?>"></script>
    <script>
        /* trigger when page is ready */
        $(document).ready(function (){
            $(".pr-password").passwordRequirements({
                numCharacters: 8,
                useLowercase:true,  
                useUppercase:true,
                useNumbers:true,
                useSpecial:true

            });
        });
        var pwdLength = /^.{8,16}$/;
        var pwdUpper = /[A-Z]+/;
        var pwdLower = /[a-z]+/;
        var pwdNumber = /[0-9]+/;
        var pwdSpecial = /[!@#$%^&()'[\]"?+-/*={}.,;:_]+/;

        $('#changePass').click(function() {
            
            var v1=$('#new_pass').val();
            if(pwdLength.test(v1) && pwdUpper.test(v1) && pwdLower.test(v1) && pwdNumber.test(v1) && pwdSpecial.test(v1)){
                $('#frmError').hide();
                if($('#new_pass').val()==$('#new_pass2').val()) {
                    $('#frmError').hide();
                    $('#myfrmId').submit();
                } else {
                    $('#frmError').html('Password & confirmed Password should be same.');
                    $('#frmError').show();
                }
            }
            else{
                $('#frmError').show();
                $('#frmError').html('The minimum password length is 8 characters and must contain <br>at least 1 lowercase letter, <br>1 capital letter, <br>1 number, <br>and 1 special character.');
            }
            
        });
    </script>
    <script>
       

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/users/preset.blade.php ENDPATH**/ ?>