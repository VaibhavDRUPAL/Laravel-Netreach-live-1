@extends('layouts.app')

@push('styles')
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


</style>

@endpush
@section('content')


    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-header bg-transparent">
                    <div class="row">
                        <div class="headingdiv">
                            <h3 class="mb-0">All Survey</h3>
                        </div>
                        <div class="col-lg-12 mb-3">
                        	<div>
															
							
                        		<input type="button"  id="myelement" class="btn btn-warning" value="Advanced"></input>
                        		<a class="btn btn-warning" href="{{ route('survey.export') }}">Export User Data</a>
	                            <!--<form id="another-element">-->
								{{ Form::open(array('url' => '/survey/filter',"id"=>"another-element")) }}
								  <div class="form-row">
								    <div class="col-md-3 mb-3">
									      <label for="validationCustom01">Assessment_Date</label>
									      <input type="date" class="form-control" id="date-time-grid" value="" >
								    </div>								    

								    <div class="col-md-3 mb-3">
									      <label for="validationCustom02">Referral_Date</label>
									      <input type="Date" class="form-control" id="validationCustom02" value="Referral Date" >      
								    </div>
								    <div class="col-md-3 mb-3">
									      <label for="validationCustom02">Acess_Date</label>
									      <input type="Date" class="form-control" id="validationCustom02" value="Acess_Date" >
								    </div>
								    <div class="col-md-3 mb-3">
									      <label for="inputState">Region</label>
									      <select id="inputState" class="form-control" onchange="return getRegion(this.value);">
									        <option selected value="">Choose...</option>
									        <option value='1'>North</option>
									        <option value="2">South</option>
									        <option value="3">East</option>
									        <option value="4">West</option>
									      </select>
								    </div>
								    <div class="col-md-3 mb-3">
									      <label for="inputStateget">State</label>
									      <select id="inputStateget" name="state_id" class="form-control">
									        <option selected value="">Choose...</option>											
									      </select>
								    </div>
								    <div class="col-md-3 mb-3">
									      <label for="inputDistrict">District</label>
									      <select id="inputDistrict" class="form-control" onchange="return getDistrict(this.value);">
												<option selected value="">Choose...</option>									        
									      </select>
								    </div>
								    <div class="col-md-3 mb-3">
									      <label for="vninputState">VN</label>
									      <select id="vninputState" name="vninputState" class="form-control">
									        <option selected value="">Choose...</option>									        
									      </select>
								    </div>
								    <div class="col-md-3 mb-3">
									      <label for="inputState">Services</label>
									      <select id="inputState" class="form-control">
									        <option selected value="">Choose...</option>									        
									      </select>
								    </div>
								    <div class="col-md-3 mb-3">
									      <label for="inputState">Target Populations</label>
									      <select id="inputState" class="form-control">
									        <option selected value="">Choose...</option>
									        <option value="MSM">MSM</option>
									        <option value="TG">TG</option>
									        <option value="MSW">MSW</option>
									        <option value="FSW">FSW</option>
									        <option value="PWID">PWID</option>
									        <option value="Adolescents and Youths (18-24)">Adolescents and Youths (18-24)</option>
									        <option value="Men and Women (above 24 yrs)">Men and Women (above 24 yrs)</option>
									        <option value="Adolescents and Youths (18-24)">Adolescents and Youths (18-24)</option>
									        <option value="Men and Women (above 24 yrs)">Men and Women (above 24 yrs)</option>
									      </select>
								    </div>
								    <div class="col-md-3 mb-3">
									      <label for="inputState">Facility Type</label>
									      <select id="inputState" class="form-control">
									        <option selected>Choose...</option>
									        <option value="1">New Client</option>
									        <option value="2">Follow Up Client</option>
									      </select>
								    </div>
								    <div class="col-md-3 mb-3">
									      <label for="validationCustom02">PID</label>
									      <input type="text" class="form-control" id="validationCustom02" placeholder="PID" value="" >
								    </div>
								    <div class="col-md-3 mb-3">
									      <label for="validationCustom02">Outcome</label>
									      <input type="text" class="form-control" id="validationCustom02" placeholder="outcome" value="Outcome" >
								    </div>
								  </div>
								  
								    <input type="hidden" class="form-control" id="search" name="search" value="search">
								  <button class="btn btn-primary" type="submit">Submit</button>
								  							  
								</form>
							</div><!-- myelement -->
                        </div>

                        <!-- <div class="col-lg-2 mt-4">
							<a class="btn btn-warning" href="{{ route('survey.export') }}">Export User Data</a>
						</div> -->
						<div class=" mt-4">
							
						</div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <div>
					    
                            <table class="table table-hover align-items-center">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">Client Type</th>
                                    <th scope="col">Assessment Date </th>
                                    <th scope="col">State</th>
                                    <th scope="col">District</th>
                                    <th scope="col">Platform</th>                                   
									<th scope="col">Age</th>
									<th scope="col">Gender</th>
									<th scope="col">Target POP</th>
									<th scope="col">Mobile</th>
									<th scope="col">Risk</th>
									<th scope="col">UID</th>
									<th scope="col">Services</th>
									<th scope="col">TI</th>
									<th scope="col">Facility Type</th>
									<th scope="col">Name</th>
									<th scope="col">Referral Date</th>
									<th scope="col">Centre</th>
									<th scope="col">Acess Date</th>
									<th scope="col">PID</th>
									<th scope="col">Outcome</th>
									@can('vn-upload-doc')
									<th scope="col">Action</th>
									@endcan
									<th scope="col">Need Counseling</th>
									@can('po-apporve-reject-action')
									<th scope="col">Action</th>
									@endcan
                                </tr>
                                </thead>
                                <tbody class="list">
								<?php 
									$genderArr = array("1"=>"Male","2"=>"Female","3"=>"Transgender","4"=>"I prefer not to say","5"=>"I prefer not to say","6"=>"Other");
									
									$services = array(
									"1"=>"HIV Test",
									"2"=>"STI Services",
									"3"=>"PrEP",
									"4"=>"PEP",
									"5"=>"Counselling on Mental Health",
									"6"=>"Referral to TI services",
									"7"=>"ART Linkages"
									);
									
									$serviceAval = array("0"=>"",1=>"ICTC",2=>"FICTC",3=>"ART",4=>"TI",5=>"Private lab");
								?>
									@foreach($survey as $list)
									
									<?php 
									   $service_required= '';
										$servicesArr = json_decode($list->services_required); 
										
										foreach($services as $key=>$value){
										
											if(!in_array($key,$servicesArr))
													continue;
											
											$service_required .= $value.",";
													
										}
										
										$services_avail='';
										if(isset($list->services_avail) && !empty($list->services_avail)){
												
											if(!empty($list->services_avail)){	
												$serviceOrginAval = explode(",",$list->services_avail);
												foreach($serviceOrginAval as $val){
													$services_avail .= $serviceAval[$val].",";
												}
												$services_avail = rtrim($services_avail,',');
											}
										}
										
									
									?>
									<tr>
										<td>{{($list->client_type==1) ? 'New Client' : 'Follow Up Client' }}</td>
										<td>{{date("d/m/Y",strtotime($list->book_date))}}</td>
										<td>{{$list->state_name}}</td>
										<td>{{$list->district_name}}</td>
										<td>{{!empty($list->platforms_name)?$list->platforms_name:'Walk-in'}}</td>										
										<td>{{$list->your_age}}</td>
										<td>{{isset($genderArr[$list->identify_yourself])?$genderArr[$list->identify_yourself]:""}}</td>
										<td>{{$list->target_population}}</td>
										<td>{{$list->client_phone_number}}</td>
										<td>{{$list->risk_level}}</td>
										<td>{{$list->uid}}</td>
										<td>{{rtrim($service_required,",")}}</td>
										<td>{{($list->hiv_test==1)?'Yes' :'No'}}</td>
										<td>{{$services_avail}}</td>
										<td>{{$list->client_name}}</td>
										<td>{{$list->appoint_date}}</td>
										<td>{{$list->center_name}}</td>
										<td>{{$list->acess_date}}</td>
										<td>{{$list->pid}}</th>
										<td> 
											@if($list->outcome==1)
												{{'Negative'}}
											@elseif($list->outcome==2)
												{{'Positive'}}	
											@elseif($list->outcome==3)
												{{'Non-reactive'}}	
											@endif
										</td>
										@can('vn-upload-doc')
										<td>
											@if($list->flag==0)  
											<button type="button" class="btn btn-block btn-default"  id="survey_id_{{$list->survey_ids}}" onclick="return uploadReport({{$list->survey_ids}});" >Upload</button>
											@else
											{{'Uploaded'}}	
											@endif
										</td>
										 @endcan
										<td>
											@if($list->survey_co_flag==0)
												@can('appoin-to-counseling')	
												<div id="div_con_btn_{{$list->survey_ids}}"><button type="button" class="btn btn-info"  id="co_id_{{$list->survey_ids}}" onclick="return counseling({{$list->survey_ids}});" >Counseling</button></div> <!-- -->
												 @endcan
											@else
												<?php echo '<span class="badge badge-pill badge-info">Assign Counseling</span>'; ?>
											@endif
										</td>
										
										@can('po-apporve-reject-action')	
										<td>
											@if($list->po_status==0)
											<div id="div_po_btn_{{$list->survey_ids}}">											
												<a href="javascript:void(0);" id="po_id_{{$list->survey_ids}}" onclick="return po_action({{$list->survey_ids}});" class="btn btn-sm btn-info  mr-4 ">PO Action</a>
											</div> <!-- -->
											@else
												<?php if($list->po_status==1){ ?>
													<span class="badge badge-success">Approve</span>
												<?php }else{ ?>
													<span class="badge badge-danger">Rejected</span>
												<?php }?>
													
											@endif
										</td>
										@endcan
										
                                    </tr>
								    @endforeach
                                 </tbody>
                                <tfoot >
                                
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts') 
<link rel="stylesheet" href="{{asset('assets/css/jquery-ui.css')}}">
<script src="{{asset('assets/js/jquery-ui.js')}}"></script>
<script src="{{asset('assets/vendor/custom_alert/bootbox.all.min.js')}}"></script>
    <script>
        
	$( function() {
	
		
	var date = new Date();
	var minDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() + 14);
    $("#acess_date").datepicker({
			showOn: "button",
			buttonImage: "{{asset('assets/img/web/calendar.gif')}}",
			buttonImageOnly: true,		
			buttonText: "Select date",
			dateFormat: 'yy-mm-dd'			
	});
	
});

