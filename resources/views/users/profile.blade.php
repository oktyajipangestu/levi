@extends('layouts.dashboard')

@section('content')
    <div class="m-3 bg-white rounded-4 p-3 p-md-5">
        <div class="timeoff-header d-flex justify-content-between px-3 px-md-5 py-3">
            <h4 class="fw-bold" style="color: #4343FF">Employee Information</h4>
            <div>
                <a class="btn btn-outline-primary" href="{{ route('dashboard') }}">Kembali</a>
            </div>
        </div>
        <hr>
        <div class="employee-information px-3 px-md-5 py-4 mb-3">
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
                                {{ isset(Auth::user()->userProfile->join_date) ? date('d-F-Y', strtotime(Auth::user()->userProfile->join_date)) : "-" }}
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
    </div>
@endsection
