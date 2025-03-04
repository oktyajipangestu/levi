<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $leaveRequest = LeaveRequest::where('user_id', $user->id)->paginate(10);
        $rejectedCount = LeaveRequest::where('status_hr', 'reject')->where('user_id', $user->id)->count();
        $pendingCount = LeaveRequest::where('status_hr', 'pending')->where('user_id', $user->id)->count();
        $approvedCount = LeaveRequest::where('status_hr', 'approve')->where('user_id', $user->id)->count();

        if ($user->role == "supervisor") {
            $userId = $user->id;
            $leaveApproval = LeaveRequest::whereHas('user', function ($query) use ($userId) {
                $query->where('supervisor_id', $userId);
            })->get();

            $countByStatus = [];
            $countByStatus['approve'] = LeaveRequest::whereHas('user', function ($query) use ($userId) {
                $query->where('supervisor_id', $userId);
            })->where('status_supervisor', 'approve')->count();
            $countByStatus['reject'] = LeaveRequest::whereHas('user', function ($query) use ($userId) {
                $query->where('supervisor_id', $userId);
            })->where('status_supervisor', 'reject')->count();
            $countByStatus['pending'] = LeaveRequest::whereHas('user', function ($query) use ($userId) {
                $query->where('supervisor_id', $userId);
            })->where('status_supervisor', 'pending')->count();
        }
        return view('leave.index', [
            'list_request' => $leaveRequest,
            'rejected' => $rejectedCount,
            'pending' => $pendingCount,
            'approved' => $approvedCount,
            'list_approval' => $leaveApproval ?? [],
            'count_approval' => $countByStatus ?? []
        ]);
    }

    public function approve($id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);
        if ($leaveRequest) {
            if (Auth::user()->role == 'supervisor') {
                $leaveRequest->status_supervisor = 'approve';
            } else {
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
}
