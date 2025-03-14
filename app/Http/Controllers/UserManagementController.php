<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index(){
        $users = User::all()->count();
        $list_role = User::select('role', DB::raw('count(*) as total'))
                        ->groupBy('role')
                        ->get();
        return view('users.index', [
            "users" => $users,
            'list_role' => $list_role
        ]);
    }

    public function create()
    {
        $supervisors = User::where('role', 'supervisor')->get();
        return view('users.create', [
            'supervisors' => $supervisors
        ]);
    }

    public function store(UserCreateRequest $request)
    {
        $validated = $request->validated();

        // Mulai transaksi
        try {
            // Mulai transaksi
            DB::transaction(function () use ($request) {
                // Simpan data ke tabel users
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'supervisor_id' => $request->supervisor_id,
                    'department' => $request->department,
                    'role' => $request->role
                ]);

                // Simpan data ke tabel profiles
                UserProfile::create([
                    'user_id' => $user->id,
                    'nip' => $request->nip,
                    'position' => $request->position,
                    'join_date' => $request->join_date,
                    'status' => $request->status
                ]);
            });

            return redirect()->route('users.index')->with('success', 'User and Profile created successfully!');
        } catch (\Exception $e) {
            return redirect()->route('users.index')->with('error', 'Failed to create user and profile: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $supervisors = User::where('role', 'supervisor')->get();
        return view('users.edit', [
            'user' => $user,
            'supervisors' => $supervisors
        ]);
    }

    public function update(UserUpdateRequest $request, string $id)
    {
        $validated = $request->validated();

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->supervisor_id = $request->supervisor_id;
        $user->department = $request->department;
        $user->role = $request->role;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        $user_profile = UserProfile::where('user_id', $id)->first();
        $user_profile->user_id = $id;
        $user_profile->nip = $request->nip;
        $user_profile->position = $request->position;
        $user_profile->join_date = $request->join_date;
        $user_profile->status = $request->status;
        $user->save();

        return redirect()->route('users.index')->with('success', 'User and Profile updated successfully!');
    }

    public function destroy(string $id) {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}
