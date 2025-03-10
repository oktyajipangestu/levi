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
            <h2 class="fw-bold">Overtime</h2>
            <p>Employee's overtime information</p>
        </div>

        @if (Auth::user()->role == 'employee')
            <div class="filter d-flex justify-content-between my-4">
                <div>
                    <span class="fw-bold fs-4 me-4">Overtime History</span>
                    <button type="button" class="btn btn-outline-primary">Filter <i class="bi bi-filter"></i></button>
                </div>

            </div>
            <div class="card-wrapper row mb-4">
                <div class="col">
                    <div class="rounded-4 p-4" style="background-color: #F7F7F7">
                        <div class="d-flex justify-content-between">
                            <h2 class="fw-bold">{{ $myData['approvedCount'] + $myData['pendingCount'] + $myData['rejectedCount'] }}</h2>
                            {{-- <h2 class="fw-bold">0</h2> --}}
                            <div>
                                <img src="{{ asset('images/icon/person.svg') }}" alt="person">
                            </div>
                        </div>
                        <div>
                            Total Overtime
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="rounded-4 p-4" style="background-color: #F7F7F7">
                        <div class="d-flex justify-content-between">
                            <h2 class="fw-bold">{{ $myData['approvedCount'] }}</h2>
                            {{-- <h2 class="fw-bold">0</h2> --}}
                            <div>
                                <img src="{{ asset('images/icon/check.svg') }}" alt="person">
                            </div>
                        </div>
                        <div>
                            Overtime Approved
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="rounded-4 p-4" style="background-color: #F7F7F7">
                        <div class="d-flex justify-content-between">
                            <h2 class="fw-bold">{{ $myData['rejectedCount'] }}</h2>
                            {{-- <h2 class="fw-bold">0</h2> --}}
                            <div>
                                <img src="{{ asset('images/icon/cross.svg') }}" alt="person">
                            </div>
                        </div>
                        <div>
                            Overtime Rejected
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="rounded-4 p-4" style="background-color: #F7F7F7">
                        <div class="d-flex justify-content-between">
                            <h2 class="fw-bold">{{ $myData['pendingCount'] }}</h2>
                            {{-- <h2 class="fw-bold">0</h2> --}}
                            <div>
                                <img src="{{ asset('images/icon/time.svg') }}" alt="person">
                            </div>
                        </div>
                        <div>
                            Overtime Pending
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <table class="table">
                    <thead>
                        <tr class="table-light">
                            <th scope="col">TYPES OF OVERTIME</th>
                            <th scope="col">SUBMISSION TIME</th>
                            <th scope="col">MEMBERS</th>
                            <th scope="col">DATE & DURATION</th>
                            <th scope="col">NOTES</th>
                            <th scope="col">ATTACHMENT</th>
                            <th scope="col">APPROVALS</th>
                            <th scope="col">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @forelse ($list_request as $request)
                            <tr>
                                <th><strong>{{ $request->type == 'annual' ? 'ANNUAL LEAVE' : ($request->type == 'big' ? 'BIG LEAVE' : ($request->type == 'sick' ? 'SICK LEAVE' : 'IMPORTANT LEAVE')) }}</strong>
                                </th>
                                <td>{{ date('d-F-Y', strtotime($request->created_at)) }}</td>
                                <td>
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex">
                                            <div>
                                                <div class="mb-2"><small>Begin</small></div>
                                                <span class="rounded px-2 py-1"
                                                    style="background-color: #F3F3FF"><small>{{ date('d-F-Y', strtotime($request->start_date)) }}</small></span>
                                            </div>
                                        </div>
                                        <div class="d-flex">
                                            <div>
                                                <div class="mb-2"><small>End</small></div>
                                                <span class="rounded px-2 py-1"
                                                    style="background-color: #F3F3FF"><small>{{ date('d-F-Y', strtotime($request->end_date)) }}</small></span>
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
                                                <img src="{{ asset('images/icon/' . $request->status_supervisor . '.svg') }}"
                                                    alt="">
                                            </div>
                                        </div>
                                        <div class="d-flex text-center">
                                            <div>
                                                <div class="mb-2"><small>Human <br>
                                                        Resources</small></div>
                                                <img src="{{ asset('images/icon/' . $request->status_hr . '.svg') }}"
                                                    alt="">
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
                        @endforelse --}}
                    </tbody>
                </table>

                {{-- {{ $list_request->links() }} --}}
            </div>
        @else
            <div>
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-history-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-history" type="button" role="tab" aria-controls="nav-history"
                            aria-selected="true">My History</button>
                        <button class="nav-link" id="nav-approval-tab" data-bs-toggle="tab" data-bs-target="#nav-approval"
                            type="button" role="tab" aria-controls="nav-approval" aria-selected="false">Overtime Report</button>
                    </div>
                </nav>
                {{-- TAB CONTENT --}}
                <div class="tab-content" id="nav-tabContent">
                    {{-- MY HISTORY --}}
                    <div class="tab-pane fade show active" id="nav-history" role="tabpanel" aria-labelledby="nav-history-tab" tabindex="0">
                        <div class="filter d-flex justify-content-between my-4">
                            <div>
                                <span class="fw-bold fs-4 me-4">Overtime History</span>
                                <button type="button" class="btn btn-outline-primary">Filter <i
                                        class="bi bi-filter"></i></button>
                            </div>
                            {{-- <div>
                                <a href="{{ route('overtime.create') }}" class="btn btn-primary">Input Overtime Request</a>
                            </div> --}}

                        </div>

                        <div class="card-wrapper row mb-4">
                            <div class="col">
                                <div class="rounded-4 p-4" style="background-color: #F7F7F7">
                                    <div class="d-flex justify-content-between">
                                        <h2 class="fw-bold">{{ $myData['approvedCount'] + $myData['pendingCount'] + $myData['rejectedCount'] }}</h2>
                                        {{-- <h2 class="fw-bold">0</h2> --}}
                                        <div>
                                            <img src="{{ asset('images/icon/person.svg') }}" alt="person">
                                        </div>
                                    </div>
                                    <div>
                                        Total Overtime
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="rounded-4 p-4" style="background-color: #F7F7F7">
                                    <div class="d-flex justify-content-between">
                                        <h2 class="fw-bold">{{ $myData['approvedCount'] }}</h2>
                                        {{-- <h2 class="fw-bold">0</h2> --}}
                                        <div>
                                            <img src="{{ asset('images/icon/check.svg') }}" alt="person">
                                        </div>
                                    </div>
                                    <div>
                                        Overtime Approved
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="rounded-4 p-4" style="background-color: #F7F7F7">
                                    <div class="d-flex justify-content-between">
                                        <h2 class="fw-bold">{{ $myData['rejectedCount'] }}</h2>
                                        {{-- <h2 class="fw-bold">0</h2> --}}
                                        <div>
                                            <img src="{{ asset('images/icon/cross.svg') }}" alt="person">
                                        </div>
                                    </div>
                                    <div>
                                        Overtime Rejected
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="rounded-4 p-4" style="background-color: #F7F7F7">
                                    <div class="d-flex justify-content-between">
                                        <h2 class="fw-bold">{{ $myData['pendingCount'] }}</h2>
                                        {{-- <h2 class="fw-bold">0</h2> --}}
                                        <div>
                                            <img src="{{ asset('images/icon/time.svg') }}" alt="person">
                                        </div>
                                    </div>
                                    <div>
                                        Overtime Pending
                                    </div>
                                </div>
                            </div>
                        </div>

                        <table class="table table-responsive">
                            <thead>
                                <tr class="table-light">
                                    <th scope="col">TYPES OF OVERTIME</th>
                                    <th scope="col">SUBMISSION TIME</th>
                                    <th scope="col">MEMBERS</th>
                                    <th scope="col">DATE & DURATION</th>
                                    <th scope="col">NOTES</th>
                                    <th scope="col">ATTACHMENT</th>
                                    <th scope="col">APPROVALS</th>
                                    <th scope="col">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($myData['transaction'] as $request)
                                    <tr>
                                        <td><strong>{{ $request->overtimeType->type }}</strong>
                                        </td>
                                        <td>{{ date('d-F-Y', strtotime($request->created_at)) }}</td>
                                        <td>

                                            <div class="d-flex">
                                                <div>
                                                    <div class="mb-2"><small>Submissed By</small></div>
                                                    <span class="rounded px-2 py-1"
                                                        style="background-color: #F3F3FF"><small>{{ date('d-F-Y', strtotime($request->start_date)) }}</small></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <x-hours duration="{{ $request->duration }}"></x-hours>
                                        </td>
                                        <td>{{ Str::limit($request->reason, 100, '...') }}</td>
                                        <td>{{ $request->supporting_document }}</td>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex text-center">
                                                    <div>
                                                        <div class="mb-2"><small>Human <br>
                                                                Resources</small></div>
                                                        <img src="{{ asset('images/icon/' . $request->status . '.svg') }}"
                                                            alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a class="text-center" href="{{ route('overtime.show', $request->id) }}"><img class="mx-auto" width="25px" src="{{ asset('images/icon/eye.svg') }}" alt="Lihat Detail"></a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Belum ada pengajuan lembur sebelumnya</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{ $myData['transaction']->links() }}
                    </div>
                    {{-- APPROVAL --}}
                    <div class="tab-pane fade" id="nav-approval" role="tabpanel" aria-labelledby="nav-approval-tab" tabindex="0">
                        <div class="filter d-flex justify-content-between my-4">
                            <div>
                                <span class="fw-bold fs-4 me-4">Overtime Approval</span>
                                <button type="button" class="btn btn-outline-primary">Filter <i
                                        class="bi bi-filter"></i></button>
                            </div>
                            <div>
                                <a href="{{ route('overtime.create') }}" class="btn btn-primary">Input Overtime Request</a>
                            </div>
                        </div>

                        <div class="card-wrapper row mb-4">
                            <div class="col">
                                <div class="rounded-4 p-4" style="background-color: #F7F7F7">
                                    <div class="d-flex justify-content-between">
                                        <h2 class="fw-bold">{{ $myRequest['approvedCount'] + $myRequest['rejectedCount'] + $myRequest['pendingCount']}}</h2>
                                        <div>
                                            <img src="{{ asset('images/icon/person.svg') }}" alt="person">
                                        </div>
                                    </div>
                                    <div>
                                        Total Requests
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="rounded-4 p-4" style="background-color: #F7F7F7">
                                    <div class="d-flex justify-content-between">
                                        <h2 class="fw-bold">{{ $myRequest['approvedCount'] }}</h2>
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
                                        <h2 class="fw-bold">{{ $myRequest['rejectedCount'] }}</h2>
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
                                        <h2 class="fw-bold">{{ $myRequest['pendingCount'] }}</h2>
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

                        <table class="table">
                            <thead>
                                <tr class="table-light">
                                    <th scope="col">TYPES OF OVERTIME</th>
                                    <th scope="col">SUBMISSION TIME</th>
                                    <th scope="col">MEMBERS</th>
                                    <th scope="col">DATE & DURATION</th>
                                    <th scope="col">NOTES</th>
                                    <th scope="col">ATTACHMENT</th>
                                    <th scope="col">APPROVALS</th>
                                    <th scope="col">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($myRequest['transaction'] as $overtimeRequest)
                                    <tr>
                                        <td><strong>{{ $overtimeRequest->overtimeType->type }}</strong></td>
                                        <td>{{ date('d-F-Y', strtotime($overtimeRequest->created_at)) }}</td>
                                        <td>
                                        {{-- <td>
                                            <div>
                                                <div>
                                                    <div class="mb-2">{{ $overtimeRequest->userProfile->name }}</div>
                                                    <span class="rounded px-2 py-1"
                                                        style="background-color: #F3F3FF"><small>{{ $overtimeRequest->userProfile->nip }}</small></span>
                                                </div>
                                                <div class="mt-4">
                                                    <div class="mb-2"><small>Position - Dept</small></div>
                                                    {{ $overtimeRequest->userProfile->position }} - {{ $overtimeRequest->userProfile->department }}
                                                </div>
                                            </div>
                                        </td> --}}
                                        <td>
                                            <div>
                                                <div class="mb-2"><small>{{ date('d-F-Y', strtotime($overtimeRequest->overtime_date)) }} </small>
                                                </div>
                                                <x-hours duration="{{ $overtimeRequest->duration }}"/>
                                            </div>
                                        </td>
                                        <td>
                                            {{-- <div class="d-flex justify-content-between"> --}}
                                                {{-- <div class="d-flex">
                                                    <div>
                                                        <div class="mb-2"><small>Begin</small></div>
                                                        <span class="rounded px-2 py-1"
                                                            style="background-color: #F3F3FF"><small>{{ date('d-F-Y', strtotime($overtimeRequest->start_date)) }}</small></span>
                                                    </div>
                                                </div>
                                                <div class="d-flex">
                                                    <div>
                                                        <div class="mb-2"><small>End</small></div>
                                                        <span class="rounded px-2 py-1"
                                                            style="background-color: #F3F3FF"><small>{{ date('d-F-Y', strtotime($overtimeRequest->end_date)) }}</small></span>
                                                    </div>
                                                </div> --}}
                                            {{-- </div> --}}
                                        </td>
                                        <td>{{ $overtimeRequest->reason }}</td>
                                        <td>
                                            @if ($overtimeRequest->status == "reject")
                                                <div>
                                                    <div class="mb-2">REJECTED <img src="{{ asset('images/icon/reject.svg') }}" alt=""></div>
                                                </div>
                                            @elseif($overtimeRequest->status == "approve")
                                                <div>
                                                    <div class="mb-2">APPROVED <img src="{{ asset('images/icon/approve.svg') }}" alt=""></div>
                                                </div>
                                            @else
                                                <div class="d-flex justify-content-between">
                                                    {{-- <form action="{{ route('overtime.reject', $overtimeRequest->id) }}" method="POST" style="display:inline;"> --}}
                                                        @csrf
                                                        <button type="submit" class="btn btn-outline-primary">Reject</button>
                                                    {{-- </form> --}}
                                                    {{-- <form action="{{ route('overtime.approve', $overtimeRequest->id) }}" method="POST" style="display:inline;"> --}}
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary">Approve</button>
                                                    {{-- </form> --}}
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada pengajuan lembur sebelumnya</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{ $myRequest['transaction']->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
