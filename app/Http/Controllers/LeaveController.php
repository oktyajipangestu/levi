<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    public function index()
    {
        $idUser = Auth::user()->id;
        $leaveRequest = LeaveRequest::where('user_id', $idUser)->paginate(10);
        $rejectedCount = LeaveRequest::where('status_hr', 'reject')->count();
        $pendingCount = LeaveRequest::where('status_hr', 'pending')->count();
        $approvedCount = LeaveRequest::where('status_hr', 'approve')->count();
        return view('leave.index', [
            'list_request' => $leaveRequest,
            'rejected' => $rejectedCount,
            'pending' => $pendingCount,
            'approved' => $approvedCount
        ]);
    }
}
