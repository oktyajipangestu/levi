@extends('layouts.dashboard')

@section('content')
    @session('success')
        <div class="m-3">
            <div class="alert alert-success mb-0" role="alert">
                {{ session('success') }}
            </div>
        </div>
    @endsession
    <div class="m-3 bg-white rounded-lg p-3 p-md-5">
        <div class="timeoff-header mb-4">
            <h2 class="fw-bold">Overtime</h2>
            <p>Employee's overtime information</p>
        </div>

        @if (Auth::user()->role == 'employee')
            <div class="filter d-flex justify-content-between my-4">
                <div>
                    <span class="fw-bold fs-4 me-4">Overtime History</span>
                </div>

            </div>
            <div class="card-wrapper row mb-4">
                <div class="col mb-3 mb-md-0">
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
            <div class="table-responsive">
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
                          @forelse ($myData['transaction'] as $request)
                          {{-- {{ dd($request) }} --}}
                                    <tr>
                                        <td><strong>{{ $request->overtimeType->type }}</strong>
                                        </td>
                                        <td>{{ date('d-F-Y', strtotime($request->created_at)) }}</td>
                                        <td>
                                            <small>Submissed by</small>
                                            <div class="mb-2"><b>{{ $request->supervisor->name }}</b></div>
                                            <x-hours duration="{{ $request->supervisor->userProfile->position }}" class="mb-4"/>

                                            <small>Team Member</small>
                                            @foreach ( $request->users as $member )
                                                <li><b>{{ $member->name }}</b></li>
                                            @endforeach

                                        </td>
                                        <td>
                                            <div class="mb-2"><small>{{ date('d-F-Y', strtotime($request->overtime_date)) }} </small>
                                                </div>
                                                <x-hours duration="{{  $request->duration }}"/>
                                        </td>
                                        <td>{{ Str::limit($request->reason, 100, '...') }}</td>
                                        <td><a class="text-center btn btn-primary -ml-px" target="_blank"
                                            href="{{ route('overtime.download', ['filename' => $request->supporting_document_path]) }} "
                                            ><i class="bi bi-file-pdf"></i> Report.pdf</a></td></td>
                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex text-center">
                                                    <div>
                                                        <div class="mb-2"><small>Human <br>
                                                                Resources</small></div>
                                                        <img src="{{ asset('images/icon/' . strtolower($request->status) . '.svg') }}"
                                                            alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a class="text-center link-underline-light"
                                            href="{{ route('overtime.show', $request->id) }}"
                                            ><img class="mx-auto"  src="{{ asset('images/icon/eye.svg') }}" alt="View Detail"> View Detail</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Belum ada pengajuan lembur sebelumnya</td>
                                    </tr>
                            @endforelse
                    </tbody>
                </table>

                {{-- {{ $list_request->links() }} --}}
            </div>
        @elseif (Auth::user()->role == 'hr')
            <div class="filter d-flex justify-content-between my-4">
                <div>
                    <span class="fw-bold fs-4 me-4">Overtime History</span>
                </div>

            </div>
            <div class="card-wrapper row mb-4">
                <div class="col mb-3 mb-md-0">
                    <div class="rounded-4 p-4" style="background-color: #F7F7F7">
                        <div class="d-flex justify-content-between">
                            <h2 class="fw-bold">{{ $hrRequest['approvedCount'] + $hrRequest['pendingCount'] + $hrRequest['rejectedCount'] }}</h2>
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
                <div class="col mb-3 mb-md-0">
                    <div class="rounded-4 p-4" style="background-color: #F7F7F7">
                        <div class="d-flex justify-content-between">
                            <h2 class="fw-bold">{{ $hrRequest['approvedCount'] }}</h2>
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
                            <h2 class="fw-bold">{{ $hrRequest['rejectedCount'] }}</h2>
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
                            <h2 class="fw-bold">{{ $hrRequest['pendingCount'] }}</h2>
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
            <div class="table-responsive">
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
                          @forelse ($hrRequest['transaction'] as $order)
                          {{-- {{ dd($order) }} --}}
                                    <tr>
                                        <td><strong>{{ $order->overtimeType->type }}</strong>
                                        </td>
                                        <td>{{ date('d-F-Y', strtotime($order->created_at)) }}</td>
                                        <td>
                                            <small>Submissed by</small>
                                            <div class="mb-2"><b>{{ $order->supervisor->name }}</b></div>
                                            <x-hours duration="{{ $order->supervisor->userProfile->position }}" class="mb-4"/>

                                            <small>Team Member</small>
                                            @foreach ( $order->users as $member )
                                                <li><b>{{ $member->name }}</b></li>
                                            @endforeach

                                        </td>
                                        <td>
                                            <div class="mb-2"><small>{{ date('d-F-Y', strtotime($order->overtime_date)) }} </small>
                                                </div>
                                                <x-hours duration="{{  $order->duration }}"/>
                                        </td>
                                        <td>{{ Str::limit($order->reason, 100, '...') }}</td>
                                        <td><a class="text-center btn btn-primary -ml-px" target="_blank"
                                            href="{{ route('overtime.download', ['filename' => $order->supporting_document_path]) }} "
                                            ><i class="bi bi-file-pdf"></i> Report.pdf</a></td></td>
                                        <td>
                                            @if ($order->status == "Rejected")
                                                <div>
                                                    <div class="mb-2">REJECTED <img src="{{ asset('images/icon/rejected.svg') }}" alt=""></div>
                                                </div>
                                            @elseif($order->status == "Approved")
                                                <div>
                                                    <div class="mb-2">APPROVED <img src="{{ asset('images/icon/approved.svg') }}" alt=""></div>
                                                </div>
                                            @else
                                                <div class="d-flex justify-content-between">
                                                    <form action="{{ route('overtime.reject', $order->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-outline-primary">Reject</button>
                                                    </form>
                                                    <form action="{{ route('overtime.approve', $order->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary">Approve</button>
                                                    </form>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <a class="text-center link-underline-light"
                                            href="{{ route('overtime.show', $order->id) }}"
                                            ><img class="mx-auto" src="{{ asset('images/icon/eye.svg') }}" alt="View Detail"> View Detail</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Belum ada pengajuan lembur sebelumnya</td>
                                    </tr>
                            @endforelse
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
                            </div>
                            {{-- <div>
                                <a href="{{ route('overtime.create') }}" class="btn btn-primary">Input Overtime Request</a>
                            </div> --}}

                        </div>

                        <div class="card-wrapper row mb-4">
                            <div class="col mb-3 mb-md-0">
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
                            <div class="col mb-3 mb-md-0">
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
                        <div class="table-responsive">
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
                                                <div class="mb-2"><small>{{ date('d-F-Y', strtotime($request->overtime_date)) }} </small>
                                                    </div>
                                                    <x-hours duration="{{  $request->duration }}"/>
                                            </td>
                                            <td>{{ Str::limit($request->reason, 100, '...') }}</td>
                                            <td><a class="text-center btn btn-primary -ml-px" target="_blank"
                                                href="{{ route('overtime.download', ['filename' => $request->supporting_document_path]) }} "
                                                ><i class="bi bi-file-pdf"></i> Report.pdf</a></td></td>
                                            <td>
                                                <div class="d-flex justify-content-between">
                                                    <div class="d-flex text-center">
                                                        <div>
                                                            <div class="mb-2"><small>Human <br>
                                                                    Resources</small></div>
                                                            <img src="{{ asset('images/icon/' . strtolower($request->status) . '.svg') }}"
                                                                alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <a class="text-center"
                                                href="{{ route('overtime.show', $request->id) }}"
                                                ><img class="mx-auto" width="25px" src="{{ asset('images/icon/eye.svg') }}" alt="View Detail"> View Detail</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">Belum ada pengajuan lembur sebelumnya</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{ $myData['transaction']->links() }}
                    </div>
                    {{-- APPROVAL --}}
                    <div class="tab-pane fade" id="nav-approval" role="tabpanel" aria-labelledby="nav-approval-tab" tabindex="0">
                        <div class="filter d-block d-md-flex justify-content-between my-4">
                            <div class="mb-2 mb-md-0">
                                <span class="fw-bold fs-4 me-4">Overtime Approval</span>
                            </div>
                            <div>
                                <a href="{{ route('overtime.create') }}" class="btn btn-primary">Input Overtime Request</a>
                            </div>
                        </div>

                        <div class="card-wrapper row mb-4">
                            <div class="col mb-3 mb-md-0">
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
                            <div class="col mb-3 mb-md-0">
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
                        <div class="table-responsive">
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
                                                {{-- {{ dd($overtimeRequest->users) }} --}}
                                                <small>Submissed by</small>
                                                <div class="mb-2"><b>{{ $overtimeRequest->userProfile->user->name }}</b></div>
                                                <x-hours duration="{{ $overtimeRequest->userProfile->position }}" class="mb-2   "/>

                                                <small>Team Member</small>
                                                @foreach ( $overtimeRequest->users as $member )
                                                    <li><b>{{ $member->name }}</b></li>
                                                @endforeach


                                            </td>
                                            <td>
                                                <div>
                                                    <div class="mb-2"><small>{{ date('d-F-Y', strtotime($overtimeRequest->overtime_date)) }} </small>
                                                    </div>
                                                    <x-hours duration="{{  $overtimeRequest->duration }}"/>
                                                </div>
                                            </td>

                                            <td>{{ Str::limit($overtimeRequest->reason, 100, '...') }}</td>
                                            <td><a class="text-center btn btn-primary -ml-px" target="_blank"
                                                href="{{ route('overtime.download', ['filename' => $overtimeRequest->supporting_document_path]) }} "
                                                ><i class="bi bi-file-pdf"></i> Report.pdf</a></td>
                                            <td>
                                                <div class="d-flex justify-content-between">
                                                    <div class="d-flex text-center">
                                                        <div>
                                                            <div class="mb-2"><small>Human <br>
                                                                    Resources</small></div>
                                                            <img src="{{ asset('images/icon/' . $overtimeRequest->status . '.svg') }}"
                                                                alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <a class="text-center link-underline-light"
                                                href="{{ route('overtime.show', $overtimeRequest->id) }}"
                                                ><img class="mx-auto"  src="{{ asset('images/icon/eye.svg') }}" alt="View Detail"> View Detail</a>
                                            </td>
                                                {{-- @if ($overtimeRequest->status == "reject")
                                                    <div>
                                                        <div class="mb-2">REJECTED <img src="{{ asset('images/icon/reject.svg') }}" alt=""></div>
                                                    </div>
                                                @elseif($overtimeRequest->status == "approve")
                                                    <div>
                                                        <div class="mb-2">APPROVED <img src="{{ asset('images/icon/approve.svg') }}" alt=""></div>
                                                    </div>
                                                @else
                                                    <div class="d-flex justify-content-between">
                                                        {{-- <form action="{{ route('overtime.reject', $overtimeRequest->id) }}" method="POST" style="display:inline;"> --
                                                            @csrf
                                                            <button type="submit" class="btn btn-outline-primary">Reject</button>
                                                        {{-- </form> --}}
                                                        {{-- <form action="{{ route('overtime.approve', $overtimeRequest->id) }}" method="POST" style="display:inline;"> --
                                                            @csrf
                                                            <button type="submit" class="btn btn-primary">Approve</button>
                                                        {{-- </form> --
                                                    </div>
                                                @endif --}}

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Belum ada pengajuan lembur sebelumnya</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $myRequest['transaction']->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
