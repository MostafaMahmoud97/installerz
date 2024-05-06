<?php

namespace App\Http\Requests\User\Project;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
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
            "address" => "required|string",
            "type" => "required|in:Solar,Roofing",
            "date" => "required|date|date_format:Y-m-d",
            "thumbnail" => "required|mimes:jpg,png,jpeg,svg,webp",
            "gallery" => "required|array|min:1",
            "gallery.*" => "required|mimes:jpg,png,jpeg,svg,webp"
        ];
    }
}
