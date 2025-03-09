@extends('layouts.dashboard')

@section('content')
    @session('success')
        <div class="m-3">
            <div class="alert alert-success mb-0" role="alert">
                {{ session('success') }}
            </div>
        </div>
    @endsession
    @session('error')
        <div class="m-3">
            <div class="alert alert-success mb-0" role="alert">
                {{ session('error') }}
            </div>
        </div>
    @endsession
    <div class="m-3 p-4 bg-white">
        <div class="timeoff-header d-flex justify-content-between mb-2 py-2">
            <div>
                <h2 class="fw-bold">User Management</h2>
                <p>List of active user of this application</p>
            </div>
            <div>
                <a class="btn btn-primary" href="{{ route('users.create') }}">Tambah User</a>
            </div>
        </div>
        <div class="counting">
            <div class="d-flex align-items-center mb-3">
                <div class="d-flex align-items-center rounded-3 px-3 py-2 me-3" style="background-color: #F5F7FF"><span
                        class="me-3"
                        style="font-weight: 700;color: #0000FE; font-size: 1.5em;">{{ $users }}</span>Total User
                </div>
                @foreach ($list_role as $role)
                    <div class="d-flex align-items-center rounded-3 px-3 py-2 me-3" style="background-color: #F5F7FF"><span
                            class="me-3"
                            style="font-weight: 700;color: #0000FE; font-size: 1.5em;">{{ $role->total }}</span>{{ $role->role == 'hr' ? 'Human Resources' : ($role->role == 'supervisor' ? 'Supervisor' : 'Staff') }}
                    </div>
                @endforeach
            </div>
        </div>
        <hr>
        @livewire('user-table')
    </div>
@endsection
