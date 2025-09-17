<?php

namespace App\Exports;

use App\Models\Outreach\Profile;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\{Exportable, FromArray, ShouldAutoSize, WithHeadings, WithMapping, WithStyles};
use Maatwebsite\Excel\Excel;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OutreachProfileExport implements FromArray, WithHeadings, WithMapping, WithStyles, Responsable, ShouldAutoSize
{
	use Exportable;

	private $fileName = 'outreach-profile.xlsx';

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
			'Name',
			'Mobile Number',
            'Status',
            'Comments',
            'UID',
            'Employee Name',
			'Unique Serial No',
			'Reg Date',
			'State',
			'District',
			'App Platform',
			'Other',
			'Remarks',
		];
	}

	public function map($profileData): array
	{
		return [
			$profileData['sr_no'],
			$profileData[Profile::profile_name],
			$profileData[Profile::phone_number],
			$profileData[Profile::status],
            $profileData[Profile::comment],
            $profileData[Profile::uid],
            $profileData[Profile::user_id],
            $profileData[Profile::unique_serial_number],
            $profileData[Profile::registration_date],
            $profileData[Profile::state_id],
            $profileData[Profile::district_id],
            $profileData[Profile::platform_id],
            $profileData[Profile::other_platform],
            $profileData[Profile::remarks],
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
