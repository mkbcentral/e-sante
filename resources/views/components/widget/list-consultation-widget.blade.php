<div>
    <div data-select2-id="4">
        @props(['error'])
        <select {{ $attributes }} class="form-control select2
         @error($error) is-invalid @enderror"
            data-select2-id="4">
            <option value="">Choisir</option>
            @foreach ($listConsultation as $consultation)
                <option value="{{ $consultation->id }}">{{ $consultation->name }}</option>
            @endforeach
        </select>
    </div>
    @push('js')
        <script type="module">
            $(function() {
                //Initialize Select2 Elements
                $('.select2').select2({
                    theme: 'bootstrap4'
                }).on('change', function(e) {
                    @this.set('consultation_id', e.target.value);
                });
            })
        </script>
    @endpush
</div>
