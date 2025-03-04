<?php

namespace App\Http\Controllers;

use App\Models\Leave;
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
            $view = 'leave.index';
            $data = [
                'list_request' => $leaveRequest,
                'rejected' => $rejectedCount,
                'pending' => $pendingCount,
                'approved' => $approvedCount,
                'list_approval' => $leaveApproval ?? [],
                'count_approval' => $countByStatus ?? []
            ];
        } elseif ($user->role == "hr") {
            $leaveRequest = LeaveRequest::where('status_supervisor', 'approve')->paginate(10);
            $rejectedCount = LeaveRequest::where('status_hr', 'reject')->where('status_supervisor', 'approve')->count();
            $pendingCount = LeaveRequest::where('status_hr', 'pending')->where('status_supervisor', 'approve')->count();
            $approvedCount = LeaveRequest::where('status_hr', 'approve')->where('status_supervisor', 'approve')->count();
            $view = 'leave.hr.index';
            $data = [
                'list_request' => $leaveRequest,
                'rejected' => $rejectedCount,
                'pending' => $pendingCount,
                'approved' => $approvedCount
            ];
        } else {
            $view = 'leave.index';
            $data = [
                'list_request' => $leaveRequest,
                'rejected' => $rejectedCount,
                'pending' => $pendingCount,
                'approved' => $approvedCount
            ];
        }

        return view($view, $data);

    }

    public function leaveHr()
    {
        $user = Auth::user();
        $leaveRequest = LeaveRequest::paginate(10);
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
                if ($leaveRequest->type == "annual") {
                    $leave = Leave::where('user_id', $leaveRequest->user_id)->where('type', 'annual')->first();

                } elseif ($leaveRequest->type == "big") {
                    # code...
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
}
