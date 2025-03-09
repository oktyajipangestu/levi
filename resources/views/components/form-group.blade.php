<!-- resources/views/components/form-group.blade.php -->
<div class="mb-3">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    {{ $slot }}
    @error($name)
        <div id="validation{{ ucfirst($name) }}" class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
