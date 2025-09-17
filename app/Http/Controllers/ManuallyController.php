<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use DB;
use Illuminate\Support\Facades\DB;
use App\Models\Outreach\Profile;
use App\Models\Outreach\ReferralService;
use App\Models\Outreach\RiskAssessment;

class ManuallyController extends Controller
{
	//
	public function import_excel()
	{
		die;
		$fileupload = $_SERVER['DOCUMENT_ROOT'] . "/import_file/reffer_service.csv";
		$row = 0;
		$attendanceArray = array();
		$html = '';
		$i = 1;
		if (($handle = fopen("$fileupload", "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

				echo "<pre>";
				print_r($data);
				echo "</pre>";
				if ($row != 0) {

					if (!isset($data[0]))
						continue;

					$date_referral = !empty($data[16]) ? date("Y-m-d", strtotime($data[16])) : "0000-00-00";
					$follow_up_date = !empty($data[31]) ? date("Y-m-d", strtotime($data[31])) : "0000-00-00";


					$dataImport = array(
						"unique_serial_number" => $data[0],
						"uid" => str_replace("/", "_", $data[0]),
						"netreach_uid_number" => $data[1],
						"client_type" => $data[2],
						"name_client" => $data[3],
						"educational_attainment" => $data[4],
						"primary_occupation_client" => $data[5],
						"other" => $data[6],
						"provided_client_with_Information_BCC" => $data[7],
						"bcc_provided" => $data[8],
						"service_type_id" => $data[9],
						"others_services" => $data[10],
						"referred_for_ti_service" => $data[11],
						"others_referred_service" => $data[12],
						"counselling_service" => $data[13],
						"prevention_programme" => $data[14],
						"type_facility_referred" => $data[15],
						"date_referral" => $date_referral,
						"referral_centre" => $data[17],
						"referred_centre_state" => $data[18],
						"referred_centre_district" => $data[19],
						"type_of_facility_where_tested" => $data[20],
						"service_accessed" => $data[21],
						"test_centre_state" => $data[22],
						"test_centre_district" => $data[23],
						"date_of_accessing_service" => $data[24],
						"applicable_for_hiv_test" => $data[25],
						"applicable_for_sti_service" => $data[26],
						"pid_or_other_unique_id_of_the_client_provided_at_the_service_cen" => $data[27],
						"outcome_of_the_service_sought" => $data[28],
						"not_access_the_service_referred" => $data[29],
						"other_not_access" => $data[30],
						"follow_up_date" => $follow_up_date,
						"remarks" => $data[32]
					);



					DB::table('outreach_referral_service')->insert($dataImport);
				}

				$i++;


				$row++;
			}
			fclose($handle);
		}







		// dd("dsfsdf");
	}

	public function index(Request $request)
	{
		$query =  DB::table('outreach_profile');
		return view('manual.outreach', ['results' => $query->get()]);
	}

	public function riskassesment(Request $request)
	{
		$query =  DB::table('outreach_profile');
		return view('manual.risk-assesment', ['results' => $query->get()]);
	}

	public function all_riskassesment_report(Request $request)
	{

		$data = array();
		$appArr = array(
			1 => "Grinder", 2 => "PlanetRomeo", 3 => "Blued", 4 => "Scruff", 5 => "Tinder", 6 => "OK CUPID", 7 => "Bumble", 8 => "WhatsApp", 9 => "Instagram", 10 => "Facebook",
			11 => "Brokers", 12 => "Gay Friendly", 13 => "TAMI", 14 => "Telegram", 15 => "WALLA", 16 => "Telephone call", 99 => "Others"
		);

		$genderArr = array(1 => "Male", 2 => "Female", 3 => "TG", 4 => "Not disclosed", 5 => "Others");

		$target_populationArr = array(
			1 => "MSM", 2 => "FSW", 3 => "MSW", 4 => "TG", 5 => "PWID", 6 => "Adolescents and Youths (18-24)",
			7 => "Men and Women with High risk behaviours accessing virtual platforms (above 24 yrs)", 8 => "Not Disclosed", 99 => "Others"
		);

		$res_client_intro_inforArr  = array(
			1 => "Responded", 2 => "Client approached", 3 => "Wants to get back later for service", 4 => "Not interested", 5 => "Did not respond",
			6 => "Blocked", 7 => "Responded & blocked later"
		);

		$please_mentionArr = array(
			1 => "Grinder", 2 => "PlanetRomeo", 3 => "Blued", 4 => "Scruff", 5 => "Tinder", 6 => "OK CUPID", 7 => "Bumble", 8 => "WhatsApp",
			9 => "Instagram", 10 => "Facebook", 11 => "Brokers", 12 => "Gay Friendly", 13 => "TAMI", 14 => "Telegram", 15 => "WALLA", 98 => "Not disclosed", 99 => "Others", '' => ''
		);
		$query =  DB::table('outreach_risk_assesment')->skip($request->start)->take($request->length)->get();
		if ($query->count() > 0) {
			foreach ($query as $value) {
				$client_type = ($value->client_type == 1) ? "New Client" : "Follow up client";
				$data[] = array(
					$value->unique_serial_number,
					$client_type,
					$value->date_risk_assessment,
					$value->high_risk,
					$value->shared_needle_for_injecting_drugs,
					$value->sexually_transmitted_infection,
					$value->sex_with_more_than_one_partners,
					$value->had_chemical_stimulant_or_alcohol_before_sex,
					$value->had_chemical_stimulant_or_alcohol_before_sex,
					$value->had_sex_in_exchange_of_goods_or_money,
					$value->other_reason_for_hiv_test,
					$value->risk_category
				);
			}
		}

		$query =  DB::table('outreach_risk_assesment')->get();
		$json_data = array(
			"draw"            => intval($request->draw),
			"recordsTotal"    => intval($query->count()),
			"recordsFiltered" => intval($query->count()),
			"data"            => $data   // total data array
		);

		echo json_encode($json_data);  // send data as json format			
		exit;
	}

	public function referralservice(Request $request)
	{
		$query =  DB::table('outreach_profile');
		return view('manual.referralservice', ['results' => $query->get()]);
	}

	public function all_referralservice_report(Request $request)
	{

		$data = array();
		$appArr = array(
			1 => "Grinder", 2 => "PlanetRomeo", 3 => "Blued", 4 => "Scruff", 5 => "Tinder", 6 => "OK CUPID", 7 => "Bumble", 8 => "WhatsApp", 9 => "Instagram", 10 => "Facebook",
			11 => "Brokers", 12 => "Gay Friendly", 13 => "TAMI", 14 => "Telegram", 15 => "WALLA", 16 => "Telephone call", 99 => "Others"
		);

		$genderArr = array(1 => "Male", 2 => "Female", 3 => "TG", 4 => "Not disclosed", 5 => "Others");

		$target_populationArr = array(
			1 => "MSM", 2 => "FSW", 3 => "MSW", 4 => "TG", 5 => "PWID", 6 => "Adolescents and Youths (18-24)",
			7 => "Men and Women with High risk behaviours accessing virtual platforms (above 24 yrs)", 8 => "Not Disclosed", 99 => "Others"
		);

		$res_client_intro_inforArr  = array(
			1 => "Responded", 2 => "Client approached", 3 => "Wants to get back later for service", 4 => "Not interested", 5 => "Did not respond",
			6 => "Blocked", 7 => "Responded & blocked later"
		);

		$please_mentionArr = array(
			1 => "Grinder", 2 => "PlanetRomeo", 3 => "Blued", 4 => "Scruff", 5 => "Tinder", 6 => "OK CUPID", 7 => "Bumble", 8 => "WhatsApp",
			9 => "Instagram", 10 => "Facebook", 11 => "Brokers", 12 => "Gay Friendly", 13 => "TAMI", 14 => "Telegram", 15 => "WALLA", 98 => "Not disclosed", 99 => "Others", '' => ''
		);
		$query =  DB::table('outreach_referral_service')->skip($request->start)->take($request->length)->get();
		if ($query->count() > 0) {
			foreach ($query as $value) {

				$client_type = ($value->client_type == 1) ? "New Client" : "Follow up client";


				$data[] = array(
					$value->unique_serial_number,
					$value->netreach_uid_number,
					$value->client_type,
					$value->name_client,
					$value->educational_attainment,
					$value->primary_occupation_client,
					$value->other,
					$value->provided_client_with_Information_BCC,
					$value->bcc_provided,
					$value->service_type_id,
					$value->others_services,
					$value->referred_for_ti_service,
					$value->others_referred_service,
					$value->counselling_service,
					$value->prevention_programme,
					$value->type_facility_referred,
					$value->date_referral,
					$value->referral_centre,
					$value->referred_centre_state,
					$value->referred_centre_district,
					$value->type_of_facility_where_tested,
					$value->service_accessed,
					$value->test_centre_state,
					$value->test_centre_district,
					$value->date_of_accessing_service,
					$value->applicable_for_hiv_test,
					$value->applicable_for_sti_service,
					$value->pid_or_other_unique_id_of_the_client_provided_at_the_service_cen,
					$value->outcome_of_the_service_sought,
					$value->not_access_the_service_referred,
					$value->other_not_access,
					$value->follow_up_date,
					$value->remarks
				);
			}
		}

		$query =  DB::table('outreach_referral_service')->get();
		$json_data = array(
			"draw"            => intval($request->draw),
			"recordsTotal"    => intval($query->count()),
			"recordsFiltered" => intval($query->count()),
			"data"            => $data   // total data array
		);

		echo json_encode($json_data);  // send data as json format			
		exit;
	}

	public function counsellingservices()
	{

		$query =  DB::table('outreach_counselling_services');
		$state_master =  DB::table('state_master');
		return view('manual.counsellingservices', ['results' => $query->get(), "state_master" => $state_master->get()]);
	}


	public function all_counsellingservices_report(Request $request)
	{

		$data = array();
		$appArr = array(
			1 => "Grinder", 2 => "PlanetRomeo", 3 => "Blued", 4 => "Scruff", 5 => "Tinder", 6 => "OK CUPID", 7 => "Bumble", 8 => "WhatsApp", 9 => "Instagram", 10 => "Facebook",
			11 => "Brokers", 12 => "Gay Friendly", 13 => "TAMI", 14 => "Telegram", 15 => "WALLA", 16 => "Telephone call", 99 => "Others"
		);

		$genderArr = array(1 => "Male", 2 => "Female", 3 => "TG", 4 => "Not disclosed", 5 => "Others");

		$target_populationArr = array(
			1 => "MSM", 2 => "FSW", 3 => "MSW", 4 => "TG", 5 => "PWID", 6 => "Adolescents and Youths (18-24)",
			7 => "Men and Women with High risk behaviours accessing virtual platforms (above 24 yrs)", 8 => "Not Disclosed", 99 => "Others"
		);

		$res_client_intro_inforArr  = array(
			1 => "Responded", 2 => "Client approached", 3 => "Wants to get back later for service", 4 => "Not interested", 5 => "Did not respond",
			6 => "Blocked", 7 => "Responded & blocked later"
		);

		$please_mentionArr = array(
			1 => "Grinder", 2 => "PlanetRomeo", 3 => "Blued", 4 => "Scruff", 5 => "Tinder", 6 => "OK CUPID", 7 => "Bumble", 8 => "WhatsApp",
			9 => "Instagram", 10 => "Facebook", 11 => "Brokers", 12 => "Gay Friendly", 13 => "TAMI", 14 => "Telegram", 15 => "WALLA", 98 => "Not disclosed", 99 => "Others", '' => ''
		);

		$query =  DB::table('outreach_counselling_services')->skip($request->start)->take($request->length)->get();
		if ($query->count() > 0) {
			foreach ($query as $value) {

				$client_type = ($value->client_type == 1) ? "New Client" : "Follow up client";
				$data[] = array(
					$value->unique_serial_number,
					$value->uid_number,
					$value->client_type,
					$value->referred_from,
					$value->referral_source,
					$value->name_the_client,
					$value->date_counselling,
					$value->phone_number,
					$value->state_id,
					$value->district_id,
					$value->location,
					$value->age,
					$value->gender,
					$value->gender_other,
					$value->type_target_population,
					$value->other_target_pop,
					$value->type_of_counselling_offered,
					$value->type_of_counselling_offered_other,
					$value->counselling_medium,
					$value->duration_counselling,
					$value->key_concerns_discussed,
					$value->follow_up_date,
					$value->remarks
				);
			}
		}

		$query =  DB::table('outreach_counselling_services')->get();
		$json_data = array(
			"draw"            => intval($request->draw),
			"recordsTotal"    => intval($query->count()),
			"recordsFiltered" => intval($query->count()),
			"data"            => $data   // total data array
		);

		echo json_encode($json_data);  // send data as json format			
		exit;
	}

	public function manuallydashboard()
	{
		$typology_master = DB::table('target_population_master')->orderBy('target_type')->get();
		$state_master =  DB::table('state_master')->orderBy('state_name')->get();
		$region = array("1"=> "North", "2" => "South", "3"=>"East", "4"=>"West");
		$risk_category = array("1"=> "High", "2" => "Medium", "3"=>"Low");
		// $vn_co =  DB::select('SELECT SUBSTRING_INDEX(unique_serial_number, "/", 1) as vns,uid FROM `outreach_profile` GROUP BY SUBSTRING_INDEX(unique_serial_number, "/", 1)');
		$vn_co =  DB::select('SELECT id as uid,vncode as vns FROM `vm_master`');
		$platforms_master =  DB::table('platforms')->orderBy('name')->get();
		$type_of_service_master =  DB::table('service_type_master')->orderBy('service_type')->get();
		$type_of_facility = array("1" => "Govt", "2" => "Private", "3" => "NGO/CBO", "4" => "TI");
		$type_of_test = array("1" => "Screening", "2" => "Confirmatory");
		$client_type_master =  DB::table('client_type_master')->orderBy('client_type')->get();
		return view('manual.dashboard', [
										"typology_master" => $typology_master,
										"vn_co" => $vn_co,
										"state_master" => $state_master,
										"region" => $region,
										"risk_category" => $risk_category,
										"platforms_master" => $platforms_master,
										"type_of_service_master" => $type_of_service_master,
										"type_of_facility" => $type_of_facility,
										"type_of_test" => $type_of_test,
										"client_type_master" => $client_type_master,
									]);
	}

	public function datapiechart(Request $request)
	{

		$first_Filter = isset($request->pop) ? $request->pop : "";
		$date_frm = isset($request->date_frm) ? $request->date_frm : "";
		$date_to = isset($request->date_to) ? $request->date_to : "";
		$region_outreach = isset($request->region_outreach) ? $request->region_outreach : "";
		$state_outreach = isset($request->state_outreach) ? $request->state_outreach : "";
		$virtual_outreach = isset($request->virtual_outreach) ? $request->virtual_outreach : "";
		//$rows = array();
		$rows['type'] = 'pie';
		$rows['name'] = 'Revenue';
		$outreachArr = array(
			"1" => "Grinder", "2" => "PlanetRomeo", 3 => "Blued", "4" => "Scruff", "5" => "Tinder", "6" => "OK CUPID",
			"7" => "Bumble", "8" => "WhatsApp", "9" => "Instagram", "10" => "Facebook", "11" => "Brokers", "12" => "Gay Friendly", "13" => "TAMI",
			"14" => "Telegram", "15" => "WALLA", "16" => "Telephone call", "99" => "Others"
		);
		// Calculate the denominator count based on applied filters
		$denominatorQuery = DB::table('outreach_profile')->where("client_type_id", 1)->where("platform_id", "<>", "")->where("platform_id", "<>", "0");

		if (!empty($first_Filter)) {
			$denominatorQuery->where("target_id", $first_Filter);
		}
	
		if (!empty($date_frm) && !empty($date_to)) {
			$denominatorQuery->whereBetween('registration_date', [$date_frm, $date_to]);
		}
	
		if (!empty($region_outreach)) {
			$denominatorQuery->where('region_id', $region_outreach);
		}
	
		if (!empty($state_outreach)) {
			$denominatorQuery->where('state_id', $state_outreach);
		}
	
		if (!empty($virtual_outreach)) {
			$denominatorQuery->whereRaw("SUBSTRING_INDEX(unique_serial_number, '/', 1) = ?", [$virtual_outreach]);
		}
	
		$denominatorCount = $denominatorQuery->count();
		$query =  DB::table('outreach_profile')->where(["client_type_id" => 1])->get();
		if ($query->count() > 0) {
			foreach ($outreachArr as $key => $value) {

				$sql = " 1=1 AND platform_id='$key' AND client_type_id='1' ";
				if (!empty($first_Filter)) {
					$sql .= " AND target_id='$first_Filter'";
				}

				if (!empty($date_frm) && !empty($date_to)) {
					$sql .= "  AND(registration_date>='$date_frm'  AND registration_date<='$date_to' ) ";
				}

				if (!empty($region_outreach)) {
					$sql .= " AND region_id=$region_outreach ";
				}

				if (!empty($state_outreach)) {
					$sql .= " AND state_id=$state_outreach ";
				}

				if (!empty($virtual_outreach)) {
					$sql .= " AND SUBSTRING_INDEX(unique_serial_number, '/', 1)='$virtual_outreach'  ";
				}

				$ctr =  DB::table('outreach_profile')->whereRaw($sql)
					->get();


				$per = ($ctr->count() * 100) / $denominatorCount;

				if ($ctr->count() > 0)
					$rows['data'][] = array($value, round($per, 2));
			}
		}

		$rslt = array();
		array_push($rslt, $rows);
		echo  json_encode($rslt, JSON_NUMERIC_CHECK);
		exit;
	}

	public function datapiechartrisk(Request $request)
	{

		// print_r($request->all());
		// die;

		$region = isset($request->region) ? $request->region : "";
		$risk_date_frm = isset($request->risk_date_frm) ? $request->risk_date_frm : "";
		$risk_date_to = isset($request->risk_date_to) ? $request->risk_date_to : "";
		$virtual_id = isset($request->virtual_id) ? $request->virtual_id : "";
		$state_risk = isset($request->state_risk) ? $request->state_risk : "";
		$target_pop_risk = isset($request->target_pop_risk) ? $request->target_pop_risk : "";
		$risk_category = isset($request->risk_category) ? $request->risk_category : "";
		$app_risk = isset($request->app_risk) ? $request->app_risk : "";

		//$rows = array();
		$query =  DB::table('state_master')
			->get();
		if ($query->count() > 0) {
			$bln = array();
			$bln['name'] = 'Bulan';
			$rows['name'] = '';
			foreach ($query as $key => $value) {

				$sql = " 1=1 and outreach_risk_assesment.client_type_id='1' ";
				if (!empty($risk_date_frm) && !empty($risk_date_to)) {
					$sql .= " AND (outreach_risk_assesment.date_of_risk_assessment>='$risk_date_frm'  AND outreach_risk_assesment.date_of_risk_assessment<='$risk_date_to' )  ";
				}

				if (!empty($virtual_id)) {
					$sql .= "  AND  SUBSTRING_INDEX(unique_serial_number, '/', 1)='$virtual_id'  ";
				}

				if (!empty($region))
					$sql .= " AND outreach_profile.region_id='$region' ";

				if (!empty($state_risk)) {
					$sql .= " AND outreach_profile.state_id='$state_risk' ";
				}

				if (!empty($target_pop_risk)) {
					$sql .= " AND outreach_profile.target_id='$target_pop_risk' ";
				}

				if (!empty($risk_category)) {
					$sql .= " AND outreach_risk_assesment.risk_category='$risk_category' ";
				}

				if (!empty($app_risk)) {
					$sql .= " AND outreach_profile.platform_id='$app_risk' ";
				}

				$leagues = DB::table('outreach_risk_assesment')
					->select('outreach_profile.profile_id')
					->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_risk_assesment.profile_id')
					->where('outreach_profile.state_id', $value->id)
					->distinct('outreach_profile.unique_serial_number')
					->whereRaw($sql)
					->get();

				if ($leagues->count() > 0) {
					$bln['data'][] = $value->state_name;
					$rows['data'][] = $leagues->count();
				}
			}
		}



		$rslt = array();
		array_push($rslt, $bln);
		array_push($rslt, $rows);
		echo json_encode($rslt, JSON_NUMERIC_CHECK);
		exit;
	}

	public function datapiechartreferred(Request $request)
{
    $service = array(
        "1" => "HIV Testing",
        "2" => "STI Services",
        "3" => "PrEP",
        "4" => "PEP",
        "5" => "HIV and STI counselling",
        "6" => "Referral for mental health counselling",
        "7" => "ART linkages",
        "8" => "Referral to TI for other services",
        "9" => "OST",
        "10" => "SRS",
        "11" => "Social Entitlements",
        "13" => "Gender Based Violence",
        "14" => "Crisis cases",
        "15" => "Referral to Care & Support centre",
        "16" => "Referral to de-addiction centre",
        "17" => "Referral for enrolling in Social Welfare schemes",
        "18" => "Sexual & Reproductive Health",
        "19" => "Social Protection Scheme",
        "20" => "NACO Helpline (1097)",
        "99" => "Others"
    );

    $region = isset($request->region) ? $request->region : "";
    $state_referral = isset($request->state_referral) ? $request->state_referral : "";
    $referred_date_frm = isset($request->referred_date_frm) ? $request->referred_date_frm : "";
    $referred_date_to = isset($request->referred_date_to) ? $request->referred_date_to : "";
    $virtual_referred = isset($request->virtual_referred) ? $request->virtual_referred : "";
    $health_facility = isset($request->health_facility) ? $request->health_facility : "";
    $referred_typology = isset($request->referred_typology) ? $request->referred_typology : "";
    $risk_category = isset($request->risk_category) ? $request->risk_category : "";
    $type_test = isset($request->type_test) ? $request->type_test : "";
    $client_type = isset($request->client_type) ? $request->client_type : "";
    $app_referred = isset($request->app_referred) ? $request->app_referred : "";
    $service_referral = isset($request->service_referral) ? $request->service_referral : "";

    $rows = array();
    $sql = "1=1";

    if (count($service) > 0) {
        $bln = array();
        $bln['name'] = 'Bulan';
        $rows['name'] = 'Referral & Service';

        // Array to store counts
        $countData = [];

        foreach ($service as $key => $value) {
            if (!empty($referred_date_frm) && !empty($referred_date_to)) {
                $sql .= "  AND (outreach_referral_service.referral_date>='$referred_date_frm'  AND outreach_referral_service.referral_date<='$referred_date_to' ) ";
            }

            if (!empty($virtual_referred)) {
                $sql .= "  AND  SUBSTRING_INDEX(unique_serial_number, '/', 1)='$virtual_referred' ";
            }

            if (!empty($state_referral))
                $sql .= " AND outreach_profile.state_id='$state_referral'";

            if (!empty($region))
                $sql .= " AND outreach_profile.region_id=$region";

            if (!empty($health_facility)) {
                $sql .= " AND outreach_referral_service.type_of_facility_where_referred=$health_facility";
            }

            if (!empty($referred_typology)) {
                $sql .= " AND outreach_profile.target_id=$referred_typology";
            }

            if (!empty($risk_category)){
                $sql .= " AND outreach_risk_assesment.risk_category=$risk_category ";
            }

            if (!empty($type_test)){
                $sql .= " AND outreach_referral_service.applicable_for_hiv_test=$type_test ";
            }

            if (!empty($client_type)){
                $sql .= " AND outreach_referral_service.client_type_id=$client_type ";
            }

            if (!empty($app_referred)){
                $sql .= " AND outreach_profile.platform_id='$app_referred' ";
            }

            if (!empty($service_referral))
                $sql .= " AND outreach_referral_service.service_type_id='$service_referral' ";

            // Your existing SQL conditions

            $leagues = DB::table('outreach_referral_service')
                ->select('outreach_profile.profile_id')
                ->leftJoin('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_referral_service.profile_id')
                ->leftJoin('outreach_risk_assesment', 'outreach_risk_assesment.profile_id', '=', 'outreach_referral_service.profile_id')
                ->join('state_master', 'state_master.id', '=', 'outreach_profile.state_id')
                ->where('outreach_referral_service.service_type_id', $key)
				->distinct('outreach_profile.unique_serial_number')
                ->whereRaw($sql)
                ->count('outreach_profile.unique_serial_number');

            if ($leagues > 0) {
                $countData[$value] = $leagues;
            }
        }

        // Sort the counts in descending order
        arsort($countData);

        // Get the top 5 counts
        $top5Counts = array_slice($countData, 0, 5, true);

        // Calculate total count for "Others"
        $othersCount = array_sum($countData) - array_sum($top5Counts);

        // Prepare data for top 5 and "Others"
        foreach ($top5Counts as $service => $count) {
            $bln['data'][] = $service;
            $rows['data'][] = $count;
        }

        if ($othersCount > 0) {
            $bln['data'][] = "Others";
            $rows['data'][] = $othersCount;
        }
    }

    $rslt = array();
    array_push($rslt, $bln);
    array_push($rslt, $rows);
    echo json_encode($rslt, JSON_NUMERIC_CHECK);
    exit;
}


	public function datapiechartavailedservices(Request $request)
	{
		$region = isset($request->region) ? $request->region : "";
		$as_date_frm = isset($request->as_date_frm) ? $request->as_date_frm : "";
		$as_date_to = isset($request->as_date_to) ? $request->as_date_to : "";
		$virtual_id = isset($request->virtual_id) ? $request->virtual_id : "";
		$as_health_facility = isset($request->as_health_facility) ? $request->as_health_facility : "";
		$as_referred_typology = isset($request->as_referred_typology) ? $request->as_referred_typology : "";
		$as_risk_category = isset($request->as_risk_category) ? $request->as_risk_category : "";
		$as_type_test = isset($request->as_type_test) ? $request->as_type_test : "";
		$as_app = isset($request->as_app) ? $request->as_app : "";
		$as_client_type = isset($request->as_client_type) ? $request->as_client_type : "";
		$state_availed = isset($request->state_availed) ? $request->state_availed : "";
		$as_service = isset($request->as_service) ? $request->as_service : "";

		//
		//if(!empty($region))
		//$sql=" region=$region";

		$sql = "1=1 ";
		if (!empty($state_availed))
			$sql .= " AND id='$state_availed' ";
		$query =  DB::table('state_master')
			->whereRaw($sql)
			->get();
		$bln = array();
		$rows = array();
		if ($query->count() > 0){

			$bln['name'] = 'Bulan';
			$rows['name'] = 'Availed Services';
			foreach ($query as $key => $value) {

				$sql = "1=1";
				if (!empty($region))
					$sql .= " AND outreach_profile.region_id='$region' ";

				if (!empty($as_date_frm) && !empty($as_date_to)) {
					$sql .= "  AND (outreach_profile.registration_date>='$as_date_frm'  AND outreach_profile.registration_date<='$as_date_to' ) ";
				}

				if (!empty($virtual_id)){
					$sql .= "  AND  SUBSTRING_INDEX(outreach_profile.unique_serial_number, '/', 1)='$virtual_id' ";
				}

				if (!empty($as_health_facility)) {
					$sql .= " AND outreach_referral_service.type_of_facility_where_referred=$as_health_facility";
				}

				if (!empty($as_referred_typology)){
					$sql .= " AND outreach_profile.target_id=$as_referred_typology";
				}

				if (!empty($as_risk_category)){
					$sql .= " AND outreach_risk_assesment.risk_category=$as_risk_category ";
				}

				if (!empty($as_type_test)){
					$sql .= " AND outreach_referral_service.applicable_for_hiv_test=$as_type_test ";
				}
				if (!empty($as_client_type)) {
					$sql .= " AND outreach_referral_service.client_type_id=$as_client_type ";
				}
				if(!empty($as_app)){
					$sql .= " AND outreach_profile.platform_id='$as_app' ";
				}
				if (!empty($as_service)){
					$sql .= " AND outreach_referral_service.service_type_id='$as_service' ";
				}

				$leagues = DB::table('outreach_risk_assesment')
					->select('outreach_profile.profile_id', 'outreach_risk_assesment.profile_id')
					->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_risk_assesment.profile_id')
					->leftJoin('outreach_referral_service', 'outreach_referral_service.profile_id', '=', 'outreach_risk_assesment.profile_id')
					->where('outreach_profile.state_id', $value->id)
					->distinct('outreach_profile.unique_serial_number')
					->whereRaw($sql)
					->get();

				if ($leagues->count() > 0){
					$bln['data'][] = $value->state_name;
					$rows['data'][] = $leagues->count();
				}
			}
		}
		
		$rslt = array();
		array_push($rslt, $bln);
		array_push($rslt, $rows);
		echo json_encode($rslt, JSON_NUMERIC_CHECK);
		exit;
	}

	public function hivpositivity(Request $request)
	{


		$virtual_id = isset($request->virtual_id) ? $request->virtual_id : "";
		$hp_referred_typology = isset($request->hp_referred_typology) ? $request->hp_referred_typology : "";
		$hp_states = isset($request->hp_states) ? $request->hp_states : "";

		$hp_date_frm = isset($request->hp_date_frm) ? $request->hp_date_frm : "";
		$hp_date_to = isset($request->hp_date_to) ? $request->hp_date_to : "";

		$sql = " 1=1 ";
		$bln = array();
		$bln['name'] = 'Bulan';
		$rows['name'] = 'HIV positivity rate';
		$lineArr = array("North" => "1", "South" => "2", "East" => "3", "West" => "4");
		foreach ($lineArr as $key => $val) {


			if (!empty($virtual_id)) {
				$sql .= "  AND  SUBSTRING_INDEX(outreach_profile.unique_serial_number, '/', 1)='$virtual_id' ";
			}

			if (!empty($hp_referred_typology)) {
				$sql .= " AND outreach_profile.target_id=$hp_referred_typology";
			}

			if (!empty($hp_states)) {
				$sql .= " AND outreach_profile.state_id=$hp_states";
			}


			if (!empty($hp_date_frm) && !empty($hp_date_to)) {
				$sql .= "  AND(outreach_profile.registration_date>='$hp_date_frm'  AND outreach_profile.registration_date<='$hp_date_to' ) ";
			}

			$postive = DB::table('outreach_risk_assesment')
				->select('outreach_profile.profile_id')
				->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_risk_assesment.profile_id')
				->join('outreach_referral_service', 'outreach_referral_service.profile_id', '=', 'outreach_risk_assesment.profile_id')
				->join('state_master', 'state_master.id', '=', 'outreach_profile.state_id')
				->where(['state_master.region' => $val, "outreach_referral_service.outcome_of_the_service_sought" => 1])
				->where([ "outreach_referral_service.service_type_id" => 1])
				->where('outreach_referral_service.pid_or_other_unique_id_of_the_service_center', "<>", 0)
				->distinct('outreach_profile.unique_serial_number')
				->whereRaw($sql)
				->get();
			$posNeg = DB::table('outreach_risk_assesment')
				->select('outreach_profile.profile_id')
				->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_risk_assesment.profile_id')
				->join('outreach_referral_service', 'outreach_referral_service.profile_id', '=', 'outreach_risk_assesment.profile_id')
				->join('state_master', 'state_master.id', '=', 'outreach_profile.state_id')
				->where(["outreach_referral_service.outcome_of_the_service_sought" => 1])
				->where(["outreach_referral_service.service_type_id" => 1])
				->where('outreach_referral_service.pid_or_other_unique_id_of_the_service_center', "<>", 0)
				->distinct('outreach_profile.unique_serial_number')
				->whereRaw($sql)
				->get();

			// $posNeg = DB::table('outreach_risk_assesment')
			// 	->select('outreach_profile.profile_id')
			// 	->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_risk_assesment.profile_id')
			// 	->join('outreach_referral_service', 'outreach_referral_service.profile_id', '=', 'outreach_risk_assesment.profile_id')
			// 	->join('state_master', 'state_master.id', '=', 'outreach_profile.state_id')
			// 	->where([ 'outreach_referral_service.service_type_id' => 1])
			// 	->whereIn('outreach_referral_service.outcome_of_the_service_sought', array(1, 2))
			// 	->whereRaw($sql)
			// 	->get();

			$formula = 0;
			if ($postive->count() > 0)
			$formula = (($postive->count() / $posNeg->count()) * 100) > 0 ? ($postive->count() / $posNeg->count()) * 100 : 0;
			
			$bln['data'][] = $key;
			$rows['data'][] = @$formula;
		}


		$rslt = array();
		array_push($rslt, $bln);
		array_push($rslt, $rows);
		echo  json_encode($rslt, JSON_NUMERIC_CHECK);
		//echo '[{"name":"Bulan","data":["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"]},{"name":"Jumlah Pelawat","data":[115,261,183,170,94,148,161,86,203,307,183,181]}]';
		exit;
	}

	public function hiv_referralconversion_rate(Request $request)
	{

		$virtual_id = isset($request->virtual_id) ? $request->virtual_id : "";
		$cr_states = isset($request->cr_states) ? $request->cr_states : "";
		$cr_date_frm = isset($request->cr_date_frm) ? $request->cr_date_frm : "";
		$cr_date_to = isset($request->cr_date_to) ? $request->cr_date_to : "";
		$cr_referred_typology = isset($request->cr_referred_typology) ? $request->cr_referred_typology : "";


		$sql = " 1=1 ";
		$sqlSecond = " 1=1 ";
		$bln = array();
		$bln['name'] = 'Bulan';
		$rows['name'] = 'HIV referral conversion rate';
		$lineArr = array("North" => "1", "South" => "2", "East" => "3", "West" => "4");
		foreach ($lineArr as $key => $val) {

			if (!empty($virtual_id)){
				$sql .= "  AND  SUBSTRING_INDEX(outreach_profile.unique_serial_number, '/', 1)='$virtual_id' ";
				$sqlSecond .= "  AND  SUBSTRING_INDEX(outreach_profile.unique_serial_number, '/', 1)='$virtual_id' ";
			}

			if (!empty($cr_states)) {
				$sql .= " AND outreach_profile.state_id=$cr_states";
				$sqlSecond .= " AND outreach_profile.state_id=$cr_states";
			}
			if (!empty($cr_date_frm)) {
				$sql .= "  AND(outreach_referral_service.referral_date>='$cr_date_frm'  AND outreach_referral_service.referral_date<='$cr_date_to' ) ";
				$sqlSecond .= "  AND(outreach_referral_service.referral_date>='$cr_date_frm'  AND outreach_referral_service.referral_date<='$cr_date_to' ) ";
			}
			if (!empty($cr_referred_typology)) {
				$sql .= " AND outreach_profile.target_id=$cr_referred_typology";
				$sqlSecond .= " AND outreach_profile.target_id=$cr_referred_typology";
			}


			$sql .= "  AND ((outreach_referral_service.referral_date<>'0000-00-00' AND outreach_referral_service.referral_date<>'1970-01-01' AND outreach_referral_service.referral_date<>'' AND outreach_referral_service.referral_date IS NOT NULL) AND outreach_referral_service.client_type_id<>4 ) ";

			$sqlSecond .= " AND (outreach_referral_service.pid_or_other_unique_id_of_the_service_center	<>0 AND outreach_referral_service.client_type_id<>4)";

			$postive = DB::table('outreach_risk_assesment')
				->select('outreach_profile.profile_id')
				->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_risk_assesment.profile_id')
				->join('outreach_referral_service', 'outreach_referral_service.profile_id', '=', 'outreach_risk_assesment.profile_id')
				->join('state_master', 'state_master.id', '=', 'outreach_profile.state_id')
				->where(['state_master.region' => $val])
				->whereRaw($sql)
				->get();

			$posNeg = DB::table('outreach_risk_assesment')
				->select('outreach_profile.profile_id')
				->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_risk_assesment.profile_id')
				->join('outreach_referral_service', 'outreach_referral_service.profile_id', '=', 'outreach_risk_assesment.profile_id')
				->join('state_master', 'state_master.id', '=', 'outreach_profile.state_id')
				->whereRaw($sql)
				->get();

			// $posNeg = DB::table('outreach_risk_assesment')
			// 	->select('outreach_profile.profile_id')
			// 	->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_risk_assesment.profile_id')
			// 	->join('outreach_referral_service', 'outreach_referral_service.profile_id', '=', 'outreach_risk_assesment.profile_id')
			// 	->join('state_master', 'state_master.id', '=', 'outreach_profile.state_id')
			// 	->where(['state_master.region' => $val])
			// 	->whereRaw($sqlSecond)
			// 	->get();

			$formula = 0;
			if ($postive->count() > 0)
				$formula = (($postive->count() / $posNeg->count()) * 100) > 0 ? ($postive->count() / $posNeg->count()) * 100 : 0;



			$bln['data'][] = $key;
			$rows['data'][] = @$formula;
		}


		$rslt = array();
		array_push($rslt, $bln);
		array_push($rslt, $rows);
		echo  json_encode($rslt, JSON_NUMERIC_CHECK);
		//echo '[{"name":"Bulan","data":["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"]},{"name":"Jumlah Pelawat","data":[115,261,183,170,94,148,161,86,203,307,183,181]}]';
		exit;
	}

	public function sti_positivity(Request $request)
	{

		$virtual_id = isset($request->virtual_id) ? $request->virtual_id : "";
		$sti_referred_typology = isset($request->sti_referred_typology) ? $request->sti_referred_typology : "";
		$sti_states = isset($request->sti_states) ? $request->sti_states : "";

		$sti_date_frm = isset($request->sti_date_frm) ? $request->sti_date_frm : "";
		$sti_date_to = isset($request->sti_date_to) ? $request->sti_date_to : "";

		$sql = " 1=1 ";
		$bln = array();
		$bln['name'] = 'Bulan';
		$rows['name'] = 'HIV positivity rate';
		$lineArr = array("North" => "1", "South" => "2", "East" => "3", "West" => "4");
		foreach ($lineArr as $key => $val) {


			if (!empty($virtual_id)) {
				$sql .= "  AND  SUBSTRING_INDEX(outreach_profile.unique_serial_number, '/', 1)='$virtual_id' ";
			}

			if (!empty($sti_referred_typology)) {
				$sql .= " AND outreach_profile.target_id=$sti_referred_typology";
			}

			if (!empty($sti_states)) {
				$sql .= " AND outreach_profile.state_id=$sti_states";
			}


			if (!empty($sti_date_frm) && !empty($sti_date_to)) {
				$sql .= "  AND(outreach_profile.registration_date>='$sti_date_frm'  AND outreach_profile.registration_date<='$sti_date_to' ) ";
			}

			$postive = DB::table('outreach_risk_assesment')
				->select('outreach_profile.profile_id')
				->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_risk_assesment.profile_id')
				->join('outreach_referral_service', 'outreach_referral_service.profile_id', '=', 'outreach_risk_assesment.profile_id')
				->join('state_master', 'state_master.id', '=', 'outreach_profile.state_id')	
				->where('outreach_referral_service.pid_or_other_unique_id_of_the_service_center', "<>", 0)
				->where(["outreach_referral_service.service_type_id" => 2, "outreach_referral_service.outcome_of_the_service_sought" => 1])
				->where(['state_master.region' => $val])
				->whereRaw($sql)
				->get();

			$posNeg = DB::table('outreach_risk_assesment')
				->select('outreach_profile.profile_id')
				->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_risk_assesment.profile_id')
				->join('outreach_referral_service', 'outreach_referral_service.profile_id', '=', 'outreach_risk_assesment.profile_id')
				->join('state_master', 'state_master.id', '=', 'outreach_profile.state_id')	
				->where('outreach_referral_service.pid_or_other_unique_id_of_the_service_center', "<>", 0)
				->where(["outreach_referral_service.service_type_id" => 2, "outreach_referral_service.outcome_of_the_service_sought" => 1])
				->whereRaw($sql)
				->get();

			// $posNeg = DB::table('outreach_risk_assesment')
			// 	->select('outreach_profile.profile_id')
			// 	->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_risk_assesment.profile_id')
			// 	->join('outreach_referral_service', 'outreach_referral_service.profile_id', '=', 'outreach_risk_assesment.profile_id')
			// 	->join('state_master', 'state_master.id', '=', 'outreach_profile.state_id')
			// 	->where(['state_master.region' => $val, 'outreach_referral_service.service_type_id' => 2])
			// 	->whereIn('outreach_referral_service.outcome_of_the_service_sought', array(1, 2))
			// 	->whereRaw($sql)
			// 	->get();

			$formula = 0;
			if ($postive->count() > 0)
				$formula = (($postive->count() / $posNeg->count()) * 100) > 0 ? ($postive->count() / $posNeg->count()) * 100 : 0;

			$bln['data'][] = $key;
			$rows['data'][] = @$formula;
		}


		$rslt = array();
		array_push($rslt, $bln);
		array_push($rslt, $rows);
		echo  json_encode($rslt, JSON_NUMERIC_CHECK);
		//echo '[{"name":"Bulan","data":["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"]},{"name":"Jumlah Pelawat","data":[115,261,183,170,94,148,161,86,203,307,183,181]}]';
		exit;
	}
	public function art_positivity(Request $request)
	{

		$region = isset($request->region) ? $request->region : "";
		$risk_date_frm = isset($request->art_date_frm) ? $request->art_date_frm : "";
		$art_date_to = isset($request->art_date_to) ? $request->art_date_to : "";
		$virtual_id = isset($request->virtual_id) ? $request->virtual_id : "";
		$sti_typology = isset($request->sti_typology) ? $request->sti_typology : "";

		//$rows = array();
		$sql = "1=1";
		if (!empty($region))
			$sql = " region=$region";


		$query =  DB::table('state_master')
			->whereRaw($sql)
			->get();
		if ($query->count() > 0) {
			$bln = array();
			$bln['name'] = 'Bulan';
			$rows['name'] = 'Art Positivity';
			foreach ($query as $key => $value) {

				if (!empty($risk_date_frm) && !empty($art_date_to)) {
					$sql = "  (outreach_risk_assesment.date_of_risk_assessment>='$risk_date_frm'  AND outreach_risk_assesment.date_of_risk_assessment<='$art_date_to' ) ";
				} else {
					$sql = " 1=1 ";
				}

				if (!empty($virtual_id)) {
					$sql .= "  AND  SUBSTRING_INDEX(unique_serial_number, '/', 1)='$virtual_id' ";
				}

				if (!empty($sti_typology)) {
					$sql .= "  AND  outreach_profile.target_id='$sti_typology' ";
				}

				$leagues = DB::table('outreach_risk_assesment')
					->select('outreach_profile.profile_id')
					->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_risk_assesment.profile_id')
					->join('outreach_plhiv', 'outreach_plhiv.profile_id', '=', 'outreach_profile.profile_id')
					->where('outreach_profile.state_id', $value->id)
					->where('outreach_plhiv.pre_art_reg_number', "<>", 0)
					->whereRaw($sql)
					->get();

				if ($leagues->count() > 0) {
					$bln['data'][] = $value->state_name;
					$rows['data'][] = $leagues->count();
				}
			}
		}

		$rslt = array();
		array_push($rslt, $bln);
		array_push($rslt, $rows);
		echo json_encode($rslt, JSON_NUMERIC_CHECK);
		exit;
	}

	public function getindicators()
	{

		$North = DB::table('outreach_profile')
			->select('outreach_profile.profile_id')
			->join('state_master', 'state_master.id', '=', 'outreach_profile.state_id')
			->where(['state_master.region' => 1, 'outreach_profile.client_type_id' => 1])
			->distinct('outreach_profile.unique_serial_number')
			->get();

		$South = DB::table('outreach_profile')
			->select('outreach_profile.profile_id')
			->join('state_master', 'state_master.id', '=', 'outreach_profile.state_id')
			->where(['state_master.region' => 2, 'outreach_profile.client_type_id' => 1])
			->distinct('outreach_profile.unique_serial_number')
			->get();

		$East = DB::table('outreach_profile')
			->select('outreach_profile.profile_id')
			->join('state_master', 'state_master.id', '=', 'outreach_profile.state_id')
			->where(['state_master.region' => 3, 'outreach_profile.client_type_id' => 1])
			->distinct('outreach_profile.unique_serial_number')
			->get();

		$West = DB::table('outreach_profile')
			->select('outreach_profile.profile_id')
			->join('state_master', 'state_master.id', '=', 'outreach_profile.state_id')
			->where(['state_master.region' => 4, 'outreach_profile.client_type_id' => 1])
			->distinct('outreach_profile.unique_serial_number')
			->get();

		//# Of persons whose HIV risk was assessed
		$NorthRisk  = DB::table('outreach_risk_assesment')
			->select('outreach_profile.profile_id')
			->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_risk_assesment.profile_id')
			->join('state_master', 'state_master.id', '=', 'outreach_profile.state_id')
			->where('outreach_risk_assesment.client_type_id', 1)
			->where(['state_master.region' => 1])
			->distinct('outreach_profile.unique_serial_number')
			->get();

		$SouthRisk  = DB::table('outreach_risk_assesment')
			->select('outreach_profile.profile_id')
			->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_risk_assesment.profile_id')
			->join('state_master', 'state_master.id', '=', 'outreach_profile.state_id')
			->where('outreach_risk_assesment.client_type_id', 1)
			->where(['state_master.region' => 2])
			->distinct('outreach_profile.unique_serial_number')
			->get();

		$EastRisk  = DB::table('outreach_risk_assesment')
			->select('outreach_profile.profile_id')
			->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_risk_assesment.profile_id')
			->join('state_master', 'state_master.id', '=', 'outreach_profile.state_id')
			->where('outreach_risk_assesment.client_type_id', 1)
			->where(['state_master.region' => 3])
			->distinct('outreach_profile.unique_serial_number')
			->get();

		$WestRisk  = DB::table('outreach_risk_assesment')
			->select('outreach_profile.profile_id')
			->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_risk_assesment.profile_id')
			->join('state_master', 'state_master.id', '=', 'outreach_profile.state_id')
			->where('outreach_risk_assesment.client_type_id', 1)
			->where(['state_master.region' => 4])
			->distinct('outreach_profile.unique_serial_number')
			->get();

		//# Of persons referred for HIV related services including HIV testing (head count)	
		$NorthHIVRelatedServices  = DB::table('outreach_referral_service')
			->select('outreach_profile.profile_id')
			->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_referral_service.profile_id')
			->join('state_master', 'state_master.id', '=', 'outreach_profile.state_id')
			->where(['state_master.region' => 1])
			->distinct('outreach_profile.unique_serial_number')
			->get();

		$SouthHIVRelatedServices   = DB::table('outreach_referral_service')
			->select('outreach_profile.profile_id')
			->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_referral_service.profile_id')
			->join('state_master', 'state_master.id', '=', 'outreach_profile.state_id')
			->where(['state_master.region' => 2])
			->distinct('outreach_profile.unique_serial_number')
			->get();

		$EastHIVRelatedServices   = DB::table('outreach_referral_service')
			->select('outreach_profile.profile_id')
			->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_referral_service.profile_id')
			->join('state_master', 'state_master.id', '=', 'outreach_profile.state_id')
			->where(['state_master.region' => 3])
			->distinct('outreach_profile.unique_serial_number')
			->get();

		$WestHIVRelatedServices   = DB::table('outreach_referral_service')
			->select('outreach_profile.profile_id')
			->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_referral_service.profile_id')
			->join('state_master', 'state_master.id', '=', 'outreach_profile.state_id')
			->where(['state_master.region' => 4])
			->distinct('outreach_profile.unique_serial_number')
			->get();


		//# Of persons referred for HIV testing 

		$NorthReferred = DB::table('outreach_referral_service')
			->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_referral_service.profile_id')
			->join('state_master', 'state_master.id', '=', 'outreach_profile.state_id')
			->where(['state_master.region' => 1, "outreach_referral_service.service_type_id" => 1])
			->distinct('outreach_profile.unique_serial_number')
			->count('outreach_profile.unique_serial_number');

		$SouthReferred = DB::table('outreach_referral_service')
			->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_referral_service.profile_id')
			->join('state_master', 'state_master.id', '=', 'outreach_profile.state_id')
			->where(['state_master.region' => 2, "outreach_referral_service.service_type_id" => 1])
			->distinct('outreach_profile.unique_serial_number')
			->count('outreach_profile.unique_serial_number');

		$EastReferred = DB::table('outreach_referral_service')
			->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_referral_service.profile_id')
			->join('state_master', 'state_master.id', '=', 'outreach_profile.state_id')
			->where(['state_master.region' => 3, "outreach_referral_service.service_type_id" => 1])
			->distinct('outreach_profile.unique_serial_number')
			->count('outreach_profile.unique_serial_number');

		$WestReferred = DB::table('outreach_referral_service')
			->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_referral_service.profile_id')
			->join('state_master', 'state_master.id', '=', 'outreach_profile.state_id')
			->where(['state_master.region' => 4, "outreach_referral_service.service_type_id" => 1])
			->distinct('outreach_profile.unique_serial_number')
			->count('outreach_profile.unique_serial_number');


		// Of persons tested for HIV
		$NorthPID  = DB::table('outreach_referral_service')
			->select('outreach_profile.profile_id')
			->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_referral_service.profile_id')
			->join('state_master', 'state_master.id', '=', 'outreach_profile.state_id')
			->where(['state_master.region' => 1, "outreach_referral_service.service_type_id" => 1])
			->where('outreach_referral_service.pid_or_other_unique_id_of_the_service_center', "<>", 0)
			->distinct('outreach_profile.unique_serial_number')
			->get();

		$SouthPID   = DB::table('outreach_referral_service')
			->select('outreach_profile.profile_id')
			->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_referral_service.profile_id')
			->join('state_master', 'state_master.id', '=', 'outreach_profile.state_id')
			->where(['state_master.region' => 2, "outreach_referral_service.service_type_id" => 1])
			->where('outreach_referral_service.pid_or_other_unique_id_of_the_service_center', "<>", 0)
			->distinct('outreach_profile.unique_serial_number')
			->get();

		$EastPID   = DB::table('outreach_referral_service')
			->select('outreach_profile.profile_id')
			->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_referral_service.profile_id')
			->join('state_master', 'state_master.id', '=', 'outreach_profile.state_id')
			->where(['state_master.region' => 3, "outreach_referral_service.service_type_id" => 1])
			->where('outreach_referral_service.pid_or_other_unique_id_of_the_service_center', "<>", 0)
			->distinct('outreach_profile.unique_serial_number')
			->get();

		$WestPID   = DB::table('outreach_referral_service')
			->select('outreach_profile.profile_id')
			->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_referral_service.profile_id')
			->join('state_master', 'state_master.id', '=', 'outreach_profile.state_id')
			->where(['state_master.region' => 4, "outreach_referral_service.service_type_id" => 1])
			->where('outreach_referral_service.pid_or_other_unique_id_of_the_service_center', "<>", 0)
			->distinct('outreach_profile.unique_serial_number')
			->get();


		//# Of person shared HIV status
		$NorthPIDStatus  = DB::table('outreach_referral_service')
			->select('outreach_profile.profile_id')
			->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_referral_service.profile_id')
			->join('state_master', 'state_master.id', '=', 'outreach_profile.state_id')
			->where(['state_master.region' => 1, "outreach_referral_service.service_type_id" => 1])
			->whereIn('outreach_referral_service.outcome_of_the_service_sought', array(1, 2))
			->get();

		$SouthPIDStatus   = DB::table('outreach_referral_service')
			->select('outreach_profile.profile_id')
			->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_referral_service.profile_id')
			->join('state_master', 'state_master.id', '=', 'outreach_profile.state_id')
			->where(['state_master.region' => 2, "outreach_referral_service.service_type_id" => 1])
			->whereIn('outreach_referral_service.outcome_of_the_service_sought', array(1, 2))
			//->where('outreach_referral_service.pid_or_other_unique_id_of_the_service_center',"<>", 0)	
			->get();

		$EastPIDStatus   = DB::table('outreach_referral_service')
			->select('outreach_profile.profile_id')
			->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_referral_service.profile_id')
			->join('state_master', 'state_master.id', '=', 'outreach_profile.state_id')
			->where(['state_master.region' => 3, "outreach_referral_service.service_type_id" => 1])
			->whereIn('outreach_referral_service.outcome_of_the_service_sought', array(1, 2))
			->get();

		$WestPIDStatus   = DB::table('outreach_referral_service')
			->select('outreach_profile.profile_id')
			->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_referral_service.profile_id')
			->join('state_master', 'state_master.id', '=', 'outreach_profile.state_id')
			->where(['state_master.region' => 4, "outreach_referral_service.service_type_id" => 1])
			->whereIn('outreach_referral_service.outcome_of_the_service_sought', array(1, 2))
			->get();


		//# Of persons found HIV positive
		$NorthHIVpositive  = DB::table('outreach_referral_service')
			->select('outreach_profile.profile_id')
			->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_referral_service.profile_id')
			->join('state_master', 'state_master.id', '=', 'outreach_profile.state_id')
			->where(['state_master.region' => 1, "outreach_referral_service.service_type_id" => 1])
			->whereIn('outreach_referral_service.outcome_of_the_service_sought', array(1))
			->where('outreach_referral_service.pid_or_other_unique_id_of_the_service_center', "<>", 0)
			->distinct('outreach_profile.unique_serial_number')
			->get();

		$SouthHIVpositive  = DB::table('outreach_referral_service')
			->select('outreach_profile.profile_id')
			->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_referral_service.profile_id')
			->join('state_master', 'state_master.id', '=', 'outreach_profile.state_id')
			->where(['state_master.region' => 2, "outreach_referral_service.service_type_id" => 1])
			->whereIn('outreach_referral_service.outcome_of_the_service_sought', array(1))
			->where('outreach_referral_service.pid_or_other_unique_id_of_the_service_center', "<>", 0)
			->distinct('outreach_profile.unique_serial_number')
			->get();

		$EastHIVpositive   = DB::table('outreach_referral_service')
			->select('outreach_profile.profile_id')
			->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_referral_service.profile_id')
			->join('state_master', 'state_master.id', '=', 'outreach_profile.state_id')
			->where(['state_master.region' => 3, "outreach_referral_service.service_type_id" => 1])
			->whereIn('outreach_referral_service.outcome_of_the_service_sought', array(1))
			->where('outreach_referral_service.pid_or_other_unique_id_of_the_service_center', "<>", 0)
			->distinct('outreach_profile.unique_serial_number')
			->get();

		$WestHIVpositive   = DB::table('outreach_referral_service')
			->select('outreach_profile.profile_id')
			->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_referral_service.profile_id')
			->join('state_master', 'state_master.id', '=', 'outreach_profile.state_id')
			->where(['state_master.region' => 4, "outreach_referral_service.service_type_id" => 1])
			->whereIn('outreach_referral_service.outcome_of_the_service_sought', array(1))
			->where('outreach_referral_service.pid_or_other_unique_id_of_the_service_center', "<>", 0)
			->distinct('outreach_profile.unique_serial_number')
			->get();

		//# Of persons linked to ART 

		$NorthART  = DB::table('outreach_plhiv')
			->select('outreach_plhiv.profile_id')
			->join('state_master', 'state_master.id', '=', 'outreach_plhiv.art_state_id')
			->where('outreach_plhiv.pre_art_reg_number', "<>", 0)
			->where(['state_master.region' => 1])
			->get();

		$SouthART  = DB::table('outreach_plhiv')
			->select('outreach_plhiv.profile_id')
			->join('state_master', 'state_master.id', '=', 'outreach_plhiv.art_state_id')
			->where('outreach_plhiv.pre_art_reg_number', "<>", 0)
			->where(['state_master.region' => 2])
			->get();
		$EastART  = DB::table('outreach_plhiv')
			->select('outreach_plhiv.profile_id')
			->join('state_master', 'state_master.id', '=', 'outreach_plhiv.art_state_id')
			->where('outreach_plhiv.pre_art_reg_number', "<>", 0)
			->where(['state_master.region' => 3])
			->get();

		$WestART  = DB::table('outreach_plhiv')
			->select('outreach_plhiv.profile_id')
			->join('state_master', 'state_master.id', '=', 'outreach_plhiv.art_state_id')
			->where('outreach_plhiv.pre_art_reg_number', "<>", 0)
			->where(['state_master.region' => 4])
			->get();

		//# Of persons Counselled

		$NorthCounselled  = DB::table('outreach_counselling_services')
			->select('outreach_counselling_services.profile_id')
			->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_counselling_services.profile_id')
			->join('state_master', 'state_master.id', '=', 'outreach_profile.state_id')
			->where(['state_master.region' => 1])
			->distinct('outreach_profile.unique_serial_number')
			->get();

		$SouthCounselled  = DB::table('outreach_counselling_services')
			->select('outreach_counselling_services.profile_id')
			->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_counselling_services.profile_id')
			->join('state_master', 'state_master.id', '=', 'outreach_profile.state_id')
			->where(['state_master.region' => 2])
			->distinct('outreach_profile.unique_serial_number')
			->get();
		$EastCounselled  = DB::table('outreach_counselling_services')
			->select('outreach_counselling_services.profile_id')
			->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_counselling_services.profile_id')
			->join('state_master', 'state_master.id', '=', 'outreach_profile.state_id')
			->where(['state_master.region' => 3])
			->distinct('outreach_profile.unique_serial_number')
			->get();

		$WestCounselled  = DB::table('outreach_counselling_services')
			->select('outreach_counselling_services.profile_id')
			->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_counselling_services.profile_id')
			->join('state_master', 'state_master.id', '=', 'outreach_profile.state_id')
			->where(['state_master.region' => 4])
			->distinct('outreach_profile.unique_serial_number')
			->get();


		//# Of persons referred for Counselling by VNs

		$sql = " (outreach_referral_service.referral_date<>'0000-00-00' AND outreach_referral_service.referral_date<>'' AND outreach_referral_service.referral_date<>'1970-01-01')";
		// $NorthReferredCounselled  = DB::table('outreach_referral_service')
		// 	->select('outreach_profile.profile_id')
		// 	->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_referral_service.profile_id')
		// 	->join('state_master', 'state_master.id', '=', 'outreach_profile.state_id')
		// 	->where(['state_master.region' => 1])
		// 	->whereIn('outreach_referral_service.service_type_id', array(5, 6))
		// 	->whereRaw($sql)
		// 	->get();

		$NorthReferredCounselled = DB::table('outreach_counselling_services')
			->join('outreach_profile', 'outreach_counselling_services.profile_id', '=', 'outreach_profile.profile_id')
			->join('state_master', 'state_master.id', '=', 'outreach_profile.state_id')
			->where(['state_master.region' => 1])
			->where('outreach_profile.unique_serial_number', 'LIKE', 'VN%')
			->distinct('outreach_profile.unique_serial_number')
			->count('outreach_profile.unique_serial_number');
	

		$SouthReferredCounselled  = DB::table('outreach_counselling_services')
			->join('outreach_profile', 'outreach_counselling_services.profile_id', '=', 'outreach_profile.profile_id')
			->join('state_master', 'state_master.id', '=', 'outreach_profile.state_id')
			->where(['state_master.region' => 2])
			->where('outreach_profile.unique_serial_number', 'LIKE', 'VN%')
			->distinct('outreach_profile.unique_serial_number')
			->count('outreach_profile.unique_serial_number');


		$EastReferredCounselled  = DB::table('outreach_counselling_services')
			->join('outreach_profile', 'outreach_counselling_services.profile_id', '=', 'outreach_profile.profile_id')
			->join('state_master', 'state_master.id', '=', 'outreach_profile.state_id')
			->where(['state_master.region' => 3])
			->where('outreach_profile.unique_serial_number', 'LIKE', 'VN%')
			->distinct('outreach_profile.unique_serial_number')
			->count('outreach_profile.unique_serial_number');


		$WestReferredCounselled  = DB::table('outreach_counselling_services')
			->join('outreach_profile', 'outreach_counselling_services.profile_id', '=', 'outreach_profile.profile_id')
			->join('state_master', 'state_master.id', '=', 'outreach_profile.state_id')
			->where(['state_master.region' => 4])
			->where('outreach_profile.unique_serial_number', 'LIKE', 'VN%')
			->distinct('outreach_profile.unique_serial_number')
			->count('outreach_profile.unique_serial_number');


//Totals
		$totalOfprofilesapproached = Profile::where('client_type_id' , 1)->distinct('unique_serial_number')->count();
		$totalOfpersonsHIVrisk = DB::table('outreach_risk_assesment')
			->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_risk_assesment.profile_id')
			->where('outreach_risk_assesment.client_type_id', 1)
			->distinct('outreach_profile.unique_serial_number')
			->count('outreach_profile.unique_serial_number');

		$totalHIVrelatedservices =  DB::table('outreach_referral_service')
		->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_referral_service.profile_id')
		->distinct('outreach_profile.unique_serial_number')
		->count('outreach_profile.unique_serial_number');

		$totalReferred = DB::table('outreach_referral_service')
			->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_referral_service.profile_id')
			->where('outreach_referral_service.service_type_id', 1)
			->distinct('outreach_profile.unique_serial_number')
			->count('outreach_profile.unique_serial_number');

	// STI tested
		$totalOfpersonstestedSTI =  DB::table('outreach_referral_service')
		->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_referral_service.profile_id')
		->where('outreach_referral_service.service_type_id', 2)
		->where('outreach_referral_service.pid_or_other_unique_id_of_the_service_center', "<>", 0)
		->distinct('outreach_profile.unique_serial_number')
		->count('outreach_referral_service.profile_id');

		$totalOfpersonstestedHIV =  DB::table('outreach_referral_service')
		->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_referral_service.profile_id')
		->where('outreach_referral_service.service_type_id', 1)
		->where('outreach_referral_service.pid_or_other_unique_id_of_the_service_center', "<>", 0)
		->distinct('outreach_profile.unique_serial_number')
		->count('outreach_referral_service.profile_id');

		$totalHivStatus = DB::table('outreach_referral_service')
		->where('outreach_referral_service.service_type_id', 1)
		->whereIn('outreach_referral_service.outcome_of_the_service_sought', array(1, 2))
		->count('outreach_referral_service.profile_id');

		// $totalHivPositive = ($NorthHIVpositive->count() + $SouthHIVpositive->count() + $EastHIVpositive->count() + $WestHIVpositive->count());
		$totalHivPositive = DB::table('outreach_referral_service')
		->select('outreach_profile.profile_id')
		->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_referral_service.profile_id')
		->where([ "outreach_referral_service.service_type_id" => 1])
		->where('outreach_referral_service.pid_or_other_unique_id_of_the_service_center', "<>", 0)
		->whereIn('outreach_referral_service.outcome_of_the_service_sought', array(1))
		->distinct('outreach_profile.unique_serial_number')
		->count();

		// $totallinkedtoART =  ($NorthART->count() + $SouthART->count() +  $EastART->count() + $WestART->count());
		$totallinkedtoART  = DB::table('outreach_plhiv')
		->select('outreach_plhiv.profile_id')
		->where('outreach_plhiv.pre_art_reg_number', "<>", 0)
		->count();

		// $totalCounselled = ($NorthCounselled->count() + $SouthCounselled->count() + $EastCounselled->count() + $WestCounselled->count());
		$totalCounselled = DB::table('outreach_counselling_services')
		->join('outreach_profile', 'outreach_counselling_services.profile_id', '=', 'outreach_profile.profile_id')
		->distinct('outreach_profile.unique_serial_number')
		->count('outreach_profile.unique_serial_number');

		// $totalCounsellingbyVNs = ($NorthReferredCounselled + $SouthReferredCounselled + $EastReferredCounselled + $WestReferredCounselled);
		$totalCounsellingbyVNs = DB::table('outreach_counselling_services')
		->join('outreach_profile', 'outreach_counselling_services.profile_id', '=', 'outreach_profile.profile_id')
		->where('outreach_profile.unique_serial_number', 'LIKE', 'VN%')
		->distinct('outreach_profile.unique_serial_number')
		->count('outreach_profile.unique_serial_number');



		$html = '';
		$html = '<tr><td># Of profiles approached</td><td>' . $North->count() . '</td><td>' . $South->count() . '</td><td>' . $East->count() . '</td><td>' . $West->count() . '</td><td>' . $totalOfprofilesapproached . '</td></tr>
			   <tr><td># Of persons whose HIV risk was assessed</td><td>' . $NorthRisk->count() . '</td><td>' . $SouthRisk->count() . '</td><td>' . $EastRisk->count() . '</td><td>' . $WestRisk->count() . '</td><td>' . $totalOfpersonsHIVrisk . '</td></tr>
				<tr><td># Of persons referred for HIV related services including HIV testing (head count)</td><td>' . $NorthHIVRelatedServices->count() . '</td><td>' . $SouthHIVRelatedServices->count() . '</td><td>' . $EastHIVRelatedServices->count() . '</td><td>' . $WestHIVRelatedServices->count() . '</td><td>' . $totalHIVrelatedservices . '</td></tr>
				<tr><td># Of persons referred for HIV testing </td><td>' . $NorthReferred . '</td><td>' . $SouthReferred . '</td><td>' . $EastReferred . '</td><td>' . $WestReferred . '</td><td>' . $totalReferred . '</td></tr>
				<tr><td># Of persons tested for HIV</td><td>' . $NorthPID->count() . '</td><td>' . $SouthPID->count() . '</td><td>' . $EastPID->count() . '</td><td>' . $WestPID->count() . '</td><td>' . $totalOfpersonstestedHIV . '</td></tr>
				<tr><td># Of person shared HIV status</td><td>' . $NorthPIDStatus->count() . '</td><td>' . $SouthPIDStatus->count() . '</td><td>' . $EastPIDStatus->count() . '</td><td>' . $WestPIDStatus->count() . '</td><td>' . $totalHivStatus . '</td></tr>
				<tr><td># Of persons found HIV positive</td><td>' . $NorthHIVpositive->count() . '</td><td>' . $SouthHIVpositive->count() . '</td><td>' . $EastHIVpositive->count() . '</td><td>' . $WestHIVpositive->count() . '</td><td>' . $totalHivPositive . '</td></tr>
				<tr><td># Of persons linked to ART </td><td>' . $NorthART->count() . '</td><td>' . $SouthART->count() . '</td><td>' . $EastART->count() . '</td><td>' . $WestART->count() . '</td><td>' . $totallinkedtoART . '</td></tr>
				<tr><td># Of persons Counselled </td><td>' . $NorthCounselled->count() . '</td><td>' . $SouthCounselled->count() . '</td><td>' . $EastCounselled->count() . '</td><td>' . $WestCounselled->count() . '</td><td>' . $totalCounselled . '</td></tr>
				<tr><td># Of persons referred for Counselling by VNs </td><td>' . $NorthReferredCounselled . '</td><td>' . $SouthReferredCounselled . '</td><td>' . $EastReferredCounselled . '</td><td>' . $WestReferredCounselled . '</td><td>' . $totalCounsellingbyVNs . '</td></tr>';
		$rslt = array("resultsHtml" => $html);
		echo json_encode($rslt, JSON_NUMERIC_CHECK);
		exit;
	}


	public function getClientindicators(Request $request)
	{


		$indi_date_frm = isset($request->indi_date_frm) ? $request->indi_date_frm : "";
		$indi_date_to = isset($request->indi_date_to) ? $request->indi_date_to : "";


		$sql = "1=1";
		if (!empty($indi_date_frm) && !empty($indi_date_to)) {
			$sql = " 1=1 AND (DATE(outreach_profile.registration_date)>='$indi_date_frm' AND  DATE(outreach_profile.registration_date)<='$indi_date_to') ";
		}

		$totalHIVrelatedservicesCount =  DB::table('outreach_referral_service')
			->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_referral_service.profile_id')
			->whereRaw($sql)
			->count('outreach_profile.unique_serial_number');


		$risktestedpositive  = DB::table('outreach_referral_service')
			->select('outreach_referral_service.profile_id')
			->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_referral_service.profile_id')
			->join('state_master', 'state_master.id', '=', 'outreach_profile.state_id')	
			->where([ "outreach_referral_service.service_type_id" => 1])
			->where('outreach_referral_service.pid_or_other_unique_id_of_the_service_center', "<>", 0)
			->where(["outreach_referral_service.outcome_of_the_service_sought" => 1])
			->distinct('outreach_profile.unique_serial_number')
			->whereRaw($sql)
			->get();

		$risktestedpositiveSti  = DB::table('outreach_referral_service')
			->select('outreach_referral_service.profile_id')
			->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_referral_service.profile_id')
			->join('state_master', 'state_master.id', '=', 'outreach_profile.state_id')	
			->where('outreach_referral_service.pid_or_other_unique_id_of_the_service_center', "<>", 0)
			->where(["outreach_referral_service.service_type_id" => 2, "outreach_referral_service.outcome_of_the_service_sought" => 1])
			->distinct('outreach_profile.unique_serial_number')
			->whereRaw($sql)
			->get();

		$risktestedpositiveoutreach_plhiv  = DB::table('outreach_plhiv')
			->select('outreach_plhiv.profile_id')
			->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_plhiv.profile_id')
			->where('outreach_plhiv.pre_art_reg_number', "<>", 0)			
			->whereRaw($sql)
			->get();

			$totalOfpersonstestedSTI =  DB::table('outreach_referral_service')
			->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_referral_service.profile_id')
			->where('outreach_referral_service.service_type_id', 2)
			->where('outreach_referral_service.pid_or_other_unique_id_of_the_service_center', "<>", 0)
			->distinct('outreach_profile.unique_serial_number')
			->whereRaw($sql)
			->count('outreach_referral_service.profile_id');
	
			$HIVRelatedServices = DB::table('outreach_referral_service')
			->select('outreach_referral_service.profile_id')
			->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_referral_service.profile_id')
			->join('state_master', 'state_master.id', '=', 'outreach_profile.state_id')
			->whereIn("outreach_referral_service.service_type_id", array(6, 3, 4, 8, 2, 1))
			->whereRaw($sql)
			->get();

			$counsellingServices = DB::table('outreach_counselling_services')
			->select('outreach_counselling_services.profile_id')
			->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_counselling_services.profile_id')
			->whereRaw($sql)
			->get();

			$totalHIVrelatedservicesHeadCount =  DB::table('outreach_referral_service')
			->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_referral_service.profile_id')
			->distinct('outreach_profile.unique_serial_number')
			->whereRaw($sql)
			->count('outreach_profile.unique_serial_number');

			
			$totalOfprofilesapproached = DB::table('outreach_profile')
			->where('client_type_id', 1)
			->distinct('unique_serial_number')
			->whereRaw($sql)
			->count('unique_serial_number');

			$totalOfpersonsHIVrisk = DB::table('outreach_risk_assesment')
				->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_risk_assesment.profile_id')
				->where('outreach_risk_assesment.client_type_id', 1)
				->distinct('outreach_profile.unique_serial_number')
				->whereRaw($sql)
				->count('outreach_profile.unique_serial_number');

			$totalOfpersonstestedHIV =  DB::table('outreach_referral_service')
				->join('outreach_profile', 'outreach_profile.profile_id', '=', 'outreach_referral_service.profile_id')
				->where('outreach_referral_service.service_type_id', 1)
				->where('outreach_referral_service.pid_or_other_unique_id_of_the_service_center', "<>", 0)
				->distinct('outreach_profile.unique_serial_number')
				->whereRaw($sql)
				->count('outreach_referral_service.profile_id');
				
				$totalCounselled = DB::table('outreach_counselling_services')
				->join('outreach_profile', 'outreach_counselling_services.profile_id', '=', 'outreach_profile.profile_id')
				->distinct('outreach_profile.unique_serial_number')
				->whereRaw($sql)
				->count('outreach_profile.unique_serial_number');


			$virtualplatformsPercentage = 0;
			if ($totalOfprofilesapproached > 0) {
				$percentage = ($totalHIVrelatedservicesHeadCount / $totalOfprofilesapproached) * 100;
				$virtualplatformsPercentage = round($percentage, 2);
			}

		$html = '';
		$html = '<tr><td>A.1</td><td>Number of new profiles approached/reached through virtual platforms</td><td>' . $totalOfprofilesapproached . '</td></tr>
				<tr><td>A.2</td><td>Number of all landings with unique IP address who completed HIV risk assessment</td><td>' . $totalOfpersonsHIVrisk . '</td></tr>
				<tr><td>A.3</td><td>Number of persons referred for HIV related services (Counselling on Mental Health, PrEP, PEP, Referral to TI services, STI services, and HIV testing)</td><td>' . $totalHIVrelatedservicesCount . '</td></tr>
				<tr><td>A.5</td><td>Number of populations at risk tested for HIV</td><td>' . $totalOfpersonstestedHIV . '</td></tr>
				<tr><td>A.6</td><td>Number of populations at risk tested for STI</td><td>' . $totalOfpersonstestedSTI . '</td></tr>
				<tr><td>A.7</td><td>Total number of populations provided with Counselling Services </td><td>' . $totalCounselled . '</td></tr>
				<tr><td>A.8 </td><td>Proportion of key population identified at virtual place and linked to HIV related services during the reporting period (%)</td><td>' . $virtualplatformsPercentage . '</td></tr>';


		$html .= '<tr><th colspan="5" style="text-align: center;">D : Core Indicators</th></tr>';
		$html .= '<tr><td>D.1</td><td>Number of populations at risk who tested HIV positive </td><td>' . $risktestedpositive->count() . '</td></tr>
				<tr><td>D.2</td><td>Number of populations at risk who tested STI positive </td><td>' . $risktestedpositiveSti->count() . '</td></tr>
				<tr><td>D.3</td><td>Number of populations tested HIV positive linked with ART center</td><td>' . $risktestedpositiveoutreach_plhiv->count() . '</td></tr>';





		$rslt = array("resultsHtml" => $html);
		echo json_encode($rslt, JSON_NUMERIC_CHECK);
		exit;
	}
}
