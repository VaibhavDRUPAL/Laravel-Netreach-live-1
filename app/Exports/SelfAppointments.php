<?php

namespace App\Exports;

use App\Models\SelfModule\Appointments;
use App\Models\SelfModule\RiskAssessment;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\{Exportable, FromArray, ShouldAutoSize, WithHeadings, WithMapping, WithStyles};
use Maatwebsite\Excel\Excel;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SelfAppointments implements FromArray, WithHeadings, WithMapping, WithStyles, Responsable, ShouldAutoSize
{
    use Exportable;

    private $fileName = 'self-appointments.xlsx';

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
            'Appointment No.',
            'Assessment No.',
            'Full name',
            'VN Name',
            'Mobile No',
            'Services',
            'State',
            'District',
            'Center',
            'Referral No',
            'UID',
            'Appointment Date',
            'Appointment Month',
            'Type of Test',
            'Test State',
            'Test District',
            'Test Center',
            'Outcome of the service sought',
            'Risk Score',
            'Date of accessing service',
            'Month of accessing service',
            'Reason (Not access the service referred)',
            'PID provided at the service center',
            'Remark',
            'Pre ART No',
            'On ART No',
            'RA Date',
            'RA Month',
            'Updated By',
            'Updated At'
        ];
    }

    public function map($appointments): array
    {

        return [
            $appointments['sr_no'],
            $appointments['assessment_no'],
            $appointments[Appointments::full_name],
            !empty($appointments['vn_name']) ? $appointments['vn_name'] : '',
            $appointments[Appointments::mobile_no],
            $appointments[Appointments::services],
            $appointments['state'],
            $appointments['district'],
            $appointments['center'],
            $appointments[Appointments::referral_no],
            $appointments[Appointments::uid],
            $appointments[Appointments::appointment_date],
            $appointments['appointment-month'],
            $appointments[Appointments::type_of_test],
            $appointments[Appointments::treated_state_id],
            $appointments[Appointments::treated_district_id],
            $appointments[Appointments::treated_center_id],
            $appointments[Appointments::outcome_of_the_service_sought],
            $appointments[RiskAssessment::risk_score],
            $appointments[Appointments::date_of_accessing_service],
            $appointments['month-of-accessing-service'],
            $appointments[Appointments::not_access_the_service_referred],
            $appointments[Appointments::pid_provided_at_the_service_center],
            $appointments[Appointments::remark],
            $appointments[Appointments::pre_art_no],
            $appointments[Appointments::on_art_no],
            $appointments['ra_date'],
            $appointments['ra-month'],
            $appointments[Appointments::updated_by],
            $appointments[Appointments::updated_at]
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
