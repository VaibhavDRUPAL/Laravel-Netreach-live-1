<?php $__env->startSection('content'); ?>
	
    <div class="row dashboard-ab">

      
		<div class="container-fluid">
			<div class="row">
				<!--<div class="col-md-4">
					<div class="card mt-4">
						<div class="card-header">Pie Chart</div>
						<div class="card-body">
							<div class="chart-container pie-chart">
								<canvas id="pie_chart"></canvas>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="card mt-4">
						<div class="card-header">Doughnut Chart</div>
						<div class="card-body">
							<div class="chart-container pie-chart">
								<canvas id="doughnut_chart"></canvas>
							</div>
						</div>
					</div>
				</div>-->
				<div class="col-md-6">
					<div class="card mt-6 mb-6">
						<div class="card-header">Total Outreach </div>
						<div class="card-body">
						    <!--<button type="button" class="btn-sm btn-warning"  onclick="return outreachDateRange;" >Date</button>-->
							<div id="date_range_out" class="row" >
                            <input type="date" name="outdate_to" class="form-control input-sm"  style="width: 142px;height:30px;float: left;"><input type="date" name="outdate_from" class="form-control input-sm" style="width: 142px;height:30px;" >
                             <button type="button" class="btn-sm btn-warning" onclick="return DateBtnTotaloutreach();"  >Submit</button>
                             </div>
							<button type="button" class="btn-sm btn-warning"  onclick="return makechart(2);" >Application Used</button> 
							<button type="button" class="btn-sm btn-warning" onclick="return makechart(1);" >Typology</button>
							
							<!--<div id="date_range_out">
                            <input type="date" name="outdate_to" class="form-control input-sm"  style="width: 142px;float: left;"><input type="date" name="outdate_from" class="form-control input-sm" style="width: 142px;" >
                             <button type="button" class="btn-sm btn-warning" onclick="return DateBtnTotaloutreach();"  >Submit</button>
                             </div>-->
					   </div>
						<div class="card-body">
							
							<div class="chart-container pie-chart">
								<canvas id="bar_chart"></canvas>
							</div>
						</div>
					</div>
				</div>
				
				
				<div class="col-md-6">
					<div class="card mt-6 mb-6">
						<div class="card-header">Total Risk Assessment </div>
						<div class="card-body">
						<!--<button type="button" class="btn-sm btn-warning"  onclick="return outreachDateRange;" >Date</button>-->
							<div id="date_range_out" class="row" >
                            <input type="date" name="outdate_to" class="form-control input-sm"  style="width: 142px;height:30px;float: left;"><input type="date" name="outdate_from" class="form-control input-sm" style="width: 142px;height:30px;" >
                             <button type="button" class="btn-sm btn-warning" onclick="return DateBtnTotaloutreach();"  >Submit</button>
                             </div>
							<button type="button" class="btn-sm btn-warning" onclick="return makechartTotalRisk(1);" >Virtual navigators </button>
							<!--<button type="button" class="btn-sm btn-warning"  onclick="return totalRiskDateRange();" >Date</button> -->
							
							<button type="button" class="btn-sm btn-warning" onclick="return makechartTotalRisk(3);" >Region</button>
							<button type="button" class="btn-sm btn-warning" onclick="return makechartTotalRisk(4);" >State</button>
							 <!--<div id="date_range">
								<input type="date" name="date_to" class="form-control input-sm"  style="width: 142px;float: left;"><input type="date" name="date_from" class="form-control input-sm" style="width: 142px;" >
								<button type="button" class="btn-sm btn-warning" onclick="return DateBtnTotalRisk();"  >Submit</button>
							 </div>-->
							
					   </div>
						<div class="card-body">
							
							<div class="chart-container bar_chart_risk">
								<canvas id="bar_chart_risk"></canvas>
							</div>
						</div>
					</div>
				</div>
				
				<!--Referred for Services with Bifurcation--->
				<div class="col-md-6">
					<div class="card mt-1 mb-1">
						<div class="card-header">Referred for Services with Bifurcation  </div>
						<div class="card-body">
						<!--<button type="button" class="btn-sm btn-warning"  onclick="return outreachDateRange;" >Date</button>-->
							<div id="date_range_out" class="row" >
                            <input type="date" name="outdate_to" class="form-control input-sm"  style="width: 142px;height:30px;float: left;"><input type="date" name="outdate_from" class="form-control input-sm" style="width: 142px;height:30px;" >
                             <button type="button" class="btn-sm btn-warning" onclick="return DateBtnTotaloutreach();"  >Submit</button>
                             </div>
						
							   
							<button type="button" class="btn-sm btn-warning"  onclick="return makechartReferredServices(1);" >Type of Service </button>
							<!--<button type="button" class="btn-sm btn-warning"  onclick="return ReferredServicesDateRange();" >Date</button>--> 
							
							<button type="button" class="btn-sm btn-warning"  onclick="return getRegion();">Region</button>
							<button type="button" class="btn-sm btn-warning"  onclick="return getState();" >State</button>
							<button type="button" class="btn-sm btn-warning"  onclick="return getNavigator();" >Virtual Navigators</button>
							<button type="button" class="btn-sm btn-warning"  onclick="return getHealthFac();" >health facility (Govt, Pvt, NGO, TI)</button>
							<button type="button" class="btn-sm btn-warning"  onclick="return getTopology();">Typology</button>
							<button type="button" class="btn-sm btn-warning"  onclick="return getRisk();" >Risk category</button>
							<!--<button type="button" class="btn-sm btn-warning"  onclick="return makechartReferredServices(5);" >Type of test</button>-->
							<button type="button" class="btn-sm btn-warning"   onclick="return getClientType();" >Client type</button>
							 <!--<div id="date_range_service" style="display:none;">
								<input type="date" name="dates_to" class="form-control input-sm"  style="width: 142px;float: left;"><input type="date" name="dates_from" class="form-control input-sm" style="width: 142px;" >
								<button type="button" class="btn-sm btn-warning" onclick="return makechartReferredServices('date','');"  >Submit</button>
							 </div>-->
							
					   </div>
					    
						<div class="card-body">
						<!-- Region Buttons-->
							<div class="row" id="regionDir" style="display:none">
                               <div class="col-3"><button type="button" class="btn-sm btn-primary dir-btn" onclick="return makechartReferredServices('N')" >North</button></div>

							   <div class="col-3"><button type="button" class="btn-sm btn-light dir-btn" onclick="return makechartReferredServices('S');">South</button></div>

							   <div class="col-3"><button type="button" class="btn-sm btn-info dir-btn" onclick="return makechartReferredServices('E');" >East</button></div>

							   <div class="col-3"><button type="button" class="btn-sm btn-dark dir-btn" onclick="return makechartReferredServices('W');" >West</button></div>
							</div>
							<!-- Risk Buttons-->
							<div class="row" id="riskSec" style="display:none">
                               <div class="col-4"><button type="button" class="btn-sm btn-primary" onclick="return makechartReferredServices('risk','High Risk')" >High Risk</button></div>

							   <div class="col-4"><button type="button" class="btn-sm btn-success" onclick="return makechartReferredServices('risk','May be Low Risk');">May be Low Risk</button></div>

							   <div class="col-4"><button type="button" class="btn-sm btn-info" onclick="return makechartReferredServices('risk','Medium Risk');" >Medium Risk</button></div>
							</div>
							
							<!-- Client type Buttons-->
							<div class="row" id="clientSec" style="display:none">
                               <div class="col-4"><button type="button" class="btn-sm btn-primary" onclick="return makechartReferredServices('client','1')" >New Client</button></div>

							   <div class="col-4"><button type="button" class="btn-sm btn-success" onclick="return makechartReferredServices('client','2');">Follow Up Client</button></div>
							</div>
							
							<!-- Health Facility Buttons-->
							<div class="row" id="healthSec" style="display:none">
                               <div class="col-2"><button type="button" class="btn-sm btn-primary" onclick="return makechartReferredServices('facility','ICTC')" >ICTC</button></div>

							   <div class="col-3"><button type="button" class="btn-sm btn-success" onclick="return makechartReferredServices('facility','FICTC');">FICTC</button></div>

							   <div class="col-2"><button type="button" class="btn-sm btn-info" onclick="return makechartReferredServices('facility','ART');" >ART</button></div>
							   
							    <div class="col-2"><button type="button" class="btn-sm btn-dark" onclick="return makechartReferredServices('facility','TI');" >TI</button></div>
								
								<div class="col-3"><button type="button" class="btn-sm btn-danger" onclick="return makechartReferredServices('facility','Private');" >Private lab</button></div>
							</div>
							
							<!-- Risk uttons-->
							<div class="row" id="riskSec" style="display:none">
                               <div class="col-4"><button type="button" class="btn-sm btn-primary" onclick="return makechartReferredServices('risk','High Risk')" >High Risk</button></div>

							   <div class="col-4"><button type="button" class="btn-sm btn-success" onclick="return makechartReferredServices('risk','May be Low Risk');">May be Low Risk</button></div>

							   <div class="col-4"><button type="button" class="btn-sm btn-info" onclick="return makechartReferredServices('risk','Medium Risk');" >Medium Risk</button></div>
							</div>

							<div class="row" id="stateSec" style="display:none">
								<div class="col-4">
									<label>Select State</label>
								</div>

							   <div class="col-8">
                                   <select  class="form-control" onChange="makechartReferredServices('state',this.value)">
									 <option value="" disabled selected>Select State</option>
									 <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									   <option value="<?php echo e($state->state_code); ?>"><?php echo e($state->state_name); ?></option>
									  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								   </select>
							   </div>
							</div>
							
							<div class="row" id="vnSec" style="display:none">
								<div class="col-4">
									<label>Select Virtual Navigators</label>
								</div>
                               
							   <div class="col-8">
                                   <select class="form-control" onChange="makechartReferredServices('vn',this.value)">
									 <option value="" disabled selected>---Selec---</option>
									
									 <?php $__currentLoopData = $user_info; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $users): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									   <option value="<?php echo e($users->id); ?>"><?php echo e($users->name." ".$users->last_name); ?></option>
									  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								   </select>
							   </div>
							</div>
							<div class="row" id="topologySec" style="display:none">
								<div class="col-4">
									<label>Select Topology</label>
								</div>
                               
							   <div class="col-8">
                                   <select class="form-control" onChange="makechartReferredServices('topology',this.value)">
									 <option value="" disabled selected>---Selec---</option>
									
									 <?php $__currentLoopData = $typologies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topology): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									  <?php if($topology->target_population == ''): ?>
										 <option value=""><?php echo e("Blank"); ?></option>
									  <?php else: ?>
										  <option value="<?php echo e($topology->target_population); ?>"><?php echo e($topology->target_population); ?></option>
										<?php endif; ?>
									   
									  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								   </select>
							   </div>
							</div>
							<br>

							<div class="chart-container bar_chart_referred">
								<canvas id="bar_chart_referred"></canvas>
							</div>
						</div>
					</div>
				</div>
				<!--Availed Services--->
				<div class="col-md-6">
					<div class="card mt-1 mb-1">
						<div class="card-header">Availed Services  </div>
						<div class="card-body">
						<!--<button type="button" class="btn-sm btn-warning"  onclick="return outreachDateRange;" >Date</button>-->
							<div id="date_range_out" class="row" >
                            <input type="date" name="outdate_to" class="form-control input-sm"  style="width: 142px;height:30px;float: left;"><input type="date" name="outdate_from" class="form-control input-sm" style="width: 142px;height:30px;" >
                             <button type="button" class="btn-sm btn-warning" onclick="return DateBtnTotaloutreach();"  >Submit</button>
                             </div>
							
							<!--<button type="button" class="btn-sm btn-warning"  onclick="return AvailedServicesDateRange();" >Date</button>-->
							<button type="button" class="btn-sm btn-warning"  onclick="return avgetRegion();">Region</button>
							<button type="button" class="btn-sm btn-warning"  onclick="return avgetState();" >State</button>
							<button type="button" class="btn-sm btn-warning"  onclick="return avgetNavigator();" >Virtual Navigators</button>
							<button type="button" class="btn-sm btn-warning"  onclick="return avgetHealthFac();" >Health facility (Govt, Pvt, NGO, TI)</button>
							<button type="button" class="btn-sm btn-warning"  onclick="return avgetTopology();">Typology</button>
							<button type="button" class="btn-sm btn-warning"  onclick="return avgetRisk();" >Risk category</button>
							<!--<button type="button" class="btn-sm btn-warning"  onclick="return makechartAvailedServices(5);" >Type of test</button>-->
							<button type="button" class="btn-sm btn-warning"   onclick="return avgetClientType();" >Client type</button>
							 <!--<div id="date_range_av" style="display:none;">
								<input type="date" name="avdate_to" class="form-control input-sm"  style="width: 142px;float: left;"><input type="date" name="avdate_from" class="form-control input-sm" style="width: 142px;" >
								<button type="button" class="btn-sm btn-warning" onclick="return makechartAvailedServices('date','');"  >Submit</button>
							 </div>-->
							
					   </div>
					    
						<div class="card-body">
						<!-- Region Buttons-->
							<div class="row" id="avregionDir" style="display:none">
                               <div class="col-3"><button type="button" class="btn-sm btn-primary dir-btn" onclick="return makechartAvailedServices('N')" >North</button></div>

							   <div class="col-3"><button type="button" class="btn-sm btn-light dir-btn" onclick="return makechartAvailedServices('S');">South</button></div>

							   <div class="col-3"><button type="button" class="btn-sm btn-info dir-btn" onclick="return makechartAvailedServices('E');" >East</button></div>

							   <div class="col-3"><button type="button" class="btn-sm btn-dark dir-btn" onclick="return makechartAvailedServices('W');" >West</button></div>
							</div>
							
							<!-- Health Facility Buttons-->
							<div class="row" id="avhealthSec" style="display:none">
                               <div class="col-2"><button type="button" class="btn-sm btn-primary" onclick="return makechartAvailedServices('facility','ICTC')" >ICTC</button></div>

							   <div class="col-3"><button type="button" class="btn-sm btn-success" onclick="return makechartAvailedServices('facility','FICTC');">FICTC</button></div>

							   <div class="col-2"><button type="button" class="btn-sm btn-info" onclick="return makechartAvailedServices('facility','ART');" >ART</button></div>
							   
							    <div class="col-2"><button type="button" class="btn-sm btn-dark" onclick="return makechartAvailedServices('facility','TI');" >TI</button></div>
								
								<div class="col-3"><button type="button" class="btn-sm btn-danger" onclick="return makechartAvailedServices('facility','Private');" >Private lab</button></div>
							</div>
							
							
							<!-- Risk Buttons-->
							<div class="row" id="avriskSec" style="display:none">
                               <div class="col-4"><button type="button" class="btn-sm btn-primary" onclick="return makechartAvailedServices('risk','High Risk')" >High Risk</button></div>

							   <div class="col-4"><button type="button" class="btn-sm btn-success" onclick="return makechartAvailedServices('risk','May be Low Risk');">May be Low Risk</button></div>

							   <div class="col-4"><button type="button" class="btn-sm btn-info" onclick="return makechartAvailedServices('risk','Medium Risk');" >Medium Risk</button></div>
							</div>
							
							<!-- Client type Buttons-->
							<div class="row" id="avclientSec" style="display:none">
                               <div class="col-4"><button type="button" class="btn-sm btn-primary" onclick="return makechartAvailedServices('client','1')" >New Client</button></div>

							   <div class="col-4"><button type="button" class="btn-sm btn-success" onclick="return makechartAvailedServices('client','2');">Follow Up Client</button></div>
							</div>
							
							<!-- Health Facility Buttons-->
							<div class="row" id="avhealthSec" style="display:none">
                               <div class="col-4"><button type="button" class="btn-sm btn-primary " onclick="return makechartAvailedServices('risk','High Risk')" >High Risk</button></div>

							   <div class="col-4"><button type="button" class="btn-sm btn-success" onclick="return makechartAvailedServices('risk','May be Low Risk');">May be Low Risk</button></div>

							   <div class="col-4"><button type="button" class="btn-sm btn-info" onclick="return makechartAvailedServices('risk','Medium Risk');" >Medium Risk</button></div>
							</div>
							<div class="row" id="avriskSec" style="display:none">
                               <div class="col-4"><button type="button" class="btn-sm btn-primary" onclick="return makechartAvailedServices('risk','High Risk')" >High Risk</button></div>

							   <div class="col-4"><button type="button" class="btn-sm btn-success" onclick="return makechartAvailedServices('risk','May be Low Risk');">May be Low Risk</button></div>

							   <div class="col-4"><button type="button" class="btn-sm btn-info" onclick="return makechartAvailedServices('risk','Medium Risk');" >Medium Risk</button></div>
							</div>

							<div class="row" id="avstateSec" style="display:none">
								<div class="col-4">
									<label>Select State</label>
								</div>

							   <div class="col-8">
                                   <select  class="form-control" onChange="makechartAvailedServices('state',this.value)">
									 <option value="" disabled selected>Select State</option>
									 <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									   <option value="<?php echo e($state->state_code); ?>"><?php echo e($state->state_name); ?></option>
									  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								   </select>
							   </div>
							</div>
							
							<div class="row" id="avvnSec" style="display:none">
								<div class="col-4">
									<label>Select Virtual Navigators</label>
								</div>
                               
							   <div class="col-8">
                                   <select class="form-control" onChange="makechartAvailedServices('vn',this.value)">
									 <option value="" disabled selected>---Selec---</option>
									
									 <?php $__currentLoopData = $user_info; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $users): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									   <option value="<?php echo e($users->id); ?>"><?php echo e($users->name." ".$users->last_name); ?></option>
									  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								   </select>
							   </div>
							</div>
							<div class="row" id="avtopologySec" style="display:none">
								<div class="col-4">
									<label>Select Topology</label>
								</div>
                               
							   <div class="col-8">
                                   <select class="form-control" onChange="makechartAvailedServices('topology',this.value)">
									 <option value="" disabled selected>---Selec---</option>
									
									 <?php $__currentLoopData = $typologies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topology): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									  <?php if($topology->target_population == ''): ?>
										 <option value=""><?php echo e("Blank"); ?></option>
									  <?php else: ?>
										  <option value="<?php echo e($topology->target_population); ?>"><?php echo e($topology->target_population); ?></option>
										<?php endif; ?>
									   
									  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								   </select>
							   </div>
							</div>
							<br>

							<div class="chart-container bar_chart_availed">
								<canvas id="bar_chart_availed"></canvas>
							</div>
						</div>
					</div>
				</div>
			<!------- End availed srvices --->
			<!--HIV Positivity Rate --->
			  <div class="col-md-6">
					<div class="card mt-1 mb-1">
						<div class="card-header">
							  <div class="row">
								 <div class="col-6">HIV Positivity Rate</div>
								 <div class="col-6 text-right">
								 <a href="#" id="hivpdf">Export as PDF</a>
								</div>
							  </div>
							
						</div>
						<div class="card-body">
						<!--<button type="button" class="btn-sm btn-warning"  onclick="return outreachDateRange;" >Date</button>-->
							<div id="date_range_out" class="row" >
                            <input type="date" name="outdate_to" class="form-control input-sm"  style="width: 142px;height:30px;float: left;"><input type="date" name="outdate_from" class="form-control input-sm" style="width: 142px;height:30px;" >
                             <button type="button" class="btn-sm btn-warning" onclick="return DateBtnTotaloutreach();"  >Submit</button>
                             </div>
							
							
							<button type="button" class="btn-sm btn-warning"  onclick="return hivRategetNavigator();" >Virtual Navigators</button>
							<button type="button" class="btn-sm btn-warning"  onclick="return hivRategetTopology();">Typology</button>
							<button type="button" class="btn-sm btn-warning"  onclick="return hivRategetRegion();">Region</button>
							<button type="button" class="btn-sm btn-warning"  onclick="return hivRategetState();" >State</button>
							<!--<button type="button" class="btn-sm btn-warning"  onclick="return hivRateDateRange();" >Date</button>-->
							
							 <!--<div id="date_range_hiv" style="display:none;">
								<input type="date" name="hivdate_to" class="form-control input-sm"  style="width: 142px;float: left;"><input type="date" name="hivdate_from" class="form-control input-sm" style="width: 142px;" >
								<button type="button" class="btn-sm btn-warning" onclick="return makechartHIVPositive('date','');"  >Submit</button>
							 </div>-->
							
					   </div>
					    
						<div class="card-body">
						<!-- Region Buttons-->
							<div class="row" id="hivRateregionDir" style="display:none">
                               <div class="col-3"><button type="button" class="btn-sm btn-primary dir-btn" onclick="return makechartHIVPositive('N')" >North</button></div>

							   <div class="col-3"><button type="button" class="btn-sm btn-light dir-btn" onclick="return makechartHIVPositive('S');">South</button></div>

							   <div class="col-3"><button type="button" class="btn-sm btn-info dir-btn" onclick="return makechartHIVPositive('E');" >East</button></div>

							   <div class="col-3"><button type="button" class="btn-sm btn-dark dir-btn" onclick="return makechartHIVPositive('W');" >West</button></div>
							</div>
							
							
							<!-- State Buttons-->
							
							<div class="row" id="hivRatestateSec" style="display:none">
								<div class="col-4">
									<label>Select State</label>
								</div>

							   <div class="col-8">
                                   <select  class="form-control" onChange="makechartHIVPositive('state',this.value)">
									 <option value="" disabled selected>Select State</option>
									 <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									   <option value="<?php echo e($state->state_code); ?>"><?php echo e($state->state_name); ?></option>
									  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								   </select>
							   </div>
							</div>
							
							<div class="row" id="hivRatevnSec" style="display:none">
								<div class="col-4">
									<label>Select Virtual Navigators</label>
								</div>
                               
							   <div class="col-8">
                                   <select class="form-control" onChange="makechartHIVPositive('vn',this.value)">
									 <option value="" disabled selected>---Selec---</option>
									
									 <?php $__currentLoopData = $user_info; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $users): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									   <option value="<?php echo e($users->id); ?>"><?php echo e($users->name." ".$users->last_name); ?></option>
									  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								   </select>
							   </div>
							</div>
							<div class="row" id="hivRatetopologySec" style="display:none">
								<div class="col-4">
									<label>Select Topology</label>
								</div>
                               
							   <div class="col-8">
                                   <select class="form-control" onChange="makechartHIVPositive('topology',this.value)">
									 <option value="" disabled selected>---Selec---</option>
									
									 <?php $__currentLoopData = $typologies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topology): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									  <?php if($topology->target_population == ''): ?>
										 <option value=""><?php echo e("Blank"); ?></option>
									  <?php else: ?>
										  <option value="<?php echo e($topology->target_population); ?>"><?php echo e($topology->target_population); ?></option>
										<?php endif; ?>
									   
									  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								   </select>
							   </div>
							</div>
							<br>
                            <div>
							
							</div>
							<div class="chart-container line_chart_hiv_positive">
								<canvas id="line_chart_hiv_positive"></canvas>
								
							</div>
						</div>
					</div>
				</div>
		
			<!--ETotal HIV Referral and Conversational Rate -->
			<div class="col-md-6">
					<div class="card mt-1 mb-1">
						<div class="card-header">
							  <div class="row">
								 <div class="col-12">Total HIV Referral and Conversion Rate</div>
								
							  </div>
							
						</div>
						<div class="card-body">
						<!--<button type="button" class="btn-sm btn-warning"  onclick="return outreachDateRange;" >Date</button>-->
							<div id="date_range_out" class="row" >
                            <input type="date" name="outdate_to" class="form-control input-sm"  style="width: 142px;height:30px;float: left;"><input type="date" name="outdate_from" class="form-control input-sm" style="width: 142px;height:30px;" >
                             <button type="button" class="btn-sm btn-warning" onclick="return DateBtnTotaloutreach();"  >Submit</button>
                             </div>
							<button type="button" class="btn-sm btn-warning"  onclick="return hivRacrNavigator();" >Virtual Navigators</button>
							<button type="button" class="btn-sm btn-warning"  onclick="return hivRacrState();" >State</button>
					   </div>
					    
						<div class="card-body">
							<!-- State Buttons-->
							
							<div class="row" id="RacrstateSec" style="display:none">
								<div class="col-4">
									<label>Select State</label>
								</div>

							   <div class="col-8">
                                   <select  class="form-control" onChange="makechartHIVReferral('state',this.value)">
									 <option value="" disabled selected>Select State</option>
									 <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									   <option value="<?php echo e($state->state_code); ?>"><?php echo e($state->state_name); ?></option>
									  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								   </select>
							   </div>
							</div>
							
							<div class="row" id="RacrvnSec" style="display:none">
								<div class="col-4">
									<label>Select Virtual Navigators</label>
								</div>
                               
							   <div class="col-8">
                                   <select class="form-control" onChange="makechartHIVReferral('vn',this.value)">
									 <option value="" disabled selected>---Selec---</option>
									
									 <?php $__currentLoopData = $user_info; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $users): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									   <option value="<?php echo e($users->id); ?>"><?php echo e($users->name." ".$users->last_name); ?></option>
									  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								   </select>
							   </div>
							</div>
							<br>
                           
							<div class="chart-container line_chart_hiv_referral">
								<canvas id="line_chart_hiv_referral"></canvas>
								
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>
         <!----- End--->
		 <!--STI  Positivity Rate --->
		 <div class="col-md-6">
					<div class="card mt-1 mb-1">
						<div class="card-header">
							  <div class="row">
								 <div class="col-6">STI  Positivity Rate</div>
								 <div class="col-6 text-right">
								 <a href="#" id="stipdf">Export as PDF</a>
								</div>
							  </div>
							
						</div>
						<div class="card-body">
						<!--<button type="button" class="btn-sm btn-warning"  onclick="return outreachDateRange;" >Date</button>-->
							<div id="date_range_out" class="row" >
                            <input type="date" name="outdate_to" class="form-control input-sm"  style="width: 142px;height:30px;float: left;"><input type="date" name="outdate_from" class="form-control input-sm" style="width: 142px;height:30px;" >
                             <button type="button" class="btn-sm btn-warning" onclick="return DateBtnTotaloutreach();"  >Submit</button>
                             </div>
							
							
							<button type="button" class="btn-sm btn-warning"  onclick="return stiRategetNavigator();" >Virtual Navigators</button>
							<button type="button" class="btn-sm btn-warning"  onclick="return stiRategetTopology();">Typology</button>
							<button type="button" class="btn-sm btn-warning"  onclick="return stiRategetRegion();">Region</button>
							<button type="button" class="btn-sm btn-warning"  onclick="return stiRategetState();" >State</button>
							<!--<button type="button" class="btn-sm btn-warning"  onclick="return stiRateDateRange();" >Date</button> 
							
							 <div id="date_range_sti" style="display:none;">
								<input type="date" name="stidate_to" class="form-control input-sm"  style="width: 142px;float: left;"><input type="date" name="stidate_from" class="form-control input-sm" style="width: 142px;" >
								<button type="button" class="btn-sm btn-warning" onclick="return makechartSTIPositive('date','');"  >Submit</button>
							 </div>-->
							
					   </div>
					    
						<div class="card-body">
						<!-- Region Buttons-->
							<div class="row" id="stiRateregionDir" style="display:none">
                               <div class="col-3"><button type="button" class="btn-sm btn-primary dir-btn" onclick="return makechartSTIPositive('N')" >North</button></div>

							   <div class="col-3"><button type="button" class="btn-sm btn-light dir-btn" onclick="return makechartSTIPositive('S');">South</button></div>

							   <div class="col-3"><button type="button" class="btn-sm btn-info dir-btn" onclick="return makechartSTIPositive('E');" >East</button></div>

							   <div class="col-3"><button type="button" class="btn-sm btn-dark dir-btn" onclick="return makechartSTIPositive('W');" >West</button></div>
							</div>
							
							
							<!-- State Buttons-->
							
							<div class="row" id="stiRatestateSec" style="display:none">
								<div class="col-4">
									<label>Select State</label>
								</div>

							   <div class="col-8">
                                   <select  class="form-control" onChange="makechartSTIPositive('state',this.value)">
									 <option value="" disabled selected>Select State</option>
									 <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									   <option value="<?php echo e($state->state_code); ?>"><?php echo e($state->state_name); ?></option>
									  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								   </select>
							   </div>
							</div>
							
							<div class="row" id="stiRatevnSec" style="display:none">
								<div class="col-4">
									<label>Select Virtual Navigators</label>
								</div>
                               
							   <div class="col-8">
                                   <select class="form-control" onChange="makechartSTIPositive('vn',this.value)">
									 <option value="" disabled selected>---Selec---</option>
									
									 <?php $__currentLoopData = $user_info; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $users): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									   <option value="<?php echo e($users->id); ?>"><?php echo e($users->name." ".$users->last_name); ?></option>
									  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								   </select>
							   </div>
							</div>
							<div class="row" id="stiRatetopologySec" style="display:none">
								<div class="col-4">
									<label>Select Topology</label>
								</div>
                               
							   <div class="col-8">
                                   <select class="form-control" onChange="makechartSTIPositive('topology',this.value)">
									 <option value="" disabled selected>---Selec---</option>
									
									 <?php $__currentLoopData = $typologies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topology): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									  <?php if($topology->target_population == ''): ?>
										 <option value=""><?php echo e("Blank"); ?></option>
									  <?php else: ?>
										  <option value="<?php echo e($topology->target_population); ?>"><?php echo e($topology->target_population); ?></option>
										<?php endif; ?>
									   
									  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								   </select>
							   </div>
							</div>
							<br>
                            <div>
							
							</div>
							<div class="chart-container line_chart_sti_positive">
								<canvas id="line_chart_sti_positive"></canvas>
								
							</div>
						</div>
					</div>
				</div>

		
    </div>


    


       


