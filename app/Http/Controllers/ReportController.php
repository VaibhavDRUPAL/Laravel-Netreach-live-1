<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Surveys;
use App\Models\CentreMaster;
use App\Models\BookAppinmentMaster;
use App\Models\DistrictMaster;
use App\Models\StateMaster;
use App\Models\VmCountStartMaster;
use App\Models\VmMaster;
use App\Models\Customer;
use App\Models\VnUploadByResults;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Validator;
use Session; 
use DB;


use App\Exports\SurveysExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function __construct()
    {
		
        $this->middleware('permission:view-user|view_survey|m-e-user-views|m-e-user-download')->except(['profile', 'profileUpdate','display']);
        $this->middleware('permission:create-user', ['only' => ['create','store']]);
        $this->middleware('permission:update-user', ['only' => ['edit','update']]);
        $this->middleware('permission:destroy-user', ['only' => ['destroy']]);		
		//$this->middleware('permission:view_survey')->except(['display']);

    }
   
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_me_report_by_pie_chart()
    {
         $title = 'User M & E Reports';
		 /* States */
	     $sql = "SELECT * FROM `state_master`";
		 $states = DB::select($sql);
		/* Users */
		$user_info = DB::select("SELECT U.id,VMS.name, VMS.last_name,VMS.state_code FROM users as U INNER JOIN vm_master AS VMS ON VMS.id = U.vms_details_ids WHERE U.user_type=2 AND VMS.name !=''");
		/* Typology */
		$typologies = DB::select("SELECT DISTINCT(target_population) FROM surveys");
		
        return view('report.index',compact('states','user_info','typologies'));
    }
	
	public function get_mereport_by_pie_chart(Request $request){
		
		//BookAppinmentMaster
		
		if($request->type==1){
				$sql = "SELECT res.target_population,COUNT(*) as total FROM (select `surveys`.`target_population`,COUNT(surveys.id) as total from `surveys` inner join `customers` as `U` on `U`.`id` = `surveys`.`user_id` 
            inner join `book_appinment_master` as `BAM` on `BAM`.`survey_id` = `surveys`.`id` 
            inner join `centre_master` as `CM` on `CM`.`id` = `BAM`.`center_ids` 
            inner join `district_master` as `D` on `D`.`district_code` = `CM`.`district_id` 
            inner join `state_master` as `SM` on `SM`.`state_code` = `D`.`state_code` 
            left join `platforms` on `platforms`.`id` = `surveys`.`platform_id` 
            left join `vn_upload_survey_files` on `vn_upload_survey_files`.`survey_id` = `surveys`.`id`
             where 1=1 group by  `surveys`.`target_population`,`surveys`.`id` order by `surveys`.`id` desc) as res WHERE 1=1 GROUP BY res.target_population ";
			$data = array();
			$user_info = DB::select($sql);
			//print_r($user_info); die();
			foreach($user_info as $row)
			{				
					$data[] = array(
						'language'		=>	!empty($row->target_population)?$row->target_population:"Blank",
						'total'			=>	$row->total,
						'color'			=>	'#' . rand(100000, 999999) . ''
					);						
			}
		}else if($request->type==2){
			$sql = "SELECT res.platforms_name,COUNT(*) as total,group_concat(res.id) as ids,res.manual_flag FROM (select surveys.id,`platforms`.`name` as platforms_name,
			COUNT(surveys.id) as total,surveys.manual_flag from `surveys` inner join `customers` as `U` on `U`.`id` = `surveys`.`user_id` 
            inner join `book_appinment_master` as `BAM` on `BAM`.`survey_id` = `surveys`.`id` 
            inner join `centre_master` as `CM` on `CM`.`id` = `BAM`.`center_ids` 
            inner join `district_master` as `D` on `D`.`district_code` = `CM`.`district_id` 
            inner join `state_master` as `SM` on `SM`.`state_code` = `D`.`state_code` 
            left join `platforms` on `platforms`.`id` = `surveys`.`platform_id` 
            left join `vn_upload_survey_files` on `vn_upload_survey_files`.`survey_id` = `surveys`.`id`
             where 1=1 group by  `surveys`.`target_population`,`surveys`.`id` order by `surveys`.`id` desc) as res WHERE 1=1 GROUP BY res.platforms_name ";
			$data = array();								
			$data1 = array();								
			
			$user_info = DB::select($sql);
			$manual_ctr = 0;
			$Walk_in_ctr=0;
			
			
			$Manual = explode(",",rtrim($user_info[0]->ids,","));
			$manual_flag_rslt = Surveys::whereIn('id', $Manual)->where("manual_flag",">",0)->get();
			$manual_ctr = $manual_flag_rslt->count();

			$Walk_in = Surveys::whereIn('id', $Manual)->where("manual_flag","=",0)->get();
			$Walk_in_ctr = $Walk_in->count();	
			
			
			$data[] = array(
						'language'		=>	"Manual",
						'total'			=>	$manual_ctr,
						'color'			=>	'#FF5733',
						'ids'			=>	''
					);	
			$data[] = array(
						'language'		=>	"Walk-in",
						'total'			=>	$Walk_in_ctr,
						'color'			=>	'#FF33F3',
						'ids'			=>	''
					);		
			
			foreach($user_info as $row)
			{				
					if(empty($row->platforms_name))
							continue;
						
					$data[] = array(
						'language'		=>	!empty($row->platforms_name)?$row->platforms_name:"Blank",
						'total'			=>	$row->total,
						'color'			=>	'#' . rand(100000, 999999) . '',
						'ids'			=>	$row->ids
					);						
			}
			
		}else if($request->type==3){
			$to_date  = date("Y-m-d",strtotime($request->to_date));
			$date_from = date("Y-m-d",strtotime($request->date_from));
			$sql = "SELECT res.platforms_name,COUNT(*) as total,group_concat(res.id) as ids,res.manual_flag FROM (select surveys.id,`platforms`.`name` as platforms_name,
			COUNT(surveys.id) as total,surveys.manual_flag from `surveys` inner join `customers` as `U` on `U`.`id` = `surveys`.`user_id` 
            inner join `book_appinment_master` as `BAM` on `BAM`.`survey_id` = `surveys`.`id` 
            inner join `centre_master` as `CM` on `CM`.`id` = `BAM`.`center_ids` 
            inner join `district_master` as `D` on `D`.`district_code` = `CM`.`district_id` 
            inner join `state_master` as `SM` on `SM`.`state_code` = `D`.`state_code` 
            left join `platforms` on `platforms`.`id` = `surveys`.`platform_id` 
            left join `vn_upload_survey_files` on `vn_upload_survey_files`.`survey_id` = `surveys`.`id`
             where 1=1 group by  `surveys`.`target_population`,`surveys`.`id` order by `surveys`.`id` desc) as res WHERE 1=1 GROUP BY res.platforms_name ";
			$data = array();								
			$data1 = array();								
			
			$user_info = DB::select($sql);
			$manual_ctr = 0;
			$Walk_in_ctr=0;
			
			
			$Manual = explode(",",rtrim($user_info[0]->ids,","));
			$manual_flag_rslt = Surveys::whereIn('id', $Manual)->where("manual_flag",">",0)->get();
			$manual_ctr = $manual_flag_rslt->count();

			$Walk_in = Surveys::whereIn('id', $Manual)->where("manual_flag","=",0)->get();
			$Walk_in_ctr = $Walk_in->count();	
			
			
			$data[] = array(
						'language'		=>	"Manual",
						'total'			=>	$manual_ctr,
						'color'			=>	'#FF5733',
						'ids'			=>	''
					);	
			$data[] = array(
						'language'		=>	"Walk-in",
						'total'			=>	$Walk_in_ctr,
						'color'			=>	'#FF33F3',
						'ids'			=>	''
					);		
			
			foreach($user_info as $row)
			{				
					if(empty($row->platforms_name))
							continue;
						
					$data[] = array(
						'language'		=>	!empty($row->platforms_name)?$row->platforms_name:"Blank",
						'total'			=>	$row->total,
						'color'			=>	'#' . rand(100000, 999999) . '',
						'ids'			=>	$row->ids
					);						
			}
			
		}
		
		echo json_encode($data);
		exit;
		
		
	}
	
	public function get_mereport_by_bar_chart(Request $request){
	
		
		if($request->type==1){ 
				$sql = "SELECT U.id,VMS.name, VMS.last_name,VMS.state_code FROM users as U INNER JOIN vm_master AS VMS ON VMS.id = U.vms_details_ids WHERE U.user_type=2 ";
			$data = array();
			$user_info = DB::select($sql);
			
			foreach($user_info as $row)
			{			
										
			$rlst = Surveys::select('U.name AS client_name','U.phone_number as client_phone_number','surveys.client_type','BAM.created_at as book_date'
			,'D.district_name','SM.state_name','surveys.your_age','surveys.identify_yourself',
			'surveys.target_population','surveys.risk_level','U.uid',
			'surveys.services_required','CM.services_avail','BAM.appoint_date',
			'CM.name as center_name',
			'platforms.name as platforms_name','surveys.hiv_test'
			,'surveys.flag','vn_upload_survey_files.acess_date','vn_upload_survey_files.pid','vn_upload_survey_files.outcome'
			)
			->join('customers as U', 'U.id', '=', 'surveys.user_id')
			->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
			->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
			->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
			->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
			->leftJoin('platforms','platforms.id', '=', 'surveys.platform_id')
			->leftJoin('vn_upload_survey_files','vn_upload_survey_files.survey_id', '=', 'surveys.id')				
			->whereIn('BAM.state_id', explode(",",$row->state_code))
			->orderBy('surveys.id', 'DESC')->get();
					
					$data[] = array(
						'language'		=>	!empty($row->name)?trim($row->name." ".$row->last_name):"Blank",
						'total'			=>	$rlst->count(),
						'color'			=>	'#' . rand(100000, 999999) . ''
					);						
			}
		}else if($request->type==3){
			$sql = 'SELECT 
						CASE WHEN region =1 THEN "North"	
						WHEN region = 2 THEN "South"
						WHEN region = 3 THEN "East"
						WHEN region = 4 THEN "West"
						ELSE ""
						END as region
						,
						GROUP_CONCAT(state_code) as state_code FROM `state_master` WHERE 1=1  GROUP BY region ';
			$data = array();											
			$region = DB::select($sql);
			foreach($region as $key=>$value){
				
				
				$rlst = Surveys::select('U.name AS client_name','U.phone_number as client_phone_number','surveys.client_type','BAM.created_at as book_date'
			,'D.district_name','SM.state_name','surveys.your_age','surveys.identify_yourself',
			'surveys.target_population','surveys.risk_level','U.uid',
			'surveys.services_required','CM.services_avail','BAM.appoint_date',
			'CM.name as center_name',
			'platforms.name as platforms_name','surveys.hiv_test'
			,'surveys.flag','vn_upload_survey_files.acess_date','vn_upload_survey_files.pid','vn_upload_survey_files.outcome'
			)
			->join('customers as U', 'U.id', '=', 'surveys.user_id')
			->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
			->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
			->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
			->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
			->leftJoin('platforms','platforms.id', '=', 'surveys.platform_id')
			->leftJoin('vn_upload_survey_files','vn_upload_survey_files.survey_id', '=', 'surveys.id')				
			->whereIn('BAM.state_id', explode(",",$value->state_code))
			->orderBy('surveys.id', 'DESC')->get();
				
				
				$data[] = array(
						'language'		=>	$value->region,
						'total'			=>	$rlst->count(),
						'color'			=>	'#FF5733',
						'ids'			=>	''
					);	
				
			}
						
		}else if($request->type==4){
			
			$state_result = StateMaster::all();
			foreach($state_result as $key=>$value){
				$stateCodeArr = array();
				$stateCodeArr[] = $value->state_code;
				$rlst = Surveys::select('U.name AS client_name','U.phone_number as client_phone_number','surveys.client_type','BAM.created_at as book_date'
			,'D.district_name','SM.state_name','surveys.your_age','surveys.identify_yourself',
			'surveys.target_population','surveys.risk_level','U.uid',
			'surveys.services_required','CM.services_avail','BAM.appoint_date',
			'CM.name as center_name',
			'platforms.name as platforms_name','surveys.hiv_test'
			,'surveys.flag','vn_upload_survey_files.acess_date','vn_upload_survey_files.pid','vn_upload_survey_files.outcome'
			)
			->join('customers as U', 'U.id', '=', 'surveys.user_id')
			->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
			->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
			->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
			->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
			->leftJoin('platforms','platforms.id', '=', 'surveys.platform_id')
			->leftJoin('vn_upload_survey_files','vn_upload_survey_files.survey_id', '=', 'surveys.id')				
			->whereIn('BAM.state_id', $stateCodeArr)
			->orderBy('surveys.id', 'DESC')->get();
				
				
				$data[] = array(
						'language'		=>	$value->state_name,
						'total'			=>	$rlst->count(),
						'color'			=>	'#FF5733',
						'ids'			=>	''
					);	
				
				
			}
			
		}else if($request->type==2){
			
			$to_date  = date("Y-m-d",strtotime($request->to_date));
			$date_from = date("Y-m-d",strtotime($request->date_from));
			//risk_level
			$rlst = Surveys::select('surveys.risk_level',DB::raw('COUNT(surveys.risk_level) AS ctr_total_risk'))
			->join('customers as U', 'U.id', '=', 'surveys.user_id')
			->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
			->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
			->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
			->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
			->leftJoin('platforms','platforms.id', '=', 'surveys.platform_id')
			->leftJoin('vn_upload_survey_files','vn_upload_survey_files.survey_id', '=', 'surveys.id')				
			->whereRaw("DATE(BAM.created_at) >='$to_date' AND  DATE(BAM.created_at) <='$date_from'")
			->groupBy('surveys.risk_level')
			->orderBy('surveys.id', 'DESC')->get();
			
			foreach($rlst as $key=>$val){
				
				$data[] = array(
						'language'		=>	$val->risk_level,
						'total'			=>	$val->ctr_total_risk,
						'color'			=>	'#FF5733',
						'ids'			=>	''
					);	
				
				
			}
			
		}
		
		echo json_encode($data);
		exit;
		
		
	}
	
	
	public function get_mereport_by_bar_service(Request $request){
	//	echo $request->type; die();
		$serviceArr = array(1=>"HIV Test",2=>"STI Services",3=>"Pre-Exposure Prophylaxis (PrEP)",5=>"Counselling,6:Referral to TI / CBO / NGO services",7=>"ART Linkages");
		$serviceColor = array(1=>"33ff57",2=>"5733ff",3=>"ffbd33",5=>"33ffbd",7=>"ff3375");
		if($request->type==1){
			foreach($serviceArr as $key=>$val){
				
				$sql = Surveys::select('surveys.id','U.name AS client_name','U.phone_number as client_phone_number','surveys.client_type','surveys.manual_flag','BAM.created_at as book_date'
			,'D.district_name','SM.state_name','surveys.your_age','surveys.identify_yourself',
			'surveys.target_population','surveys.risk_level','U.uid',
			'surveys.services_required','CM.services_avail','BAM.appoint_date',
			'CM.name as center_name',
			'platforms.name as platforms_name','surveys.hiv_test',
			'surveys.id as survey_ids','surveys.flag','vn_upload_survey_files.acess_date','vn_upload_survey_files.pid','vn_upload_survey_files.outcome','vn_upload_survey_files.file_upload','vn_upload_survey_files.detail','vn_upload_survey_files.id as file_upload_id','surveys.survey_co_flag','surveys.po_status','BAM.survey_unique_ids'
			)
			->join('customers as U', 'U.id', '=', 'surveys.user_id')
			->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
			->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
			->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
			->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
			->leftJoin('platforms','platforms.id', '=', 'surveys.platform_id')	
			->leftJoin('vn_upload_survey_files','vn_upload_survey_files.survey_id', '=', 'surveys.id')
			->whereRaw("FIND_IN_SET('".$key."',REPLACE(REPLACE(REPLACE(services_required, '[', ''),']',''),'\"',''))")
			->groupBy('surveys.id')
			->orderBy('surveys.id', 'DESC')
			->get();
				
				$color = $serviceColor[$key];
				$data[] = array('language'=>$val,'total'=>$sql->count(),'color'=>'#'.$color,'ids'=>'');
				//print_r($data); 
			}		
			
		}else if($request->type==2){
			foreach($serviceArr as $key=>$val){
				$sql = Surveys::select('surveys.id','U.name AS client_name','U.phone_number as client_phone_number','surveys.client_type','surveys.manual_flag','BAM.created_at as book_date'
				,'D.district_name','SM.state_name','surveys.your_age','surveys.identify_yourself',
				'surveys.target_population','surveys.risk_level','U.uid',
				'surveys.services_required','CM.services_avail','BAM.appoint_date', 'BAM.state_id',
				'CM.name as center_name',
				'platforms.name as platforms_name','surveys.hiv_test',
				'surveys.id as survey_ids','surveys.flag','vn_upload_survey_files.acess_date','vn_upload_survey_files.pid','vn_upload_survey_files.outcome','vn_upload_survey_files.file_upload','vn_upload_survey_files.detail','vn_upload_survey_files.id as file_upload_id','surveys.survey_co_flag','surveys.po_status','BAM.survey_unique_ids')
				->join('customers as U', 'U.id', '=', 'surveys.user_id')
				->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
				->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
				->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
				->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
				->leftJoin('platforms','platforms.id', '=', 'surveys.platform_id')	
				->leftJoin('vn_upload_survey_files','vn_upload_survey_files.survey_id', '=', 'surveys.id')
				->whereRaw("FIND_IN_SET('".$key."',REPLACE(REPLACE(REPLACE(services_required, '[', ''),']',''),'\"',''))")
				->whereIn('BAM.state_id', $StateIdArr)
				->groupBy('surveys.id')
				->orderBy('surveys.id', 'DESC')
				->get();


			}
			
		}else if($request->type == 'N' || $request->type == 'S' || $request->type == 'E' || $request->type == 'W' ){

			$type = 'N';
			$type =  $request->type;
			if($type == 'N'){
				$region = 1;
			}else if($type == 'S'){
				$region = 2;
			}else if($type == 'E'){
				$region = 3;
			}else if($type == 'W'){
				$region = 4;
			}
			
			 $sql = 'SELECT 
						CASE WHEN region =1 THEN "North"	
						WHEN region = 2 THEN "South"
						WHEN region = 3 THEN "East"
						WHEN region = 4 THEN "West"
						ELSE ""
						END as region,

						GROUP_CONCAT(state_code) as state_code FROM `state_master` WHERE 1=1 AND region="'.$region.'"  GROUP BY region ';
						//echo $sql; die();
			 $data = array();						
			 $regionSql = DB::select($sql);
			 $regionArr = array();
			 $stateCodeArr = array();			 
			    //print_r($stateCodeArr); die();			
				foreach($serviceArr as $key=>$val){
					
					$StateIdArr = explode(",",$regionSql[0]->state_code);
					$sql = Surveys::select('surveys.id','U.name AS client_name','U.phone_number as client_phone_number','surveys.client_type','surveys.manual_flag','BAM.created_at as book_date'
					,'D.district_name','SM.state_name','surveys.your_age','surveys.identify_yourself',
					'surveys.target_population','surveys.risk_level','U.uid',
					'surveys.services_required','CM.services_avail','BAM.appoint_date', 'BAM.state_id',
					'CM.name as center_name',
					'platforms.name as platforms_name','surveys.hiv_test',
					'surveys.id as survey_ids','surveys.flag','vn_upload_survey_files.acess_date','vn_upload_survey_files.pid','vn_upload_survey_files.outcome','vn_upload_survey_files.file_upload','vn_upload_survey_files.detail','vn_upload_survey_files.id as file_upload_id','surveys.survey_co_flag','surveys.po_status','BAM.survey_unique_ids')
					->join('customers as U', 'U.id', '=', 'surveys.user_id')
					->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
					->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
					->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
					->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
					->leftJoin('platforms','platforms.id', '=', 'surveys.platform_id')	
					->leftJoin('vn_upload_survey_files','vn_upload_survey_files.survey_id', '=', 'surveys.id')
					->whereRaw("FIND_IN_SET('".$key."',REPLACE(REPLACE(REPLACE(services_required, '[', ''),']',''),'\"',''))")
					->whereIn('BAM.state_id', $StateIdArr)
					->groupBy('surveys.id')
					->orderBy('surveys.id', 'DESC')
					->get();
                  //echo $sql; die();
					$color = $serviceColor[$key];
				    $data[] = array('language'=>$val,'total'=>$sql->count(),'color'=>'#'.$color,'ids'=>'');
				}
			
		}else if($request->type == 'state'){
               $state_code = $request->value;
			   foreach($serviceArr as $key=>$val){
				$sql = Surveys::select('surveys.id','U.name AS client_name','U.phone_number as client_phone_number','surveys.client_type','surveys.manual_flag','BAM.created_at as book_date'
					,'D.district_name','SM.state_name','surveys.your_age','surveys.identify_yourself',
					'surveys.target_population','surveys.risk_level','U.uid',
					'surveys.services_required','CM.services_avail','BAM.appoint_date', 'BAM.state_id',
					'CM.name as center_name',
					'platforms.name as platforms_name','surveys.hiv_test',
					'surveys.id as survey_ids','surveys.flag','vn_upload_survey_files.acess_date','vn_upload_survey_files.pid','vn_upload_survey_files.outcome','vn_upload_survey_files.file_upload','vn_upload_survey_files.detail','vn_upload_survey_files.id as file_upload_id','surveys.survey_co_flag','surveys.po_status','BAM.survey_unique_ids')
					->join('customers as U', 'U.id', '=', 'surveys.user_id')
					->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
					->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
					->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
					->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
					->leftJoin('platforms','platforms.id', '=', 'surveys.platform_id')	
					->leftJoin('vn_upload_survey_files','vn_upload_survey_files.survey_id', '=', 'surveys.id')
					->whereRaw("FIND_IN_SET('".$key."',REPLACE(REPLACE(REPLACE(services_required, '[', ''),']',''),'\"',''))")
					->where('BAM.state_id', $state_code)
					->groupBy('surveys.id')
					->orderBy('surveys.id', 'DESC')
					->get();
                  //echo $sql; die();
					$color = $serviceColor[$key];
				    $data[] = array('language'=>$val,'total'=>$sql->count(),'color'=>'#'.$color,'ids'=>'');
                  // print_r($data); die("dire");
			   }
        
		}else if($request->type == 'vn'){
		
			foreach($serviceArr as $key=>$val){
				$sql = Surveys::select('surveys.id','U.name AS client_name','U.phone_number as client_phone_number','surveys.client_type','surveys.manual_flag','BAM.created_at as book_date'
				,'D.district_name','SM.state_name','surveys.your_age','surveys.identify_yourself',
				'surveys.target_population','surveys.risk_level','U.uid',
				'surveys.services_required','CM.services_avail','BAM.appoint_date', 'BAM.state_id',
				'CM.name as center_name',
				'platforms.name as platforms_name','surveys.hiv_test',
				'surveys.id as survey_ids','surveys.flag','vn_upload_survey_files.acess_date','vn_upload_survey_files.pid','vn_upload_survey_files.outcome','vn_upload_survey_files.file_upload','vn_upload_survey_files.detail','vn_upload_survey_files.id as file_upload_id','surveys.survey_co_flag','surveys.po_status','BAM.survey_unique_ids')
				->join('customers as U', 'U.id', '=', 'surveys.user_id')
				->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
				->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
				->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
				->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
				->leftJoin('platforms','platforms.id', '=', 'surveys.platform_id')	
				->leftJoin('vn_upload_survey_files','vn_upload_survey_files.survey_id', '=', 'surveys.id')
				->whereRaw("FIND_IN_SET('".$key."',REPLACE(REPLACE(REPLACE(services_required, '[', ''),']',''),'\"',''))")
				->where('surveys.user_id', $user_id)
				->groupBy('surveys.id')
				->orderBy('surveys.id', 'DESC')
				->get();
			  //echo $sql; die();
				$color = $serviceColor[$key];
				$data[] = array('language'=>$val,'total'=>$sql->count(),'color'=>'#'.$color,'ids'=>'');

			}
		}else if($request->type == 'topology'){
			$target_population = $request->value;
			foreach($serviceArr as $key=>$val){
				$sql = Surveys::select('surveys.id','U.name AS client_name','U.phone_number as client_phone_number','surveys.client_type','surveys.manual_flag','BAM.created_at as book_date'
				,'D.district_name','SM.state_name','surveys.your_age','surveys.identify_yourself',
				'surveys.target_population','surveys.risk_level','U.uid',
				'surveys.services_required','CM.services_avail','BAM.appoint_date', 'BAM.state_id',
				'CM.name as center_name',
				'platforms.name as platforms_name','surveys.hiv_test',
				'surveys.id as survey_ids','surveys.flag','vn_upload_survey_files.acess_date','vn_upload_survey_files.pid','vn_upload_survey_files.outcome','vn_upload_survey_files.file_upload','vn_upload_survey_files.detail','vn_upload_survey_files.id as file_upload_id','surveys.survey_co_flag','surveys.po_status','BAM.survey_unique_ids')
				->join('customers as U', 'U.id', '=', 'surveys.user_id')
				->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
				->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
				->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
				->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
				->leftJoin('platforms','platforms.id', '=', 'surveys.platform_id')	
				->leftJoin('vn_upload_survey_files','vn_upload_survey_files.survey_id', '=', 'surveys.id')
				->whereRaw("FIND_IN_SET('".$key."',REPLACE(REPLACE(REPLACE(services_required, '[', ''),']',''),'\"',''))")
				->where('surveys.target_population', $target_population)
				->groupBy('surveys.id')
				->orderBy('surveys.id', 'DESC')
				->get();
				$color = $serviceColor[$key];
				$data[] = array('language'=>$val,'total'=>$sql->count(),'color'=>'#'.$color,'ids'=>'');

			}

		}else if($request->type == 'risk'){
			$risk_level = $request->value;
			foreach($serviceArr as $key=>$val){
				$sql = Surveys::select('surveys.id','U.name AS client_name','U.phone_number as client_phone_number','surveys.client_type','surveys.manual_flag','BAM.created_at as book_date'
				,'D.district_name','SM.state_name','surveys.your_age','surveys.identify_yourself',
				'surveys.target_population','surveys.risk_level','U.uid',
				'surveys.services_required','CM.services_avail','BAM.appoint_date', 'BAM.state_id',
				'CM.name as center_name',
				'platforms.name as platforms_name','surveys.hiv_test',
				'surveys.id as survey_ids','surveys.flag','vn_upload_survey_files.acess_date','vn_upload_survey_files.pid','vn_upload_survey_files.outcome','vn_upload_survey_files.file_upload','vn_upload_survey_files.detail','vn_upload_survey_files.id as file_upload_id','surveys.survey_co_flag','surveys.po_status','BAM.survey_unique_ids')
				->join('customers as U', 'U.id', '=', 'surveys.user_id')
				->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
				->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
				->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
				->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
				->leftJoin('platforms','platforms.id', '=', 'surveys.platform_id')	
				->leftJoin('vn_upload_survey_files','vn_upload_survey_files.survey_id', '=', 'surveys.id')
				->whereRaw("FIND_IN_SET('".$key."',REPLACE(REPLACE(REPLACE(services_required, '[', ''),']',''),'\"',''))")
				->where('surveys.risk_level', $risk_level)
				->groupBy('surveys.id')
				->orderBy('surveys.id', 'DESC')
				->get();
				$color = $serviceColor[$key];
				$data[] = array('language'=>$val,'total'=>$sql->count(),'color'=>'#'.$color,'ids'=>'');


			}
		}else if($request->type == 'client'){
			$client_type = $request->value;
			foreach($serviceArr as $key=>$val){
				$sql = Surveys::select('surveys.id','U.name AS client_name','U.phone_number as client_phone_number','surveys.client_type','surveys.manual_flag','BAM.created_at as book_date'
				,'D.district_name','SM.state_name','surveys.your_age','surveys.identify_yourself',
				'surveys.target_population','surveys.risk_level','U.uid',
				'surveys.services_required','CM.services_avail','BAM.appoint_date', 'BAM.state_id',
				'CM.name as center_name',
				'platforms.name as platforms_name','surveys.hiv_test',
				'surveys.id as survey_ids','surveys.flag','vn_upload_survey_files.acess_date','vn_upload_survey_files.pid','vn_upload_survey_files.outcome','vn_upload_survey_files.file_upload','vn_upload_survey_files.detail','vn_upload_survey_files.id as file_upload_id','surveys.survey_co_flag','surveys.po_status','BAM.survey_unique_ids')
				->join('customers as U', 'U.id', '=', 'surveys.user_id')
				->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
				->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
				->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
				->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
				->leftJoin('platforms','platforms.id', '=', 'surveys.platform_id')	
				->leftJoin('vn_upload_survey_files','vn_upload_survey_files.survey_id', '=', 'surveys.id')
				->whereRaw("FIND_IN_SET('".$key."',REPLACE(REPLACE(REPLACE(services_required, '[', ''),']',''),'\"',''))")
				->where('surveys.client_type', $client_type)
				->groupBy('surveys.id')
				->orderBy('surveys.id', 'DESC')
				->get();
				$color = $serviceColor[$key];
				$data[] = array('language'=>$val,'total'=>$sql->count(),'color'=>'#'.$color,'ids'=>'');


			}
		}else if($request->type == 'date'){
			$to_date  = date("Y-m-d",strtotime($request->to_date));
			$date_from = date("Y-m-d",strtotime($request->date_from));
		
			foreach($serviceArr as $key=>$val){
				$sql = Surveys::select('surveys.id','U.name AS client_name','U.phone_number as client_phone_number','surveys.client_type','surveys.manual_flag','BAM.created_at as book_date'
				,'D.district_name','SM.state_name','surveys.your_age','surveys.identify_yourself',
				'surveys.target_population','surveys.risk_level','U.uid',
				'surveys.services_required','CM.services_avail','BAM.appoint_date', 'BAM.state_id',
				'CM.name as center_name',
				'platforms.name as platforms_name','surveys.hiv_test',
				'surveys.id as survey_ids','surveys.flag','vn_upload_survey_files.acess_date','vn_upload_survey_files.pid','vn_upload_survey_files.outcome','vn_upload_survey_files.file_upload','vn_upload_survey_files.detail','vn_upload_survey_files.id as file_upload_id','surveys.survey_co_flag','surveys.po_status','BAM.survey_unique_ids')
				->join('customers as U', 'U.id', '=', 'surveys.user_id')
				->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
				->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
				->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
				->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
				->leftJoin('platforms','platforms.id', '=', 'surveys.platform_id')	
				->leftJoin('vn_upload_survey_files','vn_upload_survey_files.survey_id', '=', 'surveys.id')
				->whereRaw("FIND_IN_SET('".$key."',REPLACE(REPLACE(REPLACE(services_required, '[', ''),']',''),'\"',''))")
				->whereRaw("DATE(BAM.created_at) >='$to_date' AND  DATE(BAM.created_at) <='$date_from'")
				->groupBy('BAM.created_at')
				->orderBy('surveys.id', 'DESC')
				->get();
				$color = $serviceColor[$key];
				$data[] = array('language'=>$val,'total'=>$sql->count(),'color'=>'#'.$color,'ids'=>'');


			}
		}else if($request->type == 'facility'){
			// $facility_type = $request->value;
			 if($request->value == 'ICTC'){ $services_avail = 1; }else if($request->value == 'FICTC'){ $services_avail = 2; }else if($request->value == 'ART'){ $services_avail = 3; } else if($request->value == 'TI'){ $services_avail = 4; }else if($request->value == 'Private'){ $services_avail = 5; }
			foreach($serviceArr as $key=>$val){
				$sql = Surveys::select('surveys.id','U.name AS client_name','U.phone_number as client_phone_number','surveys.client_type','surveys.manual_flag','BAM.created_at as book_date'
				,'D.district_name','SM.state_name','surveys.your_age','surveys.identify_yourself',
				'surveys.target_population','surveys.risk_level','U.uid',
				'surveys.services_required','CM.services_avail','BAM.appoint_date', 'BAM.state_id',
				'CM.name as center_name',
				'platforms.name as platforms_name','surveys.hiv_test',
				'surveys.id as survey_ids','surveys.flag','vn_upload_survey_files.acess_date','vn_upload_survey_files.pid','vn_upload_survey_files.outcome','vn_upload_survey_files.file_upload','vn_upload_survey_files.detail','vn_upload_survey_files.id as file_upload_id','surveys.survey_co_flag','surveys.po_status','BAM.survey_unique_ids')
				->join('customers as U', 'U.id', '=', 'surveys.user_id')
				->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
				->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
				->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
				->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
				->leftJoin('platforms','platforms.id', '=', 'surveys.platform_id')	
				->leftJoin('vn_upload_survey_files','vn_upload_survey_files.survey_id', '=', 'surveys.id')
				->whereRaw("FIND_IN_SET('".$key."',REPLACE(REPLACE(REPLACE(services_required, '[', ''),']',''),'\"',''))")
				->where('BAM.center_ids', $services_avail)
				->groupBy('surveys.id')
				->orderBy('surveys.id', 'DESC')
				->get();
			
				$color = $serviceColor[$key];
				$data[] = array('language'=>$val,'total'=>$sql->count(),'color'=>'#'.$color,'ids'=>'');
			}
		}
		
		echo json_encode($data);
		exit;
	}
	
	/** function availed serices **/
	    
		
	public function get_mereport_by_bar_availed(Request $request){

		$serviceArr = array(1=>"HIV Test",2=>"STI Services",3=>"Pre-Exposure Prophylaxis (PrEP)",5=>"Counselling,6:Referral to TI / CBO / NGO services",7=>"ART Linkages");
		$serviceColor = array(1=>"33ff57",2=>"5733ff",3=>"ffbd33",5=>"33ffbd",7=>"ff3375");
		if($request->type==1){
			foreach($serviceArr as $key=>$val){
				
			$sql = Surveys::select('surveys.id','U.name AS client_name','U.phone_number as client_phone_number','surveys.client_type','surveys.manual_flag','BAM.created_at as book_date'
			,'D.district_name','SM.state_name','surveys.your_age','surveys.identify_yourself',
			'surveys.target_population','surveys.risk_level','U.uid',
			'surveys.services_required','CM.services_avail','BAM.appoint_date',
			'CM.name as center_name',
			'platforms.name as platforms_name','surveys.hiv_test',
			'surveys.id as survey_ids','surveys.flag','vn_upload_survey_files.acess_date','vn_upload_survey_files.pid','vn_upload_survey_files.outcome','vn_upload_survey_files.file_upload','vn_upload_survey_files.detail','vn_upload_survey_files.id as file_upload_id','surveys.survey_co_flag','surveys.po_status','BAM.survey_unique_ids'
			)
			->join('customers as U', 'U.id', '=', 'surveys.user_id')
			->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
			->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
			->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
			->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
			->leftJoin('platforms','platforms.id', '=', 'surveys.platform_id')	
			->leftJoin('vn_upload_survey_files','vn_upload_survey_files.survey_id', '=', 'surveys.id')
			->whereRaw("FIND_IN_SET('".$key."',REPLACE(REPLACE(REPLACE(services_required, '[', ''),']',''),'\"',''))")
			->where('vn_upload_survey_files.pid','!=', '')
			->groupBy('surveys.id')
			->orderBy('surveys.id', 'DESC')
			->get();
				
				$color = $serviceColor[$key];
				$data[] = array('language'=>$val,'total'=>$sql->count(),'color'=>'#'.$color,'ids'=>'');
				//print_r($data); 
			}		
			
		}else if($request->type==2){
			foreach($serviceArr as $key=>$val){
				$sql = Surveys::select('surveys.id','U.name AS client_name','U.phone_number as client_phone_number','surveys.client_type','surveys.manual_flag','BAM.created_at as book_date'
				,'D.district_name','SM.state_name','surveys.your_age','surveys.identify_yourself',
				'surveys.target_population','surveys.risk_level','U.uid',
				'surveys.services_required','CM.services_avail','BAM.appoint_date', 'BAM.state_id',
				'CM.name as center_name',
				'platforms.name as platforms_name','surveys.hiv_test',
				'surveys.id as survey_ids','surveys.flag','vn_upload_survey_files.acess_date','vn_upload_survey_files.pid','vn_upload_survey_files.outcome','vn_upload_survey_files.file_upload','vn_upload_survey_files.detail','vn_upload_survey_files.id as file_upload_id','surveys.survey_co_flag','surveys.po_status','BAM.survey_unique_ids')
				->join('customers as U', 'U.id', '=', 'surveys.user_id')
				->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
				->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
				->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
				->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
				->leftJoin('platforms','platforms.id', '=', 'surveys.platform_id')	
				->leftJoin('vn_upload_survey_files','vn_upload_survey_files.survey_id', '=', 'surveys.id')
				->whereRaw("FIND_IN_SET('".$key."',REPLACE(REPLACE(REPLACE(services_required, '[', ''),']',''),'\"',''))")
				->whereIn('BAM.state_id', $StateIdArr)
				->groupBy('surveys.id')
				->orderBy('surveys.id', 'DESC')
				->get();


			}
			
		}else if($request->type == 'N' || $request->type == 'S' || $request->type == 'E' || $request->type == 'W' ){

			$type = 'N';
			$type =  $request->type;
			if($type == 'N'){
				$region = 1;
			}else if($type == 'S'){
				$region = 2;
			}else if($type == 'E'){
				$region = 3;
			}else if($type == 'W'){
				$region = 4;
			}
			
			 $sql = 'SELECT 
						CASE WHEN region =1 THEN "North"	
						WHEN region = 2 THEN "South"
						WHEN region = 3 THEN "East"
						WHEN region = 4 THEN "West"
						ELSE ""
						END as region,

						GROUP_CONCAT(state_code) as state_code FROM `state_master` WHERE 1=1 AND region="'.$region.'"  GROUP BY region ';
						//echo $sql; die();
			 $data = array();						
			 $regionSql = DB::select($sql);
			 $regionArr = array();
			 $stateCodeArr = array();			 
			    //print_r($stateCodeArr); die();			
				foreach($serviceArr as $key=>$val){
					
					$StateIdArr = explode(",",$regionSql[0]->state_code);
					$sql = Surveys::select('surveys.id','U.name AS client_name','U.phone_number as client_phone_number','surveys.client_type','surveys.manual_flag','BAM.created_at as book_date'
					,'D.district_name','SM.state_name','surveys.your_age','surveys.identify_yourself',
					'surveys.target_population','surveys.risk_level','U.uid',
					'surveys.services_required','CM.services_avail','BAM.appoint_date', 'BAM.state_id',
					'CM.name as center_name',
					'platforms.name as platforms_name','surveys.hiv_test',
					'surveys.id as survey_ids','surveys.flag','vn_upload_survey_files.acess_date','vn_upload_survey_files.pid','vn_upload_survey_files.outcome','vn_upload_survey_files.file_upload','vn_upload_survey_files.detail','vn_upload_survey_files.id as file_upload_id','surveys.survey_co_flag','surveys.po_status','BAM.survey_unique_ids')
					->join('customers as U', 'U.id', '=', 'surveys.user_id')
					->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
					->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
					->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
					->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
					->leftJoin('platforms','platforms.id', '=', 'surveys.platform_id')	
					->leftJoin('vn_upload_survey_files','vn_upload_survey_files.survey_id', '=', 'surveys.id')
					->whereRaw("FIND_IN_SET('".$key."',REPLACE(REPLACE(REPLACE(services_required, '[', ''),']',''),'\"',''))")
					->whereIn('BAM.state_id', $StateIdArr)
					->where('vn_upload_survey_files.pid','!=', '')
					->groupBy('surveys.id')
					->orderBy('surveys.id', 'DESC')
					->get();
                  //echo $sql; die();
					$color = $serviceColor[$key];
				    $data[] = array('language'=>$val,'total'=>$sql->count(),'color'=>'#'.$color,'ids'=>'');
				}
			
		}else if($request->type == 'state'){
               $state_code = $request->value;
			   foreach($serviceArr as $key=>$val){
				$sql = Surveys::select('surveys.id','U.name AS client_name','U.phone_number as client_phone_number','surveys.client_type','surveys.manual_flag','BAM.created_at as book_date'
					,'D.district_name','SM.state_name','surveys.your_age','surveys.identify_yourself',
					'surveys.target_population','surveys.risk_level','U.uid',
					'surveys.services_required','CM.services_avail','BAM.appoint_date', 'BAM.state_id',
					'CM.name as center_name',
					'platforms.name as platforms_name','surveys.hiv_test',
					'surveys.id as survey_ids','surveys.flag','vn_upload_survey_files.acess_date','vn_upload_survey_files.pid','vn_upload_survey_files.outcome','vn_upload_survey_files.file_upload','vn_upload_survey_files.detail','vn_upload_survey_files.id as file_upload_id','surveys.survey_co_flag','surveys.po_status','BAM.survey_unique_ids')
					->join('customers as U', 'U.id', '=', 'surveys.user_id')
					->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
					->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
					->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
					->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
					->leftJoin('platforms','platforms.id', '=', 'surveys.platform_id')	
					->leftJoin('vn_upload_survey_files','vn_upload_survey_files.survey_id', '=', 'surveys.id')
					->whereRaw("FIND_IN_SET('".$key."',REPLACE(REPLACE(REPLACE(services_required, '[', ''),']',''),'\"',''))")
					->where('BAM.state_id', $state_code)
					->where('vn_upload_survey_files.pid','!=', '')
					->groupBy('surveys.id')
					->orderBy('surveys.id', 'DESC')
					->get();
                  //echo $sql; die();
					$color = $serviceColor[$key];
				    $data[] = array('language'=>$val,'total'=>$sql->count(),'color'=>'#'.$color,'ids'=>'');
                  // print_r($data); die("dire");
			   }
        
		}else if($request->type == 'vn'){
			$user_id = $request->value;
			foreach($serviceArr as $key=>$val){
				$sql = Surveys::select('surveys.id','U.name AS client_name','U.phone_number as client_phone_number','surveys.client_type','surveys.manual_flag','BAM.created_at as book_date'
				,'D.district_name','SM.state_name','surveys.your_age','surveys.identify_yourself',
				'surveys.target_population','surveys.risk_level','U.uid',
				'surveys.services_required','CM.services_avail','BAM.appoint_date', 'BAM.state_id',
				'CM.name as center_name',
				'platforms.name as platforms_name','surveys.hiv_test',
				'surveys.id as survey_ids','surveys.flag','vn_upload_survey_files.acess_date','vn_upload_survey_files.pid','vn_upload_survey_files.outcome','vn_upload_survey_files.file_upload','vn_upload_survey_files.detail','vn_upload_survey_files.id as file_upload_id','surveys.survey_co_flag','surveys.po_status','BAM.survey_unique_ids')
				->join('customers as U', 'U.id', '=', 'surveys.user_id')
				->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
				->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
				->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
				->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
				->leftJoin('platforms','platforms.id', '=', 'surveys.platform_id')	
				->leftJoin('vn_upload_survey_files','vn_upload_survey_files.survey_id', '=', 'surveys.id')
				->whereRaw("FIND_IN_SET('".$key."',REPLACE(REPLACE(REPLACE(services_required, '[', ''),']',''),'\"',''))")
				->where('surveys.user_id', $user_id)
				->where('vn_upload_survey_files.pid','!=', '')
				->groupBy('surveys.id')
				->orderBy('surveys.id', 'DESC')
				->get();
			  //echo $sql; die();
				$color = $serviceColor[$key];
				$data[] = array('language'=>$val,'total'=>$sql->count(),'color'=>'#'.$color,'ids'=>'');

			}
		}else if($request->type == 'topology'){
			$target_population = $request->value;
			foreach($serviceArr as $key=>$val){
				$sql = Surveys::select('surveys.id','U.name AS client_name','U.phone_number as client_phone_number','surveys.client_type','surveys.manual_flag','BAM.created_at as book_date'
				,'D.district_name','SM.state_name','surveys.your_age','surveys.identify_yourself',
				'surveys.target_population','surveys.risk_level','U.uid',
				'surveys.services_required','CM.services_avail','BAM.appoint_date', 'BAM.state_id',
				'CM.name as center_name',
				'platforms.name as platforms_name','surveys.hiv_test',
				'surveys.id as survey_ids','surveys.flag','vn_upload_survey_files.acess_date','vn_upload_survey_files.pid','vn_upload_survey_files.outcome','vn_upload_survey_files.file_upload','vn_upload_survey_files.detail','vn_upload_survey_files.id as file_upload_id','surveys.survey_co_flag','surveys.po_status','BAM.survey_unique_ids')
				->join('customers as U', 'U.id', '=', 'surveys.user_id')
				->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
				->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
				->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
				->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
				->leftJoin('platforms','platforms.id', '=', 'surveys.platform_id')	
				->leftJoin('vn_upload_survey_files','vn_upload_survey_files.survey_id', '=', 'surveys.id')
				->whereRaw("FIND_IN_SET('".$key."',REPLACE(REPLACE(REPLACE(services_required, '[', ''),']',''),'\"',''))")
				->where('surveys.target_population', $target_population)
				->where('vn_upload_survey_files.pid','!=', '')
				->groupBy('surveys.id')
				->orderBy('surveys.id', 'DESC')
				->get();
				$color = $serviceColor[$key];
				$data[] = array('language'=>$val,'total'=>$sql->count(),'color'=>'#'.$color,'ids'=>'');

			}

		}else if($request->type == 'risk'){
			$risk_level = $request->value;
			foreach($serviceArr as $key=>$val){
				$sql = Surveys::select('surveys.id','U.name AS client_name','U.phone_number as client_phone_number','surveys.client_type','surveys.manual_flag','BAM.created_at as book_date'
				,'D.district_name','SM.state_name','surveys.your_age','surveys.identify_yourself',
				'surveys.target_population','surveys.risk_level','U.uid',
				'surveys.services_required','CM.services_avail','BAM.appoint_date', 'BAM.state_id',
				'CM.name as center_name',
				'platforms.name as platforms_name','surveys.hiv_test',
				'surveys.id as survey_ids','surveys.flag','vn_upload_survey_files.acess_date','vn_upload_survey_files.pid','vn_upload_survey_files.outcome','vn_upload_survey_files.file_upload','vn_upload_survey_files.detail','vn_upload_survey_files.id as file_upload_id','surveys.survey_co_flag','surveys.po_status','BAM.survey_unique_ids')
				->join('customers as U', 'U.id', '=', 'surveys.user_id')
				->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
				->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
				->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
				->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
				->leftJoin('platforms','platforms.id', '=', 'surveys.platform_id')	
				->leftJoin('vn_upload_survey_files','vn_upload_survey_files.survey_id', '=', 'surveys.id')
				->whereRaw("FIND_IN_SET('".$key."',REPLACE(REPLACE(REPLACE(services_required, '[', ''),']',''),'\"',''))")
				->where('surveys.risk_level', $risk_level)
				->where('vn_upload_survey_files.pid','!=', '')
				->groupBy('surveys.id')
				->orderBy('surveys.id', 'DESC')
				->get();
				$color = $serviceColor[$key];
				$data[] = array('language'=>$val,'total'=>$sql->count(),'color'=>'#'.$color,'ids'=>'');


			}
		}else if($request->type == 'client'){
			$client_type = $request->value;
			foreach($serviceArr as $key=>$val){
				$sql = Surveys::select('surveys.id','U.name AS client_name','U.phone_number as client_phone_number','surveys.client_type','surveys.manual_flag','BAM.created_at as book_date'
				,'D.district_name','SM.state_name','surveys.your_age','surveys.identify_yourself',
				'surveys.target_population','surveys.risk_level','U.uid',
				'surveys.services_required','CM.services_avail','BAM.appoint_date', 'BAM.state_id',
				'CM.name as center_name',
				'platforms.name as platforms_name','surveys.hiv_test',
				'surveys.id as survey_ids','surveys.flag','vn_upload_survey_files.acess_date','vn_upload_survey_files.pid','vn_upload_survey_files.outcome','vn_upload_survey_files.file_upload','vn_upload_survey_files.detail','vn_upload_survey_files.id as file_upload_id','surveys.survey_co_flag','surveys.po_status','BAM.survey_unique_ids')
				->join('customers as U', 'U.id', '=', 'surveys.user_id')
				->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
				->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
				->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
				->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
				->leftJoin('platforms','platforms.id', '=', 'surveys.platform_id')	
				->leftJoin('vn_upload_survey_files','vn_upload_survey_files.survey_id', '=', 'surveys.id')
				->whereRaw("FIND_IN_SET('".$key."',REPLACE(REPLACE(REPLACE(services_required, '[', ''),']',''),'\"',''))")
				->where('surveys.client_type', $client_type)
				->where('vn_upload_survey_files.pid','!=', '')
				->groupBy('surveys.id')
				->orderBy('surveys.id', 'DESC')
				->get();
				$color = $serviceColor[$key];
				$data[] = array('language'=>$val,'total'=>$sql->count(),'color'=>'#'.$color,'ids'=>'');


			}
		}else if($request->type == 'date'){
			$to_date  = date("Y-m-d",strtotime($request->to_date));
			$date_from = date("Y-m-d",strtotime($request->date_from));
		
			foreach($serviceArr as $key=>$val){
				$sql = Surveys::select('surveys.id','U.name AS client_name','U.phone_number as client_phone_number','surveys.client_type','surveys.manual_flag','BAM.created_at as book_date'
				,'D.district_name','SM.state_name','surveys.your_age','surveys.identify_yourself',
				'surveys.target_population','surveys.risk_level','U.uid',
				'surveys.services_required','CM.services_avail','BAM.appoint_date', 'BAM.state_id',
				'CM.name as center_name',
				'platforms.name as platforms_name','surveys.hiv_test',
				'surveys.id as survey_ids','surveys.flag','vn_upload_survey_files.acess_date','vn_upload_survey_files.pid','vn_upload_survey_files.outcome','vn_upload_survey_files.file_upload','vn_upload_survey_files.detail','vn_upload_survey_files.id as file_upload_id','surveys.survey_co_flag','surveys.po_status','BAM.survey_unique_ids')
				->join('customers as U', 'U.id', '=', 'surveys.user_id')
				->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
				->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
				->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
				->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
				->leftJoin('platforms','platforms.id', '=', 'surveys.platform_id')	
				->leftJoin('vn_upload_survey_files','vn_upload_survey_files.survey_id', '=', 'surveys.id')
				->whereRaw("FIND_IN_SET('".$key."',REPLACE(REPLACE(REPLACE(services_required, '[', ''),']',''),'\"',''))")
				->whereRaw("DATE(BAM.created_at) >='$to_date' AND  DATE(BAM.created_at) <='$date_from'")
				->groupBy('BAM.created_at')
				->orderBy('surveys.id', 'DESC')
				->get();
				$color = $serviceColor[$key];
				$data[] = array('language'=>$val,'total'=>$sql->count(),'color'=>'#'.$color,'ids'=>'');


			}
		}else if($request->type == 'facility'){
			// $facility_type = $request->value;
			 if($request->value == 'ICTC'){ $services_avail = 1; }else if($request->value == 'FICTC'){ $services_avail = 2; }else if($request->value == 'ART'){ $services_avail = 3; } else if($request->value == 'TI'){ $services_avail = 4; }else if($request->value == 'Private'){ $services_avail = 5; }
			foreach($serviceArr as $key=>$val){
				$sql = Surveys::select('surveys.id','U.name AS client_name','U.phone_number as client_phone_number','surveys.client_type','surveys.manual_flag','BAM.created_at as book_date'
				,'D.district_name','SM.state_name','surveys.your_age','surveys.identify_yourself',
				'surveys.target_population','surveys.risk_level','U.uid',
				'surveys.services_required','CM.services_avail','BAM.appoint_date', 'BAM.state_id',
				'CM.name as center_name',
				'platforms.name as platforms_name','surveys.hiv_test',
				'surveys.id as survey_ids','surveys.flag','vn_upload_survey_files.acess_date','vn_upload_survey_files.pid','vn_upload_survey_files.outcome','vn_upload_survey_files.file_upload','vn_upload_survey_files.detail','vn_upload_survey_files.id as file_upload_id','surveys.survey_co_flag','surveys.po_status','BAM.survey_unique_ids')
				->join('customers as U', 'U.id', '=', 'surveys.user_id')
				->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
				->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
				->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
				->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
				->leftJoin('platforms','platforms.id', '=', 'surveys.platform_id')	
				->leftJoin('vn_upload_survey_files','vn_upload_survey_files.survey_id', '=', 'surveys.id')
				->whereRaw("FIND_IN_SET('".$key."',REPLACE(REPLACE(REPLACE(services_required, '[', ''),']',''),'\"',''))")
				->where('BAM.center_ids', $services_avail)
				->where('vn_upload_survey_files.pid','!=', '')
				->groupBy('surveys.id')
				->orderBy('surveys.id', 'DESC')
				->get();
			
				$color = $serviceColor[$key];
				$data[] = array('language'=>$val,'total'=>$sql->count(),'color'=>'#'.$color,'ids'=>'');
			}
		}
		
		echo json_encode($data);
		exit;
	}

	/** HIV Positive Report **/
	public function get_mereport_by_hivrate_chart(Request $request){
        
		$serviceArr = array(1=>"HIV Test");
		$serviceColor = array(1=>"33ff57",2=>"5733ff",3=>"ffbd33",5=>"33ffbd",7=>"ff3375");
		if($request->type==1){
			foreach($serviceArr as $key=>$val){
				
			$sql = Surveys::select('surveys.id','U.name AS client_name','U.phone_number as client_phone_number','surveys.client_type','surveys.manual_flag','BAM.created_at as book_date'
			,'D.district_name','SM.state_name','surveys.your_age','surveys.identify_yourself',
			'surveys.target_population','surveys.risk_level','U.uid',
			'surveys.services_required','CM.services_avail','BAM.appoint_date',
			'CM.name as center_name',
			'platforms.name as platforms_name','surveys.hiv_test',
			'surveys.id as survey_ids','surveys.flag','vn_upload_survey_files.acess_date','vn_upload_survey_files.pid','vn_upload_survey_files.outcome','vn_upload_survey_files.file_upload','vn_upload_survey_files.detail','vn_upload_survey_files.id as file_upload_id','surveys.survey_co_flag','surveys.po_status','BAM.survey_unique_ids'
			)
			->join('customers as U', 'U.id', '=', 'surveys.user_id')
			->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
			->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
			->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
			->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
			->leftJoin('platforms','platforms.id', '=', 'surveys.platform_id')	
			->leftJoin('vn_upload_survey_files','vn_upload_survey_files.survey_id', '=', 'surveys.id')
			->whereRaw("FIND_IN_SET('".$key."',REPLACE(REPLACE(REPLACE(services_required, '[', ''),']',''),'\"',''))")
			->where('vn_upload_survey_files.pid','!=', '')
			->groupBy('surveys.id')
			->orderBy('surveys.id', 'DESC')
			->get();
				
				$color = $serviceColor[$key];
				$data[] = array('language'=>$val,'total'=>$sql->count(),'color'=>'#'.$color,'ids'=>'');
				//print_r($data); 
			}		
			
		}else if($request->type == 'N' || $request->type == 'S' || $request->type == 'E' || $request->type == 'W' ){

			$type = 'N';
			$type =  $request->type;
			if($type == 'N'){
				$region = 1;
			}else if($type == 'S'){
				$region = 2;
			}else if($type == 'E'){
				$region = 3;
			}else if($type == 'W'){
				$region = 4;
			}
			
			 $sql = 'SELECT 
						CASE WHEN region =1 THEN "North"	
						WHEN region = 2 THEN "South"
						WHEN region = 3 THEN "East"
						WHEN region = 4 THEN "West"
						ELSE ""
						END as region,

						GROUP_CONCAT(state_code) as state_code FROM `state_master` WHERE 1=1 AND region="'.$region.'"  GROUP BY region ';
						//echo $sql; die();
			 $data = array();						
			 $regionSql = DB::select($sql);
			 $regionArr = array();
			 $stateCodeArr = array();			 
			    //print_r($stateCodeArr); die();			
				foreach($serviceArr as $key=>$val){
					
					$StateIdArr = explode(",",$regionSql[0]->state_code);
					$sql_positive = Surveys::select('surveys.id','U.name AS client_name','U.phone_number as client_phone_number','surveys.client_type','surveys.manual_flag','BAM.created_at as book_date'
					,'D.district_name','SM.state_name','surveys.your_age','surveys.identify_yourself',
					'surveys.target_population','surveys.risk_level','U.uid',
					'surveys.services_required','CM.services_avail','BAM.appoint_date', 'BAM.state_id',
					'CM.name as center_name',
					'platforms.name as platforms_name','surveys.hiv_test',
					'surveys.id as survey_ids','surveys.flag','vn_upload_survey_files.acess_date','vn_upload_survey_files.pid','vn_upload_survey_files.outcome','vn_upload_survey_files.file_upload','vn_upload_survey_files.detail','vn_upload_survey_files.id as file_upload_id','surveys.survey_co_flag','surveys.po_status','BAM.survey_unique_ids')
					->join('customers as U', 'U.id', '=', 'surveys.user_id')
					->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
					->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
					->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
					->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
					->leftJoin('platforms','platforms.id', '=', 'surveys.platform_id')	
					->leftJoin('vn_upload_survey_files','vn_upload_survey_files.survey_id', '=', 'surveys.id')
					->whereRaw("FIND_IN_SET('".$key."',REPLACE(REPLACE(REPLACE(services_required, '[', ''),']',''),'\"',''))")
					->whereIn('BAM.state_id', $StateIdArr)
					->where('vn_upload_survey_files.pid','!=', '')
					->where('vn_upload_survey_files.outcome','=', '2')
					->groupBy('surveys.id')
					->orderBy('surveys.id', 'DESC')
					->get();

					$sql_negative = Surveys::select('surveys.id','U.name AS client_name','U.phone_number as client_phone_number','surveys.client_type','surveys.manual_flag','BAM.created_at as book_date'
					,'D.district_name','SM.state_name','surveys.your_age','surveys.identify_yourself',
					'surveys.target_population','surveys.risk_level','U.uid',
					'surveys.services_required','CM.services_avail','BAM.appoint_date', 'BAM.state_id',
					'CM.name as center_name',
					'platforms.name as platforms_name','surveys.hiv_test',
					'surveys.id as survey_ids','surveys.flag','vn_upload_survey_files.acess_date','vn_upload_survey_files.pid','vn_upload_survey_files.outcome','vn_upload_survey_files.file_upload','vn_upload_survey_files.detail','vn_upload_survey_files.id as file_upload_id','surveys.survey_co_flag','surveys.po_status','BAM.survey_unique_ids')
					->join('customers as U', 'U.id', '=', 'surveys.user_id')
					->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
					->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
					->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
					->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
					->leftJoin('platforms','platforms.id', '=', 'surveys.platform_id')	
					->leftJoin('vn_upload_survey_files','vn_upload_survey_files.survey_id', '=', 'surveys.id')
					->whereRaw("FIND_IN_SET('".$key."',REPLACE(REPLACE(REPLACE(services_required, '[', ''),']',''),'\"',''))")
					->whereIn('BAM.state_id', $StateIdArr)
					->where('vn_upload_survey_files.pid','!=', '')
					->where('vn_upload_survey_files.outcome','=', '1')
					->groupBy('surveys.id')
					->orderBy('surveys.id', 'DESC')
					->get();

					$positive = $sql_positive->count();
					$negative = $sql_negative->count();
					
					if($positive != 0 OR $negative !=0 ){
						$total = $positive/(($positive + $negative) * 100);
					}else{
						$total = 0;
					}
					$color = $serviceColor[$key];
					$data[] = array('language'=>$val,'total'=>$total,'color'=>'#'.$color,'ids'=>'');
				}
			
		}else if($request->type == 'state'){
               $state_code = $request->value;
			   foreach($serviceArr as $key=>$val){
				$sql_positive = Surveys::select('surveys.id','U.name AS client_name','U.phone_number as client_phone_number','surveys.client_type')
					->join('customers as U', 'U.id', '=', 'surveys.user_id')
					->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
					->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
					->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
					->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
					->leftJoin('platforms','platforms.id', '=', 'surveys.platform_id')	
					->leftJoin('vn_upload_survey_files','vn_upload_survey_files.survey_id', '=', 'surveys.id')
					->whereRaw("FIND_IN_SET('".$key."',REPLACE(REPLACE(REPLACE(services_required, '[', ''),']',''),'\"',''))")
					->where('BAM.state_id', $state_code)
					->where('vn_upload_survey_files.pid','!=', '')
					->where('vn_upload_survey_files.outcome','=', '2')
					->groupBy('surveys.id')
					->orderBy('surveys.id', 'DESC')
					->get();

					$sql_negative = Surveys::select('surveys.id','U.name AS client_name','U.phone_number as client_phone_number','surveys.client_type')
					->join('customers as U', 'U.id', '=', 'surveys.user_id')
					->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
					->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
					->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
					->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
					->leftJoin('platforms','platforms.id', '=', 'surveys.platform_id')	
					->leftJoin('vn_upload_survey_files','vn_upload_survey_files.survey_id', '=', 'surveys.id')
					->whereRaw("FIND_IN_SET('".$key."',REPLACE(REPLACE(REPLACE(services_required, '[', ''),']',''),'\"',''))")
					->where('BAM.state_id', $state_code)
					->where('vn_upload_survey_files.pid','!=', '')
					->where('vn_upload_survey_files.outcome','=', '1')
					->groupBy('surveys.id')
					->orderBy('surveys.id', 'DESC')
					->get();

					$positive = $sql_positive->count();
					$negative = $sql_negative->count();
					
					if($positive != 0 OR $negative !=0 ){
						$total = $positive/(($positive + $negative) * 100);
					}else{
						$total = 0;
					}
				
					$color = $serviceColor[$key];
					$data[] = array('language'=>$val,'total'=>$total,'color'=>'#'.$color,'ids'=>'');
			   }
        
		}else if($request->type == 'vn'){
			$user_id = $request->value;
			foreach($serviceArr as $key=>$val){
				$sql_positive = Surveys::select('surveys.id','U.name AS client_name','U.phone_number as client_phone_number','surveys.client_type')
				->join('customers as U', 'U.id', '=', 'surveys.user_id')
				->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
				->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
				->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
				->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
				->leftJoin('platforms','platforms.id', '=', 'surveys.platform_id')	
				->leftJoin('vn_upload_survey_files','vn_upload_survey_files.survey_id', '=', 'surveys.id')
				->whereRaw("FIND_IN_SET('".$key."',REPLACE(REPLACE(REPLACE(services_required, '[', ''),']',''),'\"',''))")
				->where('surveys.user_id', $user_id)
				->where('vn_upload_survey_files.pid','!=', '')
				->where('vn_upload_survey_files.outcome','=', '2')
				->orderBy('surveys.id', 'DESC')
				->get();

				$sql_negative = Surveys::select('surveys.id','U.name AS client_name','U.phone_number as client_phone_number','surveys.client_type')
				->join('customers as U', 'U.id', '=', 'surveys.user_id')
				->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
				->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
				->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
				->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
				->leftJoin('platforms','platforms.id', '=', 'surveys.platform_id')	
				->leftJoin('vn_upload_survey_files','vn_upload_survey_files.survey_id', '=', 'surveys.id')
				->whereRaw("FIND_IN_SET('".$key."',REPLACE(REPLACE(REPLACE(services_required, '[', ''),']',''),'\"',''))")
				->where('surveys.user_id', $user_id)
				->where('vn_upload_survey_files.pid','!=', '')
				->where('vn_upload_survey_files.outcome','=', '1')
				->orderBy('surveys.id', 'DESC')
				->get();
				    $positive = $sql_positive->count();
					$negative = $sql_negative->count();
					
					if($positive != 0 OR $negative !=0 ){
						$total = $positive/(($positive + $negative) * 100);
					}else{
						$total = 0;
					}
					 $color = $serviceColor[$key];
					 $data[] = array('language'=>$val,'total'=>$total,'color'=>'#'.$color,'ids'=>'');
			
			}
		}else if($request->type == 'topology'){
			$target_population = $request->value;
			foreach($serviceArr as $key=>$val){
				$sql_positive = Surveys::select('surveys.id','U.name AS client_name','U.phone_number as client_phone_number','surveys.client_type')
				->join('customers as U', 'U.id', '=', 'surveys.user_id')
				->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
				->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
				->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
				->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
				->leftJoin('platforms','platforms.id', '=', 'surveys.platform_id')	
				->leftJoin('vn_upload_survey_files','vn_upload_survey_files.survey_id', '=', 'surveys.id')
				->whereRaw("FIND_IN_SET('".$key."',REPLACE(REPLACE(REPLACE(services_required, '[', ''),']',''),'\"',''))")
				->where('surveys.target_population', $target_population)
				->where('vn_upload_survey_files.pid','!=', '')
				->where('vn_upload_survey_files.outcome','=', '2')
				->orderBy('surveys.id', 'DESC')
				->get();

				$sql_negative = Surveys::select('surveys.id','U.name AS client_name','U.phone_number as client_phone_number','surveys.client_type')
				->join('customers as U', 'U.id', '=', 'surveys.user_id')
				->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
				->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
				->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
				->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
				->leftJoin('platforms','platforms.id', '=', 'surveys.platform_id')	
				->leftJoin('vn_upload_survey_files','vn_upload_survey_files.survey_id', '=', 'surveys.id')
				->whereRaw("FIND_IN_SET('".$key."',REPLACE(REPLACE(REPLACE(services_required, '[', ''),']',''),'\"',''))")
				->where('surveys.target_population', $target_population)
				->where('vn_upload_survey_files.pid','!=', '')
				->where('vn_upload_survey_files.outcome','=', '1')
				->orderBy('surveys.id', 'DESC')
				->get();
				$positive = $sql_positive->count();
				$negative = $sql_negative->count();
				
				if($positive != 0 OR $negative !=0 ){
					$total = $positive/(($positive + $negative) * 100);
				}else{
					$total = 0;
				}
				 $color = $serviceColor[$key];
				 $data[] = array('language'=>$val,'total'=>$total,'color'=>'#'.$color,'ids'=>'');

			}

		}else if($request->type == 'date'){
			$to_date  = date("Y-m-d",strtotime($request->to_date));
			$date_from = date("Y-m-d",strtotime($request->date_from));
		
			foreach($serviceArr as $key=>$val){
				$sql_positive = Surveys::select('surveys.id','U.name AS client_name','U.phone_number as client_phone_number','surveys.client_type')
				->join('customers as U', 'U.id', '=', 'surveys.user_id')
				->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
				->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
				->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
				->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
				->leftJoin('platforms','platforms.id', '=', 'surveys.platform_id')	
				->leftJoin('vn_upload_survey_files','vn_upload_survey_files.survey_id', '=', 'surveys.id')
				->whereRaw("FIND_IN_SET('".$key."',REPLACE(REPLACE(REPLACE(services_required, '[', ''),']',''),'\"',''))")
				->whereRaw("DATE(BAM.created_at) >='$to_date' AND  DATE(BAM.created_at) <='$date_from'")
			    ->where('vn_upload_survey_files.pid','!=', '')
				->where('vn_upload_survey_files.outcome','=', '2')
				->groupBy('BAM.created_at')
				->get();

				$sql_negative = Surveys::select('surveys.id','U.name AS client_name','U.phone_number as client_phone_number','surveys.client_type')
				->join('customers as U', 'U.id', '=', 'surveys.user_id')
				->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
				->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
				->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
				->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
				->leftJoin('platforms','platforms.id', '=', 'surveys.platform_id')	
				->leftJoin('vn_upload_survey_files','vn_upload_survey_files.survey_id', '=', 'surveys.id')
				->whereRaw("FIND_IN_SET('".$key."',REPLACE(REPLACE(REPLACE(services_required, '[', ''),']',''),'\"',''))")
				->whereRaw("DATE(BAM.created_at) >='$to_date' AND  DATE(BAM.created_at) <='$date_from'")
			    ->where('vn_upload_survey_files.pid','!=', '')
				->where('vn_upload_survey_files.outcome','=', '1')
				->groupBy('BAM.created_at')
				->get();
				$positive = $sql_positive->count();
				$negative = $sql_negative->count();
				
				if($positive != 0 OR $negative !=0 ){
					$total = $positive/(($positive + $negative) * 100);
				}else{
					$total = 0;
				}
				 $color = $serviceColor[$key];
				 $data[] = array('language'=>$val,'total'=>$total,'color'=>'#'.$color,'ids'=>'');

			}
		}
		
		echo json_encode($data);
		exit;
	}

	    /** HIV Referral and Conversation Rate **/
	public function get_mereport_by_referral_chart(Request $request){
        
		$serviceArr = array(1=>"Referral & Conversation Rate");
		$serviceColor = array(1=>"33ff57");
		if($request->type == 'state'){
			$state_code = $request->value;
			
			foreach($serviceArr as $key=>$val){
			 $sql_tested = Surveys::select('surveys.id','U.name AS client_name','U.phone_number as client_phone_number','surveys.client_type')
				 ->join('customers as U', 'U.id', '=', 'surveys.user_id')
				 ->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
				 ->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
				 ->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
				 ->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
				 ->leftJoin('platforms','platforms.id', '=', 'surveys.platform_id')	
				 ->leftJoin('vn_upload_survey_files','vn_upload_survey_files.survey_id', '=', 'surveys.id')
				 ->whereRaw("FIND_IN_SET('".$key."',REPLACE(REPLACE(REPLACE(services_required, '[', ''),']',''),'\"',''))")
				 ->where('BAM.state_id', $state_code)
				 ->where('vn_upload_survey_files.pid','!=', '')
				 ->groupBy('surveys.id')
				 ->orderBy('surveys.id', 'DESC')
				 ->get();
				 
				 $sql_referred = Surveys::select('surveys.id','U.name AS client_name','U.phone_number as client_phone_number','surveys.client_type','surveys.manual_flag','BAM.created_at as book_date'
				 ,'D.district_name','SM.state_name','surveys.your_age','surveys.identify_yourself',
				 'surveys.target_population','surveys.risk_level','U.uid',
				 'surveys.services_required','CM.services_avail','BAM.appoint_date',
				 'CM.name as center_name',
				 'platforms.name as platforms_name','surveys.hiv_test',
				 'surveys.id as survey_ids','surveys.flag','vn_upload_survey_files.acess_date','vn_upload_survey_files.pid','vn_upload_survey_files.outcome','vn_upload_survey_files.file_upload','vn_upload_survey_files.detail','vn_upload_survey_files.id as file_upload_id','surveys.survey_co_flag','surveys.po_status','BAM.survey_unique_ids'
				 )
				 ->join('customers as U', 'U.id', '=', 'surveys.user_id')
				 ->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
				 ->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
				 ->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
				 ->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
				 ->leftJoin('platforms','platforms.id', '=', 'surveys.platform_id')	
				 ->leftJoin('vn_upload_survey_files','vn_upload_survey_files.survey_id', '=', 'surveys.id')
				 ->whereRaw("FIND_IN_SET('".$key."',REPLACE(REPLACE(REPLACE(services_required, '[', ''),']',''),'\"',''))")
				 ->where('BAM.state_id', $state_code)
				 ->groupBy('surveys.id')
				 ->orderBy('surveys.id', 'DESC')
				 ->get();
	
				 $hivTested = $sql_tested->count();
				 $referred = $sql_referred->count();
				 $total = 0;

				 if($hivTested AND $referred != 0){
					 $total = $hivTested/($referred * 100);
				 }
				 $color = $serviceColor[$key];
				 $data[] = array('language'=>$val,'total'=>$total,'hivtested'=>$hivTested,'referred'=>$referred,'color'=>'#'.$color,'ids'=>'');
			 }
			 
	    }else if($request->type == 'vn'){
			$user_id = $request->value;
			foreach($serviceArr as $key=>$val){
				$sql_tested = Surveys::select('surveys.id','U.name AS client_name','U.phone_number as client_phone_number','surveys.client_type')
				->join('customers as U', 'U.id', '=', 'surveys.user_id')
				->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
				->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
				->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
				->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
				->leftJoin('platforms','platforms.id', '=', 'surveys.platform_id')	
				->leftJoin('vn_upload_survey_files','vn_upload_survey_files.survey_id', '=', 'surveys.id')
				->whereRaw("FIND_IN_SET('".$key."',REPLACE(REPLACE(REPLACE(services_required, '[', ''),']',''),'\"',''))")
				->where('surveys.user_id', $user_id)
				->where('vn_upload_survey_files.pid','!=', '')
				->orderBy('surveys.id', 'DESC')
				->get();

				$sql_referred = Surveys::select('surveys.id','U.name AS client_name','U.phone_number as client_phone_number','surveys.client_type','surveys.manual_flag','BAM.created_at as book_date'
					,'D.district_name','SM.state_name','surveys.your_age','surveys.identify_yourself',
					'surveys.target_population','surveys.risk_level','U.uid',
					'surveys.services_required','CM.services_avail','BAM.appoint_date',
					'CM.name as center_name',
					'platforms.name as platforms_name','surveys.hiv_test',
					'surveys.id as survey_ids','surveys.flag','vn_upload_survey_files.acess_date','vn_upload_survey_files.pid','vn_upload_survey_files.outcome','vn_upload_survey_files.file_upload','vn_upload_survey_files.detail','vn_upload_survey_files.id as file_upload_id','surveys.survey_co_flag','surveys.po_status','BAM.survey_unique_ids'
					)
					->join('customers as U', 'U.id', '=', 'surveys.user_id')
					->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
					->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
					->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
					->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
					->leftJoin('platforms','platforms.id', '=', 'surveys.platform_id')	
					->leftJoin('vn_upload_survey_files','vn_upload_survey_files.survey_id', '=', 'surveys.id')
					->whereRaw("FIND_IN_SET('".$key."',REPLACE(REPLACE(REPLACE(services_required, '[', ''),']',''),'\"',''))")
					->where('surveys.user_id', $user_id)
					->groupBy('surveys.id')
					->orderBy('surveys.id', 'DESC')
					->get();
       
					$hivTested = $sql_tested->count();
					$referred = $sql_referred->count();
					$total = 0;
					if($hivTested AND $referred != 0){
						$total = $hivTested/($referred * 100);
					}
					$color = $serviceColor[$key];
					$data[] = array('language'=>$val,'total'=>$total,'hivtested'=>$hivTested,'referred'=>$referred,'color'=>'#'.$color,'ids'=>'');
			}
		}
		
		echo json_encode($data);
		exit;
		
	}

	 /** STI Positive Rate **/
	 public function get_mereport_by_sti_chart(Request $request){
		$serviceArr = array(2=>"STI Test");
		$serviceColor = array(1=>"33ff57",2=>"5733ff",3=>"ffbd33",5=>"33ffbd",7=>"ff3375");
		if($request->type==1){
			foreach($serviceArr as $key=>$val){
				
			$sql = Surveys::select('surveys.id','U.name AS client_name','U.phone_number as client_phone_number','surveys.client_type','surveys.manual_flag','BAM.created_at as book_date'
			,'D.district_name','SM.state_name','surveys.your_age','surveys.identify_yourself',
			'surveys.target_population','surveys.risk_level','U.uid',
			'surveys.services_required','CM.services_avail','BAM.appoint_date',
			'CM.name as center_name',
			'platforms.name as platforms_name','surveys.hiv_test',
			'surveys.id as survey_ids','surveys.flag','vn_upload_survey_files.acess_date','vn_upload_survey_files.pid','vn_upload_survey_files.outcome','vn_upload_survey_files.file_upload','vn_upload_survey_files.detail','vn_upload_survey_files.id as file_upload_id','surveys.survey_co_flag','surveys.po_status','BAM.survey_unique_ids'
			)
			->join('customers as U', 'U.id', '=', 'surveys.user_id')
			->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
			->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
			->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
			->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
			->leftJoin('platforms','platforms.id', '=', 'surveys.platform_id')	
			->leftJoin('vn_upload_survey_files','vn_upload_survey_files.survey_id', '=', 'surveys.id')
			->whereRaw("FIND_IN_SET('".$key."',REPLACE(REPLACE(REPLACE(services_required, '[', ''),']',''),'\"',''))")
			->where('vn_upload_survey_files.pid','!=', '')
			->groupBy('surveys.id')
			->orderBy('surveys.id', 'DESC')
			->get();
				
				$color = $serviceColor[$key];
				$data[] = array('language'=>$val,'total'=>$sql->count(),'color'=>'#'.$color,'ids'=>'');
				//print_r($data); 
			}		
			
		}else if($request->type == 'N' || $request->type == 'S' || $request->type == 'E' || $request->type == 'W' ){

			$type = 'N';
			$type =  $request->type;
			if($type == 'N'){
				$region = 1;
			}else if($type == 'S'){
				$region = 2;
			}else if($type == 'E'){
				$region = 3;
			}else if($type == 'W'){
				$region = 4;
			}
			
			 $sql = 'SELECT 
						CASE WHEN region =1 THEN "North"	
						WHEN region = 2 THEN "South"
						WHEN region = 3 THEN "East"
						WHEN region = 4 THEN "West"
						ELSE ""
						END as region,

						GROUP_CONCAT(state_code) as state_code FROM `state_master` WHERE 1=1 AND region="'.$region.'"  GROUP BY region ';
						//echo $sql; die();
			 $data = array();						
			 $regionSql = DB::select($sql);
			 $regionArr = array();
			 $stateCodeArr = array();			 
			    //print_r($stateCodeArr); die();			
				foreach($serviceArr as $key=>$val){
					
					$StateIdArr = explode(",",$regionSql[0]->state_code);
					$sql_positive = Surveys::select('surveys.id','U.name AS client_name','U.phone_number as client_phone_number','surveys.client_type','surveys.manual_flag','BAM.created_at as book_date'
					,'D.district_name','SM.state_name','surveys.your_age','surveys.identify_yourself',
					'surveys.target_population','surveys.risk_level','U.uid',
					'surveys.services_required','CM.services_avail','BAM.appoint_date', 'BAM.state_id',
					'CM.name as center_name',
					'platforms.name as platforms_name','surveys.hiv_test',
					'surveys.id as survey_ids','surveys.flag','vn_upload_survey_files.acess_date','vn_upload_survey_files.pid','vn_upload_survey_files.outcome','vn_upload_survey_files.file_upload','vn_upload_survey_files.detail','vn_upload_survey_files.id as file_upload_id','surveys.survey_co_flag','surveys.po_status','BAM.survey_unique_ids')
					->join('customers as U', 'U.id', '=', 'surveys.user_id')
					->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
					->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
					->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
					->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
					->leftJoin('platforms','platforms.id', '=', 'surveys.platform_id')	
					->leftJoin('vn_upload_survey_files','vn_upload_survey_files.survey_id', '=', 'surveys.id')
					->whereRaw("FIND_IN_SET('".$key."',REPLACE(REPLACE(REPLACE(services_required, '[', ''),']',''),'\"',''))")
					->whereIn('BAM.state_id', $StateIdArr)
					->where('vn_upload_survey_files.pid','!=', '')
					->where('vn_upload_survey_files.outcome','=', '2')
					->groupBy('surveys.id')
					->orderBy('surveys.id', 'DESC')
					->get();

					$sql_negative = Surveys::select('surveys.id','U.name AS client_name','U.phone_number as client_phone_number','surveys.client_type','surveys.manual_flag','BAM.created_at as book_date'
					,'D.district_name','SM.state_name','surveys.your_age','surveys.identify_yourself',
					'surveys.target_population','surveys.risk_level','U.uid',
					'surveys.services_required','CM.services_avail','BAM.appoint_date', 'BAM.state_id',
					'CM.name as center_name',
					'platforms.name as platforms_name','surveys.hiv_test',
					'surveys.id as survey_ids','surveys.flag','vn_upload_survey_files.acess_date','vn_upload_survey_files.pid','vn_upload_survey_files.outcome','vn_upload_survey_files.file_upload','vn_upload_survey_files.detail','vn_upload_survey_files.id as file_upload_id','surveys.survey_co_flag','surveys.po_status','BAM.survey_unique_ids')
					->join('customers as U', 'U.id', '=', 'surveys.user_id')
					->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
					->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
					->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
					->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
					->leftJoin('platforms','platforms.id', '=', 'surveys.platform_id')	
					->leftJoin('vn_upload_survey_files','vn_upload_survey_files.survey_id', '=', 'surveys.id')
					->whereRaw("FIND_IN_SET('".$key."',REPLACE(REPLACE(REPLACE(services_required, '[', ''),']',''),'\"',''))")
					->whereIn('BAM.state_id', $StateIdArr)
					->where('vn_upload_survey_files.pid','!=', '')
					->where('vn_upload_survey_files.outcome','=', '1')
					->groupBy('surveys.id')
					->orderBy('surveys.id', 'DESC')
					->get();
					
					$positive = $sql_positive->count();
					$negative = $sql_negative->count();
					
					if($positive != 0 OR $negative != 0){
						$total = $positive/(($positive + $negative) * 100);
					}else{
						$total = 0;
					}

					$color = $serviceColor[$key];
					$data[] = array('language'=>$val,'total'=>$total,'color'=>'#'.$color,'ids'=>'');
				}
			
		}else if($request->type == 'state'){
               $state_code = $request->value;
			   foreach($serviceArr as $key=>$val){
				$sql_positive = Surveys::select('surveys.id','U.name AS client_name','U.phone_number as client_phone_number','surveys.client_type')
					->join('customers as U', 'U.id', '=', 'surveys.user_id')
					->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
					->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
					->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
					->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
					->leftJoin('platforms','platforms.id', '=', 'surveys.platform_id')	
					->leftJoin('vn_upload_survey_files','vn_upload_survey_files.survey_id', '=', 'surveys.id')
					->whereRaw("FIND_IN_SET('".$key."',REPLACE(REPLACE(REPLACE(services_required, '[', ''),']',''),'\"',''))")
					->where('BAM.state_id', $state_code)
					->where('vn_upload_survey_files.pid','!=', '')
					->where('vn_upload_survey_files.outcome','=', '2')
					->groupBy('surveys.id')
					->orderBy('surveys.id', 'DESC')
					->get();

					$sql_negative = Surveys::select('surveys.id','U.name AS client_name','U.phone_number as client_phone_number','surveys.client_type')
					->join('customers as U', 'U.id', '=', 'surveys.user_id')
					->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
					->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
					->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
					->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
					->leftJoin('platforms','platforms.id', '=', 'surveys.platform_id')	
					->leftJoin('vn_upload_survey_files','vn_upload_survey_files.survey_id', '=', 'surveys.id')
					->whereRaw("FIND_IN_SET('".$key."',REPLACE(REPLACE(REPLACE(services_required, '[', ''),']',''),'\"',''))")
					->where('BAM.state_id', $state_code)
					->where('vn_upload_survey_files.pid','!=', '')
					->where('vn_upload_survey_files.outcome','=', '1')
					->groupBy('surveys.id')
					->orderBy('surveys.id', 'DESC')
					->get();

					$positive = $sql_positive->count();
					$negative = $sql_negative->count();
					if($positive != 0 OR $negative != 0){
						$total = $positive/(($positive + $negative) * 100);
					}else{
						$total = 0;
					}

					$color = $serviceColor[$key];
					$data[] = array('language'=>$val,'total'=>$total,'color'=>'#'.$color,'ids'=>'');
			   }
        
		}else if($request->type == 'vn'){
			$user_id = $request->value;
			foreach($serviceArr as $key=>$val){
				$sql_positive = Surveys::select('surveys.id','U.name AS client_name','U.phone_number as client_phone_number','surveys.client_type')
				->join('customers as U', 'U.id', '=', 'surveys.user_id')
				->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
				->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
				->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
				->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
				->leftJoin('platforms','platforms.id', '=', 'surveys.platform_id')	
				->leftJoin('vn_upload_survey_files','vn_upload_survey_files.survey_id', '=', 'surveys.id')
				->whereRaw("FIND_IN_SET('".$key."',REPLACE(REPLACE(REPLACE(services_required, '[', ''),']',''),'\"',''))")
				->where('surveys.user_id', $user_id)
				->where('vn_upload_survey_files.pid','!=', '')
				->where('vn_upload_survey_files.outcome','=', '2')
				->orderBy('surveys.id', 'DESC')
				->get();

				$sql_negative = Surveys::select('surveys.id','U.name AS client_name','U.phone_number as client_phone_number','surveys.client_type')
				->join('customers as U', 'U.id', '=', 'surveys.user_id')
				->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
				->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
				->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
				->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
				->leftJoin('platforms','platforms.id', '=', 'surveys.platform_id')	
				->leftJoin('vn_upload_survey_files','vn_upload_survey_files.survey_id', '=', 'surveys.id')
				->whereRaw("FIND_IN_SET('".$key."',REPLACE(REPLACE(REPLACE(services_required, '[', ''),']',''),'\"',''))")
				->where('surveys.user_id', $user_id)
				->where('vn_upload_survey_files.pid','!=', '')
				->where('vn_upload_survey_files.outcome','=', '1')
				->orderBy('surveys.id', 'DESC')
				->get();
				    $positive = $sql_positive->count();
					$negative = $sql_negative->count();
					if($positive != 0 OR $negative != 0){
						$total = $positive/(($positive + $negative) * 100);
					}else{
						$total = 0;
					}
					
					 $color = $serviceColor[$key];
					 $data[] = array('language'=>$val,'total'=>$total,'color'=>'#'.$color,'ids'=>'');
			
			}
		}else if($request->type == 'topology'){
			$target_population = $request->value;
			foreach($serviceArr as $key=>$val){
				$sql_positive = Surveys::select('surveys.id','U.name AS client_name','U.phone_number as client_phone_number','surveys.client_type')
				->join('customers as U', 'U.id', '=', 'surveys.user_id')
				->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
				->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
				->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
				->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
				->leftJoin('platforms','platforms.id', '=', 'surveys.platform_id')	
				->leftJoin('vn_upload_survey_files','vn_upload_survey_files.survey_id', '=', 'surveys.id')
				->whereRaw("FIND_IN_SET('".$key."',REPLACE(REPLACE(REPLACE(services_required, '[', ''),']',''),'\"',''))")
				->where('surveys.target_population', $target_population)
				->where('vn_upload_survey_files.pid','!=', '')
				->where('vn_upload_survey_files.outcome','=', '2')
				->orderBy('surveys.id', 'DESC')
				->get();

				$sql_negative = Surveys::select('surveys.id','U.name AS client_name','U.phone_number as client_phone_number','surveys.client_type')
				->join('customers as U', 'U.id', '=', 'surveys.user_id')
				->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
				->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
				->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
				->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
				->leftJoin('platforms','platforms.id', '=', 'surveys.platform_id')	
				->leftJoin('vn_upload_survey_files','vn_upload_survey_files.survey_id', '=', 'surveys.id')
				->whereRaw("FIND_IN_SET('".$key."',REPLACE(REPLACE(REPLACE(services_required, '[', ''),']',''),'\"',''))")
				->where('surveys.target_population', $target_population)
				->where('vn_upload_survey_files.pid','!=', '')
				->where('vn_upload_survey_files.outcome','=', '1')
				->orderBy('surveys.id', 'DESC')
				->get();
				$positive = $sql_positive->count();
				$negative = $sql_negative->count();
				if($positive != 0 OR $negative != 0){
					$total = $positive/(($positive + $negative) * 100);
				}else{
					$total = 0;
				}

				 $color = $serviceColor[$key];
				 $data[] = array('language'=>$val,'total'=>$total,'color'=>'#'.$color,'ids'=>'');

			}

		}else if($request->type == 'date'){
			$to_date  = date("Y-m-d",strtotime($request->to_date));
			$date_from = date("Y-m-d",strtotime($request->date_from));
		
			foreach($serviceArr as $key=>$val){
				$sql_positive = Surveys::select('surveys.id','U.name AS client_name','U.phone_number as client_phone_number','surveys.client_type')
				->join('customers as U', 'U.id', '=', 'surveys.user_id')
				->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
				->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
				->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
				->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
				->leftJoin('platforms','platforms.id', '=', 'surveys.platform_id')	
				->leftJoin('vn_upload_survey_files','vn_upload_survey_files.survey_id', '=', 'surveys.id')
				->whereRaw("FIND_IN_SET('".$key."',REPLACE(REPLACE(REPLACE(services_required, '[', ''),']',''),'\"',''))")
				->whereRaw("DATE(BAM.created_at) >='$to_date' AND  DATE(BAM.created_at) <='$date_from'")
			    ->where('vn_upload_survey_files.pid','!=', '')
				->where('vn_upload_survey_files.outcome','=', '2')
				->groupBy('BAM.created_at')
				->get();

				$sql_negative = Surveys::select('surveys.id','U.name AS client_name','U.phone_number as client_phone_number','surveys.client_type')
				->join('customers as U', 'U.id', '=', 'surveys.user_id')
				->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
				->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
				->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
				->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
				->leftJoin('platforms','platforms.id', '=', 'surveys.platform_id')	
				->leftJoin('vn_upload_survey_files','vn_upload_survey_files.survey_id', '=', 'surveys.id')
				->whereRaw("FIND_IN_SET('".$key."',REPLACE(REPLACE(REPLACE(services_required, '[', ''),']',''),'\"',''))")
				->whereRaw("DATE(BAM.created_at) >='$to_date' AND  DATE(BAM.created_at) <='$date_from'")
			    ->where('vn_upload_survey_files.pid','!=', '')
				->where('vn_upload_survey_files.outcome','=', '1')
				->groupBy('BAM.created_at')
				->get();
				$positive = $sql_positive->count();
				$negative = $sql_negative->count();
				if($positive != 0 OR $negative != 0){
						$total = $positive/(($positive + $negative) * 100);
					}else{
						$total = 0;
					}

				 $color = $serviceColor[$key];
				 $data[] = array('language'=>$val,'total'=>$total,'color'=>'#'.$color,'ids'=>'');

			}
		}	
		echo json_encode($data);
		exit;
	 }


}
