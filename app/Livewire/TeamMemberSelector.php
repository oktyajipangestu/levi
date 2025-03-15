<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TeamMemberSelector extends Component
{
    public $teamMembers;
    public $selectedMembers = [];
    public $selectedMember;

    public function mount()
    {
        $this->teamMembers = User::where('supervisor_id', Auth::id())
                            ->orWhere('id',Auth::id())
                            ->get();
    }

    public function addMember()
    {
        if ($this->selectedMember && !in_array($this->selectedMember, $this->selectedMembers)) {
            $this->selectedMembers[] = $this->selectedMember;
        }
    }

    public function removeMember($memberId)
    {
        $this->selectedMembers = array_filter($this->selectedMembers, function ($id) use ($memberId) {
            return $id != $memberId;
        });
    }

    public function render()
    {
        return view('livewire.team-member-selector');
    }
}
