<?php

namespace App\Livewire;

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
}
