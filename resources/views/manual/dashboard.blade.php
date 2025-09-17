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

	.required-field::before {
		content: "*";
		color: red;
		float: right;
	}


	.assessment_date {
		display: none;
	}

	.referral_date {
		display: none;
	}

	.acess_date {
		display: none;
	}
	td, th {
		padding: 4px;
	}
	.dwnldBtn{
   		margin-bottom: 0.5rem;
	}

</style>

@endpush
@section('content')


<div class="dashboard-view">
	<div class="row">
		<div class="col-md-12 col-sm-12">
			<div class="table-responsive">
				<div class="header-div">
					<select name="target_pop" id="target_pop">
						<option value="">--Typology--</option>
						@foreach($typology_master as $key => $val)
						<option value="{{$val->target_id}}">{{$val->target_type}}</option>
						@endforeach
					</select>

					<select name="region_outreach" id="region_outreach">
						<option value="">--Region --</option>
							@foreach ($region as $key => $val)
								<option value="{{$key}}">{{$val}}</option>
							@endforeach
					</select>

					<select name="state_outreach" id="state_outreach">
						<option value="">--State--</option>
						@foreach($state_master as $key=>$val)
						<option value="{{$val->id}}">{{$val->state_name}}</option>
						@endforeach
					</select>

					<select name="virtual_outreach" id="virtual_outreach">
						<option value="">--VN/CO--</option>
						@foreach($vn_co as $key=>$val)
						<option value="{{$val->vns}}">{{$val->vns}}</option>
						@endforeach;
					</select>
					<br />
					<label>From</label> <input type="date" id="date_frm" name="date_frm">
					<label>To</label> <input type="date" id="date_to" name="date_to">
					<input type="button" value="Submit" id="btn_outreach">
					<input type="button" value="Reset" id="btn_outreach-reset">
				</div><!-- header-div -->
				<div id="container" style="min-width: 400px; height: 500px; margin: 0 auto"></div>
			</div><!-- table-responsive -->
		</div><!-- col-6 -->
	</div><!-- row -->
	<hr>
	<div class="row">
		<div class="col-md-12 col-sm-12">
			<div class="table-responsive">
				<div class="header-div">
					<select name="region" id="region">
						<option value="">--Region--</option> 
						@foreach ($region as $key => $val)
							<option value="{{$key}}">{{$val}}</option>
						@endforeach
					</select>

					<select name="virtual" id="virtual">
						<option value="">--VN/CO--</option>
						@foreach($vn_co as $key=>$val)
						<option value="{{$val->vns}}">{{$val->vns}}</option>
						@endforeach;
					</select>

					<select name="state_risk" id="state_risk">
						<option value="">--State--</option>
						@foreach($state_master as $key=>$val)
						<option value="{{$val->id}}">{{$val->state_name}}</option>
						@endforeach
					</select>

					<select name="target_pop_risk" id="target_pop_risk">
						<option value="">--Typology--</option>
						@foreach($typology_master as $key => $val)
						<option value="{{$val->target_id}}">{{$val->target_type}}</option>
						@endforeach
					</select>

					<select name="risk_category" id="risk_category">
						<option value="">--Risk Category--</option>
						@foreach($risk_category as $key => $val)
						<option value="{{$key}}">{{$val}}</option>
						@endforeach
					</select>


					<select name="app_risk" id="app_risk">
						<option value="">--Application--</option>
						@foreach($platforms_master as $key => $val)
						<option value="{{$val->id}}">{{$val->name}}</option>
						@endforeach
					</select>

					<label>From</label> <input type="date" id="risk_date_frm" name="risk_date_frm">
					<label>To</label> <input type="date" id="risk_date_to" name="risk_date_to">
					<input type="button" value="Submit" id="btn_risk_assignment">
					<input type="button" value="Reset" id="btn_risk_assignment-reset">
				</div><!-- header-div -->
				<div id="Risk_Assesment" style="min-width: 400px; height: 500px; margin: 0 auto"></div>
			</div><!-- table-responsive -->
		</div><!-- col-6 -->
	</div><!-- row -->

	<hr>

	<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="table-responsive">
            <div class="header-div">
                <select name="referral_region" id="referral_region">
                    <option value="">--Region --</option>
						@foreach ($region as $key => $val)
							<option value="{{$key}}">{{$val}}</option>
						@endforeach
                </select>
                <select name="state_referral" id="state_referral">
                    <option value="">--State--</option>
                    @foreach($state_master as $key=>$val)
                    <option value="{{$val->id}}">{{$val->state_name}}</option>
                    @endforeach
                </select>
                <select name="health_facility " id="health_facility">
                    <option value="">--Type of facility--</option>
                    @foreach ($type_of_facility as $key => $val)
							<option value="{{$key}}">{{$val}}</option>
					@endforeach
                </select>

                <select name="virtual_referred" id="virtual_referred">
                    <option value="">--VN/CO--</option>
                    @foreach($vn_co as $key=>$val)
                    <option value="{{$val->vns}}">{{$val->vns}}</option>
                    @endforeach;

                </select>

                <select name="referred_typology" id="referred_typology">
                    <option value="">--Typology--</option>
                    @foreach($typology_master as $key => $val)
						<option value="{{$val->target_id}}">{{$val->target_type}}</option>
						@endforeach
                </select>

                <select name="risk_category" id="referred_risk_category">
                    <option value="">--Risk category--</option>
                    	@foreach($risk_category as $key => $val)
						<option value="{{$key}}">{{$val}}</option>
						@endforeach
                </select>

                <select name="type_test" id="referred_type_test">
                    <option value="">--Type of test--</option>
                    @foreach($type_of_test as $key => $val)
						<option value="{{$key}}">{{$val}}</option>
						@endforeach
                </select>

                <select name="client_type" id="referred_client_type">
                    <option value="">--Client type--</option>
                     @foreach($client_type_master as $key => $val)
						<option value="{{$val->client_type_id}}">{{$val->client_type}}</option>
						@endforeach
                </select>

                <select name="app_referred" id="app_referred">
                    <option value="">--Application--</option>
                    @foreach($platforms_master as $key => $val)
						<option value="{{$val->id}}">{{$val->name}}</option>
						@endforeach
                </select>

                <select name="service_referral" id="service_referral">
                    <option value="">--Type of service--</option>
                    @foreach($type_of_service_master as $key => $val)
						<option value="{{$val->service_type_id}}">{{$val->service_type}}</option>
						@endforeach

                </select>

                <label>From</label> <input type="date" id="referred_date_frm" name="referred_date_frm">
                <label>To</label> <input type="date" id="referred_date_to" name="referred_date_to">
                <input type="button" value="Submit" id="btn_referred">
                <input type="button" value="Reset" id="btn_referred-reset">

            </div><!-- header-div -->
            <div id="Referred_services" style="min-width: 400px; height: 500px; margin: 0 auto"></div>
        </div><!-- table-responsive -->
    </div><!-- col-12 -->