function counseling(s_id){
	
	  jQuery.confirm({
                    icon: 'fas fa-wind-warning',
                    closeIcon: true,
                    title: 'Are you sure!',
                    //content: 'You want to counseling? ', 
                    type: 'red',
                    typeAnimated: true,
                    buttons: {
                        confirm: function () {                            
							ajax_counseling(s_id);								
                        },
                        cancel: function () {
                           //alert("cancel");
                        }
                    }
         });		
}


function ajax_counseling(sid){
	
	$.ajax({
		type:"POST",
		url:"{{ route('flag.counseling') }}",		
		data: {"_token": "{{ csrf_token() }}","sid": sid},
		dataType:"json",
		success:function(data){	
			
			if(data.results=="Success")
				$("#div_con_btn_"+sid).text('Assign Counseling');
			
				
		}		
	});
	
}
</script>

<script type="text/javascript">

function uploadReport(id){

	$("#survey_id").val(id);		 
	$('#modal-form').modal('show');	
		
}
$(document).ready(function (e) {
    
$('#multi-file-upload').submit(function(e) {
	e.preventDefault();
		

	
	var conf = confirm("Are You sure?You want to save Data?");
	if(!conf)
		return false;
	
	var formData = new FormData(this);
	let detail = $("#detail").val();
	let acess_date = $("#acess_date").val();
	let user_pid = $("#user_pid").val();
	let survey_id = $("#survey_id").val();
	let TotalImages = $('#files')[0].files.length; //Total Images
	let images = $('#files')[0];
	for (let i = 0; i < TotalImages; i++) {
		formData.append('images' + i, images.files[i]);
	}
	formData.append('detail', detail);
	formData.append('acess_date', acess_date);
	formData.append('user_pid', user_pid);
	formData.append('totalImages', TotalImages);
	formData.append('survey_id', survey_id);
		$.ajax({
			type:'POST',
			url: "{{ route('vn.upload') }}",
			data: formData,
			cache:false,
			contentType: false,
			processData: false,
			dataType:"json",
			success: (data) => {
				//this.reset();
				//$("#acess_date_err").html(data.error.acess_date[0]);
				
				
				if(data.message=="Success"){
					$("#survey_id_"+survey_id).remove();
					this.reset();	
					$('#modal-form').modal('hide');
					$('#modal-notification').modal('show');	
					
				}else{
					
					if(data.error.acess_date==''){					
						$("#acess_date_err").html('');
						$("#acess_date_err").removeClass("alert alert-danger" );
					}else{
						$("#acess_date_err").html(data.error.acess_date);
						$("#acess_date_err").addClass("alert alert-danger" );
					}	
				
					if(data.error.user_pid==''){					
						$("#user_pid_err").html('');
						$("#user_pid_err").removeClass("alert alert-danger" );
					}else{
						$("#user_pid_err").html(data.error.user_pid);
						$("#user_pid_err").addClass("alert alert-danger" );
					}	
				
					if(data.error.detail==''){					
						$("#detail_err").html('');
						$("#detail_err").removeClass("alert alert-danger" );
					}else{
						$("#detail_err").html(data.error.user_pid);
						$("#detail_err").addClass("alert alert-danger" );
					}
				
					if(data.error.files==''){					
						$("#file_err").html('');
						$("#file_err").removeClass("alert alert-danger" );
					}else{
						$("#file_err").html(data.error.user_pid);
						$("#file_err").addClass("alert alert-danger" );
					}
				
					if(data.error.outcome==''){					
						$("#outcome_err").html('');
						$("#outcome_err").removeClass("alert alert-danger" );
					}else{
						$("#outcome_err").html(data.error.user_pid);
						$("#outcome_err").addClass("alert alert-danger" );
					}
					
					
				}
				//alert('Images has been uploaded using jQuery ajax with preview');
				//$('.show-multiple-image-preview').html("")
			},
			error: function(data){
				console.log(data);
			}
		});
	});
	
	
	
	$('#po-upload').submit(function(e) {
		e.preventDefault();
		
		var conf = confirm("Are You sure?You want to save Data?");
		if(!conf)
			return false;
		
		let detail = $("#detail").val();
		let action = $("#action").val();
		let survey_po_id = $("#survey_po_id").val();
		var formData = new FormData(this);		
		formData.append('detail', detail);
		formData.append('action', action);
		formData.append('survey_po_id', survey_po_id);
		
		$.ajax({
			type:'POST',
			url: "{{ route('po.action') }}",
			data: formData,
			cache:false,
			contentType: false,
			processData: false,
			dataType:"json",
			success: (data) => {
				//this.reset();	
				if(data.message=="Success"){					
					this.reset();
					if(data.action==1)
						$("#div_po_btn_"+survey_po_id).html('<span class="badge badge-success">Approve</span>');
					else
						$("#div_po_btn_"+survey_po_id).html('<span class="badge badge-danger">Rejected</span>');
					
					$('#modal-po-action-form').modal('hide');										
				}else{
					
					if(data.error.detail==''){					
						$("#detail_err").html('');
						$("#detail_err").removeClass("alert alert-danger" );
					}else{
						$("#detail_err").html(data.error.detail);
						$("#detail_err").addClass("alert alert-danger" );
					}
					
					
					if(data.error.action==''){					
						$("#action_err").html('');
						$("#action_err").removeClass("alert alert-danger" );
					}else{
						$("#action_err").html(data.error.action);
						$("#action_err").addClass("alert alert-danger" );
					}
					
					
				}
				
			},
			error: function(data){
				console.log(data);
			}
		});		
	});

	
	
	
$('#inputStateget').change(function(){
	
	let state_code = $("#inputStateget").val();
	console.log("state code= "+ state_code);	
	//formData.append('state_code', state_code);
	//formData.append('_token', '{{ csrf_token() }}');
		
	var jsonData = {"_token": "{{ csrf_token() }}","state_code": state_code}
		$.ajax({
			type:'POST',
			url: "{{ route('usr.district')}}",
			data: jsonData,
			dataType:"json",
			success: (data) => {
				console.log(data);				
				$('#inputDistrict').html(data.district_list);				
				
			},
			error: function(data){
				console.log(data);
			}
		});
		
	}); 			
	
	
});

