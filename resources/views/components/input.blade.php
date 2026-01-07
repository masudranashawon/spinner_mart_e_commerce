<div class="form-group">
  @if ($label)
    <label for="{{ $name }}" class="form-label">
      {{ $label }}

      @if ($required)
        <span class="text-danger">*</span>
      @endif
    </label>
  @endif

  <input type="{{ $type }}" name="{{ $name }}" id="{{ $id ?? $name }}"
    class="form-control {{ $class }}" placeholder="{{ $placeholder }}"
    @if (!empty($value)) value="{{ old($name, $value) }}" @endif
    @if (!empty($required)) required @endif @if (!empty($disabled)) disabled @endif
    @if (!empty($readonly)) readonly @endif>

  @error($name)
    <span class="text-danger">{{ $message }}</span>
  @enderror
</div>
