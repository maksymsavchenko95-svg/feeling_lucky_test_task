<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class RegisterRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'phone:UA'],
        ];
    }

    public function messages(): array
    {
        return [
            'phone.phone' => 'Enter a valid Ukrainian phone number, e.g. +380 50 123 4567.',
        ];
    }

    /**
     * A taken username may be reused only by its owner, identified by the phone number.
     *
     * @return array<int, callable>
     */
    public function after(): array
    {
        return [
            function (Validator $validator) {
                if ($validator->errors()->isNotEmpty()) {
                    return;
                }

                $owner = User::firstWhere('username', $this->input('username'));

                if ($owner?->phone->notEquals($this->input('phone'), 'UA')) {
                    $validator->errors()->add('username', "The username \"{$owner->username}\" is already taken.");
                }
            },
        ];
    }
}
