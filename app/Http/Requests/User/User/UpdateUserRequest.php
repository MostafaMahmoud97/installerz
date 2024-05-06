<?php

namespace App\Http\Requests\User\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateUserRequest extends FormRequest
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
            "company_name" => "required|string",
            "email" => "required|email|unique:users,email,".Auth::id(),
            "phone" => "required|",
            "mail" => "required|email",
            "address" => "required",
            "slogan" => "required",
            "logo" => "nullable|mimes:jpg,png,svg,jpeg,webp"
        ];
    }
}
