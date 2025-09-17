<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Surveys extends Model
{
	use LogsActivity;

	public function getActivitylogOptions(): LogOptions
	{
		return LogOptions::defaults();
	}

	protected $fillable = [
		'user_id',
		'your_age',
		'identify_yourself',
		'identify_others',
		'sexually',
		'hiv_infection',
		'risk_level',
		'flag',
		'survey_co_flag',
		'hiv_infection_new'
	];

	public static function getPoReportCtr($status = 0, $start = '', $limit = 10, $stateArr = array(), $srch = '')
	{


		$sql =   Surveys::select(
			'U.name AS client_name',
			'U.phone_number as client_phone_number',
			'surveys.client_type',
			'BAM.created_at as book_date',
			'D.district_name',
			'SM.state_name',
			'surveys.your_age',
			'surveys.identify_yourself',
			'surveys.target_population',
			'surveys.risk_level',
			'U.uid',
			'surveys.services_required',
			'CM.services_avail',
			'BAM.appoint_date',
			'CM.name as center_name',
			'platforms.name as platforms_name',
			'surveys.hiv_test',
			'surveys.id as survey_ids',
			'surveys.flag',
			'vn_upload_survey_files.acess_date',
			'vn_upload_survey_files.pid',
			'vn_upload_survey_files.outcome',
			'surveys.survey_co_flag',
			'surveys.po_status'
		)
			->join('customers as U', 'U.id', '=', 'surveys.user_id')
			->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
			->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
			->join('district_master as D', 'D.district_code', '=', 'CM.district_id')
			->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
			->leftJoin('platforms', 'platforms.id', '=', 'surveys.platform_id')
			->leftJoin('vn_upload_survey_files', 'vn_upload_survey_files.survey_id', '=', 'surveys.id')
			->where(["surveys.po_status" => $status]);

		if (count($stateArr) > 0) {
			$sql->whereIn('BAM.state_id', $stateArr);
		}
		if (!empty($srch)) {
			$sql->where('SM.state_name', 'like', '%' . $srch . '%');
		}

		$sql->groupBy('surveys.id')->orderBy('surveys.id', 'DESC');


		if ($start <> '' && !empty($limit)) {
			$sql->skip($start)->take($limit);
		}
		return $sql->get();
	}

	public static function get_all_survey($start = '', $limit = 10, $stateArr = array(), $srch = '', $conArr = array(0, 1), $facility = '', $target_pop = '', $pid_survey = '', $outcome = '', $date_type = '', $date_to = '', $date_from = '', $services = '')
	{



		$sql = Surveys::select(
			'surveys.id',
			'U.name AS client_name',
			'U.phone_number as client_phone_number',
			'surveys.client_type',
			'surveys.manual_flag',
			'surveys.sexually',
			'surveys.hiv_infection',
			'surveys.survey_details',
			'BAM.created_at as book_date',
			'D.district_name',
			'SM.state_name',
			'surveys.your_age',
			'surveys.identify_yourself',
			'surveys.target_population',
			'surveys.risk_level',
			'U.uid',
			'surveys.services_required',
			'CM.services_avail',
			'BAM.appoint_date',
			'CM.name as center_name',
			'platforms.name as platforms_name',
			'surveys.hiv_test',
			'surveys.id as survey_ids',
			'surveys.flag',
			'vn_upload_survey_files.acess_date',
			'vn_upload_survey_files.pid',
			'vn_upload_survey_files.outcome',
			'vn_upload_survey_files.file_upload',
			'vn_upload_survey_files.detail',
			'vn_upload_survey_files.id as file_upload_id',
			'surveys.survey_co_flag',
			'surveys.po_status',
			'BAM.survey_unique_ids'
		)
			->join('customers as U', 'U.id', '=', 'surveys.user_id')
			->join('book_appinment_master as BAM', 'BAM.survey_id', '=', 'surveys.id')
			->join('centre_master as CM', 'CM.id', '=', 'BAM.center_ids')
			->join('district_master as D', 'D.id', '=', 'CM.district_id')
			->join('state_master as SM', 'SM.state_code', '=', 'D.state_code')
			->leftJoin('platforms', 'platforms.id', '=', 'surveys.platform_id')
			->leftJoin('vn_upload_survey_files', 'vn_upload_survey_files.survey_id', '=', 'surveys.id');

		$sql->whereIn('BAM.state_id', $stateArr);
		$sql->whereIn('surveys.survey_co_flag', $conArr);

		if (!empty($facility)) {
			$sql->whereRaw("FIND_IN_SET($facility,CM.services_avail)");
		}

		if (!empty($target_pop)) {

			$sql->where('surveys.target_population', $target_pop);
		}

		if (!empty($date_type) && $date_type == "assessment_date") {
			$sql->whereDate('BAM.created_at', '>=', $date_from);
			$sql->whereDate('BAM.created_at', '<=', $date_to);
		} else if (!empty($date_type) && $date_type == "referral_date") {
			$sql->whereDate('BAM.appoint_date', '>=', $date_from);
			$sql->whereDate('BAM.appoint_date', '<=', $date_to);
		} else if (!empty($date_type) && $date_type == "acess_date") {
			$sql->whereDate('vn_upload_survey_files.acess_date', '>=', $date_from);
			$sql->whereDate('vn_upload_survey_files.acess_date', '<=', $date_to);
		}

		if (!empty($pid_survey)) {
			$sql->where('vn_upload_survey_files.pid', $pid_survey);
		}

		if (!empty($outcome)) {
			$sql->where('vn_upload_survey_files.outcome', $outcome);
		}
		if (!empty($services)) {
			$sql->whereRaw("FIND_IN_SET('" . $services . "',REPLACE(REPLACE(REPLACE(services_required, '[', ''),']',''),'\"',''))");
		}
		$sql->groupBy('surveys.id');
		$sql->orderBy('surveys.id', 'DESC');
		if (!empty($limit)) {
			$sql->skip($start)->take($limit);
		}
		return $sql->get();
	}
}