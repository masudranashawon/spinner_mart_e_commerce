<div class="form-group">
  @if ($label)
    <label for="{{ $name }}" class="form-label">
      {{ $label }}

      @if ($required)
        <span class="text-danger">*</span>
      @endif
    </label>
  @endif

  <textarea name="{{ $name }}" id="{{ $id ?? $name }}" class="form-control {{ $class }}"
    placeholder="{{ $placeholder }}" @if (!empty($required)) required @endif rows="5">{{ old($name, $value) }}</textarea>

  @error($name)
    <span class="text-danger">{{ $message }}</span>
  @enderror
</div>
