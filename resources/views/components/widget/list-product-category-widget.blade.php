<div>
    <div wire:ignore>
        @props(['error'])
        <select {{ $attributes }} class="form-control select2 @error($error) is-invalid @enderror">
            <option value="">Choisir</option>
            @foreach ($categories as $cat)
                <option class="text-uppercase" value="{{ $cat->id }}">{{ $cat->name }}</option>
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
                    @this.set('category_id', e.target.value);
                });
            })
        </script>
    @endpush
</div>
