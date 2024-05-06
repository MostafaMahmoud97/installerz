<?php

namespace App\Http\Requests\User\HomePage;

use Illuminate\Foundation\Http\FormRequest;

class StoreHomePageRequest extends FormRequest
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
            "first_title" => "required|string",
            "second_title" => "required|string",
            "third_title" => "required|string",
            "info_title" => "required|string",
            "info_description" => "required|string",
            "benefits_title" => "required|string",
            "benefits_description" => "required|string",
            "cover" => "required|mimes:jpg,png,jpeg,svg,webp",
            "info_cover" => "required|mimes:jpg,png,jpeg,svg,webp",
            "benefits_cover" => "required|mimes:jpg,png,jpeg,svg,webp",
        ];
    }
}
