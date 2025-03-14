<div>
    @session('message')
        <div class="m-3">
            <div class="alert alert-success mb-0" role="alert">
                {{ session('message') }}
            </div>
        </div>
    @endsession
    <div class="d-block d-md-flex justify-content-between my-4">
        <div class="row align-items-center g-3 w-100 w-md-50" >
            <div class="col">
                <input type="text" class="form-control" id="search" wire:model.live="search"
                    placeholder="Silakan cari nama">
            </div>
            <div class="col-auto">
                <select class="form-select" aria-label="Default select example" wire:model.live="role">
                    <option value="">All</option>
                    <option value="employee">Staff</option>
                    <option value="supervisor">Supervisor</option>
                    <option value="hr">Human Resource</option>
                </select>
            </div>
            {{-- <div class="col-auto">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div> --}}
        </div>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr class="table-light">
                    <th scope="col">USERNAME</th>
                    <th scope="col">NAME</th>
                    <th scope="col">NIP</th>
                    <th scope="col">DEPT</th>
                    <th scope="col">ROLE</th>
                    <th scope="col">ACTION</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->userProfile->nip ?? '' }}</td>
                        <td>{{ $user->department }}</td>
                        <td>{{ $user->role }}</td>
                        <td>
                            <div class="d-flex justify-content-around">
                                <a class="text-center" style="text-decoration: none;"href="{{ route('users.edit', $user->id) }}">
                                    Edit <img class="mx-auto" width="25px" src="{{ asset('images/icon/pencil.svg') }}" alt="Lihat Detail">
                                </a>
                                <button wire:click.prevent="deleteUser({{ $user->id }})" onclick="return confirm('Are you sure you want to delete this user?')" style="background: none; border: none;">
                                    Hapus <img class="mx-auto" width="25px" src="{{ asset('images/icon/trash.svg') }}" alt="Hapus">
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada pengajuan cuti sebelumnya</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $users->links('vendor.pagination.bootstrap-5') }}
</div>
