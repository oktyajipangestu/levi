<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email:rfc,strict|unique:users,email',
            'password' => 'required|min:8',
            'nip' => 'required|numeric',
            'department' => 'required',
            'role' => 'required|in:employee,supervisor,hr',
            'position' => 'required',
            'join_date' => 'required|date',
            'supervisor_id' => 'required',
            'status' => 'required'
        ];
    }
}
