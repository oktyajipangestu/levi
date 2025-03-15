<?php

namespace App\Livewire;

use App\Models\Leave;
use App\Models\LeaveRequest;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class LeaveTable extends Component
{
    use WithPagination;

    public $search = '';
    public $type = '';
    public $type_spv = '';
    public $status_spv = '';
    public $status_hr= '';
    public $activeTab = 'history';

    public function render()
    {
        $user = Auth::user();
        if ($user->role == "supervisor") {
            $userId = $user->id;

            $leaveRequest = LeaveRequest::query()->when($this->status_hr, function ($query) {
                return $query->where('status_hr', $this->status_hr);
            })
            ->when($this->type, function ($query) {
                return $query->where('type', $this->type);
            })->where('user_id', $user->id)->latest()->paginate(10);

            $rejectedCount = LeaveRequest::where('status_hr', 'reject')->where('user_id', $user->id)->count();
            $pendingCount = LeaveRequest::where('status_hr', 'pending')->where('user_id', $user->id)->count();
            $approvedCount = LeaveRequest::where('status_hr', 'approve')->where('user_id', $user->id)->count();

            $leaveApproval = LeaveRequest::whereHas('user', function ($query) use ($userId) {
                    $query->where('supervisor_id', $userId);
                })->when($this->status_spv, function ($query) {
                    return $query->where('status_supervisor', $this->status_spv);
                })
                ->when($this->type_spv, function ($query) {
                    return $query->where('type', $this->type_spv);
                })->latest()->get();

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
            $view = 'livewire.leave-table';
            $data = [
                'list_request' => $leaveRequest,
                'rejected' => $rejectedCount,
                'pending' => $pendingCount,
                'approved' => $approvedCount,
                'list_approval' => $leaveApproval ?? [],
                'count_approval' => $countByStatus ?? []
            ];
        } elseif ($user->role == "hr") {
            $leaveRequest = LeaveRequest::where('status_supervisor', 'approve')
                            ->when($this->status_hr, function ($query) {
                                return $query->where('status_hr', $this->status_hr);
                            })
                            ->when($this->type, function ($query) {
                                return $query->where('type', $this->type);
                            })->latest()->paginate(10);

            $rejectedCount = LeaveRequest::where('status_hr', 'reject')->where('status_supervisor', 'approve')->count();
            $pendingCount = LeaveRequest::where('status_hr', 'pending')->where('status_supervisor', 'approve')->count();
            $approvedCount = LeaveRequest::where('status_hr', 'approve')->where('status_supervisor', 'approve')->count();
            $view = 'livewire.leave-table-hr';
            $data = [
                'list_request' => $leaveRequest,
                'rejected' => $rejectedCount,
                'pending' => $pendingCount,
                'approved' => $approvedCount
            ];
        } else {
            $leaveRequest = LeaveRequest::query()->when($this->status_spv, function ($query) {
                return $query->where('status_supervisor', $this->status_spv);
            })
            ->when($this->status_hr, function ($query) {
                return $query->where('status_hr', $this->status_hr);
            })
            ->when($this->type, function ($query) {
                return $query->where('type', $this->type);
            })->where('user_id', $user->id)->latest()->paginate(10);

            $rejectedCount = LeaveRequest::where('status_hr', 'reject')->where('user_id', $user->id)->count();
            $pendingCount = LeaveRequest::where('status_hr', 'pending')->where('user_id', $user->id)->count();
            $approvedCount = LeaveRequest::where('status_hr', 'approve')->where('user_id', $user->id)->count();

            $view = 'livewire.leave-table';
            $data = [
                'list_request' => $leaveRequest,
                'rejected' => $rejectedCount,
                'pending' => $pendingCount,
                'approved' => $approvedCount
            ];
        }

        return view($view, $data);
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
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
                } elseif ($leaveRequest->type == "sick") {
                    $leave = Leave::where('user_id', $leaveRequest->user_id)->where('type', 'sick')->first();
                    if ($leave) {
                        $leave->used = intval($leave->used) + $days;
                        $leave->save();
                    } else {
                        $leave_new = new Leave();
                        $leave_new->user_id = $leaveRequest->user_id;
                        $leave_new->type = 'sick';
                        $leave_new->total = $days;
                        $leave_new->used = $days;
                        $leave_new->remaining = $days;

                        $leave_new->save();
                    }
                } else {
                    $leave = Leave::where('user_id', $leaveRequest->user_id)->where('type', 'important')->first();
                    if ($leave) {
                        $leave->used = intval($leave->used) + $days;
                        $leave->save();
                    } else {
                        $leave_new = new Leave();
                        $leave_new->user_id = $leaveRequest->user_id;
                        $leave_new->type = 'important';
                        $leave_new->total = $days;
                        $leave_new->used = $days;
                        $leave_new->remaining = $days;

                        $leave_new->save();
                    }
                }
                $leaveRequest->status_hr = 'approve';
            }

            $leaveRequest->save();
            return session('success', 'Leave request approved successfully.');
        }
        return session('error', 'Leave request not found.');
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
            return session('success', 'Leave request rejected successfully.');
        }
        return session('error', 'Leave request not found.');
    }
}
