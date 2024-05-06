<?php

namespace App\Http\Requests\User\StandOutSection;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStandOutRequest extends FormRequest
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
            "description" => "required|string",
            "cover" => "nullable|mimes:jpg,png,jpeg,svg,webp",
            "icon" => "nullable|mimes:jpg,png,jpeg,svg,webp"
        ];
    }
}
