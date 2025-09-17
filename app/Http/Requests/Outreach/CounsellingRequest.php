<?php

namespace App\Http\Requests\Outreach;

use App\Models\Outreach\Counselling;
use Illuminate\Foundation\Http\FormRequest;

class CounsellingRequest extends FormRequest
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
            Counselling::profile_id => 'required',
            Counselling::client_type_id => 'required',
            Counselling::referred_from => 'required',
            Counselling::referral_source => 'required_if:referred_from,99',
            Counselling::name_the_client => 'required',
            Counselling::date_of_counselling => 'required|after_or_equal:profile_registration_date',
            Counselling::phone_number => 'required|regex:' . MOB_REGEX,
            Counselling::type_of_counselling_offered => 'required',
            Counselling::type_of_counselling_offered_other => 'required_if:type_of_counselling_offered,99',
            Counselling::duration_of_counselling => 'present|nullable|numeric',
            Counselling::key_concerns_discussed => 'required',
            Counselling::follow_up_date => 'nullable|after_or_equal:date_of_counselling',
            Counselling::remarks => 'present|nullable'
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
            Counselling::referral_source => $this->referral_source ?? null,
            Counselling::type_of_counselling_offered_other => $this->type_of_counselling_offered_other ?? null,
        ]);
    }
}