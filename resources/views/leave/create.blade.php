@extends('layouts.dashboard')

@section('content')
    <div class="m-3 bg-white rounded-lg">
        <form action="" method="post">
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
                                <strong>ANETTE BLACK</strong>
                                <div class="px-2 py-1 rounded mt-3" style="background-color: #F3F3FF; color: #4343FF">NIP :
                                    1234567890</div>
                            </td>
                            <td class="p-3">
                                <div>
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <span><small>Position</small></span><br>
                                            Software Engineer SPV
                                        </div>
                                        <div>
                                            <span><small>Departement</small></span><br>
                                            Information Technology
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
                                    31 July 2024
                                </div>
                            </td>
                            <td class="p-3">
                                <div>
                                    <small>Status</small><br>
                                    Civil Servant Candidate
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
                        <h4>Detail Leave & Time Off</h4>
                        <div class="mb-3">
                            <label for="type" class="form-label">Types of Leave</label>
                            <select class="form-select" aria-label="Types of Leave">
                                <option value="annual">Annual Leave</option>
                                <option value="big">Big Leave</option>
                                <option value="sick">Sick Leave</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Leave & Time Off Date</label>
                            <div class="row">
                                <div class="col">
                                    <label class="visually-hidden" for="begin">Begin</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control" id="begin" placeholder="Username">
                                    </div>
                                </div>
                                <div class="col">
                                    <label class="visually-hidden" for="begin">Begin</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control" id="begin" placeholder="Username">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="reason" class="form-label">Reason for Leave & Time Off</label>
                            <textarea class="form-control" id="reason" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="col px-5 py-4">
                        <div>
                            <div class="d-flex justify-content-between">
                                <div>
                                    Annual Leave Balance
                                </div>
                                <div>
                                    4/12
                                </div>
                            </div>
                            <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="75"
                                aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar w-75"></div>
                            </div>
                        </div>
                        <div class="my-3">
                            <div>
                                <h4>Leave & Time Off History</h4>
                            </div>
                            <div>
                                <div>
                                    <div class="row rounded-4 p-4" style="background-color: #F7F7F7">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                Annual Leave Take <br>
                                                12/02/2025 ~ 14/02/2025
                                            </div>
                                            <div>
                                                Reason <br>
                                                Taking vacay to Bali
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