function getRegion(id){
	
	var jsonData = {"_token": "{{ csrf_token() }}","city_id": id}
		$.ajax({
			type:'POST',
			url: "{{ route('usr.region')}}",
			data: jsonData,
			dataType:"json",
			success: (data) => {
				console.log(data);				
				$('#inputStateget').html(data.state_list);				
				
			},
			error: function(data){
				console.log(data);
			}
		});		
	
}

function getDistrict(id){
	
	var state_code = $("select#inputStateget").val();
	var jsonData = {"_token": "{{ csrf_token() }}","state_code": state_code}
		$.ajax({
			type:'POST',
			url: "{{ route('usr.statebydistrict')}}",
			data: jsonData,
			dataType:"json",
			success: (data) => {
				console.log(data);				
				$('#vninputState').html(data.user_list);				
				
			},
			error: function(data){
				console.log(data);
			}
		});		
	
	
}


function po_action(id){
	
	$('#modal-po-action-form').modal('show');
	$("#survey_po_id").val(id);
	//alert(id);
	
}

</script>
<script>
	$(document).ready(function (e) {
    	$( "#myelement" ).click(function() {     
		   $('#another-element').toggle("slide", { direction: "right" }, 1000);
		   if (this.value=="Advanced") this.value = "Filter";
    		else this.value = "Advanced";
		});
		
	});
