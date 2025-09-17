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
                            <h3 class="mb-0">PO Survey</h3>
                        </div>
                        <div class="col-lg-12 mb-3">
							<div>
								<select name="region" class="form-control" >
									<option value="">--Select Region--</option>
									<option value="1">North</option>
									<option value="2">South</option>
									<option value="3">East</option>
									<option value="4">West</option>
									
								</select>
							</div><br/>
                        	<div>
								<button type="button" class="btn btn-primary" onclick="return AdminPoSurveyReport(0);"><span>Pending</span><span class="badge badge-md badge-circle badge-floating badge-danger border-white">{{\App\Models\Surveys::getPoReportCtr(0)->count()}}</span></button>
                        		<button type="button" class="btn btn-success" onclick="return AdminPoSurveyReport(1);"><span>Approve</span><span class="badge badge-md badge-circle badge-floating badge-danger border-white">{{\App\Models\Surveys::getPoReportCtr(1)->count()}}</span></button>
								<button type="button" class="btn btn-danger" onclick="return AdminPoSurveyReport(2);"><span>Rejected</span><span class="badge badge-md badge-circle badge-floating badge-danger border-white">{{\App\Models\Surveys::getPoReportCtr(2)->count()}}</span></button>
								
								
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
                            <table class="table table-hover align-items-center" id="po_survey_data">
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
<link rel="stylesheet" media="all" href="{{asset('assets/css/jquery.dataTables.css')}}">
<script type="text/javascript" charset="utf8" src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript">

function AdminPoSurveyReport(type){
	//alert(type);

      $('#po_survey_data').dataTable({
        "processing": true,
		"serverSide": true,	
		"bDestroy": true,
		"sDom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",		
        "ajax": {
            "url": "{{route('po.report') }}",
            "type": "POST",
			"data": function(d){
					d.report_type = type,
					d._token = "{{ csrf_token() }}",
					d.region = $("select[name=region]").val() 
			}
        },								
		columns: [{
			data: 'client_type',
			title: 'CLIENT TYPE'
		  }, {
			data: 'book_date',
			title: 'ASSESSMENT DATE'
		  },{
			  data:"state_name",
			  title: 'State Name'
		  }, {
			data: 'district_name',
			title: 'District Name'
		  }, {
			data: 'platforms_name',
			title: 'Platforms Name'
		  }, {
			data: 'your_age',
			title: 'Age'
		  }, {
			data: 'identify_yourself',
			title: 'Gender'
		  }, {
			data: 'target_population',
			title: 'TARGET POP'
		  }, {
			data: 'client_phone_number',
			title: 'MOBILE'
		  }, {
			data: 'risk_level',
			title: 'RISK'
		  }, {
			data: 'uid',
			title: 'UID'
		  }, {
			data: 'service_required',
			title: 'SERVICES'
		  }, {
			data: 'hiv_test',
			title: 'IT'
		  }, {
			data: 'services_avail',
			title: 'FACILITY TYPE'
		  }, {
			data: 'client_name',
			title: 'NAME'
		  }, {
			data: 'appoint_date',
			title: 'REFERRAL DATE'
		  }, {
			data: 'center_name',
			title: 'CENTRE'
		  }, {
			data: 'acess_date',
			title: 'Acess Date'
		  }, {
			data: 'pid',
			title: 'PID'
		  }, {
			data: 'outcome',
			title: 'Outcome'
		  }
		  
		  ]		
      });  


	
}

</script>

@endpush

@push('modal') 

@endpush