</div><!-- row -->

<hr>

<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="table-responsive">
            <div class="header-div">
                <select name="availed_services_region" id="availed_services_region">
                    <option value="">--Region --</option>
                    @foreach ($region as $key => $val)
							<option value="{{$key}}">{{$val}}</option>
						@endforeach
                </select>

                <select name="state_availed" id="state_availed">
                    <option value="">--State--</option>
                    @foreach($state_master as $key=>$val)
                    <option value="{{$val->id}}">{{$val->state_name}}</option>
                    @endforeach
                </select>

                <select name="as_virtual" id="as_virtual">
                    <option value="">--VN/CO--</option>
                    @foreach($vn_co as $key=>$val)
                    <option value="{{$val->vns}}">{{$val->vns}}</option>
                    @endforeach;
                </select>

                <select name="as_health_facility " id="as_health_facility">
                    <option value="">--Type of facility--</option>
                    @foreach ($type_of_facility as $key => $val)
							<option value="{{$key}}">{{$val}}</option>
					@endforeach
                </select>

                <select name="as_referred_typology" id="as_referred_typology">
                    <option value="">--Typology--</option>
                    @foreach($typology_master as $key => $val)
						<option value="{{$val->target_id}}">{{$val->target_type}}</option>
						@endforeach
                </select>

                <select name="as_risk_category" id="as_risk_category">
                    <option value="">--Risk category--</option>
                    @foreach($risk_category as $key => $val)
						<option value="{{$key}}">{{$val}}</option>
						@endforeach
                </select>

                <select name="as_type_test" id="as_type_test">
                    <option value="">--Type of test--</option>
                     @foreach($type_of_test as $key => $val)
						<option value="{{$key}}">{{$val}}</option>
						@endforeach
                </select>

                <select name="as_client_type" id="as_client_type">
                    <option value="">--Client Type--</option>
                    @foreach($client_type_master as $key => $val)
						<option value="{{$val->client_type_id}}">{{$val->client_type}}</option>
						@endforeach
                </select>

                <select name="as_app" id="as_app">
                    <option value="">--Application--</option>
                    @foreach($platforms_master as $key => $val)
						<option value="{{$val->id}}">{{$val->name}}</option>
						@endforeach
                </select>


                <select name="as_service" id="as_service">
                    <option value="">--Type of service--</option>
                    @foreach($type_of_service_master as $key => $val)
						<option value="{{$val->service_type_id}}">{{$val->service_type}}</option>
						@endforeach

                </select>

                <label>From</label> <input type="date" id="as_date_frm" name="as_date_frm">
                <label>To</label> <input type="date" id="as_date_to" name="as_date_to">
                <input type="button" value="Submit" id="btn_as">
                <input type="button" value="Reset" id="btn_as-reset">

            </div><!-- header-div -->
            <div id="availed_services" style="min-width: 400px; height: 500px; margin: 0 auto"></div>
        </div><!-- table-responsive -->
    </div><!-- col-12 -->
</div><!-- row -->

<hr />

