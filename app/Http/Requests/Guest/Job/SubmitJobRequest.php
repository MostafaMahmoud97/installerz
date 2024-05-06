<?php

namespace App\Http\Requests\Guest\Job;

use Illuminate\Foundation\Http\FormRequest;

class SubmitJobRequest extends FormRequest
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
            "user_id" => "required|integer|exists:users,id",
            "service" => "required|in:Install and BOS only,Permit,Project Management,All services",
            "company_name" => "required|string",
            "project_manager" => "required|string",
            "pm_phone" => "required|string",
            "pm_email" => "required|email",
            //------------------->
            "full_name" => "required|string",
            "address" => "required|string",
            "phone" => "required|string",
            "email" => "required|email",
            "is_hoa" => "required|in:0,1",
            "site_survey_needed" => "required|in:0,1",
            "site_survey_file" => "required_if:site_survey_needed,==,1|mimes:jpg,png,svg,jpeg,webp,pdf",
            "design_needed" => "required|in:0,1",
            "design_needed_file" => "required_if:design_needed,==,1|mimes:jpg,png,svg,jpeg,webp,pdf",
            //--------------------->
            "installation_type" => "required|in:ground mount,roof top",
            "num_of_feet_trenching" => "required_if:installation_type,==,ground mount|numeric|nullable",
            "roof_type" => "required_if:installation_type,==,roof top|in:shingle,espanshe|nullable",
            "roof_pitch" => "numeric|nullable",
            "bird_protected" => "required_if:installation_type,==,roof top|in:0,1|nullable",
            "solar_lip" => "required_if:installation_type,==,roof top|in:0,1|nullable",
            "number_of_panels" => "required|integer",
            "panel_wattage" => "required|numeric",
            "system_size" => "required|numeric",
            "inverter_type" => "nullable|string",
            "main_survey_upgrade" => "required|in:0,1",
            "existing_amp" => "required_if:main_survey_upgrade,==,1|string",
            "de_rate" => "required|in:0,1",
            "new_amp" => "required_if:de_rate,==,1|string",
            "is_battery" => "required|in:0,1",
            "number_battery" => "required_if:is_battery,==,1|integer",
            "is_ev_charger" => "required|in:0,1",
            "number_feet_from_service_panel" => "required_if:is_ev_charger,==,1|numeric"
        ];
    }
}
