@extends('layouts.dashboard')

@section('content')
    <div class="m-3 bg-white rounded-lg">
        <form action="{{ route('overtime.store') }}" method="post" enctype="multipart/form-data">
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
            <div class="timeoff-header mb-4 d-block d-md-flex justify-content-between px-3 px-md-5 py-4">
                <h2 class="fw-bold">Overtime Request Form</h2>
                <div>
                    <a class="btn btn-outline-primary" href="{{ route('overtime.history') }}">Kembali</a>
                    {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
                </div>
            </div>
            <hr>
            @include('overtime.partials.employee-information')
            <hr class="m-0">
            <div>
                <div class="row px-3 px-md-5">
                    <div class="col px-3 px-md-5 py-4" style="border-right: #D8DCE0 solid 1px">
                        <h4 class="fw-bold" style="color: #4343FF">Detail Overtime</h4>
                        <div class="mb-3">
                            <x-alert message="Maximum overtime per day is 8 hours."
                                icon="bi bi-info-circle-fill text-primary me-2" />

                            <label for="type" class="form-label">Types of Overtime</label>
                            <select name="overtime_type_id" class="form-select" aria-label="Types of Overtime" disabled>
                                {{-- @foreach ($transaction['overtimeType'] as $type) --}}
                                <option value="{{ $transaction['overtimeType']->id }}" selected>
                                    {{ $transaction['overtimeType']->type }}
                                </option>
                                {{-- @endforeach --}}
                            </select>
                            @error('overtime_type_id')
                                <div id="validationType" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>
                        <div class="mb-3">
                            <label class="form-label">Overtime Date</label>
                            <div class="row">
                                <div class="col">
                                    <label class="visually-hidden" for="overtime_date">overtime_date</label>
                                    <div class="input-group">
                                        <input name="overtime_date" type="date" class="form-control" id="overtime_date"
                                            placeholder="Start Date" value="{{ $transaction->overtime_date }}" disabled>
                                    </div>
                                    @error('overtime_date')
                                        <div id="validationType" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label class="visually-hidden" for="duration">Duration</label>
                                    <div class="input-group mb-3">
                                        <select id="duration" name="duration" class="form-control"
                                            aria-label="Duration Hour" disabled>
                                            <option value="{{ $transaction->duration }}">{{ $transaction->duration }}
                                            </option>
                                        </select>
                                        <span class="input-group-text" id="basic-addon2">Hour</span>
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
                            <label for="reason" class="form-label">Reason for Overtime</label>
                            <textarea name="reason" class="form-control" id="reason" rows="3" disabled>{{ $transaction->reason }}</textarea>
                            @error('reason')
                                <div id="validationType" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col px-3 px-md-5 py-4">
                        <div class="my-3">
                            <div>
                                <h4 class="fw-bold" style="color: #4343FF">ATTACHMENT</h4>
                            </div>
                            <div>
                                <div class="card mb-3">
                                    {{-- <button class="btn btn-outline-primary w-100">Upload Overtime Report</button> --}}
                                    <div class="form-group">
                                        <label for="supporting_document">Unggah Dokumen Pendukung (PDF, maks.
                                            500KB):</label>
                                        <input type="file" name="supporting_document" accept=".pdf" class="form-control"
                                            disabled>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <h4 class="fw-bold" style="color: #4343FF">TEAM MEMBERS</h4>
                                    <div>
                                        <x-alert
                                            message="Only team leader/supervisor can input an overtime. Choose your overtime mate below."
                                            icon="bi bi-info-circle-fill text-primary me-2" />
                                    </div>
                                    <div>
                                        <label for="type" class="form-label">Team Leader / Supervisor</label>
                                        <x-alert message="{{ Auth::user()->name }}" icon="" />
                                    </div>
                                    <div>
                                        <label for="team_members" class="form-label">Members</label>
                                        <br>
                                        {{-- <div class="row"> --}}
                                        @foreach ($transaction['users'] as $member)
                                            <div class="btn btn-outline-info ml-2 mb-2">
                                                {{ $member->name }}
                                                {{-- <button type="button" class="btn btn-danger btn-sm"
                                                    wire:click="removeMember({{ $member->id }})">X</button> --}}
                                            </div>
                                        @endforeach
                                        {{-- </div> --}}
                                        @error('team_members')
                                            <div id="validationTeamMembers" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        {{-- <label for="team_members" class="form-label">Members</label>
                                        <select name="team_members[]" class="form-select" aria-label="Team Members">
                                            @foreach ($teamMembers as $member)
                                                <option value="{{ $member->id }}" {{ in_array($member->id, old('team_members', [])) ? 'selected' : '' }}>
                                                    {{ $member->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('team_members')
                                            <div id="validationTeamMembers" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror --}}

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
