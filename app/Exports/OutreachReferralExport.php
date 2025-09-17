<?php

namespace App\Exports;

use App\Models\Outreach\ReferralService;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\{Exportable, FromArray, ShouldAutoSize, WithHeadings, WithMapping, WithStyles};
use Maatwebsite\Excel\Excel;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OutreachReferralExport implements FromArray, WithHeadings, WithMapping, WithStyles, Responsable, ShouldAutoSize
{
	use Exportable;

	private $fileName = 'outreach-referral.xlsx';

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
			'Unique Serial No',
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

		
			// 'Sr. No',
			// 'Referral ID',
			// 'Employee Name',
			// 'UID',
			// 'Profile Name',
			// 'Age',
			// 'Target Population',
			// 'Others',
			// 'Type of Service',
			// 'Other service type',
			// 'Name and address of Referral Centre',
			// 'Referred state',
			// 'Referred District',
			// 'Date of Referral',
			// 'Date of Accessing Service',
			// 'Service accessed Centre state',
			// 'Service accessed Centre District',
			// 'Name and address of Service accessed Centre',
			// 'PRE-ART NO',
			// 'ON-ART NO',
			// 'PID or other unique ID',
			// 'Outcome of the Service Sought',
			// 'Created At',
			// 'Updated At'
		];
	}

	public function map($referralData): array
	{
		return [
			$referralData['sr_no'],
			$referralData['unique_serial_no'],
			$referralData['profile_name'],
			$referralData[ReferralService::client_name],
			$referralData[ReferralService::user_id],
			$referralData[ReferralService::age_client],
			$referralData[ReferralService::service_type_id],
			$referralData[ReferralService::other_service_type],
			$referralData[ReferralService::referred_state_id],
			$referralData[ReferralService::referred_district_id],
			$referralData[ReferralService::referral_center_id],
			$referralData[ReferralService::referral_service_id],
			$referralData[ReferralService::netreach_uid_number],
			$referralData[ReferralService::referral_date],
			$referralData[ReferralService::target_id],
			$referralData[ReferralService::others_target_population],
			$referralData[ReferralService::type_of_test],
			$referralData[ReferralService::test_centre_state_id],
			$referralData[ReferralService::test_centre_district_id],
			$referralData[ReferralService::service_accessed_center_id],
			$referralData[ReferralService::outcome_of_the_service_sought],
			$referralData[ReferralService::date_of_accessing_service],
			$referralData[ReferralService::pid_or_other_unique_id_of_the_service_center],
			$referralData[ReferralService::remarks],
			$referralData[ReferralService::pre_art_no],
			$referralData[ReferralService::on_art_no],
			$referralData[ReferralService::created_at],
			$referralData[ReferralService::updated_at],	
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
