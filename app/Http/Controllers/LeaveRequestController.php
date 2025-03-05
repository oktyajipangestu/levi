<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeaveFormRequest;
use App\Models\Leave;
use App\Models\LeaveRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $userId = Auth::user()->id;
        $user = User::find($userId);
        $annualLeaves = Leave::where('type', 'annual')->where('user_id', $userId)->first();
        $list_request = LeaveRequest::where('user_id', $userId)->latest()->get();
        return view('leave.create', [
            'annual_leaves' => $annualLeaves,
            'list_request' => $list_request
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LeaveFormRequest $request)
    {
        $validated = $request->validated();

        $user = Auth::user();

        $leaveRequest = new LeaveRequest();
        $leaveRequest->user_id = $user->id;
        $leaveRequest->type = $request->type;
        $leaveRequest->start_date = $request->start_date;
        $leaveRequest->end_date = $request->end_date;
        $leaveRequest->reason = $request->reason;
        if ($user->role == "supervisor") {
            $leaveRequest->status_supervisor = "approve";
        }

        $leaveRequest->save();

        return redirect()->route('dashboard')->with('success', 'Permohonan cuti berhasil diajukan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $userId = Auth::user()->id;
        $user = User::find($userId);
        $annualLeaves = Leave::where('type', 'annual')->where('user_id', $userId)->first();
        $list_request = LeaveRequest::where('user_id', $userId)->latest()->get();

        $request = LeaveRequest::findOrFail($id);
        return view('leave.show', [
            'request' => $request,
            'annual_leaves' => $annualLeaves,
            'list_request' => $list_request
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
