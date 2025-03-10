<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Overtime;
use App\Models\OvertimeTransaction;
use App\Models\OvertimeType;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class OvertimeController extends Controller
{
    /**
     * Menampilkan form pengajuan lembur.
     */
    public function create()
    {
        // Mendapatkan semua tipe lembur yang aktif
        $overtimeTypes = OvertimeType::get();

        // Mendapatkan anggota tim di bawah supervisor yang sedang login
        // $teamMembers = User::where('supervisor_id', Auth::id())->get();

        return view('overtime.create', compact('overtimeTypes'));
    }

    /**
     * Menyimpan data pengajuan lembur.
     */
    public function store(Request $request)
    {
        // dd($request);
        // Validasi data yang diterima dari form
        $validatedData = $request->validate([
            'overtime_date' => 'required|date',
            'overtime_type_id' => 'required|exists:overtime_types,id',
            'selected_members' => 'required|array',
            'selected_members.*' => 'exists:users,id',
            'supporting_document' => 'required|file|mimes:pdf|max:512'
        ]);


        // Proses unggahan file
        if ($request->hasFile('supporting_document')) {
            $file = $request->file('supporting_document');
            $filePath = $file->store('public/supporting_documents');
        }

        // Simpan data pengajuan lembur
        $overtimeRequest = OvertimeTransaction::create([
            'employee_id' => Auth::id(), //as supervisor ID
            'overtime_date' => $request->overtime_date,
            // 'start_time' => $request->start_time,
            // 'end_time' => $request->end_time,
            'duration' => $request->duration,
            'overtime_type_id' => $request->overtime_type_id,
            'status' => 'Pending',
            'supporting_document_path' => $filePath ?? null,
        ]);

         // Simpan anggota tim yang dipilih
        $overtimeRequest->users()->sync($validatedData['selected_members']);

        // // Menghitung durasi lembur dalam jam
        // $startTime = strtotime($request->start_time);
        // $endTime = strtotime($request->end_time);
        // $duration = ($endTime - $startTime) / 3600;

        // Membuat pengajuan lembur baru
        // OvertimeTransaction::create([
        //     'employee_id' => Auth::user()->id,
        //     'overtime_date' => $request->overtime_date,
        //     'start_time' => $request->overtime_date,
        //     'end_time' => $request->end_time,
        //     'duration' => $duration,
        //     'overtime_type_id' => $request->overtime_type_id,
        //     'status' => 'Pending',
        // ]);

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
        $overtime = OvertimeTransaction::where('status', 'Pending')->with('userProfile', 'overtimeType')->get();

        // Menampilkan view persetujuan lembur dengan data pengajuan lembur
        return view('overtime.history', compact('overtime'));
    }


}
