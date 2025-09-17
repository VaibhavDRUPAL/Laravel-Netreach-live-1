<?php

namespace App\Exports;

use App\Models\SelfModule\Appointments;
use App\Models\SelfModule\RiskAssessmentQuestionnaire;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\{Exportable, FromArray, ShouldAutoSize, WithHeadings, WithMapping, WithStyles};
use Maatwebsite\Excel\Excel;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class QuestionariesExport implements FromArray, WithHeadings, WithMapping, WithStyles, Responsable, ShouldAutoSize
{
	use Exportable;

	private $fileName = 'self-questionaries.xlsx';

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
			'Question',
			'Count',
		];
	}

	public function map($appointments): array
	{
		return [
			$appointments['sr_no'],
			$appointments[RiskAssessmentQuestionnaire::question],
			$appointments[RiskAssessmentQuestionnaire::counter],
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
