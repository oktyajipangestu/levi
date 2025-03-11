<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\OvertimeType;
use Illuminate\Support\Facades\Auth;

class OvertimeRequestForm extends Component
{
    public $overtimeTypes;
    public $teamMembers;
    public $selectedMembers = [];
    public $overtimeDate;
    public $duration;
    public $reason;

    public function mount()
    {
        $this->overtimeTypes = OvertimeType::where('is_active', true)->get();
        $this->teamMembers = User::where('supervisor_id', Auth::id())->get();
    }

    public function addMember($memberId)
    {
        if (!in_array($memberId, $this->selectedMembers)) {
            $this->selectedMembers[] = $memberId;
        }
    }

    public function removeMember($memberId)
    {
        $this->selectedMembers = array_diff($this->selectedMembers, [$memberId]);
    }

    public function submit()
    {
        $validatedData = $request->validate([
            'overtime_type_id' => 'required|exists:overtime_types,id',
            'overtime_date' => 'required|date',
            'duration' => 'required|integer|min:1|max:8',
            'reason' => 'required|string|max:255',
            'selectedMembers' => 'required|array|min:1',
            'selectedMembers.*' => 'exists:users,id',
            'supporting_document' => 'required|file|mimes:pdf|max:512'
        ]);


        // Proses unggahan file
        if ($request->hasFile('supporting_document')) {
            $file = $request->file('supporting_document');
            $filePath = $file->store('public/supporting_documents');
        }

        // Simpan data pengajuan lembur
        $overtimeRequest = OvertimeTransaction::create([
            'employee_id' => Auth::id(), //as supervisor ID
            'start_time' => $request->overtime_date,
            // 'start_time' => $request->start_time,
            // 'end_time' => $request->end_time,
            'duration' => $duration,
            'overtime_type_id' => $request->overtime_type_id,
            'status' => 'Pending',
            'supporting_document' => $filePath ?? null,
        ]);

         // Simpan anggota tim yang dipilih
        $overtimeRequest->teamMembers()->sync($validatedData['team_members']);

        // $this->validate([
        //     'overtime_type_id' => 'required|exists:overtime_types,id',
        //     'overtime_date' => 'required|date',
        //     'duration' => 'required|integer|min:1|max:8',
        //     'reason' => 'required|string|max:255',
        //     'selectedMembers' => 'required|array|min:1',
        //     'selectedMembers.*' => 'exists:users,id',
        //     'supporting_document' => 'required|file|mimes:pdf|max:512'
        //     ]);

        // Process the form submission, e.g., save to the database

        session()->flash('message', 'Overtime request submitted successfully.');
    }

    public function render()
    {
        return view('livewire.overtime-request-form');
    }
}
