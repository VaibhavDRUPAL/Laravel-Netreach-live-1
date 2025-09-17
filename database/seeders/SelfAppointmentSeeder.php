<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SelfModule\{Appointments, RiskAssessment};
use Illuminate\Support\Facades\DB;

class SelfAppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            DB::beginTransaction();

            $currentDateTime = currentDateTime(FOR_FILE_NAME_FORMAT);

            $existingAssessmentData = RiskAssessment::all();
            $existingAppointmentData = Appointments::all();

            // JSON Backup
            mediaOperations(BACKUP_PATH . 'assessment' . UNDERSCORE . $currentDateTime . EXT_JSON, $existingAssessmentData->toJson(), FL_CREATE, MDT_STORAGE, STD_LOCAL);
            mediaOperations(BACKUP_PATH . 'appointments' . UNDERSCORE . $currentDateTime . EXT_JSON, $existingAppointmentData->toJson(), FL_CREATE, MDT_STORAGE, STD_LOCAL);

            $existingAppointmentsOfNotNullEvidencePath = Appointments::whereNotNull(Appointments::evidence_path)->orderByDesc(Appointments::appointment_id)->get();
            $mobileNoFromAppoinmentOfNotNullEvidencePath = $existingAppointmentsOfNotNullEvidencePath->pluck(Appointments::mobile_no);
            $mobileNoCountFromAppoinmentOfNotNullEvidencePath = $mobileNoFromAppoinmentOfNotNullEvidencePath->countBy()->sort();

            $appointmentLogData = collect()->make();
            $assessmentLogData = collect()->make();

            $mobileNoCountFromAppoinmentOfNotNullEvidencePath->each(function ($key, $value) use ($existingAssessmentData, $appointmentLogData, $assessmentLogData) {

                $isExists = $existingAssessmentData->where(RiskAssessment::mobile_no, $value);

                if ($assessmentLogData->isNotEmpty()) $isExists = $isExists->whereNotIn(RiskAssessment::risk_assessment_id, $assessmentLogData->all());

                $isExists = $isExists->isNotEmpty();

                if ($isExists) {
                    $data = $existingAssessmentData->where(RiskAssessment::mobile_no, $value)->first();
                    $query = Appointments::where(Appointments::mobile_no, $value)
                        ->where(Appointments::assessment_id, 0);

                    if ($appointmentLogData->isNotEmpty()) $query = $query->whereNotIn(Appointments::appointment_id, $appointmentLogData->all());

                    $query = $query->orderByDesc(Appointments::appointment_id)
                        ->take(1);

                    if ($query->exists()) {
                        $appointmentData = $query->first();

                        $query->update([
                            Appointments::assessment_id => $data[RiskAssessment::risk_assessment_id]
                        ]);

                        $appointmentLogData->push($appointmentData[Appointments::appointment_id]);
                        $assessmentLogData->push($data[RiskAssessment::risk_assessment_id]);
                    }
                }
            });

            Appointments::whereNull(Appointments::evidence_path)->delete();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
        }
    }
}
