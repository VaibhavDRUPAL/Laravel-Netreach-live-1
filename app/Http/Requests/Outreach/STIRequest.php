<?php

namespace App\Http\Requests\Outreach;

use App\Models\Outreach\STIService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class STIRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            STIService::profile_id => 'required',
            STIService::client_type_id => 'required',
            STIService::date_of_sti => 'required|date',
            STIService::pid_or_other_unique_id_of_the_service_center => 'required',
            STIService::is_treated => 'required|boolean',
            STIService::sti_service_id => 'required',
            STIService::applicable_for_syphillis => 'nullable|max:250',
            STIService::state_id => Rule::requiredIf($this->integer(STIService::is_treated) == 1),
            STIService::district_id => Rule::requiredIf($this->integer(STIService::is_treated) == 1),
            STIService::center_id => Rule::requiredIf($this->integer(STIService::is_treated) == 1),
            STIService::type_facility_where_treated => Rule::requiredIf($this->integer(STIService::is_treated) == 1),
            STIService::other_sti_service => 'nullable|required_if:sti_service_id,99',
            STIService::remarks => 'nullable',
            STIService::status => 'boolean'
        ];
    }
}