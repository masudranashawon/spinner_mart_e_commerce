<div class="form-group">
  @if ($label)
    <label for="{{ $name }}" class="form-label">
      {{ $label }}

      @if ($required)
        <span class="text-danger">*</span>
      @endif
    </label>
  @endif

  <select name="{{ $name }}" id="{{ $id ?? $name }}" class="form-select form-control {{ $class }}"
    @if (!empty($required)) required @endif @if (!empty($disabled)) disabled @endif
    @if (!empty($multiple)) multiple @endif>{{ $slot }}</select>

  @error($name)
    <span class="text-danger">{{ $message }}</span>
  @enderror
</div>
