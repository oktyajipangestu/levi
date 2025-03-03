@extends('layouts.dashboard')

@section('content')
    @session('success')
        <div class="m-3">
            <div class="alert alert-success mb-0" role="alert">
                {{ session('success') }}
            </div>
        </div>
    @endsession
    <div class="m-3 bg-white rounded-lg p-5">
        <div class="timeoff-header mb-4">
            <h2 class="fw-bold">Leave & Time Off</h2>
            <p>Employee's leave & time off information</p>
        </div>
        <div class="filter d-flex justify-content-between my-4">
            <div>
                <span class="fw-bold fs-4 me-4">Leave & Time Off History</span>
                <button type="button" class="btn btn-outline-primary">Filter <i class="bi bi-filter"></i></button>
            </div>
            <div>
                <a href="{{ route('leave.create') }}" class="btn btn-primary">Input Leave & Time Off Request</a>
            </div>
        </div>
        <div class="card-wrapper row mb-4">
            <div class="col">
                <div class="rounded-4 p-4" style="background-color: #F7F7F7">
                    <div class="d-flex justify-content-between">
                        <h2 class="fw-bold">{{ $approved + $pending + $rejected }}</h2>
                        <div>
                            <img src="{{ asset('images/icon/person.svg') }}" alt="person">
                        </div>
                    </div>
                    <div>
                        Total Leave & Time Off
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="rounded-4 p-4" style="background-color: #F7F7F7">
                    <div class="d-flex justify-content-between">
                        <h2 class="fw-bold">{{ $approved }}</h2>
                        <div>
                            <img src="{{ asset('images/icon/check.svg') }}" alt="person">
                        </div>
                    </div>
                    <div>
                        Leave & Time Off Approved
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
                        Leave & Time Off Rejected
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
                        Leave & Time Off Pending
                    </div>
                </div>
            </div>
        </div>
        <div>
            <table class="table">
                <thead>
                    <tr class="table-light">
                        <th scope="col">TYPES OF LEAVE</th>
                        <th scope="col">SUBMISSION TIME</th>
                        <th scope="col">DURATION</th>
                        <th scope="col">NOTES</th>
                        <th scope="col">APPROVALS</th>
                        <th scope="col">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($list_request as $request)
                        <tr>
                            <th><strong>{{ $request->type == 'annual' ? 'ANNUAL LEAVE' : ( $request->type == 'big' ? 'BIG LEAVE' : ( $request->type == 'sick' ? 'SICK LEAVE' : 'IMPORTANT LEAVE') ) }}</strong></th>
                            <td>{{ date('d-F-Y', strtotime($request->created_at)) }}</td>
                            <td>
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex">
                                        <div>
                                            <div class="mb-2"><small>Begin</small></div>
                                            <span class="rounded px-2 py-1" style="background-color: #F3F3FF"><small>{{ date('d-F-Y', strtotime($request->start_date)) }}</small></span>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <div>
                                            <div class="mb-2"><small>End</small></div>
                                            <span class="rounded px-2 py-1" style="background-color: #F3F3FF"><small>{{ date('d-F-Y', strtotime($request->end_date)) }}</small></span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $request->reason }}</td>
                            <td>
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex text-center">
                                        <div>
                                            <div class="mb-2"><small>Direct <br>
                                                    Supervisor</small></div>
                                            <img src="{{ asset('images/icon/' . $request->status_supervisor .  '.svg') }}" alt="">
                                        </div>
                                    </div>
                                    <div class="d-flex text-center">
                                        <div>
                                            <div class="mb-2"><small>Human <br>
                                                    Resources</small></div>
                                            <img src="{{ asset('images/icon/' . $request->status_hr .  '.svg') }}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <a href=""><i class="bi bi-eye-fill"></i> View Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada pengajuan cuti sebelumnya</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $list_request->links() }}
        </div>
    </div>
@endsection
