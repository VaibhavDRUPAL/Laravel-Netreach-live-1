<?php

namespace App\Http\Requests\Self\Admin;

use App\Models\SelfModule\Appointments;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class Appointment extends FormRequest
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
            Appointments::appointment_id => 'required',
            Appointments::not_access_the_service_referred => 'nullable|numeric',
            Appointments::date_of_accessing_service => 'nullable|date',
            Appointments::pid_provided_at_the_service_center => 'nullable|max:250',
            Appointments::outcome_of_the_service_sought => 'nullable|numeric',
            // Appointments::evidence_path => [
            //     Rule::requiredIf(!$this->filled('existing_evidence_path')),
            //     'array', // Ensure the field is an array
            //     'max:5', // Limit the array to a maximum of 5 files
            // ],
            Appointments::evidence_path . '.*' => [
                'file', // Each item in the array must be a file
                File::types(['pdf', 'jpg', 'jpeg', 'png'])->max(2048), // File type and size validation
            ],
            Appointments::remark => 'nullable',
        ];
    }

    // public function rules(): array
    // {
    //     return [
    //         Appointments::appointment_id => 'required',
    //         Appointments::not_access_the_service_referred => 'nullable|numeric',
    //         Appointments::date_of_accessing_service => 'nullable|date',
    //         Appointments::pid_provided_at_the_service_center => 'nullable|max:250',
    //         Appointments::outcome_of_the_service_sought => 'nullable|numeric',
    //         Appointments::evidence_path => [
    //             Rule::requiredIf(!$this->filled('existing_evidence_path')),
    //             'array',
    //         ],
    //         Appointments::evidence_path . '.*' => [
    //             'file',
    //             File::types(['pdf', 'jpg', 'jpeg', 'png'])->max(2048),
    //         ],
    //         Appointments::remark => 'nullable',
    //     ];
    // }
}

// namespace App\Http\Requests\Self\Admin;

// use App\Models\SelfModule\Appointments;
// use Illuminate\Foundation\Http\FormRequest;
// use Illuminate\Validation\Rule;
// use Illuminate\Validation\Rules\File;

// class Appointment extends FormRequest
// {
//     /**
//      * Determine if the user is authorized to make this request.
//      */
//     public function authorize(): bool
//     {
//         return true;
//     }

//     /**
//      * Get the validation rules that apply to the request.
//      *
//      * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
//      */
//     public function rules(): array
//     {
//         return [
//             Appointments::appointment_id => 'required',
//             Appointments::not_access_the_service_referred => 'nullable|numeric',
//             Appointments::date_of_accessing_service => 'nullable|date',
//             Appointments::pid_provided_at_the_service_center => 'nullable|max:250',
//             Appointments::outcome_of_the_service_sought => 'nullable|numeric',
//             Appointments::evidence_path => [
//                 Rule::requiredIf(!$this->filled('existing_evidence_path')),
//                 'file',
//                 File::types(['pdf', 'jpg', 'jpeg', 'png'])->max(2048)
//             ],
//             Appointments::remark => 'nullable',
//         ];
//     }
// }
