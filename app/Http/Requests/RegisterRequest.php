<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Allow all users to make this request
    }

    public function rules()
    {        
        return [
            'username'      => 'required|string|max:255|unique:users',
            'first_name'    => 'required|string|max:255',
            'middle_name'   => 'nullable|string|max:255',
            'last_name'     => 'required|string|max:255',
            'email'         => 'required|string|email|max:255|unique:users',
            'gender'        => 'required|in:male,female,other',
            'date_of_birth' => 'required|date|before:today',
            'phone'         => 'required|string|max:15|unique:users',
            'password'      => 'required|string|min:6|confirmed',
        ];
    }
}
