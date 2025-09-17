<?php $__env->startPush('styles'); ?>
<style>
.custom-control-inline {   
    margin-right: 0rem !important;
}
form#another-element {
  padding: 15px;
  border: 1px solid #666;
  background: #fff;
  display: none;
  margin-top: 20px;
}

.required-field::before {
  content: "*";
  color: red;
  float: right;
}


.assessment_date{display:none;}
.referral_date{display:none;}
.acess_date{display:none;}

</style>

<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>


    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <div>					    
							
							<table class="table table-hover align-items-center" id="survy_data_tbl_id">
                                <thead class="thead-light">
                                <tr>									
                                    <th scope="col">Unique serial number</th>
                                    <th scope="col">NETREACH UID Number</th>
                                    <th scope="col">Client type</th>
                                    <th scope="col">Name of the client</th>
                                    <th scope="col">Educational Attainment </th>
                                    <th scope="col">Primary Occupation of the client</th>
                                    <th scope="col">If Other, Specify </th>
                                    <th scope="col">Provided the client with Information and BCC   </th>
                                    <th scope="col">If Yes, types of BCC provided</th>
                                    <th scope="col">Type of service</th>
                                    <th scope="col">If others, please specify</th>
                                    <th scope="col">If referred for TI service </th>
                                    <th scope="col">If others, please specify</th>
                                    <th scope="col">Referred to NETREACH Counselor</th>
                                    <th scope="col">Ever had a HIV test as part of any Targeted Intervention programme or other HIV prevention programme</th>
                                    <th scope="col">Type of facility where referred</th>
                                    <th scope="col">Date of referral </th>
                                    <th scope="col">Name and address of referral centre </th>
                                    <th scope="col">Referred Centre State</th>
                                    <th scope="col">Referred Centre District</th>
                                    <th scope="col">Type of facility where tested</th>
                                    <th scope="col">Name and Address where service accessed </th>                                    
                                    <th scope="col">If different from where referred</th>                                    
                                    <th scope="col">Date of accessing service</th>                                    
                                    <th scope="col">Applicable for HIV test</th>                                    
                                    <th scope="col">Applicable for STI service</th>                                    
                                    <th scope="col">PID or other  unique ID of the client provided at the service centre </th>                                    
                                    <th scope="col">Outcome of the service sought</th>                                    
                                    <th scope="col">Reason for not accessing service</th>                                    
                                    <th scope="col">If others, please specify</th>                                    
                                    <th scope="col">Follow up date </th>                                    
                                    <th scope="col">Remarks</th>                                    
                                </tr>
                                </thead>
                                <tbody></tbody>
								
								</table>
								
							
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?> 
<link rel="stylesheet" href="<?php echo e(asset('assets/css/jquery-ui.css')); ?>">
<script src="<?php echo e(asset('assets/js/jquery-ui.js')); ?>"></script>
<script src="<?php echo e(asset('assets/vendor/custom_alert/bootbox.all.min.js')); ?>"></script>
<link rel="stylesheet" media="all" href="<?php echo e(asset('assets/css/jquery.dataTables.css')); ?>">
<script type="text/javascript" charset="utf8" src="<?php echo e(asset('assets/js/jquery.dataTables.min.js')); ?>"></script>

    <script>
      
	$(document).ready(function() {
		
	    var dataTableObj = $('#survy_data_tbl_id').dataTable({
        "processing": true,
		"serverSide": true,	
		"bDestroy": true,
		"searching": false,
		"bPaginate": true,
		"sDom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",		
        "ajax": {
            "url": "<?php echo e(route('all.referralservice.report')); ?>",
            "type": "POST",
			"data": function(d){  d._token = "<?php echo csrf_token() ?>" }
        }
		
      });
	
	  $("#btn_serch").click(function(){					
			dataTableObj.fnDraw();			
	  });

	  
	});
		
	

	
	
	
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('modal'); ?> 				
						
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/manual1/referralservice.blade.php ENDPATH**/ ?>