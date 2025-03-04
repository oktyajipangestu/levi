<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Overtime;
use App\Models\OvertimeTransaction;
use App\Models\OvertimeType;
use Illuminate\Support\Facades\Auth;

class OvertimeController extends Controller
{
    /**
     * Menampilkan form pengajuan lembur.
     */
    public function create()
    {
        // Mengambil data jenis lembur untuk ditampilkan pada dropdown
        $overtimeType = OvertimeType::all();

        // Menampilkan view pengajuan lembur dengan data jenis lembur
        return view('overtime.request', compact('overtimeType'));
    }

    /**
     * Menyimpan data pengajuan lembur.
     */
    public function store(Request $request)
    {
        // Validasi data yang diterima dari form
        $request->validate([
            'overtime_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'overtime_type_id' => 'required|exists:overtime_types,id',
        ]);

        // Menghitung durasi lembur dalam jam
        $startTime = strtotime($request->start_time);
        $endTime = strtotime($request->end_time);
        $duration = ($endTime - $startTime) / 3600;

        // Membuat pengajuan lembur baru
        OvertimeTransaction::create([
            'employee_id' => Auth::user()->employee->id,
            'overtime_date' => $request->overtime_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'duration' => $duration,
            'overtime_type_id' => $request->overtime_type_id,
            'status' => 'Pending',
        ]);

        // Redirect ke halaman riwayat lembur dengan pesan sukses
        return redirect()->route('overtime.history')->with('success', 'Overtime requested successfully.');
    }

    /**
     * Menampilkan daftar pengajuan lembur untuk persetujuan.
     */
    public function indexApproval()
    {
        // Mengambil data pengajuan lembur dengan status 'Pending'
        $overtimeRequest = OvertimeTransaction::where('status', 'Pending')->with('employee', 'overtimeType')->get();

        // Menampilkan view persetujuan lembur dengan data pengajuan lembur
        return view('overtime.approval', compact('overtimeRequest'));
    }

    /**
     * Memperbarui status pengajuan lembur (approve/reject).
     */
    public function updateStatus(Request $request, $id)
    {
        // Validasi input status
        $request->validate([
            'status' => 'required|in:Approved,Rejected',
        ]);

        // Mencari pengajuan lembur berdasarkan ID
        $overtimeRequest = OvertimeTransaction::findOrFail($id);

        // Memperbarui status pengajuan lembur
        $overtimeRequest->update([
            'status' => $request->status,
        ]);

        // Redirect kembali ke halaman persetujuan dengan pesan sukses
        return redirect()->route('overtime.approval')->with('success', 'Overtime status updated successfully.');
    }

    public function history()
    {
        // Mengambil data pengajuan lembur dengan status 'Pending'
        $overtimeRequest = OvertimeTransaction::where('status', 'Pending')->with('employee', 'overtimeType')->get();

        // Menampilkan view persetujuan lembur dengan data pengajuan lembur
        // return view('overtime.approval', compact('overtimeRequest'));
    }


}
