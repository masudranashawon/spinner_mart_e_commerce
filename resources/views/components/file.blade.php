<div class="form-group">
  <div class="row">
    <div class="col-xl-6">
      @if ($label)
        <label for="{{ $id ?? $name }}" class="form-label">
          {{ $label }}
          @if ($required)
            <span class="text-danger">*</span>
          @endif
        </label>
      @endif

      <input type="file" name="{{ $name }}" id="{{ $id ?? $name }}" class="form-control {{ $class }}"
        @if ($required) required @endif>

      @error($name)
        <span class="text-danger">{{ $message }}</span>
      @enderror
    </div>

    @if ($preview)
      <div class="col-xl-6 mt-xl-0 mt-3">
        <div class="w-50 h-100 d-flex align-items-center overflow-hidden">
          <img id="{{ $name }}_preview" class="object-fit-scale">
        </div>
      </div>
    @endif
  </div>
</div>

@if ($preview)
  @push('script')
    <script>
      document.getElementById('{{ $id ?? $name }}')
        .addEventListener('change', function(e) {

          const file = e.target.files[0];
          if (!file) return;

          const preview = document.getElementById('{{ $name }}_preview');
          preview.src = URL.createObjectURL(file);
          preview.classList.add('border');
          preview.style.width = '6rem';
          preview.style.height = '6rem';
          preview.style.objectFit = 'contain';
        });
    </script>
  @endpush
@endif