<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<style>
.exp-btn{	
    width: 100%;
    text-align: right;
    padding: 0 0 8px 0px;
	display:none;
}
.dir-btn{
	width:inherit;
}
#date_range{display:none;}

</style>
<script>
function totalRiskDateRange(){
	$("#date_range").toggle();
} 


/** Referred Services **/
function getRegion()
{
	$('#regionDir').show();
	$('#stateSec,#vnSec,#topologySec,#riskSec,#clientSec,#date_range_service,#healthSec').hide();
	
}
function getState()
{
	$('#stateSec').show();
	$('#regionDir,#vnSec,#topologySec,#riskSec,#clientSec,#date_range_service,#healthSec').hide();
	//$('#vnSec').hide();
	//$('#topologySec').hide();
}
function getNavigator()
{
	$('#vnSec').show();
	$('#stateSec,#regionDir,#topologySec,#riskSec,#clientSec,#date_range_service,#healthSec').hide();
	//$('#regionDir').hide();
	//$('#topologySec').hide();
}
function getTopology()
{
	$('#topologySec').show();
	$('#vnSec,#stateSec,#regionDir,#riskSec,#clientSec,#date_range_service,#healthSec').hide();
	//$('#stateSec').hide();
	//$('#regionDir').hide();
}
function getRisk()
{
	$('#riskSec').show();
	$('#vnSec,#stateSec,#regionDir,#topologySec,#clientSec,#date_range_service,#healthSec').hide();
}
function getClientType()
{
	$('#clientSec').show();
	$('#vnSec,#stateSec,#regionDir,#topologySec,#riskSec,#date_range_service,#healthSec').hide();
}
function ReferredServicesDateRange(){
	$("#date_range_service").toggle();
	$('#vnSec,#stateSec,#regionDir,#topologySec,#riskSec,#clientSec,#healthSec').hide();
}

