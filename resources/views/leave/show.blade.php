@extends('layouts.dashboard')

@section('content')
    <div class="m-3 bg-white rounded-lg">
        <form action="{{ route('leave.store') }}" method="post">
            @csrf
            @if ($errors->any())
                <div class="alert alert-danger mb-0">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="timeoff-header mb-4 d-flex justify-content-between px-3 px-md-5 py-4">
                <h2 class="fw-bold">Leave & Time Off Request Form</h2>
                <div>
                    <a class="btn btn-outline-primary" href="{{ route('dashboard') }}">Kembali</a>
                </div>
            </div>
            <hr>
            <div class="employee-information px-3 px-md-5 py-4 mb-3">
                <h4 class="fw-bold" style="color: #4343FF">Employee Information</h4>
                <div class="table-responsive">
                    <table class="table-bordered w-100">
                        <tr>
                            <td class="p-3">
                                <strong>{{ Auth::user()->name }}</strong>
                                <div class="mt-3"><span class="px-2 py-1 rounded" style="background-color: #F3F3FF; color: #4343FF">NIP :
                                    {{ Auth::user()->userProfile->nip ?? "-" }}</span></div>
                            </td>
                            <td class="p-3">
                                <div>
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <span><small>Position</small></span><br>
                                            {{ Auth::user()->userProfile->position ?? "-" }}
                                        </div>
                                        <div>
                                            <span><small>Departement</small></span><br>
                                            {{ Auth::user()->department }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="p-3">
                                <div>
                                    <small>Direct Supervisor</small><br>
                                    {{ $spv->name ?? '-' }}
                                </div>
                            </td>
                            <td class="p-3">
                                <div>
                                    <small>Join Date</small><br>
                                    {{ date('d-F-Y', strtotime(Auth::user()->userProfile->join_date)) ?? "-" }}
                                </div>
                            </td>
                            <td class="p-3">
                                <div>
                                    <small>Status</small><br>
                                    {{ Auth::user()->userProfile->status ?? "-" }}
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <hr class="m-0">
            <div>
                <div class="row px-3 px-md-5">
                    <div class="col px-3 px-md-5 py-4" style="border-right: #D8DCE0 solid 1px">
                        <h4 class="fw-bold" style="color: #4343FF">Detail Leave & Time Off</h4>
                        <div class="mb-3">
                            <label for="type" class="form-label">Types of Leave</label>
                            <select name="type" class="form-select" aria-label="Types of Leave" disabled>
                                <option value="annual" {{ $request->type == "annual" ? "selected" : "" }}>Annual Leave</option>
                                <option value="big" {{ $request->type == "big" ? "selected" : "" }}>Big Leave</option>
                                <option value="sick" {{ $request->type == "sick" ? "selected" : "" }}>Sick Leave</option>
                                <option value="important" {{ $request->type == "important" ? "selected" : "" }}>Other Leave</option>
                            </select>
                            @error('type')
                                <div id="validationType" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Leave & Time Off Date</label>
                            <div class="row">
                                <div class="col">
                                    <label class="visually-hidden" for="begin">Begin</label>
                                    <div class="input-group">
                                        <input name="start_date" type="date" class="form-control" id="begin" placeholder="Start Date" value="{{ $request->start_date }}" disabled>
                                    </div>
                                    @error('start_date')
                                        <div id="validationType" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label class="visually-hidden" for="begin">Begin</label>
                                    <div class="input-group">
                                        <input name="end_date" type="date" class="form-control" id="begin" placeholder="End Date" value="{{ $request->start_date }}" disabled>
                                    </div>
                                    @error('end_date')
                                        <div id="validationType" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="reason" class="form-label">Reason for Leave & Time Off</label>
                            <textarea name="reason" class="form-control" id="reason" rows="3" disabled>{{ $request->reason }}</textarea>
                            @error('reason')
                                <div id="validationType" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col px-3 px-md-5 py-4">
                        <div>
                            <div class="d-flex justify-content-between">
                                <div>
                                    Annual Leave Balance
                                </div>
                                <div>
                                    @if ($annual_leaves)
                                        {{ $annual_leaves['remaining'] }} / 12
                                    @else
                                        12/12
                                    @endif
                                </div>
                            </div>
                            @if ($annual_leaves)
                                <div class="progress mt-2 rounded-3" role="progressbar" aria-label="Example 20px high" aria-valuenow="{{ $annual_leaves['remaining'] / 12 * 100 }}"
                                aria-valuemin="0" aria-valuemax="12" style="height: 15px">
                                    <div class="progress-bar rounded-3" style="width: {{ $annual_leaves['remaining'] / 12 * 100 }}%"></div>
                                </div>
                            @else
                                <div class="progress mt-2 rounded-3" role="progressbar" aria-label="Example 20px high" aria-valuenow="0"
                                    aria-valuemin="0" aria-valuemax="12" style="height: 15px">
                                    <div class="progress-bar rounded-3" style="width: 100%"></div>
                                </div>
                            @endif
                        </div>
                        <div class="my-3">
                            <div>
                                <h4 class="fw-bold" style="color: #4343FF">Leave & Time Off History</h4>
                            </div>
                            <div>
                                @forelse ($list_request as $leave)
                                    <div class="row rounded-4 p-4 mb-3" style="background-color: #F7F7F7">
                                        <div class="d-block d-md-flex">
                                            <div>
                                                Annual Leave Take
                                                <hr class="my-1">
                                                <small>start: <br><strong>{{ date('d F Y', strtotime($leave->start_date)) }}</strong> <br> end: <br><strong>{{ date('d F Y', strtotime($leave->end_date)) }}</strong></small>
                                            </div>
                                            <div class="ps-4">
                                                Reason
                                                <hr class="my-1">
                                                {{ Str::limit($leave->reason, 50, '...') }}
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="row rounded-4 p-4" style="background-color: #F7F7F7">
                                        Anda belum pernah mengajukan Cuti sebelumnya
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
