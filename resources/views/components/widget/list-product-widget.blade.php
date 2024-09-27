<div>
    <div wire:ignore>
        @props(['error'])
        <select {{ $attributes }} class="form-control selectProduct2 @error($error) is-invalid @enderror">
            <option value="">Choisir</option>
            @foreach ($listProduct as $product)
                <option class="text-uppercase" value="{{ $product->id }}">{{ $product->name }}</option>
            @endforeach
        </select>
    </div>
    @push('js')
        <script type="module">
            console.log('OK');
            $(function() {
                //Initialize Select2 Elements
                $('.selectProduct2').select2({
                    theme: 'bootstrap4'
                }).on('change', function(e) {
                    console.log(e.target.value);
                    @this.set('product_id', e.target.value);
                });
            })
        </script>
    @endpush
</div>