</script>
@endpush

@push('modal') 

<div class="modal fade" id="modal-po-action-form" tabindex="-1" role="dialog" aria-labelledby="modal-form"
                            aria-hidden="true">
                            <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
                                <div class="modal-content">
                                    <div class="modal-body p-0">
                                        <div class="card bg-secondary shadow border-0">                                            
											
                                            <div class="card-body px-lg-5 py-lg-5">
                                               
                                               <form id="po-upload" method="POST"  action="javascript:void(0)" accept-charset="utf-8" enctype="multipart/form-data">
												@csrf
                                                    
													<div class="form-group"> 
														<label>Detail</label>
														<textarea id="detail" name="detail" class="required form-control" rows="4" cols="30"></textarea>
														<div class="" id="detail_err" ></div>
													</div>
													
													<div class="form-group"> 
														<label>Action</label>
														<select name="action" id="action" class="form-control required">
															<option value=''>--Select--</option>
															<option value="1">Approve</option>
															<option value="2">Rejected</option>
														</select>
														<div class="" id="action_err" ></div>
													</div>
																										
                                                    <div class="text-center">
														<input type="hidden" id="survey_po_id" name="survey_po_id" class="custom-control-input" >
                                                        <button type="submit" class="btn btn-primary my-4" >Submit</button>
                                                    </div>
                                               {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form"
                            aria-hidden="true">
                            <div class="modal-dialog modal- modal-dialog-centered modal-sm" role="document">
                                <div class="modal-content">
                                    <div class="modal-body p-0">
                                        <div class="card bg-secondary shadow border-0">
                                            <!--<div class="card-header bg-white pb-5">
                                                <div class="text-muted text-center mb-3"><small>Sign in with</small>
                                                </div>                                                
                                            </div>-->
											
                                            <div class="card-body px-lg-5 py-lg-5">
                                               
                                               <form id="multi-file-upload" method="POST"  action="javascript:void(0)" accept-charset="utf-8" enctype="multipart/form-data">
												@csrf
                                                    <div class="form-group mb-3"> 
														<label>Acess Date</label>
														<input class="form-control required" placeholder="" type="text" id="acess_date" name="acess_date" readonly>
														
														<div class="" id="acess_date_err" ></div>
														
                                                    </div>
                                                    <div class="form-group">                 
														<input class="form-control required" placeholder="PID" type="text" name="user_pid" id="user_pid">
														<div id="user_pid_err"></div>
													</div>
                                                    
													<div class="form-group"> 
														<label>Detail</label>
														<textarea id="detail" name="detail" class="required" rows="4" cols="30"></textarea>
														<div id="detail_err"></div>
													</div>
													
													<div class="form-group">
														<label>File Upload</label>
														<input class="form-control required"  type="file" name="files" id="files">
														<div id="file_err"></div>
													</div>
													
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" id="negative" name="outcome"
															class="custom-control-input " value="1">
														<label class="custom-control-label" for="negative">Negative</label>
													</div>
													
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" id="positive" name="outcome"
															class="custom-control-input" value="2">
														<label class="custom-control-label" for="positive">Positive</label>
													</div>
													
													<div class="custom-control custom-radio custom-control-inline">
														<input type="radio" id="non_reactive" name="outcome"
															class="custom-control-input" value="3">
														<label class="custom-control-label" for="non_reactive">Non-reactive </label>
													</div>
													<div id="outcome_err"></div>
													
													
                                                    <div class="text-center">
														<input type="hidden" id="survey_id" name="survey_id" class="custom-control-input" >
                                                        <button type="submit" class="btn btn-primary my-4" >Save</button>
                                                    </div>
                                               {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
						
						
						<div class="modal fade" id="modal-notification" tabindex="-1" role="dialog"
                            aria-labelledby="modal-notification" aria-hidden="true">
                            <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
                                <div class="modal-content bg-gradient-danger">
                                    <div class="modal-header">
                                        <h6 class="modal-title" id="modal-title-notification">Your Data Save </h6>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="py-3 text-center">
                                            <i class="ni ni-bell-55 ni-3x"></i>
                                            <h4 class="heading mt-4">You should read this!</h4>
                                            <p>Your have been Successfully! Save </p>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-white">Ok, Got it</button>
                                        <button type="button" class="btn btn-link text-white ml-auto"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
@endpush

