<?php

namespace App\Http\Requests\User\OurTeam;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOurTeamRequest extends FormRequest
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
            "name" => "required|string",
            "position" => "required|string",
            "description" => "required|string",
            "cover" => "nullable|mimes:jpg,png,jpeg,svg,webp",
        ];
    }
}
