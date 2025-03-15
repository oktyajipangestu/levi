@extends('layouts.dashboard')

@section('content')
    <div class="m-3 bg-white rounded-4 p-3 p-md-5">
        <div>
            <h3>Create User</h3>
        </div>
        <hr>
        @if ($errors->any())
            <div class="alert alert-danger mb-3">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('users.store') }}" method="post">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email <span class="text-danger"><small>*</small></span></label>
                <input type="email" class="form-control" id="email" placeholder="email" name="email"
                    value="{{ old('email') }}">
                @error('email')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Nama Lengkap <span class="text-danger"><small>*</small></span></label>
                <input type="text" class="form-control" id="name" placeholder="name" name="name"
                    value="{{ old('name') }}">
                @error('name')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="password" class="form-label">Password: <span class="text-danger"><small>*</small></span></label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password" placeholder="password" name="password"
                    value="{{ old('password') }}">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary ms-3" type="button" id="togglePassword">
                            Show
                        </button>
                    </div>
                </div>
                @error('password')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="nip" class="form-label">NIP <span class="text-danger"><small>*</small></span></label>
                <input type="text" class="form-control" id="nip" placeholder="nip" name="nip"
                    value="{{ old('nip') }}">
                @error('nip')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="row">
                <div class="col-6 mb-3">
                    <label for="department" class="form-label">Departement <span class="text-danger"><small>*</small></span></label>
                    <input type="text" class="form-control" id="department" placeholder="department" name="department"
                        value="{{ old('department') }}">
                    @error('department')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-6 mb-3">
                    <label for="position" class="form-label">Position <span class="text-danger"><small>*</small></span></label>
                    <input type="text" class="form-control" id="position" placeholder="position" name="position"
                        value="{{ old('position') }}">
                    @error('position')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    <label for="supervisor_id" class="form-label">Supervisor <span class="text-danger"><small>*</small></span></label>
                    <select class="form-select" aria-label="Default select example" name="supervisor_id">
                        <option value="">--- Pilih Supervisor ---</option>
                        @foreach ($supervisors as $supervisor)
                            <option value="{{ $supervisor->id }}" {{ old('supervisor_id') == $supervisor->id ? 'selected' : '' }}>{{ $supervisor->name }}</option>
                        @endforeach
                    </select>
                    @error('supervisor_id')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col mb-3">
                    <label for="supervisor_id" class="form-label">Role <span class="text-danger"><small>*</small></span></label>
                    <select class="form-select" aria-label="Default select example" name="role">
                        <option value="">--- Role ---</option>
                        <option value="employee" {{ old('role') == 'employee' ? 'selected' : '' }}>Staff</option>
                        <option value="supervisor" {{ old('role') == 'supervisor' ? 'selected' : '' }}>Supervisor</option>
                        <option value="hr" {{ old('role') == 'hr' ? 'selected' : '' }}>Human Resource</option>
                    </select>
                    @error('role')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-6 mb-3">
                    <label for="status" class="form-label">Status <span class="text-danger"><small>*</small></span></label>
                    <input type="text" class="form-control" id="status" placeholder="status" name="status"
                        value="{{ old('status') }}">
                    @error('status')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-6 mb-3">
                    <label for="join_date" class="form-label">Waktu Bergabung <span class="text-danger"><small>*</small></span></label>
                    <input type="date" class="form-control" id="join_date" placeholder="join_date" name="join_date"
                        value="{{ old('join_date') }}">
                    @error('join_date')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div>
                <a class="btn btn-outline-primary" href="{{ route('users.index') }}">Batal</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
@endsection

@push('additional-script')
<script>
    console.log("Halo");

    $(document).ready(function() {
        // Toggle password visibility
        $('#togglePassword').click(function() {
            var input = $('#password');
            var type = input.attr('type');
            if (type === 'password') {
                input.attr('type', 'text');
                $(this).text('Hide');
            } else {
                input.attr('type', 'password');
                $(this).text('Show');
            }
        });
    });
</script>
@endpush