<div class="row">
    <div class="col-md-6 col-sm-12">
        <div class="table-responsive">
            <div class="header-div">
                <select name="hp_virtual" id="hp_virtual">
                    <option value="">--VN/CO--</option>
                    @foreach($vn_co as $key=>$val)
                    <option value="{{$val->vns}}">{{$val->vns}}</option>
                    @endforeach;

                </select>

                <select name="hp_referred_typology" id="hp_referred_typology">
                    <option value="">--Typology--</option>
                    @foreach($typology_master as $key => $val)
						<option value="{{$val->target_id}}">{{$val->target_type}}</option>
						@endforeach
                </select>

                {{-- <select name="hp_states" id="hp_states">
                    <option value="">--State--</option>
                    @foreach($state_master as $key=>$value)
                    <option value="{{$value->id}}">{{$value->state_name}}</option>
                    @endforeach;
                </select> --}}

                <label>From</label> <input type="date" id="hp_date_frm" name="hp_date_frm">
                <label>To</label> <input type="date" id="hp_date_to" name="hp_date_to">
                <input type="button" value="Submit" id="btn_hp">
                <input type="button" value="Reset" id="btn_hp-reset">
            </div><!-- header-div -->
            <div id="hiv_positivity" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
        </div><!-- table-responsive -->
    </div><!-- col-6 -->
{{-- </div><!-- row -->
<hr>
<div class="row"> --}}
    <div class="col-md-6 col-sm-12">
        <div class="table-responsive">
            <div class="header-div">
                <select name="cr_virtual_referred" id="cr_virtual_referred">
                    <option value="">--VN/CO--</option>
                    @foreach($vn_co as $key=>$val)
                    <option value="{{$val->vns}}">{{$val->vns}}</option>
                    @endforeach;
                </select>
				<select name="cr_referred_typology" id="cr_referred_typology">
                    <option value="">--Typology--</option>
                    @foreach($typology_master as $key => $val)
					<option value="{{$val->target_id}}">{{$val->target_type}}</option>
					@endforeach
                </select>
				<label>From</label> <input type="date" id="cr_date_frm" name="cr_date_frm">
                <label>To</label> <input type="date" id="cr_date_to" name="cr_date_to">
                <input type="button" value="Submit" id="btn_cr">
                <input type="button" value="Reset" id="btn_cr-reset">
            </div><!-- header-div -->
            <div id="hiv_referral_conversion_rate" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
        </div><!-- table-responsive -->
    </div><!-- col-6 -->
</div><!-- row -->

<hr />

<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="table-responsive">
            <div class="header-div">
                <select name="sti_virtual" id="sti_virtual">
                    <option value="">--VN/CO--</option>
                    @foreach($vn_co as $key=>$val)
                    <option value="{{$val->vns}}">{{$val->vns}}</option>
                    @endforeach;

                </select>

                <select name="sti_referred_typology" id="sti_referred_typology">
                    <option value="">--Typology--</option>
                     @foreach($typology_master as $key => $val)
						<option value="{{$val->target_id}}">{{$val->target_type}}</option>
						@endforeach
                </select>

                {{-- <select name="sti_states" id="sti_states">
                    <option value="">--State--</option>
                    @foreach($state_master as $key=>$value)
                    <option value="{{$value->id}}">{{$value->state_name}}</option>
                    @endforeach;
                </select> --}}

                <label>From</label> <input type="date" id="sti_date_frm" name="sti_date_frm">
                <label>To</label> <input type="date" id="sti_date_to" name="sti_date_to">
                <input type="button" value="Submit" id="btn_sti">
                <input type="button" value="Reset" id="btn_sti-reset">
            </div><!-- header-div -->
            <div id="sti_positivity" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
        </div><!-- table-responsive -->
    </div><!-- col-6 -->
</div><!-- row -->

<hr>

<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="table-responsive">
            <div class="header-div">
                <select name="art_region" id="art_region">
                    <option value="">--Region--</option>
                    <option value="1">North</option>
                    <option value="2">South</option>
                    <option value="3">East</option>
                    <option value="4">West</option>
                </select>
                <select name="art_virtual" id="art_virtual">
                    <option value="">--VN/CO--</option>
                    @foreach($vn_co as $key=>$val)
                    <option value="{{$val->vns}}">{{$val->vns}}</option>
                    @endforeach;
                </select>

                <select name="sti_typology" id="sti_typology">
                    <option value="">--Typology--</option>
                     @foreach($typology_master as $key => $val)
						<option value="{{$val->target_id}}">{{$val->target_type}}</option>
						@endforeach
                </select>
                <label>From</label> <input type="date" id="art_date_frm" name="art_date_frm">
                <label>To</label> <input type="date" id="art_date_to" name="art_date_to">
                <input type="button" value="Submit" id="btn_art">
				<input type="button" value="Reset" id="btn_art-reset">
            </div><!-- header-div -->
            <div id="art_linked" style="min-width: 400px; height: 500px; margin: 0 auto"></div>
        </div><!-- table-responsive -->
    </div><!-- col-6 -->
</div><!-- row -->


<hr />