function getHealthFac(){
	$('#healthSec').show();
	$('#vnSec,#stateSec,#regionDir,#topologySec,#riskSec,#clientSec,#date_range_service').hide();
}


/** Availed Services **/
function avgetRegion()
{
	$('#avregionDir').show();
	$('#avstateSec,#avvnSec,#avtopologySec,#avriskSec,#avclientSec,#avdate_range_service,#avhealthSec').hide();
	
}
function avgetState()
{
	$('#avstateSec').show();
	$('#avregionDir,#avvnSec,#avtopologySec,#avriskSec,#avclientSec,#avdate_range_service,#avhealthSec').hide();
	
}
function avgetNavigator()
{
	$('#avvnSec').show();
	$('#avstateSec,#avregionDir,#avtopologySec,#avriskSec,#avclientSec,#avdate_range_service,#avhealthSec').hide();
	
}
function avgetTopology()
{
	$('#avtopologySec').show();
	$('#avvnSec,#avstateSec,#avregionDir,#avriskSec,#avclientSec,#avdate_range_service,#avhealthSec').hide();
	
}
function avgetRisk()
{
	$('#avriskSec').show();
	$('#avvnSec,#avstateSec,#avregionDir,#avtopologySec,#avclientSec,#avdate_range_service,#avhealthSec').hide();
}
function avgetClientType()
{
	$('#avclientSec').show();
	$('#avvnSec,#avstateSec,#avregionDir,#avtopologySec,#avriskSec,#avdate_range_service,#avhealthSec').hide();
}
function AvailedServicesDateRange(){
	$("#avdate_range_service").toggle();
	$('#avvnSec,#avstateSec,#avregionDir,#avtopologySec,#avriskSec,#avclientSec,#avhealthSec').hide();
}

