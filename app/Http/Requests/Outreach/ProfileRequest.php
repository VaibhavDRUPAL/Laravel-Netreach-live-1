<?php

namespace App\Http\Requests\Outreach;

use App\Models\Outreach\Profile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
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
            Profile::district_id => 'required',
            Profile::state_id => 'required',
            Profile::client_type_id => 'required',
            Profile::registration_date => 'required',
            Profile::location => 'nullable',
            Profile::platform_id => 'required',
            Profile::profile_name => 'required',
            Profile::age => Rule::when($this->filled('age_not_disclosed'), 'prohibited', ['required', 'numeric', 'gt:18', 'lt:100']),
            Profile::age_not_disclosed => 'boolean',
            Profile::other_platform => 'required_if:platform_id,99',
            Profile::gender_id => 'required',
            Profile::other_gender => 'required_if:gender_id,5',
            Profile::target_id => 'required',
            Profile::others_target_population => 'required_if:target_id,99',
            Profile::response_id => 'required',
            Profile::virtual_platform => 'nullable',
            Profile::mention_platform_id => 'required_if:virtual_platform,1',
            Profile::others_mentioned => 'required_if:mention_platform_id,99',
            Profile::follow_up_date => 'nullable|after_or_equal:registration_date',
            Profile::phone_number => 'nullable|numeric|digits_between:10,10|regex:' . MOB_REGEX,
            Profile::referral_other => 'required_if:in_referral,99',
            Profile::purpose_other => 'required_if:purpose_val,99'

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
            Profile::other_platform => $this->other_platform ?? null,
            Profile::other_gender => $this->other_gender ?? null,
            Profile::others_target_population => $this->others_target_population ?? null,
            Profile::mention_platform_id => $this->mention_platform_id ?? null,
            Profile::unique_serial_number => $this->unique_serial_number ?? null,
            Profile::uid => $this->uid ?? null,
            Profile::referral_other => $this->referral_other ?? null,
            Profile::purpose_other => $this->purpose_other ?? null,
        ]);
    }
}