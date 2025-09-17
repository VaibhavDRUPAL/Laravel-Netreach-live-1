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
                            <h3 class="mb-0">All Credit Survey</h3>
                        </div>
                        

                        
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
										
                                    </tr>
								    @endforeach
                                 </tbody>
                                <tfoot >
                                <tr>
                                    <td colspan="6">
                                        {{$survey->links()}}
                                    </td>
                                </tr>
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

@endpush

@push('modal') 

@endpush

