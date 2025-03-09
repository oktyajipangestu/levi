@extends('layouts.dashboard')

@section('content')
    <div class="m-3 bg-white rounded-lg">
        <form action="{{ route('overtime.store') }}" method="post">
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
                <h2 class="fw-bold">Overtime Request Form</h2>
                <div>
                    <a class="btn btn-outline-primary" href="{{ route('dashboard') }}">Cancel</a>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
            <hr>
            @include('overtime.partials.employee-information')
            <hr class="m-0">
            <div>
                <div class="row px-5">
                    <div class="col px-5 py-4" style="border-right: #D8DCE0 solid 1px">
                        <h4 class="fw-bold" style="color: #4343FF">Detail Overtime</h4>
                        <div class="mb-3">
                            <x-alert message="Maximum overtime per day is 8 hours." icon="bi bi-info-circle-fill text-primary me-2" />

                            <label for="type" class="form-label">Types of Overtime</label>
                            <select name="type" class="form-select" aria-label="Types of Overtime">
                                <option value="annual">Team Planning</option>
                            </select>
                            @error('type')
                                <div id="validationType" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Overtime Date</label>
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
                                    <label class="visually-hidden" for="duration">Duration</label>
                                    <div class="input-group mb-3">
                                    <select name="type" class="form-control" aria-label="Duration Hour">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                        </select>
                                    <span class="input-group-text" id="basic-addon2">Hour</span>
                                    </div>
                                        {{-- <label for="exampleSelect" class="mr-2">Pilih Opsi:</label>
                                        <select id="exampleSelect" class="form-control" name="exampleSelect">
                                            <option value="1">Opsi 1</option>
                                            <option value="2">Opsi 2</option>
                                            <option value="3">Opsi 3</option>
                                        </select>
                                        {{-- <select name="type" class="form-group" aria-label="Duration Hour">
                                            <option value="annual">1</option>
                                            <option value="annual">2</option>
                                            <option value="annual">3</option>
                                            <option value="annual">4</option>
                                            <option value="annual">5</option>
                                            <option value="annual">6</option>
                                            <option value="annual">7</option>
                                            <option value="annual">8</option>
                                        </select>
                                        <label class="form-group" for="hour">Hour</label> --
                                    </div> --}}
                                    @error('end_date')
                                        <div id="validationType" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="reason" class="form-label">Reason for Overtime</label>
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

                                </div>
                                <div>
                                    {{-- @if ($annual_leaves->isEmpty())
                                        0/12
                                    @else
                                        {{ $annual_leaves['used'] }}
                                    @endif --}}
                                </div>
                            </div>
                            {{-- @if ($annual_leaves->isEmpty())
                                <div class="progress mt-2" role="progressbar" aria-label="Example 20px high" aria-valuenow="0"
                                    aria-valuemin="0" aria-valuemax="12" style="height: 20px">
                                    <div class="progress-bar" style="width: 0%"></div>
                                </div>
                            @else
                                <div class="progress mt-2" role="progressbar" aria-label="Example 20px high" aria-valuenow="{{ $annual_leaves['used'] / 12 * 100 }}"
                                    aria-valuemin="0" aria-valuemax="12" style="height: 20px">
                                    <div class="progress-bar" style="width: {{ $annual_leaves['used'] / 12 * 100 }}%"></div>
                                </div>
                            @endif --}}
                        </div>
                        <div class="my-3">
                            <div>
                                <h4 class="fw-bold" style="color: #4343FF">ATTACHMENT</h4>
                            </div>
                            <div>
                                <div class="card mb-3">
                                    <button class="btn btn-outline-primary w-100">Upload Overtime Report</button>
                                </div>
                                <div class="mt-3">
                                    <h4 class="fw-bold" style="color: #4343FF">TEAM MEMBERS</h4>
                                    <div>
                                        <x-alert message="Only team leader/supervisor can input an overtime. Choose your overtime mate below."  icon="bi bi-info-circle-fill text-primary me-2" />
                                    </div>
                                    <div>
                                        <label for="type" class="form-label">Team Leader / Supervisor</label>
                                        <x-alert message="{{ Auth::user()->name }}" icon="" />
                                    </div>
                                    <div>
                                        <label for="type" class="form-label">Members</label>
                                        <select name="type" class="form-select" aria-label="Team Members">
                                            <option @readonly(true)>Select Member</option>
                                            <option value="">June Cruickshank</option>
                                            <option value="">Adriel Skiles</option>
                                            <option value="">Ruben Marvin</option>
                                            <option value="">Krystina Orn </option>
                                            <option value="">Rasheed Daniel </option>
                                            <option value="">Nicholas Kemmer</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- @forelse ($list_request as $leave)
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
                                @empty --}}
                                    {{-- <div class="row rounded-4 p-4" style="background-color: #F7F7F7">
                                        Anda belum pernah mengajukan Lembur sebelumnya
                                    </div> --}}
                                {{-- @endforelse --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
