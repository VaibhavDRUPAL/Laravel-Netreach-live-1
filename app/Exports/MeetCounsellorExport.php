<?php

namespace App\Exports;

use App\Models\SelfModule\MeetCounsellor;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\{Exportable, FromArray, ShouldAutoSize, WithHeadings, WithMapping, WithStyles};
use Maatwebsite\Excel\Excel;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MeetCounsellorExport implements FromArray, WithHeadings, WithMapping, WithStyles, Responsable, ShouldAutoSize
{
	use Exportable;

	private $fileName = 'meet-counsellor.xlsx';

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
			'ID',
			'Name',
			'Mobile Number',
			'State',
			'Region',
			'Message',
			'Date',
			'Follow-up Contacted',
			'Follow-up Action Taken',
			'Follow-Up Image',
			'Follow-Up Date'
		];
	}

	public function map($counsellorData): array
	{
		return [
			$counsellorData[MeetCounsellor::meet_id],
			$counsellorData[MeetCounsellor::name],
			$counsellorData[MeetCounsellor::mobile_no],
			$counsellorData[MeetCounsellor::state_name],
			$counsellorData[MeetCounsellor::region],
			$counsellorData[MeetCounsellor::message],
			$counsellorData[MeetCounsellor::created_at],
			$counsellorData['contacted'],
			$counsellorData['action_taken'],
			$counsellorData['follow_up_image'],
			$counsellorData['follow_up_date']
		];
	}

	public function styles(Worksheet $sheet)
	{
		$sheet->getStyle('A1:Z1000')->getAlignment()->setWrapText(true);
		return [
			1 => [
				'font' => [
					'bold' => true
				]
			]
		];
	}
}
