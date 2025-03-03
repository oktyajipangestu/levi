@extends('layouts.dashboard')

@section('content')
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
                    <h3 class="fw-bold">8</h3>
                    <div>
                        <i class="bi bi-person-fill-down"></i>
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
                    <h3 class="fw-bold">4</h3>
                    <div>
                        <i class="bi bi-person-fill-down"></i>
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
                    <h3 class="fw-bold">3</h3>
                    <div>
                        <i class="bi bi-person-fill-down"></i>
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
                    <h3 class="fw-bold">7</h3>
                    <div>
                        <i class="bi bi-person-fill-down"></i>
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
              <tr>
                <th><strong>ANNUAL LEAVE</strong></th>
                <td>26 Feb 2025</td>
                <td>
                    <div class="d-flex justify-content-between">
                        <div class="d-flex">
                            <div>
                                <div class="mb-2"><small>Begin</small></div>
                                <span class="rounded px-2 py-1" style="background-color: #F3F3FF"><small>28 Feb 2025</small></span>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div>
                                <div class="mb-2"><small>End</small></div>
                                <span class="rounded px-2 py-1" style="background-color: #F3F3FF"><small>28 Feb 2025</small></span>
                            </div>
                        </div>
                    </div>
                </td>
                <td>Would like to take my annual leave for vacay</td>
                <td>
                    <div class="d-flex justify-content-between">
                        <div class="d-flex text-center">
                            <div>
                                <div class="mb-2"><small>Direct <br>
                                    Supervisor</small></div>
                                <img src="{{ asset('images/icon/check.svg') }}" alt="">
                            </div>
                        </div>
                        <div class="d-flex text-center">
                            <div>
                                <div class="mb-2"><small>Human <br>
                                    Resources</small></div>
                                <img src="{{ asset('images/icon/time.svg') }}" alt="">
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <a href=""><i class="bi bi-eye-fill"></i> View Detail</a>
                </td>
              </tr>
            </tbody>
          </table>
    </div>
 </div>
@endsection
