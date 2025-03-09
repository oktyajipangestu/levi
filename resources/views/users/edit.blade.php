@extends('layouts.dashboard')

@section('content')
    <div class="m-3 bg-white rounded-4 p-5">
        <div>
            <h3>Update User</h3>
        </div>
        <hr>
        @if ($errors->any())
            <div class="alert alert-danger mb-2">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('users.update', $user->id) }}" method="post">
            @method('PUT')
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" placeholder="email" name="email"
                    value="{{ old('email', $user->email) }}">
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="name" placeholder="name" name="name"
                    value="{{ old('name', $user->name) }}">
            </div>
            <div class="mb-3">
                <label for="nip" class="form-label">NIP</label>
                <input type="text" class="form-control" id="nip" placeholder="nip" name="nip"
                    value="{{ old('nip', $user->userProfile->nip) }}">
            </div>
            <div class="row">
                <div class="col-6 mb-3">
                    <label for="department" class="form-label">Departement</label>
                    <input type="text" class="form-control" id="department" placeholder="department" name="department"
                        value="{{ old('department', $user->department) }}">
                </div>
                <div class="col-6 mb-3">
                    <label for="position" class="form-label">Position</label>
                    <input type="text" class="form-control" id="position" placeholder="position" name="position"
                        value="{{ old('position', $user->userProfile->position) }}">
                </div>
            </div>
            <div class="row">
                <div class="col-6 mb-3">
                    <label for="supervisor_id" class="form-label">Supervisor</label>
                    <select class="form-select" aria-label="Default select example" wire:model.live="role">
                        @foreach ($supervisors as $supervisor)
                            <option value="{{ $supervisor->id }}"
                                {{ $supervisor->id == $user->supervisor_id ? 'selected' : '' }}>{{ $supervisor->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col mb-3">
                    <label for="supervisor_id" class="form-label">Supervisor</label>
                    <select class="form-select" aria-label="Default select example" name="role">
                        <option value="">Role</option>
                        <option value="employee" {{ $user->role == 'employee' ? 'selected' : '' }}>Staff</option>
                        <option value="supervisor" {{ $user->role == 'supervisor' ? 'selected' : '' }}>Supervisor</option>
                        <option value="hr" {{ $user->role == 'hr' ? 'selected' : '' }}>Human Resource</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-6 mb-3">
                    <label for="status" class="form-label">Status</label>
                    <input type="text" class="form-control" id="status" placeholder="status" name="status"
                        value="{{ old('status', $user->userProfile->status) }}">
                </div>
                <div class="col-6 mb-3">
                    <label for="join_date" class="form-label">Waktu Bergabung</label>
                    <input type="date" class="form-control" id="join_date" placeholder="join_date" name="join_date"
                        value="{{ old('join_date', $user->userProfile->join_date) }}">
                </div>
            </div>
            <div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
@endsection