<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="table-responsive table-layout">
            <div class="header-div">
                <input type="button" value="Download" class="dwnldBtn" id="download-indicators">
            </div><!-- header-div -->
            <table border="1" cellpadding="0" cellspacing="0" width="100%" id="dataTable-indicators">
                <thead>
                    <th>Indicators</th>
                    <th>North</th>
                    <th>South</th>
                    <th>East</th>
                    <th>West</th>
                    <th>Total</th>
                </thead>
                <tbody id="incators">
                </tbody>
            </table>
        </div><!-- table-responsive -->
    </div><!-- col-6 -->
</div><!-- row -->

<hr>

<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="table-responsive table-layout">
            <div class="header-div">
                <label>From</label> <input type="date" id="indi_date_frm" name="indi_date_frm">
                <label>To</label> <input type="date" id="indi_date_to" name="indi_date_to">
                <input type="button" value="Submit" id="btn_indi">
                <input type="button" value="Reset" id="btn_indi-reset">
                <input type="button" value="Download" class="dwnldBtn" id="download-core-indicators">
            </div><!-- header-div -->
            <table border="1" cellpadding="0" cellspacing="0" width="100%" id="dataTable-core-indicators">
                <thead>
                    <tr>
                        <th colspan="5" style="text-align: center;">A : Core Indicators</th>
                    </tr>
                </thead>
                <tbody id="indicators"></tbody>
            </table>
        </div><!-- table-responsive -->
    </div><!-- col-6 -->
</div><!-- row -->

</div><!-- dashboard-view -->



@endsection
@push('scripts')
<script src="
https://cdn.jsdelivr.net/npm/jquery-scroll-lock@3.1.3/jquery-scrollLock.min.js
"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script type="text/javascript" src="http://code.highcharts.com/highcharts.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/a ... "></script>
<script type="text/javascript" src="https://code.highcharts.com/highcharts.js"></script>
<script src=
"//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js">
    </script>
<script>
	$(document).ready(function () {
		$('#download-core-indicators').on('click', function () {
			$("#dataTable-core-indicators").table2excel({
				filename: "core-indicators.xls"
			});
		});
	});

	$(document).ready(function () {
		$('#download-indicators').on('click', function () {
			$("#dataTable-indicators").table2excel({
				filename: "indicators.xls"
			});
		});
	});
</script>

