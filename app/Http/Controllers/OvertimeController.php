<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Overtime;
use App\Models\OvertimeTransaction;
use App\Models\OvertimeType;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


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
        // dd($request->reason);
        // Validasi data yang diterima dari form
        $validatedData = $request->validate([
            'overtime_date' => 'required|date',
            'reason' => 'required',
            'overtime_type_id' => 'required|exists:overtime_types,id',
            'selected_members' => 'required|array',
            'selected_members.*' => 'exists:users,id',
            'supporting_document' => 'required|file|mimes:pdf|max:512'
        ]);


        // Proses unggahan file
        if ($request->hasFile('supporting_document')) {
            $file = $request->file('supporting_document');
            $filePath = $file->store('','supporting_documents');
        }

        // Simpan data pengajuan lembur
        $overtimeRequest = OvertimeTransaction::create([
            'employee_id' => Auth::id(), //as supervisor ID
            'overtime_date' => $request->overtime_date,
            'reason' => $request->reason,
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
        $user = Auth::user();
        $userId = $user->id;
        $overtimeTransactions = OvertimeTransaction::whereHas('users', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->with('overtimeType')->with('supervisor')->paginate(10);

        $rejectedCount = OvertimeTransaction::whereHas('users', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->where('status','rejected')->count();

        $pendingCount = OvertimeTransaction::whereHas('users', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->where('status', 'pending')->count();

        $approvedCount = OvertimeTransaction::whereHas('users', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->where('status', 'approved')->count();

        $myData = [
            'transaction' => $overtimeTransactions,
            'rejectedCount' => $rejectedCount,
            'pendingCount' => $pendingCount,
            'approvedCount' => $approvedCount,
        ];
        $myRequest = [];
        if ($user->role == "supervisor") {

            $requestTransaction = OvertimeTransaction::where('employee_id',$userId)->with('userProfile')->with('users')->latest()->paginate(10);

            $requestRejectedCount = OvertimeTransaction::where('employee_id', $userId)->where('status', 'rejected')->count();

            $requestPendingCount = OvertimeTransaction::where('employee_id', $userId)->where('status', 'pending')->count();

            $requestApprovedCount = OvertimeTransaction::where('employee_id', $userId)->where('status', 'approved')->count();

            $myRequest = [
                'transaction' => $requestTransaction,
                'rejectedCount' => $requestRejectedCount,
                'pendingCount' => $requestPendingCount,
                'approvedCount' => $requestApprovedCount
            ];
        }
        $hrRequest = [];
        if ($user->role == "hr") {

            $hrTransaction = OvertimeTransaction::with('userProfile')->with('users')->latest()->paginate(10);

            $hrRejectedCount = OvertimeTransaction::where('status', 'rejected')->count();

            $hrPendingCount = OvertimeTransaction::where('status', 'pending')->count();

            $hrApprovedCount = OvertimeTransaction::where('status', 'approved')->count();

            $hrRequest = [
                'transaction' => $hrTransaction,
                'rejectedCount' => $hrRejectedCount,
                'pendingCount' => $hrPendingCount,
                'approvedCount' => $hrApprovedCount
            ];
        }

        // Menampilkan view persetujuan lembur dengan data pengajuan lembur
        return view('overtime.history', compact('myData','myRequest','hrRequest'));
    }

    public function download($filename)
    {
        $path = storage_path('app/supporting_documents/'. $filename);

        if (!File::exists($path)) {
            abort(404, 'File not found');
        }

        $headers = [
            'Content-Type' => File::mimeType($path),
            'Content-Disposition' => 'attachment; filename="'. pathinfo($path, PATHINFO_FILENAME). '.'. pathinfo($path, PATHINFO_EXTENSION). '"',
        ];

        return response()->download($path, $filename, $headers);
    }

    public function approve($id)
    {
        $overtimeRequest = OvertimeTransaction::findOrFail($id);
        if ($overtimeRequest) {
            if (Auth::user()->role == 'hr') {
                $overtimeRequest->status = 'approved';
            }

            $overtimeRequest->save();
            return redirect()->back()->with('success', 'Overtime request approved successfully.');
        }
        return redirect()->back()->with('error', 'Overtime request not found.');
    }

    public function reject($id)
    {
        $overtimeRequest = OvertimeTransaction::findOrFail($id);
        if ($overtimeRequest) {
            if (Auth::user()->role == 'hr') {
                $overtimeRequest->status = 'rejected';
            }
            $overtimeRequest->save();
            return redirect()->back()->with('success', 'Overtime request rejected successfully.');
        }
        return redirect()->back()->with('error', 'Overtime request not found.');
    }

    public function show(string $id)
    {
        $userId = Auth::user()->id;

        $transaction = OvertimeTransaction::whereHas('users', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->with('overtimeType')->with('users')->findOrFail($id);

        // dd($transaction);

        return view('overtime.show', compact('transaction'));

        return "Show";
    }



}
