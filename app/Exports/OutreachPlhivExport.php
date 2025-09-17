<?php

namespace App\Exports;

use App\Models\Outreach\ReferralService;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\{Exportable, FromArray, ShouldAutoSize, WithHeadings, WithMapping, WithStyles};
use Maatwebsite\Excel\Excel;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OutreachPlhivExport implements FromArray, WithHeadings, WithMapping, WithStyles, Responsable, ShouldAutoSize
{
	use Exportable;

	private $fileName = 'outreach-plhiv.xlsx';

	private $writerType = Excel::XLSX;

	protected $data;

	public function __construct(array $data)
	{
		$this->data = $data;
	}

	public function array(): array
	{
		return $this->data;
	}

	public function headings(): array
	{
		return [
			'Sr. No',
			'Profile Name',
			'Client Name',
			'Employee Name',
			'Age',
			'Type of Service',
			'Other service type',
			'Referred state',
			'Referred District',
			'Name and address of Referral Centre',
			'Referral No',
			'UID',
			'Date of Referral',
			'Target Population',
			'Others',
			'Type of Test',
			'Service accessed Centre state',
			'Service accessed Centre District',
			'Name and address of Service accessed Centre',
			'Outcome of the Service Sought',
			'Date of Accessing Service',
			'PID or other unique ID',
			'Remarks',
			'PRE-ART NO',
			'ON-ART NO',
			'Created At',
			'Updated At'
		];
	}

	public function map($plhivData): array
	{
        return [
			$plhivData['sr_no'],
			$plhivData['profile_name'],
			$plhivData[ReferralService::client_name],
			$plhivData[ReferralService::user_id],
			$plhivData[ReferralService::age_client],
			$plhivData[ReferralService::service_type_id],
			$plhivData[ReferralService::other_service_type],
			$plhivData[ReferralService::referred_state_id],
			$plhivData[ReferralService::referred_district_id],
			$plhivData[ReferralService::referral_center_id],
			$plhivData[ReferralService::referral_service_id],
			$plhivData[ReferralService::netreach_uid_number],
			$plhivData[ReferralService::referral_date],
			$plhivData[ReferralService::target_id],
			$plhivData[ReferralService::others_target_population],
			$plhivData[ReferralService::type_of_test],
			$plhivData[ReferralService::test_centre_state_id],
			$plhivData[ReferralService::test_centre_district_id],
			$plhivData[ReferralService::service_accessed_center_id],
			$plhivData[ReferralService::outcome_of_the_service_sought],
			$plhivData[ReferralService::date_of_accessing_service],
			$plhivData[ReferralService::pid_or_other_unique_id_of_the_service_center],
			$plhivData[ReferralService::remarks],
			$plhivData[ReferralService::pre_art_no],
			$plhivData[ReferralService::on_art_no],
			$plhivData[ReferralService::created_at],
		];
	}

	public function styles(Worksheet $sheet)
	{
		return [
			1 => [
				'font' => [
					'bold' => true
				]
			]
		];
	}
}
