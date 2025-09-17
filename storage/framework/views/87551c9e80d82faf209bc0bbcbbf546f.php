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
					<h1 class="font4"> <b> Lets Get Going </b> </h1>
					<h4 class="font5" style=""> Help Us Get To Know You Better </h4>
					<?php echo e(Form::open(array('url' => '/letsgo_second'))); ?>

					<h5 class="mt-4"><b>Your Age </b></h5>
					<p><input type="text" placeholder="Enter your age" name="age_limt" id="age_limt" min="1" max="3" value="<?php echo e(Session::get('age_limt')); ?>" class="required agelimt w-sm-100" data-bind="number"></p>

					<div class="row">
						<div class="col-6 col-md-4 text-left">
							<a href="/" class="btn_back">
								<img src="<?php echo e(asset('assets/img/web/left_arrow.png')); ?>" style="width:100px">
							</a>
						</div>

						<div class="col-6 col-md-4 text-right">
							<input type="submit" id="submit" class="btn_next" name="" value="">
						</div>
					</div>
					<?php echo e(Form::close()); ?>

				</div>


				<div class="col-md-5 px-0 d-block d-sm-none">
					<div class="card border-0">
						<img src="<?php echo e(asset('assets/img/web/q1.png')); ?>" class="card-img-top rounded-0" alt="...">
					</div>
				</div>
			</div>
			<!--row-->


		</div>
		<!--container-->
	</div>
	<!--banner-caption-->
</section>
<!--landing-sec-1-->

<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
	//$("#fname").hide();
	/*$("#age_limt").keypress(function (evt){
		var theEvent = evt || window.event;
		var key = theEvent.keyCode || theEvent.which;
		key = String.fromCharCode( key );
		var regex = /[-\d\.]/; // dowolna liczba (+- ,.) :)
		var objRegex = /^-?\d*[\.]?\d*$/;
		var val = $(evt.target).val();
		if(!regex.test(key) || !objRegex.test(val+key) || 
				!theEvent.keyCode == 46 || !theEvent.keyCode == 8) {
			theEvent.returnValue = false;
			if(theEvent.preventDefault) theEvent.preventDefault();
		};
		if(val.toString().length > 2){
			theEvent.returnValue = false;
			theEvent.preventDefault();
		}
		
		if(parseInt(val)>100){
			$(evt.target).val(100);
			theEvent.returnValue = false;
			theEvent.preventDefault();
		}
		
	}); */
	/*function identify_cust(i){
		if(i==6)
			$("#fname").show();			
		else
			$("#fname").hide();
	}*/

	$(document).ready(function() {
		$(document).prop('title','Lets go|NETREACH');
		$('#submit').click(function() {
			//alert("ff");
			var mesg = {};
			if (hiv.validate(mesg)) {
				return true;
			}
			return false;
		});
	});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.apphome', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/home/survey/page_second.blade.php ENDPATH**/ ?>