function avgetHealthFac(){
	$('#avhealthSec').show();
	$('#avvnSec,#avstateSec,#avregionDir,#avtopologySec,#avriskSec,#avclientSec,#avdate_range_service').hide();
}


/** HIV Positive Services **/
function hivRategetNavigator(){
	$('#hivRatevnSec').show();
	$('#hivRatetopologySec,#hivRateregionDir,#hivRatestateSec,#date_range_hiv').hide();
}

function hivRategetTopology(){
	$('#hivRatetopologySec').show();
	$('#hivRatevnSec,#hivRateregionDir,#hivRatestateSec,#date_range_hiv').hide();
}

function hivRategetRegion(){
	$('#hivRateregionDir').show();
	$('#hivRatetopologySec,#hivRatevnSec,#hivRatestateSec,#date_range_hiv').hide();
}

function hivRategetState(){
	$('#hivRatestateSec').show();
	$('#hivRateregionDir,#hivRatetopologySec,#hivRatevnSec,#date_range_hiv').hide();
}

function hivRateDateRange(){
	$("#date_range_hiv").toggle();
	$('#hivRateregionDir,#hivRatetopologySec,#hivRateregionDir,#hivRatestateSec').hide();
}


/** STI Positive Services **/
function stiRategetNavigator(){
	$('#stiRatevnSec').show();
	$('#stiRatetopologySec,#stiRateregionDir,#stiRatestateSec,#date_range_sti').hide();
}

