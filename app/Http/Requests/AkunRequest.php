<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class AkunRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', Rule::unique('users')->ignore($this->users)],
            'email' => ['required', 'email:rfc,dns', Rule::unique('users')->ignore($this->users)],
            'jabatan_id' => 'required',
            'password' => ['min:6', 'required', Rules\Password::defaults()],
        ];
    }
}
