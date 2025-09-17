<?php

namespace App\Http\Requests\Outreach;

use App\Models\Outreach\ReferralService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReferralServiceRequest extends FormRequest
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
            ReferralService::profile_id => 'required',
            ReferralService::client_type_id => 'required',
            ReferralService::educational_attainment_id => 'required',
            ReferralService::occupation_id => 'required',
            ReferralService::service_type_id => 'required',
            ReferralService::other_service_type => 'required_if:service_type_id,99',
            ReferralService::target_id => 'required',
            ReferralService::others_target_population => 'required_if:target_id,99',
            ReferralService::ti_service_id => Rule::requiredIf($this->integer('service_type_id') == 8),
            ReferralService::other_referred_service => 'required_if:ti_service_id,99',
            ReferralService::counselling_service => 'required',
            ReferralService::prevention_programme => 'required',
            ReferralService::referral_date => Rule::when($this->filled('date_of_risk_assessment'), ['required', 'date', 'after_or_equal:date_of_risk_assessment'], ['required', 'date']),
            ReferralService::referred_state_id => 'required',
            ReferralService::referred_district_id => 'required',
            ReferralService::type_of_facility_where_tested => Rule::requiredIf($this->integer('access_service') == 1 && $this->integer('client_access_service') == 0),
            ReferralService::test_centre_state_id => Rule::requiredIf($this->integer('access_service') == 1 && $this->integer('client_access_service') == 0),
            ReferralService::test_centre_district_id => Rule::requiredIf($this->integer('access_service') == 1 && $this->integer('client_access_service') == 0),
            ReferralService::service_accessed_center_id => Rule::requiredIf($this->integer('access_service') == 1 && $this->integer('client_access_service') == 0),
            ReferralService::date_of_accessing_service => Rule::when($this->integer('access_service') == 1, ['required', 'date', 'after_or_equal:referral_date']),
            ReferralService::applicable_for_hiv_test => Rule::requiredIf($this->integer('type_service') == 1),
            ReferralService::sti_service_id => Rule::requiredIf($this->integer('type_service') == 2),
            ReferralService::pid_or_other_unique_id_of_the_service_center => Rule::requiredIf($this->integer('access_service') == 1),
            ReferralService::outcome_of_the_service_sought => Rule::requiredIf($this->integer('access_service') == 1),
            ReferralService::reason_id => Rule::requiredIf($this->integer('access_service') == 0),
            ReferralService::other_not_access => Rule::when($this->integer(ReferralService::reason_id) == 99, 'required', ['nullable', 'max:250']),
            ReferralService::follow_up_date => 'nullable',
            ReferralService::remarks => 'nullable|max:255'
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        // $this->merge([
        //     'othere' => $this->othere ?? "",
        //     'others_services' => $this->others_services ?? "",
        //     'bcc_provided' => $this->bcc_provided ?? "",
        //     'others_referred_service' => $this->others_referred_service ?? "",
        // ]);
    }
}