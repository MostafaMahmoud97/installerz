<?php

namespace App\Http\Requests\User\FactsSection;

use Illuminate\Foundation\Http\FormRequest;

class StoreFactRequest extends FormRequest
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
            "number" => "required|string",
            "icon" => "required|mimes:jpg,png,jpeg,svg,webp"
        ];
    }
}
