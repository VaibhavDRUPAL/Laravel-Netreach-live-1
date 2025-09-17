<?php

namespace App\Http\Requests\Outreach;

use App\Models\Outreach\PLHIV;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PLHIVRequest extends FormRequest
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
            PLHIV::profile_id => 'required',
            PLHIV::client_type_id => 'required',
            PLHIV::pid_or_other_unique_id_of_the_service_center => 'required',
            PLHIV::date_of_confirmatory => 'required',

            PLHIV::date_of_art_reg => 'date|after_or_equal:profile_registration_date',
            PLHIV::pre_art_reg_number => 'present|nullable',
            PLHIV::date_of_on_art => 'date|after_or_equal:profile_registration_date',
            PLHIV::on_art_reg_number => 'present|nullable',

            PLHIV::type_of_facility_where_treatment_sought => 'required',
            PLHIV::art_state_id => 'required',
            PLHIV::art_district_id => 'required',
            PLHIV::art_center_id => 'required',
            PLHIV::remarks => 'max:250'
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        //
    }
}
