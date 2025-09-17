<?php

namespace App\Http\Requests\Outreach;

use App\Models\Outreach\RiskAssessment;
use Illuminate\Foundation\Http\FormRequest;

class RiskAssessmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            RiskAssessment::profile_id => 'required',
            RiskAssessment::client_type_id => 'required',
            RiskAssessment::date_of_risk_assessment => 'required|after_or_equal:profile_registration_date',
            RiskAssessment::had_sex_without_a_condom => 'required',
            RiskAssessment::shared_needle_for_injecting_drugs => 'required',
            RiskAssessment::sexually_transmitted_infection => 'required',
            RiskAssessment::sex_with_more_than_one_partners => 'required',
            RiskAssessment::had_chemical_stimulantion_or_alcohol_before_sex => 'required',
            RiskAssessment::had_sex_in_exchange_of_goods_or_money => 'required',
            RiskAssessment::other_reason_for_hiv_test => 'max:255'
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            RiskAssessment::other_reason_for_hiv_test => $this->other_reason_for_hiv_test ?? null
        ]);
    }
}