function stiRategetTopology(){
	$('#stiRatetopologySec').show();
	$('#stiRatevnSec,#stiRateregionDir,#stiRatestateSec,#date_range_sti').hide();
}

function stiRategetRegion(){
	$('#stiRateregionDir').show();
	$('#stiRatetopologySec,#stiRatevnSec,#stiRatestateSec,#date_range_sti').hide();
}

function stiRategetState(){
	$('#stiRatestateSec').show();
	$('#stiRateregionDir,#stiRatetopologySec,#stiRatevnSec,#date_range_sti').hide();
}

function stiRateDateRange(){
	$("#date_range_sti").toggle();
	$('#stiRateregionDir,#stiRatetopologySec,#stiRateregionDir,#stiRatestateSec').hide();
}


/** HIV Referral and conversation rate */
function hivRacrNavigator(){
	$("#RacrvnSec").show();
	$('#RacrstateSec').hide();
}
function hivRacrState(){
	$("#RacrstateSec").show();
	$('#RacrvnSec').hide();
}


makechart(1);
makecharttotal();
makechartTotalRisk(1);
makechartReferredServices(1,'');
makechartAvailedServices(1,'');
makechartHIVPositive('vn','1');
makechartHIVReferral('vn','1');
makechartSTIPositive('vn','1');
function makechart(type)
	{
			
		var DataJson =  {"_token": "<?php echo e(csrf_token()); ?>","type":type}
		$.ajax({
			url:"<?php echo e(route('dashboard.mereport.chart')); ?>",
			method:"POST",
			data:DataJson,
			dataType:"JSON",
			success:function(data)
			{	
				$(".pie-chart").html('<canvas id="bar_chart"></canvas>');
				
				var language = [];
				var total = [];
				var color = [];

				for(var count = 0; count < data.length; count++)
				{
					language.push(data[count].language);
					total.push(data[count].total);
					color.push(data[count].color);
				}

				var chart_data = {
					labels:language,
					datasets:[
						{
							label:'Report',
							backgroundColor:color,
							color:'#fff',
							data:total
						}
					]
				};

				var options = {
					responsive:true,
					scales:{
						yAxes:[{
							ticks:{
								min:0
							}
						}]
					},
					legend: {
						display: true
					},
					 tooltips: {
						enabled: true
					 }
				};

				var group_chart3 = $('#bar_chart');

				var graph3 = new Chart(group_chart3, {
					type:'pie',
					data:chart_data,
					//options:options
				});
			}
		});
	}
	function makecharttotal(type)
	{
			
		var DataJson =  {"_token": "<?php echo e(csrf_token()); ?>","type":type}
		$.ajax({
			url:"<?php echo e(route('dashboard.mereport.chart')); ?>",
			method:"POST",
			data:DataJson,
			dataType:"JSON",
			success:function(data)
			{	
				$(".pie-chart").html('<canvas id="bar_chart"></canvas>');
				
				var language = [];
				var total = [];
				var color = [];

				for(var count = 0; count < data.length; count++)
				{
					language.push(data[count].language);
					total.push(data[count].total);
					color.push(data[count].color);
				}

				var chart_data = {
					labels:language,
					datasets:[
						{
							label:'Report',
							backgroundColor:color,
							color:'#fff',
							data:total
						}
					]
				};

				var options = {
					responsive:true,
					scales:{
						yAxes:[{
							ticks:{
								min:0
							}
						}]
					},
					legend: {
						display: true
					},
					 tooltips: {
						enabled: true
					 }
				};

				var group_chart3 = $('#bar_chart');

				var graph3 = new Chart(group_chart3, {
					type:'pie',
					data:chart_data,
					//options:options
				});
			}
		});
	}
