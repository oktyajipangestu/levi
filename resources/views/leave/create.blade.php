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
            <div class="timeoff-header mb-4 d-flex justify-content-between px-5 py-4">
                <h2 class="fw-bold">Leave & Time Off Request Form</h2>
                <div>
                    <a class="btn btn-outline-primary" href="{{ route('dashboard') }}">Cancel</a>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
            <hr>
            <div class="employee-information px-5 py-4 mb-3">
                <h4 class="fw-bold" style="color: #4343FF">Employee Information</h4>
                <div>
                    <table class="table-bordered w-100">
                        <tr>
                            <td class="p-3">
                                <strong>{{ Auth::user()->name }}</strong>
                                <div class="px-2 py-1 rounded mt-3" style="background-color: #F3F3FF; color: #4343FF">NIP :
                                    {{ Auth::user()->userProfile->nip }}</div>
                            </td>
                            <td class="p-3">
                                <div>
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <span><small>Position</small></span><br>
                                            {{ Auth::user()->userProfile->position }}
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
                                    Alexandra
                                </div>
                            </td>
                            <td class="p-3">
                                <div>
                                    <small>Join Date</small><br>
                                    {{ date('d-F-Y', strtotime(Auth::user()->userProfile->join_date)) }}
                                </div>
                            </td>
                            <td class="p-3">
                                <div>
                                    <small>Status</small><br>
                                    {{ Auth::user()->userProfile->status }}
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <hr class="m-0">
            <div>
                <div class="row px-5">
                    <div class="col px-5 py-4" style="border-right: #D8DCE0 solid 1px">
                        <h4 class="fw-bold" style="color: #4343FF">Detail Leave & Time Off</h4>
                        <div class="mb-3">
                            <label for="type" class="form-label">Types of Leave</label>
                            <select name="type" class="form-select" aria-label="Types of Leave">
                                <option value="annual">Annual Leave</option>
                                <option value="big">Big Leave</option>
                                <option value="sick">Sick Leave</option>
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
                                        <input name="start_date" type="date" class="form-control" id="begin" placeholder="Start Date" value="{{ old('start_date') }}">
                                    </div>
                                    @error('start_date')
                                        <div id="validationType" class="invalid-feedback">
                                            {{ $message }} tes
                                        </div>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label class="visually-hidden" for="begin">Begin</label>
                                    <div class="input-group">
                                        <input name="end_date" type="date" class="form-control" id="begin" placeholder="End Date" value="{{ old('end_date') }}">
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
                            <textarea name="reason" class="form-control" id="reason" rows="3">{{ old('reason') }}</textarea>
                            @error('reason')
                                <div id="validationType" class="invalid-feedback">
                                    {{ $message }} tes
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col px-5 py-4">
                        <div>
                            <div class="d-flex justify-content-between">
                                <div>
                                    Annual Leave Balance
                                </div>
                                <div>
                                    @if ($annual_leaves->isEmpty())
                                        0/12
                                    @else
                                        {{ $annual_leaves['used'] }}
                                    @endif
                                </div>
                            </div>
                            @if ($annual_leaves->isEmpty())
                                <div class="progress mt-2" role="progressbar" aria-label="Example 20px high" aria-valuenow="0"
                                    aria-valuemin="0" aria-valuemax="12" style="height: 20px">
                                    <div class="progress-bar" style="width: 0%"></div>
                                </div>
                            @else
                                <div class="progress mt-2" role="progressbar" aria-label="Example 20px high" aria-valuenow="{{ $annual_leaves['used'] / 12 * 100 }}"
                                    aria-valuemin="0" aria-valuemax="12" style="height: 20px">
                                    <div class="progress-bar" style="width: {{ $annual_leaves['used'] / 12 * 100 }}%"></div>
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
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                Annual Leave Take <br>
                                                {{ date('d F Y', strtotime($leave->start_date)) }} ~ {{ date('d F Y', strtotime($leave->end_date)) }}
                                            </div>
                                            <div>
                                                Reason <br>
                                                {{ $leave->reason }}
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
