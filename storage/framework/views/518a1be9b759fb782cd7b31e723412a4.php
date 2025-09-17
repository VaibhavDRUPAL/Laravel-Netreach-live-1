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
                                    <th scope="col">Unique Serial Number</th>
                                    <th scope="col">Client Type</th>
                                    <th scope="col">Date Risk Assessment</th>
                                    <th scope="col">Had sex without a condom (high risk)</th>
                                    <th scope="col">Shared needle for injecting drugs (high risk)</th>
                                    <th scope="col">Having a sexually transmitted infection (STI)  (high risk)</th>
                                    <th scope="col">Sex with more than one partners (medium risk)</th>
                                    <th scope="col">Had chemical stimulant or alcohol before sex (medium risk) </th>
                                    <th scope="col">Had sex in exchange of goods or money (medium risk)</th>
                                    <th scope="col">Other reason for HIV test (please specify)</th>
                                    <th scope="col">Risk Category</th>                                                                      
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
            "url": "<?php echo e(route('all.riskassesment.report')); ?>",
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


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/manual1/risk-assesment.blade.php ENDPATH**/ ?>