function DateBtnTotalRisk(){
	
	var to_date = $("input[name=date_to]").val();
	var date_from = $("input[name=date_from]").val();
	
	var DataJson =  {"_token": "<?php echo e(csrf_token()); ?>","type":2,"to_date":to_date,"date_from":date_from}
		$.ajax({
			url:"<?php echo e(route('dashboard.mereport.bar.chart')); ?>",
			method:"POST",
			data:DataJson,
			dataType:"JSON",
			success:function(data)
			{	
				$(".bar_chart_risk").html('<canvas id="bar_chart_risk"></canvas>');
				
				var language = [];
				var total = [];
				var color = [];

				for(var count = 0; count < data.length; count++)
				{
					language.push(data[count].language);
					total.push(data[count].total);
					color.push(data[count].color);
				}

				var chart_data = {
					labels:language,
					datasets:[
						{
							label:'Report',
							backgroundColor:color,
							color:'#fff',
							data:total
						}
					]
				};

				var options = {
					responsive:true,
					scales:{
						yAxes:[{
							ticks:{
								min:0,
								max: 100000
							}
						}]
					},
					legend: {
						display: true
					},
					 tooltips: {
						enabled: true
					 }
				};

				var group_chart2 = $('#bar_chart_risk');

				var graph3 = new Chart(group_chart2, {
					type:'bar',
					data:chart_data,
					options:options
				});
			}
		});
	
	
}	
function makechartTotalRisk(type){
	
	$("#date_range").hide();
	var DataJson =  {"_token": "<?php echo e(csrf_token()); ?>","type":type,"to_date":'',"date_from":''}
		$.ajax({
			url:"<?php echo e(route('dashboard.mereport.bar.chart')); ?>",
			method:"POST",
			data:DataJson,
			dataType:"JSON",
			success:function(data)
			{	
				$(".bar_chart_risk").html('<canvas id="bar_chart_risk"></canvas>');
				
				var language = [];
				var total = [];
				var color = [];

				for(var count = 0; count < data.length; count++)
				{
					language.push(data[count].language);
					total.push(data[count].total);
					color.push(data[count].color);
				}

				var chart_data = {
					labels:language,
					datasets:[
						{
							label:'Report',
							backgroundColor:color,
							color:'#fff',
							data:total
						}
					]
				};

				var options = {
					responsive:true,
					scales:{
						yAxes:[{
							ticks:{
								min:0,
								max: 100000
							}
						}]
					},
					legend: {
						display: true
					},
					 tooltips: {
						enabled: true
					 }
				};

				var group_chart2 = $('#bar_chart_risk');

				var graph3 = new Chart(group_chart2, {
					type:'bar',
					data:chart_data,
					options:options
				});
			}
		});
	
}	

