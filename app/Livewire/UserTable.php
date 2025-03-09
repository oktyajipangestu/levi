<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserTable extends Component
{
    use WithPagination;

    public $search = '';
    public $role = '';

    public function deleteUser($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            $previousUrl = url()->previous();
            session()->flash('message', 'User deleted successfully.');
            return redirect()->to($previousUrl);
        }
    }

    public function render()
    {
        $list_user = User::query()->when($this->role, function ($query) {
                            return $query->where('role', $this->role);
                        })
                        ->when($this->search, function ($query) {
                            return $query->where('name', 'like', '%' . $this->search . '%');
                        })->paginate(10);

        return view('livewire.user-table', [
            'users' => $list_user
        ]);
    }
}
