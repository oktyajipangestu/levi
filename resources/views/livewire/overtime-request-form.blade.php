<div class="m-3 bg-white rounded-lg">
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="submit">
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
        <div class="row px-5">
            <div class="col px-5 py-4" style="border-right: #D8DCE0 solid 1px">
                <h4 class="fw-bold" style="color: #4343FF">Detail Overtime</h4>
                <div class="mb-3">
                    <x-alert message="Maximum overtime per day is 8 hours."
                        icon="bi bi-info-circle-fill text-primary me-2" />
                    <label for="type" class="form-label">Types of Overtime</label>
                    <select wire:model="overtimeType" class="form-select" aria-label="Types of Overtime">
                        <option value="">Select Overtime Type</option>
                        @foreach ($overtimeTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->type }}</option>
                        @endforeach
                    </select>
                    @error('overtimeType')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Overtime Date</label>
                    <input wire:model="overtimeDate" type="date" class="form-control">
                    @error('overtimeDate')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Duration (Hours)</label>
                    <input wire:model="duration" type="number" class="form-control" min="1" max="8">
                    @error('duration')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="reason" class="form-label">Reason for Overtime</label>
                    <textarea wire:model="reason" class="form-control" rows="3"></textarea>
                    @error('reason')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col px-5 py-4">
                <h4 class="fw-bold" style="color: #4343FF">Team Members</h4>
                <div class="mb-3">
                    <label for="team_member" class="form-label">Add Member</label>
                    <livewire:team-member-selector />
                    {{-- <select wire:model="selectedMember" class="form-select" aria-label="Add Team Member">
                        <option value="">Select Member</option>
                        @foreach ($teamMembers as $member)
                            <option value="{{ $member->id }}">{{ $member->name }}</option>
                        @endforeach
                    </select> --}}
                    <button type="button" class="btn btn-primary mt-2" wire:click="addMember(selectedMember)">Add
                        Member</button>
                    @error('selectedMembers')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <ul class="list-group">
                    @foreach ($selectedMembers as $memberId)
                        @php
                            $member = $teamMembers->find($memberId);
                        @endphp
                        @if ($member)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $member->name }}
                                <button type="button" class="btn btn-danger btn-sm"
                                    wire:click="removeMember({{ $memberId }})">Remove</button>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </form>
</div>
