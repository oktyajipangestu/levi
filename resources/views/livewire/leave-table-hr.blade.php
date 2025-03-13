<div class="m-3 bg-white rounded-lg p-3 p-md-5">
    <div class="timeoff-header mb-4">
        <h2 class="fw-bold">Leave & Time Off Request Approval</h2>
        <p>Employee's leave & time off information</p>
    </div>
    <div>

        <div class="card-wrapper row mb-4">
            <div class="col mb-3 mb-0">
                <div class="rounded-4 p-4" style="background-color: #F7F7F7">
                    <div class="d-flex justify-content-between">
                        <h2 class="fw-bold">{{ $approved + $rejected + $pending }}</h2>
                        <div>
                            <img src="{{ asset('images/icon/person.svg') }}" alt="person">
                        </div>
                    </div>
                    <div>
                        Total Requests
                    </div>
                </div>
            </div>
            <div class="col mb-3 mb-0">
                <div class="rounded-4 p-4" style="background-color: #F7F7F7">
                    <div class="d-flex justify-content-between">
                        <h2 class="fw-bold">{{ $approved }}</h2>
                        <div>
                            <img src="{{ asset('images/icon/check.svg') }}" alt="person">
                        </div>
                    </div>
                    <div>
                        Approved Requests
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="rounded-4 p-4" style="background-color: #F7F7F7">
                    <div class="d-flex justify-content-between">
                        <h2 class="fw-bold">{{ $rejected }}</h2>
                        <div>
                            <img src="{{ asset('images/icon/cross.svg') }}" alt="person">
                        </div>
                    </div>
                    <div>
                        Rejected Requests
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="rounded-4 p-4" style="background-color: #F7F7F7">
                    <div class="d-flex justify-content-between">
                        <h2 class="fw-bold">{{ $pending }}</h2>
                        <div>
                            <img src="{{ asset('images/icon/time.svg') }}" alt="person">
                        </div>
                    </div>
                    <div>
                        Pending Requests
                    </div>
                </div>
            </div>
        </div>
        {{-- FILTER --}}
        <div class="my-3 border rounded p-3">
            <div class="row align-items-center g-3" >
                <div class="col">
                    <div>Tipe Cuti</div>
                    <select class="form-select" aria-label="Default select example" wire:model.live="type">
                        <option value="">All</option>
                        <option value="annual">Annual</option>
                        <option value="big">Big</option>
                        <option value="sick">Sick</option>
                    </select>
                </div>
                <div class="col">
                    <div>Status</div>
                    <select class="form-select" aria-label="Default select example" wire:model.live="status_hr">
                        <option value="">All</option>
                        <option value="approve">Approved</option>
                        <option value="reject">Rejected</option>
                        <option value="pending">Pending</option>
                    </select>
                </div>
                {{-- <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div> --}}
            </div>
        </div>
        {{-- END OF FILTER --}}
        <div class="table-responsive">
            <table class="table table-responsive">
                <thead>
                    <tr class="table-light">
                        <th scope="col">REQUESTED BY</th>
                        <th scope="col">TYPES OF LEAVE</th>
                        <th scope="col">SUBMISSION TIME</th>
                        <th scope="col">DURATION</th>
                        <th scope="col">NOTES</th>
                        <th scope="col">APPROVALS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($list_request as $approval)
                        <tr>
                            <td>
                                <div>
                                    <div>
                                        <div class="mb-2">{{ $approval->user->name }}</div>
                                        <span class="rounded px-2 py-1"
                                            style="background-color: #F3F3FF"><small>{{ $approval->user->userProfile->nip }}</small></span>
                                    </div>
                                    <div class="mt-4">
                                        <div class="mb-2"><small>Postion - Dept</small></div>
                                        {{ $approval->user->userProfile->position }} - {{ $approval->user->department }}
                                    </div>
                                </div>
                            </td>
                            <th>{{ $approval->type == 'annual' ? 'ANNUAL LEAVE' : ($approval->type == 'big' ? 'BIG LEAVE' : ($approval->type == 'sick' ? 'SICK LEAVE' : 'IMPORTANT LEAVE')) }}
                            </th>
                            <td>{{ date('d-F-Y', strtotime($approval->created_at)) }}</td>
                            <td>
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex">
                                        <div>
                                            <div class="mb-2"><small>Begin</small></div>
                                            <span class="rounded px-2 py-1"
                                                style="background-color: #F3F3FF"><small>{{ date('d-F-Y', strtotime($approval->start_date)) }}</small></span>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <div>
                                            <div class="mb-2"><small>End</small></div>
                                            <span class="rounded px-2 py-1"
                                                style="background-color: #F3F3FF"><small>{{ date('d-F-Y', strtotime($approval->end_date)) }}</small></span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ Str::limit($approval->reason, 85, '...') }}</td>
                            <td>
                                @if ($approval->status_hr == "reject")
                                    <div>
                                        <div class="mb-2">REJECTED <img src="{{ asset('images/icon/reject.svg') }}" alt=""></div>
                                    </div>
                                @elseif($approval->status_hr == "approve")
                                    <div>
                                        <div class="mb-2">APPROVED <img src="{{ asset('images/icon/approve.svg') }}" alt=""></div>
                                    </div>
                                @else
                                    <div class="d-flex justify-content-between">
                                        <form action="{{ route('leave.reject', $approval->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-primary">Reject</button>
                                        </form>
                                        <form action="{{ route('leave.approve', $approval->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">Approve</button>
                                        </form>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada pengajuan cuti sebelumnya</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $list_request->links() }}
    </div>
</div>