/** Referred Services **/
function makechartReferredServices(type,value=""){
	//alert(type);
	/** Region wise data **/
	 if(type != 'N' || type != 'S' || type != 'E' || type != 'W'){
	 	$('#regionDir').hide();
	   
	}if(type == 'N' || type == 'S' || type == 'E' || type == 'W'){
		$('#regionDir').show();
	}
	
	/** State wise data **/
	 if(type != 'state'){
	 	$('#stateSec').hide();
	   
	}if(type == 'state'){
		$('#stateSec').show();
	}
	/* Virtual Navigator */
	if(type != 'vn'){
	 	$('#vnSec').hide();
	}
	/* Virtual Navigator */
	if(type != 'topology'){
	 	$('#topologySec').hide();
	}
	/* Risk Category */
	if(type != 'risk'){
	 	$('#riskSec').hide();
	}
	/* Client type Category */
	if(type != 'facility'){
	 	$('#healthSec').hide();
	} 
	
	var to_date = $("input[name=dates_to]").val();
	var date_from = $("input[name=dates_from]").val();
	//alert(to_date);
	
	var DataJson =  {"_token": "<?php echo e(csrf_token()); ?>","type":type,"value":value,"to_date":to_date,"date_from":date_from}
		$.ajax({
			url:"<?php echo e(route('dashboard.mereport.service.chart')); ?>",
			method:"POST",
			data:DataJson,
			dataType:"JSON",
			success:function(data)
			{	
				$(".bar_chart_referred").html('<canvas id="bar_chart_referred"></canvas>');
				
				var language = [];
				var total = [];
				var color = [];

				for(var count = 0; count < data.length; count++)
				{
					language.push(data[count].language);
					total.push(data[count].total);
					color.push(data[count].color);
				}

				var chart_data = {
					labels:language,
					datasets:[
						{
							label:'Report',
							backgroundColor:color,
							color:'#fff',
							data:total
						}
					]
				};

				var options = {
					responsive:true,
					scales:{
						yAxes:[{
							ticks:{
								min:0,
								max: 100000
							}
						}]
					},
					legend: {
						display: true,						
					},
					 tooltips: {
						enabled: true,												
					 }
				};

				var group_chart2 = $('#bar_chart_referred');

				var graph3 = new Chart(group_chart2, {
					type:'bar',
					data:chart_data,
					options:options
				});
			}
		});
	
	
}

/** Availed Services **/
function makechartAvailedServices(type,value=""){
	//alert(type);
	/** Region wise data **/
	 if(type != 'N' || type != 'S' || type != 'E' || type != 'W'){
	 	$('#avregionDir').hide();
	   
	}if(type == 'N' || type == 'S' || type == 'E' || type == 'W'){
		$('#avregionDir').show();
	}
	
	/** State wise data **/
	 if(type != 'state'){
	 	$('#avstateSec').hide();
	   
	}if(type == 'state'){
		$('#avstateSec').show();
	}
	/* Virtual Navigator */
	if(type != 'vn'){
	 	$('#avvnSec').hide();
	}
	/* Virtual Navigator */
	if(type != 'topology'){
	 	$('#avtopologySec').hide();
	}
	/* Risk Category */
	if(type != 'risk'){
	 	$('#avriskSec').hide();
	}
	/* Client type Category */
	if(type != 'facility'){
	 	$('#avhealthSec').hide();
	} 
	
	var to_date = $("input[name=avdate_to]").val();
	var date_from = $("input[name=avdate_from]").val();

	
	var DataJson =  {"_token": "<?php echo e(csrf_token()); ?>","type":type,"value":value,"to_date":to_date,"date_from":date_from}
		$.ajax({
			url:"<?php echo e(route('dashboard.mereport.availed.chart')); ?>",
			method:"POST",
			data:DataJson,
			dataType:"JSON",
			success:function(data)
			{	
				$(".bar_chart_availed").html('<canvas id="bar_chart_availed"></canvas>');
				
				var language = [];
				var total = [];
				var color = [];

				for(var count = 0; count < data.length; count++)
				{
					language.push(data[count].language);
					total.push(data[count].total);
					color.push(data[count].color);
				}

				var chart_data = {
					labels:language,
					datasets:[
						{
							label:'Report',
							backgroundColor:color,
							color:'#fff',
							data:total
						}
					]
				};

				var options = {
					responsive:true,
					scales:{
						yAxes:[{
							ticks:{
								min:0,
								max: 100000
							}
						}]
					},
					legend: {
						display: true,						
					},
					 tooltips: {
						enabled: true,												
					 }
				};

				var group_chart2 = $('#bar_chart_availed');

				var graph3 = new Chart(group_chart2, {
					type:'bar',
					data:chart_data,
					options:options
				});
			}
		});
}


/** HIV Positive Rate  **/

function makechartHIVPositive(type,value=""){
 
	/** Region wise data **/
	if(type != 'N' || type != 'S' || type != 'E' || type != 'W'){
	 	$('#hivRateregionDir').hide();
	   
	}if(type == 'N' || type == 'S' || type == 'E' || type == 'W'){
		$('#hivRateregionDir').show();
	}
	
	/** State wise data **/
	 if(type != 'state'){
	 	$('#hivRatestateSec').hide();
	   
	}if(type == 'state'){
		$('#hivRatestateSec').show();
	}
	/* Virtual Navigator */
	if(type != 'vn'){
	 	$('#hivRatevnSec').hide();
	}
	/* Virtual Navigator */
	if(type != 'topology'){
	 	$('#hivRatetopologySec').hide();
	}
	
	var to_date = $("input[name=hivdate_to]").val();
	var date_from = $("input[name=hivdate_from]").val();
	var DataJson =  {"_token": "<?php echo e(csrf_token()); ?>","type":type,"value":value,"to_date":to_date,"date_from":date_from}
    $.ajax({
		url:"<?php echo e(route('dashboard.mereport.hivrate.chart')); ?>",
			method:"POST",
			data:DataJson,
			dataType:"JSON",
			success:function(data){
				$(".line_chart_hiv_positive").html('<canvas id="line_chart_hiv_positive"></canvas>');
				
				var language = [];
				var total = [];
				var color = [];

				for(var count = 0; count < data.length; count++)
				{
					language.push(data[count].language);
					total.push(data[count].total);
					color.push(data[count].color);
				}
                console.log(total);
				var chart_data = {
					labels:language,
					datasets:[
						{
							label:'HIV Positive Rate ('+total+')',
							backgroundColor:color,
							color:'#fff',
							fillColor: "rgba(254, 164, 0, 1)",
							highlightFill: "rgba(254, 164, 0, 1)",
							borderColor: 'rgb(75, 192, 192)',
							data:total
						}
					]
				};

				var options = {
					responsive:true,
					scales:{
						yAxes:[{
							ticks:{
								min:0,
								max: 100000
							}
						}]
					},
					legend: {
						display: true,						
					},
					 tooltips: {
						enabled: true,												
					 }
				};

				var group_chart2 = $('#line_chart_hiv_positive');

				var graph3 = new Chart(group_chart2, {
					type:'line',
					data:chart_data,
					options:options
				});
			}
	});	
		
}
   /** STI Positive Rate  **/

