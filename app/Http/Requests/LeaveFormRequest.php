<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class LeaveFormRequest extends FormRequest
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
            'type' => 'required|in:annual,big,sick,maternity,important',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'type.required' => 'Tipe Cuti Wajib Diisi',
            'type.in' => 'Silakan isi tipe cuti sesuai ketentuan',
            'start_date.required' => 'Tanggal Awal Wajib Diisi',
            'end_date.required' => 'Tanggal Akhir Wajib Diisi',
            'end_date.after_or_equal' => 'Tanggal Akhir tidak boleh lebih awal daripada Tanggal Awal',
            'reason.required' => 'Alasan cuti wajib diisi'
        ];
    }
}
