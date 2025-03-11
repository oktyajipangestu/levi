<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\LeaveRequest;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    public function index()
    {
        // $user = Auth::user();
        // $leaveRequest = LeaveRequest::where('user_id', $user->id)->latest()->paginate(10);
        // $rejectedCount = LeaveRequest::where('status_hr', 'reject')->where('user_id', $user->id)->count();
        // $pendingCount = LeaveRequest::where('status_hr', 'pending')->where('user_id', $user->id)->count();
        // $approvedCount = LeaveRequest::where('status_hr', 'approve')->where('user_id', $user->id)->count();

        // if ($user->role == "supervisor") {
        //     $userId = $user->id;
        //     $leaveApproval = LeaveRequest::whereHas('user', function ($query) use ($userId) {
        //         $query->where('supervisor_id', $userId);
        //     })->get();

        //     $countByStatus = [];
        //     $countByStatus['approve'] = LeaveRequest::whereHas('user', function ($query) use ($userId) {
        //         $query->where('supervisor_id', $userId);
        //     })->where('status_supervisor', 'approve')->count();
        //     $countByStatus['reject'] = LeaveRequest::whereHas('user', function ($query) use ($userId) {
        //         $query->where('supervisor_id', $userId);
        //     })->where('status_supervisor', 'reject')->count();
        //     $countByStatus['pending'] = LeaveRequest::whereHas('user', function ($query) use ($userId) {
        //         $query->where('supervisor_id', $userId);
        //     })->where('status_supervisor', 'pending')->count();
        //     $view = 'leave.index';
        //     $data = [
        //         'list_request' => $leaveRequest,
        //         'rejected' => $rejectedCount,
        //         'pending' => $pendingCount,
        //         'approved' => $approvedCount,
        //         'list_approval' => $leaveApproval ?? [],
        //         'count_approval' => $countByStatus ?? []
        //     ];
        // } elseif ($user->role == "hr") {
        //     $leaveRequest = LeaveRequest::where('status_supervisor', 'approve')->latest()->paginate(10);
        //     $rejectedCount = LeaveRequest::where('status_hr', 'reject')->where('status_supervisor', 'approve')->count();
        //     $pendingCount = LeaveRequest::where('status_hr', 'pending')->where('status_supervisor', 'approve')->count();
        //     $approvedCount = LeaveRequest::where('status_hr', 'approve')->where('status_supervisor', 'approve')->count();
        //     $view = 'leave.hr.index';
        //     $data = [
        //         'list_request' => $leaveRequest,
        //         'rejected' => $rejectedCount,
        //         'pending' => $pendingCount,
        //         'approved' => $approvedCount
        //     ];
        // } else {
        //     $view = 'leave.index';
        //     $data = [
        //         'list_request' => $leaveRequest,
        //         'rejected' => $rejectedCount,
        //         'pending' => $pendingCount,
        //         'approved' => $approvedCount
        //     ];
        // }

        // return view($view, $data);
        return view('leave.index');

    }

    public function leaveHr()
    {
        $user = Auth::user();
        $leaveRequest = LeaveRequest::latest()->latest()->paginate(10);
        $rejectedCount = LeaveRequest::where('status_hr', 'reject')->count();
        $pendingCount = LeaveRequest::where('status_hr', 'pending')->count();
        $approvedCount = LeaveRequest::where('status_hr', 'approve')->count();

        return view('leave.hr.index', [
            'list_request' => $leaveRequest,
            'rejected' => $rejectedCount,
            'pending' => $pendingCount,
            'approved' => $approvedCount
        ]);
    }

    public function approve($id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);
        if ($leaveRequest) {
            if (Auth::user()->role == 'supervisor') {
                $leaveRequest->status_supervisor = 'approve';
            } else {
                $days = $this->calculateDays($leaveRequest->start_date, $leaveRequest->end_date);
                if ($leaveRequest->type == "annual") {
                    $leave = Leave::where('user_id', $leaveRequest->user_id)->where('type', 'annual')->first();
                    if ($leave) {
                        $leave->used = intval($leave->used) + $days;
                        $leave->remaining = intval($leave->total) - intval($leave->total);
                        $leave->save();
                    } else {
                        $leave_new = new Leave();
                        $leave_new->user_id = $leaveRequest->user_id;
                        $leave_new->type = 'annual';
                        $leave_new->total = 12;
                        $leave_new->used = $days;
                        $leave_new->remaining = 12 - $days;

                        $leave_new->save();
                    }
                } elseif ($leaveRequest->type == "big") {
                    $leave = Leave::where('user_id', $leaveRequest->user_id)->where('type', 'big')->first();
                    if ($leave) {
                        $leave->used = intval($leave->used) + $days;
                        $leave->save();
                    } else {
                        $leave_new = new Leave();
                        $leave_new->user_id = $leaveRequest->user_id;
                        $leave_new->type = 'big';
                        $leave_new->total = $days;
                        $leave_new->used = $days;
                        $leave_new->remaining = $days;

                        $leave_new->save();
                    }
                }
                $leaveRequest->status_hr = 'approve';
            }

            $leaveRequest->save();
            return redirect()->back()->with('success', 'Leave request approved successfully.');
        }
        return redirect()->back()->with('error', 'Leave request not found.');
    }

    public function reject($id)
    {
        $leaveRequest = LeaveRequest::find($id);
        if ($leaveRequest) {
            if (Auth::user()->role == 'supervisor') {
                $leaveRequest->status_supervisor = 'reject';
            } else {
                $leaveRequest->status_hr = 'reject';
            }
            $leaveRequest->save();
            return redirect()->back()->with('success', 'Leave request rejected successfully.');
        }
        return redirect()->back()->with('error', 'Leave request not found.');
    }

    public function calculateDays($start_date, $end_date) {
        // Ubah string tanggal menjadi objek DateTime
        $start = new DateTime($start_date);
        $end = new DateTime($end_date);

        // Jika start_date dan end_date sama, kembalikan 1
        if ($start == $end) {
            return 1;
        }

        // Hitung selisih hari
        $interval = $start->diff($end);
        $days = $interval->days;

        // Jika end_date lebih awal dari start_date, kembalikan 0 atau pesan error
        if ($start > $end) {
            return 0; // Atau Anda bisa mengembalikan pesan error
        }

        // Tambahkan 1 karena kita ingin termasuk start_date dan end_date
        return $days + 1;
    }
}
