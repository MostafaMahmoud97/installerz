<?php

namespace App\Http\Requests\User\AboutMe;

use Illuminate\Foundation\Http\FormRequest;

class StoreAboutMeRequest extends FormRequest
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
            "description" => "required|string",
            "cover" => "required|mimes:jpg,png,jpeg,svg,webp",
            "info_about_me" => "required|array|min:1",
            "info_about_me.*.title" => "required|string",
            "info_about_me.*.sub_info" => "required|array|min:1",
            "info_about_me.*.sub_info.*.title" => "required|string",
            "info_about_me.*.sub_info.*.description" => "required|string",

        ];
    }
}
