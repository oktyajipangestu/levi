<div>
    <div class="mb-3">
        <label for="team_member" class="form-label visually-hidden">Team Members</label>
        <div class="input-group mb-3">
            <select wire:model="selectedMember" class="form-control" aria-label="Tambah Anggota Tim">
                <option value="">Select Member</option>
                @foreach ($teamMembers as $member)
                    <option value="{{ $member->id }}">{{ $member->name }}</option>
                @endforeach
            </select>
            <button type="button" class="btn btn-primary input-group-text" wire:click="addMember">Add
                Member</button>
        </div>
    </div>

    {{-- <div class="row"> --}}
    {{-- <ul class=""> --}}
    @foreach ($selectedMembers as $memberId)
        <input type="hidden" name="selected_members[]" value="{{ $memberId }}">
        @php
            $member = $teamMembers->find($memberId);
        @endphp
        @if ($member)
            {{-- <li class="list-group-item justify-content-between align-items-center"> --}}
            <x-member member="{{ $member->name }}" member-id="{{ $memberId }}" />
            {{-- <li class="list-group-item p-1 border-danger">
                    {{ $member->name }}
                    <button type="button" class="btn btn-danger btn-sm"
                        wire:click="removeMember({{ $memberId }})">x</button>
                </li> --}}
        @endif
    @endforeach

    {{-- </ul> --}}
    {{-- </div> --}}
</div>
