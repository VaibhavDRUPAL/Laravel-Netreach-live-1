<?php

namespace App\Exports;

use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\{Exportable, FromArray, ShouldAutoSize, WithHeadings, WithMapping, WithStyles};
use Maatwebsite\Excel\Excel;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SelfRiskAssessment implements FromArray, WithHeadings, WithMapping, WithStyles, Responsable, ShouldAutoSize
{
    use Exportable;

    private $fileName;

    private $writerType = Excel::XLSX;

    protected $header, $slug, $data, $isCombineList;

    public function __construct(array $header, array $slug, array $data, bool $isCombineList)
    {
        $this->header = $header;
        $this->slug = $slug;
        $this->data = $data;
        $this->isCombineList = $isCombineList;
        $this->fileName = $isCombineList ? 'master-line-list.xlsx' : 'self-risk-assessment.xlsx';
        // dd($this->data);
    }

    public function array(): array
    {
        return $this->data;
    }

    public function headings(): array
    {
        $headers  = [
            'Assessment No',
            'Appointment No',
            'Full name',
            'Total Risk',
            'VN Name',
            'Has Appointment',
        ];

        $this->header = array_merge($headers, $this->header);
        $this->header = array_merge($this->header, ['RA Date']);
        $this->header = array_merge($this->header, ['RA Month']);

        if ($this->isCombineList) {
            $this->header  = array_merge(
                $this->header,
                [
                    'Referral no',
                    'UID',
                    'Mobile no',
                    'Services',
                    'Appointment date',
                    'Appointment Month',
                    'Not access the service referred',
                    'Date of accessing service',
                    'Month of accessing service',
                    'PID provided at the service center',
                    'Outcome of the service sought',
                    'Remark',
                    'Booked at',
                    'Booking Month',
                    'Appointment State',
                    'Appointment District',
                    'Appointment Center',
                    'Pre ART No',
                    'On ART No',
                    'Updated By',
                    'Updated At'
                ]
            );
        }

        $this->header = array_merge($this->header, [
            'IP',
            'User Country',
            'User State',
            'User City'
        ]);

        return $this->header;
    }

    public function map($row): array
    {
        $slug  = [
            'sr-no',
            'appointment-no',
            'full-name',
            'risk-score',
            'vn-name',
            'has-appointment'
        ];

        $this->slug = array_merge($slug, $this->slug);
        $this->slug = array_merge($this->slug, ['ra-date']);
        $this->slug = array_merge($this->slug, ['ra-month']);

        if ($this->isCombineList) {
            $this->slug  = array_merge(
                $this->slug,
                [
                    'referral-no',
                    'uid',
                    'mobile-no',
                    'services',
                    'appointment-date',
                    'appointment-month',
                    'not-access-the-service-referred',
                    'date-of-accessing-service',
                    'month-of-accessing-service',
                    'pid-provided-at-the-service-center',
                    'outcome-of-the-service-sought',
                    'remark',
                    'booked-at',
                    'booked-month',
                    'appointment-state',
                    'district',
                    'center',
                    'pre-art-no',
                    'on-art-no',
                    'updated-by',
                    'updated-at'
                ]
            );
        }

        $this->slug = array_merge($this->slug, [
            'ip',
            'ip-country',
            'ip-state',
            'ip-city'
        ]);

        $setRow = collect()->make();

        foreach ($this->slug as $value)
            $setRow->put($value, $row[$value]);

        return $setRow->all();
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