function makechartSTIPositive(type,value=""){

	/** Region wise data **/
	if(type != 'N' || type != 'S' || type != 'E' || type != 'W'){
	  $('#stiRateregionDir').hide();
	
 }if(type == 'N' || type == 'S' || type == 'E' || type == 'W'){
	 $('#stiRateregionDir').show();
 }
 
 /** State wise data **/
  if(type != 'state'){
	  $('#stiRatestateSec').hide();
	
 }if(type == 'state'){
	 $('#stiRatestateSec').show();
 }
 /* Virtual Navigator */
 if(type != 'vn'){
	  $('#stiRatevnSec').hide();
 }
 /* Virtual Navigator */
 if(type != 'topology'){
	  $('#stiRatetopologySec').hide();
 }

 var to_date = $("input[name=stidate_to]").val();
 var date_from = $("input[name=stidate_from]").val();
 var DataJson =  {"_token": "<?php echo e(csrf_token()); ?>","type":type,"value":value,"to_date":to_date,"date_from":date_from}

	$.ajax({
		url:"<?php echo e(route('dashboard.mereport.sti.chart')); ?>",
			method:"POST",
			data:DataJson,
			dataType:"JSON",
			success:function(data){
				$(".line_chart_sti_positive").html('<canvas id="line_chart_sti_positive"></canvas>');
				
				var language = [];
				var total = [];
				var color = [];

				for(var count = 0; count < data.length; count++)
				{
					language.push(data[count].language);
					total.push(data[count].total);
					color.push(data[count].color);
				}
                console.log(total);
				var chart_data = {
					labels:language,
					datasets:[
						{
							label:'STI Positive Rate ('+total+')',
							backgroundColor:color,
							color:'#fff',
							fillColor: "rgba(254, 164, 0, 1)",
							highlightFill: "rgba(254, 164, 0, 1)",
							borderColor: 'rgb(75, 192, 192)',
							data:total
						}
					]
				};

				var options = {
					responsive:true,
					scales:{
						yAxes:[{
							ticks:{
								min:0,
								max: 100000
							}
						}]
					},
					legend: {
						display: true,						
					},
					 tooltips: {
						enabled: true,												
					 }
				};

				var group_chart2 = $('#line_chart_sti_positive');

				var graph3 = new Chart(group_chart2, {
					type:'line',
					data:chart_data,
					options:options
				});
			}
	});
}

/** HIV Referral and conversion rate */
function makechartHIVReferral(type,value=""){
	/** State wise data **/
	if(type != 'state'){
	 	$('#hivRatestateSec').hide();
	   
	}if(type == 'state'){
		$('#hivRatestateSec').show();
	}
	/* Virtual Navigator */
	if(type != 'vn'){
	 	$('#hivRatevnSec').hide();
	}

	var to_date = $("input[name=hivdate_to]").val();
	var date_from = $("input[name=hivdate_from]").val();
	var DataJson =  {"_token": "<?php echo e(csrf_token()); ?>","type":type,"value":value,"to_date":to_date,"date_from":date_from}
    $.ajax({
		url:"<?php echo e(route('dashboard.mereport.referral.chart')); ?>",
			method:"POST",
			data:DataJson,
			dataType:"JSON",
			success:function(data){
				$(".line_chart_hiv_referral").html('<canvas id="line_chart_hiv_referral"></canvas>');
				
				var language = [];
				var total = [];
				var color = [];
				var hivtested = [];
				var hivreferred = [];

				for(var count = 0; count < data.length; count++)
				{
					language.push(data[count].language);
					total.push(data[count].total);
					color.push(data[count].color);
					hivtested.push(data[count].hivtested);
					hivreferred.push(data[count].referred);
				}
            
				var chart_data = {
					labels:language,
					// datasets:[
					// 	{
					// 		label:'Total HIV referral and conversion rate ',
					// 		backgroundColor:color,
					// 		color:'#fff',
					// 		fillColor: "rgba(254, 164, 0, 1)",
					// 		highlightFill: "rgba(254, 164, 0, 1)",
					// 		borderColor: 'rgb(75, 192, 192)',
					// 		data:total
					// 	}
					// ]
				};

				var options = {
					responsive:true,
					scales:{
						yAxes:[{
							ticks:{
								min:0,
								max: 100000
							}
						}]
					},
					legend: {
						display: true,						
					},
					 tooltips: {
						enabled: true,												
					 }
				};

				var group_chart2 = $('#line_chart_hiv_referral');

				var graph3 = new Chart(group_chart2, {
					type: 'bar',
					data: {
						datasets: [{
							label: 'Tested ('+hivtested+')',
							type: 'bar',
							data: hivtested,
							borderColor: 'rgb(255, 99, 132)',
							borderColor: 'rgb(255, 99, 132)',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)'
						}, {
							type: 'line',
							label: 'Referred  ('+hivreferred+')   ||  Rate ('+ total+')',
							data:  hivreferred,
							fill: false,
							borderColor: 'rgb(54, 162, 235)'
						}],
						labels: language
					},
					options: options
					
				});
			}
	});

}
function outreachDateRange(){
	$("#date_range_out").toggle();
} 
function DateBtnTotaloutreach(){
	
	var to_date = $("input[name=outdate_to]").val();
	var date_from = $("input[name=outdate_from]").val();
	
	var DataJson =  {"_token": "<?php echo e(csrf_token()); ?>","type":2,"to_date":to_date,"date_from":date_from}
		$.ajax({
			url:"<?php echo e(route('dashboard.mereport.chart')); ?>",
			method:"POST",
			data:DataJson,
			dataType:"JSON",
			success:function(data)
			{	
				$(".pie-chart").html('<canvas id="bar_chart"></canvas>');
				
				var language = [];
				var total = [];
				var color = [];

				for(var count = 0; count < data.length; count++)
				{
					language.push(data[count].language);
					total.push(data[count].total);
					color.push(data[count].color);
				}

				var chart_data = {
					labels:language,
					datasets:[
						{
							label:'Report',
							backgroundColor:color,
							color:'#fff',
							data:total
						}
					]
				};

				var options = {
					responsive:true,
					scales:{
						yAxes:[{
							ticks:{
								min:0
							}
						}]
					},
					legend: {
						display: true
					},
					 tooltips: {
						enabled: true
					 }
				};

				var group_chart2 = $('#bar_chart');

				var graph3 = new Chart(group_chart3, {
					type:'pie',
					data:chart_data,
					options:options
				});
			}
		});
	
	
}

</script>

<?php $__env->stopPush(); ?>

<?php $__env->startPush('modal'); ?>


<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/netreach2/resources/views/report/index.blade.php ENDPATH**/ ?>