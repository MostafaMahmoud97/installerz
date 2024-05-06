<?php

namespace App\Http\Requests\User\License;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLicenseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "title" => "required|string",
            "license_number" => "required|string",
            "description" => "required|string",
            "workers_comp" => "nullable|mimes:pdf",
            "liability_insurance" => "nullable|mimes:pdf",
        ];
    }
}