<script type="text/javascript">
	$(document).ready(function() {
		var options = {
			chart: {
				renderTo: 'container',
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false
			},
			title: {
				text: 'OutReach'
			},
			tooltip: {
				formatter: function() {
					return '<b>' + this.point.name + '</b>: ' + this.y + " %";
				}
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					dataLabels: {
						enabled: true,
						color: '#000000',
						connectorColor: '#000000',
						formatter: function() {
							return '<b>' + this.point.name + '</b>: ' + this.y + ' %';
						}
					},
					showInLegend: true
				}
			},
			series: []
		};



		 $.getJSON("{{route('outreach.manually.datapiechart') }}", function(json) {
		 	console.log(json);
		     options.series = json;
		     chart = new Highcharts.Chart(options);
		});


		$("#btn_outreach").click(function() {

			var pop = $("#target_pop").val();
			var date_frm = $("#date_frm").val();
			var date_to = $("#date_to").val();
			var region_outreach = $("#region_outreach").val();
			var state_outreach = $("#state_outreach").val();
			var virtual_outreach = $("#virtual_outreach").val();

			var myObject = {
				pop: pop,
				date_frm: date_frm,
				date_to: date_to,
				region_outreach: region_outreach,
				state_outreach: state_outreach,
				virtual_outreach: virtual_outreach
			};

			$.getJSON("{{route('outreach.manually.datapiechart') }}", myObject, function(json) {
				console.log(json);

				options.series = json;
				chart = new Highcharts.Chart(options);
			});

		});
		
		$("#btn_outreach-reset").click(function(){
				 $.getJSON("{{route('outreach.manually.datapiechart') }}", function(json) {
					console.log(json);
					
					options.series = json;
					chart = new Highcharts.Chart(options);

					$("#target_pop").val("");
					$("#date_frm").val("");
					$("#date_to").val("");
					$("#region_outreach").val("");
					$("#state_outreach").val("");
					$("#virtual_outreach").val("");
				});
				
			});

		// Risk Assesment


		var Risk = {
			chart: {
				renderTo: 'Risk_Assesment',
				type: 'column'
			},
			title: {
				text: 'Risk Assessment',
				x: -20 //center
			},
			subtitle: {
				text: 'Risk Assessment',
				x: -20
			},
			xAxis: {
				categories: []
			},
			yAxis: {
				title: {
					text: 'Risk Assessment'
				},
				plotLines: [{
					value: 0,
					width: 1,
					color: '#808080'
				}]
			},
			tooltip: {
				headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
				pointFormat: '<span style="color:{point.color}">{point.name}</span>:<b>{point.y}</b> of total<br/>'
			},
			plotOptions: {
				series: {
					borderWidth: 0,
					dataLabels: {
						enabled: true,
						format: '{point.y}'
					}
				}
			},
			legend: false,
			series: []
		};

		$.getJSON("{{route('outreach.manually.datapiechartrisk') }}", function(json) {
		console.log(json);					
		Risk.xAxis.categories = json[0]['data']; //xAxis: {categories: []}
		Risk.series[0] = json[1];
		chart = new Highcharts.Chart(Risk);
		});

		$("#btn_risk_assignment").click(function() {

			var region = $("#region").val();
			var risk_date_frm = $("#risk_date_frm").val();
			var risk_date_to = $("#risk_date_to").val();
			var virtual_id = $("#virtual").val();
			var state_risk = $("#state_risk").val();
			var target_pop_risk = $("#target_pop_risk").val();
			var risk_category = $("#risk_category").val();
			var app_risk = $("#app_risk").val();

			var myObject = {
				region: region,
				risk_date_frm: risk_date_frm,
				risk_date_to: risk_date_to,
				virtual_id: virtual_id,
				state_risk: state_risk,
				target_pop_risk: target_pop_risk,
				risk_category: risk_category,
				app_risk: app_risk
			};
			$.getJSON("{{route('outreach.manually.datapiechartrisk') }}", myObject, function(json) {
				//console.log(json);					
				Risk.xAxis.categories = json[0]['data']; //xAxis: {categories: []}
				Risk.series[0] = json[1];
				chart = new Highcharts.Chart(Risk);
			});


		});
		$("#btn_risk_assignment-reset").click(function() {
			$.getJSON("{{route('outreach.manually.datapiechartrisk') }}", function(json) {
				//console.log(json);					
				Risk.xAxis.categories = json[0]['data']; //xAxis: {categories: []}
				Risk.series[0] = json[1];
				chart = new Highcharts.Chart(Risk);
			});
			//clear 
			$("#region").val("");
			$("#risk_date_frm").val("");
			$("#risk_date_to").val("");
			$("#virtual").val("");
			$("#state_risk").val("");
			$("#target_pop_risk").val("");
			$("#risk_category").val("");
			$("#app_risk").val("");
		});



		//Referred for services 

		var Referred = {
			chart: {
				renderTo: 'Referred_services',
				type: 'column'
			},
			title: {
				text: 'Referred for services',
				x: -20 //center
			},
			subtitle: {
				text: 'Referred for services',
				x: -20
			},
			xAxis: {
				categories: []
			},
			yAxis: {
				title: {
					text: 'Referred for services'
				},
				plotLines: [{
					value: 0,
					width: 1,
					color: '#808080'
				}]
			},
			tooltip: {
				headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
				pointFormat: '<span style="color:{point.color}">{point.name}</span>:<b>{point.y}</b> of total<br/>'
			},
			plotOptions: {
				series: {
					borderWidth: 0,
					dataLabels: {
						enabled: true,
						format: '{point.y}'
					}
				}
			},
			legend: false,
			series: []
		};

		$.getJSON("{{route('outreach.manually.datapiechartreferred') }}", function(json) {
		// 	//console.log(json);					
		   Referred.xAxis.categories = json[0]['data']; //xAxis: {categories: []}
		   Referred.series[0] = json[1];
		   chart = new Highcharts.Chart(Referred);
		});

		$("#btn_referred").click(function() {

			var region = $("#referral_region").val();
			var state_referral = $("#state_referral").val();
			var referred_date_frm = $("#referred_date_frm").val();
			var referred_date_to = $("#referred_date_to").val();
			var virtual_referred = $("#virtual_referred").val();
			var health_facility = $("#health_facility").val();
			var referred_typology = $("#referred_typology").val();
			var risk_category = $("#referred_risk_category").val();
			var type_test = $("#referred_type_test").val();
			var client_type = $("#referred_client_type").val();
			var app_referred = $("#app_referred").val();
			var service_referral = $("#service_referral").val();

			var myObject = {
				region: region,
				state_referral: state_referral,
				referred_date_frm: referred_date_frm,
				referred_date_to: referred_date_to,
				virtual_referred: virtual_referred,
				health_facility: health_facility,
				referred_typology: referred_typology,
				risk_category: risk_category,
				type_test: type_test,
				client_type: client_type,
				app_referred: app_referred,
				service_referral: service_referral
			};
			$.getJSON("{{route('outreach.manually.datapiechartreferred') }}", myObject, function(json) {
				//console.log(json);					
				Referred.xAxis.categories = json[0]['data']; //xAxis: {categories: []}
				Referred.series[0] = json[1];
				chart = new Highcharts.Chart(Referred);
			});


		});

		$("#btn_referred-reset").click(function() {
    $.getJSON("{{route('outreach.manually.datapiechartreferred')}}", function(json) {

		$.getJSON("{{route('outreach.manually.datapiechartreferred') }}", function(json) {
		// 	//console.log(json);					
		   Referred.xAxis.categories = json[0]['data']; //xAxis: {categories: []}
		   Referred.series[0] = json[1];
		   chart = new Highcharts.Chart(Referred);
		});
        // Reset form values
        $("#referral_region").val("");
        $("#state_referral").val("");
        $("#referred_date_frm").val("");
        $("#referred_date_to").val("");
        $("#virtual_referred").val("");
        $("#health_facility").val("");
        $("#referred_typology").val("");
        $("#referred_risk_category").val("");
        $("#referred_type_test").val("");
        $("#referred_client_type").val("");
        $("#app_referred").val("");
        $("#service_referral").val("");
    });
});


		//4.	Availed services 

		var availedservices = {
			chart: {
				renderTo: 'availed_services',
				type: 'column'
			},
			title: {
				text: 'Availed Services',
				x: -20 //center
			},
			subtitle: {
				text: 'Availed Services',
				x: -20
			},
			xAxis: {
				categories: []
			},
			yAxis: {
				title: {
					text: 'Availed Services'
				},
				plotLines: [{
					value: 0,
					width: 1,
					color: '#808080'
				}]
			},
			tooltip: {
				headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
				pointFormat: '<span style="color:{point.color}">{point.name}</span>:<b>{point.y}</b> of total<br/>'
			},
			plotOptions: {
				series: {
					borderWidth: 0,
					dataLabels: {
						enabled: true,
						format: '{point.y}'
					}
				}
			},
			legend: false,
			series: []
		};

		$.getJSON("{{route('outreach.manually.datapiechartavailedservices') }}", function(json) {
		// 	//console.log(json);					
		availedservices.xAxis.categories = json[0]['data']; //xAxis: {categories: []}
		availedservices.series[0] = json[1];
		chart = new Highcharts.Chart(availedservices);
		});

		$("#btn_as").click(function() {

			var region = $("#availed_services_region").val();
			var as_date_frm = $("#as_date_frm").val();
			var as_date_to = $("#as_date_to").val();
			var virtual_id = $("#as_virtual").val();
			var as_health_facility = $("#as_health_facility").val();
			var as_referred_typology = $("#as_referred_typology").val();
			var as_risk_category = $("#as_risk_category").val();
			var as_type_test = $("#as_type_test").val();
			var as_app = $("#as_app").val();
			var as_client_type = $("#as_client_type").val();
			var state_availed = $("#state_availed").val();
			var as_service = $("#as_service").val();

			var myObject = {
				region: region,
				as_date_frm: as_date_frm,
				as_date_to: as_date_to,
				virtual_id: virtual_id,
				as_health_facility: as_health_facility,
				as_referred_typology: as_referred_typology,
				as_risk_category: as_risk_category,
				as_type_test: as_type_test,
				as_app: as_app,
				as_client_type: as_client_type,
				state_availed: state_availed,
				as_service: as_service
			};
			$.getJSON("{{route('outreach.manually.datapiechartavailedservices') }}", myObject, function(json) {
				//console.log(json);					
				availedservices.xAxis.categories = json[0]['data']; //xAxis: {categories: []}
				availedservices.series[0] = json[1];
				chart = new Highcharts.Chart(availedservices);
			});


		});
		$("#btn_as-reset").click(function() {
			$.getJSON("{{route('outreach.manually.datapiechartavailedservices') }}", function(json) {			
			availedservices.xAxis.categories = json[0]['data']; 
			availedservices.series[0] = json[1];
			chart = new Highcharts.Chart(availedservices);
			});

			// Reset form values
			$("#availed_services_region").val("");
			$("#as_date_frm").val("");
			$("#as_date_to").val("");
			$("#as_virtual").val("");
			$("#as_health_facility").val("");
			$("#as_referred_typology").val("");
			$("#as_risk_category").val("");
			$("#as_type_test").val("");
			$("#as_app").val("");
			$("#as_client_type").val("");
			$("#state_availed").val("");
			$("#as_service").val("");
		});



		// Bar chart configuration for HIV positivity rate
		var hiv_positivity_bar = {
			chart: {
				renderTo: 'hiv_positivity',
				type: 'column'
			},
			title: {
				text: 'HIV positivity rate',
				x: -20 //center
			},
			subtitle: {
				text: 'HIV positivity rate',
				x: -20
			},
			xAxis: {
				categories: [],
				title: {
					text: ''
				}
			},
			yAxis: {
				title: {
					text: 'HIV positivity rate'
				},
				plotLines: [{
					value: 0,
					width: 1,
					color: '#808080'
				}]
			},
			tooltip: {
				valueSuffix: ''
			},
			legend: false,
			series: []
		};

		// Fetch data for HIV positivity rate and populate the bar chart
		$.getJSON("{{route('outreach.manually.hivpositivity') }}", function(json) {
			hiv_positivity_bar.xAxis.categories = json[0]['data'];
			hiv_positivity_bar.series[0] = json[1];
			chart = new Highcharts.Chart(hiv_positivity_bar);
		});

		// Event listener for button click to update the bar chart with new data
		$("#btn_hp").click(function() {
			var hp_date_frm = $("#hp_date_frm").val();
			var hp_date_to = $("#hp_date_to").val();
			var virtual_id = $("#hp_virtual").val();
			var hp_referred_typology = $("#hp_referred_typology").val();
			// var hp_states = $("#hp_states").val();

			var myObject = {
				hp_date_frm: hp_date_frm,
				hp_date_to: hp_date_to,
				virtual_id: virtual_id,
				hp_referred_typology: hp_referred_typology,
				// hp_states: hp_states
			};

			// Fetch new data based on user input and update the bar chart
			$.getJSON("{{route('outreach.manually.hivpositivity') }}", myObject, function(json) {
				hiv_positivity_bar.xAxis.categories = json[0]['data'];
				hiv_positivity_bar.series[0] = json[1];
				chart = new Highcharts.Chart(hiv_positivity_bar);
			});
		});

		$("#btn_hp-reset").click(function() {
			$.getJSON("{{route('outreach.manually.hivpositivity')}}", function(json) {
				// Update chart data
				hiv_positivity_bar.xAxis.categories = json[0]['data'];
				hiv_positivity_bar.series[0] = json[1];
				chart = new Highcharts.Chart(hiv_positivity_bar);

				// Reset form values
				$("#hp_date_frm").val("");
				$("#hp_date_to").val("");
				$("#hp_virtual").val("");
				$("#hp_referred_typology").val("");
			});
		});




		var hiv_referral_conversion_rate = {
			chart: {
				renderTo: 'hiv_referral_conversion_rate',
				type: 'column'
			},
			title: {
				text: 'HIV referral conversion rate',
				x: -20 //center
			},
			subtitle: {
				text: 'HIV positivity rate ',
				x: -20
			},
			xAxis: {
				categories: [],
				title: {
					text: ''
				}
			},
			yAxis: {
				title: {
					text: 'HIV referral conversion rate'
				},
				plotLines: [{
					value: 0,
					width: 1,
					color: '#808080'
				}]
			},
			tooltip: {
				valueSuffix: ''
			},
			legend: false,
			series: []
		};

		$.getJSON("{{route('outreach.manually.hiv.referralconversion.rate') }}", function(json) {
			 hiv_referral_conversion_rate.xAxis.categories = json[0]['data']; //xAxis: {categories: []}
		    hiv_referral_conversion_rate.series[0] = json[1];
		    chart = new Highcharts.Chart(hiv_referral_conversion_rate);;
		});


		$("#btn_cr").click(function() {
			var virtual_id = $("#cr_virtual_referred").val();
			// var cr_states = $("#cr_states").val();
			var cr_date_frm = $("#cr_date_frm").val();
			var cr_date_to = $("#cr_date_to").val();
			var cr_referred_typology = $("#cr_referred_typology").val();


			var myObject = {
				virtual_id: virtual_id,
				// cr_states: cr_states,
				cr_date_frm: cr_date_frm,
				cr_date_to: cr_date_to,
				cr_referred_typology: cr_referred_typology,

			};
			$.getJSON("{{route('outreach.manually.hiv.referralconversion.rate') }}", myObject, function(json) {
				//console.log(json);					
				hiv_referral_conversion_rate.xAxis.categories = json[0]['data']; //xAxis: {categories: []}
				hiv_referral_conversion_rate.series[0] = json[1];
				chart = new Highcharts.Chart(hiv_referral_conversion_rate);;
			});


		});

		$("#btn_cr-reset").click(function() {
			$.getJSON("{{route('outreach.manually.hiv.referralconversion.rate')}}", function(json) {
				// Update chart data
				hiv_referral_conversion_rate.xAxis.categories = json[0]['data'];
				hiv_referral_conversion_rate.series[0] = json[1];
				chart = new Highcharts.Chart(hiv_referral_conversion_rate);

				// Reset form values
				$("#cr_virtual_referred").val("");
				$("#cr_date_frm").val("");
				$("#cr_date_to").val("");
				$("#cr_referred_typology").val("");
			});
		});




		var sti_positivity = {
			chart: {
				renderTo: 'sti_positivity',
				type: 'column'
			},
			title: {
				text: 'STI positivity rate',
				x: -20 //center
			},
			subtitle: {
				text: 'STI positivity rate ',
				x: -20
			},
			xAxis: {
				categories: [],
				title: {
					text: ''
				}
			},
			yAxis: {
				title: {
					text: 'STI positivity rate'
				},
				plotLines: [{
					value: 0,
					width: 1,
					color: '#808080'
				}]
			},
			tooltip: {
				valueSuffix: ''
			},
			legend: false,
			series: []
		};
		$.getJSON("{{route('outreach.manually.hiv.sti.positivity') }}", function(json) {

			 sti_positivity.xAxis.categories = json[0]['data']; //xAxis: {categories: []}
		    sti_positivity.series[0] = json[1];
		    chart = new Highcharts.Chart(sti_positivity);;
		});

		$("#btn_sti").click(function() {


			var sti_date_frm = $("#sti_date_frm").val();
			var sti_date_to = $("#sti_date_to").val();
			var virtual_id = $("#sti_virtual").val();
			var sti_referred_typology = $("#sti_referred_typology").val();
			// var sti_states = $("#sti_states").val();



			var myObject = {
				sti_date_frm: sti_date_frm,
				sti_date_to: sti_date_to,
				virtual_id: virtual_id,
				sti_referred_typology: sti_referred_typology,
				// sti_states: sti_states
			};
			$.getJSON("{{route('outreach.manually.hiv.sti.positivity') }}", myObject, function(json) {
				//console.log(json);					
				sti_positivity.xAxis.categories = json[0]['data']; //xAxis: {categories: []}
				sti_positivity.series[0] = json[1];
				chart = new Highcharts.Chart(sti_positivity);
			});


		});

		$("#btn_sti-reset").click(function() {
			$.getJSON("{{route('outreach.manually.hiv.sti.positivity')}}", function(json) {
				// Update chart data
				sti_positivity.xAxis.categories = json[0]['data'];
				sti_positivity.series[0] = json[1];
				chart = new Highcharts.Chart(sti_positivity);

				// Reset form values
				$("#sti_date_frm").val("");
				$("#sti_date_to").val("");
				$("#sti_virtual").val("");
				$("#sti_referred_typology").val("");
			});
		});


		// <!--8.	One graph showing total ART linked by date, regions, states, virtual navigators, Typology.-->
		var art_linked = {
			chart: {
				renderTo: 'art_linked',
				type: 'column'
			},
			title: {
				text: 'Art Linked',
				x: -20 //center
			},
			subtitle: {
				text: 'Art Linked',
				x: -20
			},
			xAxis: {
				categories: []
			},
			yAxis: {
				title: {
					text: 'Art Linked'
				},
				plotLines: [{
					value: 0,
					width: 1,
					color: '#808080'
				}]
			},
			tooltip: {
				headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
				pointFormat: '<span style="color:{point.color}">{point.name}</span>:<b>{point.y}</b> of total<br/>'
			},
			plotOptions: {
				series: {
					borderWidth: 0,
					dataLabels: {
						enabled: true,
						format: '{point.y}'
					}
				}
			},
			legend: false,
			series: []
		};

		 $.getJSON("{{route('outreach.manually.hiv.art.positivity') }}", function(json) {
			//console.log(json);					
		    art_linked.xAxis.categories = json[0]['data']; //xAxis: {categories: []}
		    art_linked.series[0] = json[1];
		    chart = new Highcharts.Chart(art_linked);
		});


		$("#btn_art").click(function() {

			var region = $("#art_region").val();
			var art_date_frm = $("#art_date_frm").val();
			var art_date_to = $("#art_date_to").val();
			var virtual_id = $("#art_virtual").val();
			var sti_typology = $("#sti_typology").val();

			var myObject = {
				region: region,
				art_date_frm: art_date_frm,
				art_date_to: art_date_to,
				virtual_id: virtual_id,
				sti_typology: sti_typology
			};
			$.getJSON("{{route('outreach.manually.hiv.art.positivity') }}", myObject, function(json) {
				//console.log(json);					
				art_linked.xAxis.categories = json[0]['data']; //xAxis: {categories: []}
				art_linked.series[0] = json[1];
				chart = new Highcharts.Chart(art_linked);
			});


		});

		$("#btn_art-reset").click(function() {
		$.getJSON("{{route('outreach.manually.hiv.art.positivity')}}", function(json) {
			// Update chart data
			art_linked.xAxis.categories = json[0]['data'];
			art_linked.series[0] = json[1];
			chart = new Highcharts.Chart(art_linked);

			// Reset form values
			$("#art_region").val("");
			$("#art_date_frm").val("");
			$("#art_date_to").val("");
			$("#art_virtual").val("");
			$("#sti_typology").val("");
		});
	});



		setTimeout(getIndicate, 1000);
		setTimeout(getIndicators, 1000);

		$("#btn_indi").click(function() {

			getIndicate();
			getIndicators();
		})

		$("#btn_indi-reset").click(function() {
			// Reset form values
			$("#indi_date_frm").val("");
			$("#indi_date_to").val("");

			// Call functions to reset or re-fetch data if necessary
			getIndicate();
			getIndicators();
		});
	});
</script>
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script>
	function getIndicate(){

		var indi_date_frm = $("#indi_date_frm").val();
		var indi_date_to = $("#indi_date_to").val();

		var myObject = {indi:123,indi_date_frm:indi_date_frm,indi_date_to:indi_date_to};
			 $.getJSON("{{route('outreach.manually.hiv.art.indicators') }}",myObject, function(json){
					console.log(json);
				$("#incators").html(json.resultsHtml);							
			});
	}

	function getIndicators(){

		var indi_date_frm = $("#indi_date_frm").val();
		var indi_date_to = $("#indi_date_to").val();
		var myObject = {indi:123,indi_date_frm:indi_date_frm,indi_date_to:indi_date_to};
			 $.getJSON("{{route('outreach.manually.hiv.art.client.indicators') }}",myObject, function(json) {
					console.log(json);
				$("#indicators").html(json.resultsHtml);							

			});
	}

	var dateInputs = document.querySelectorAll('input[type="date"]');
	var currentDate = new Date().toISOString().split('T')[0];
	dateInputs.forEach(function(input) {
	// Set min attribute to April 1, 2021
	input.min = '2021-04-01';
	// Set max attribute to current date
	input.max = currentDate;
});
</script>


@endpush

@push('modal')

@endpush