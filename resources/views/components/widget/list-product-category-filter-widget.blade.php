@php
    $categories = App\Models\ProductCategory::all();
@endphp
@props(['error'=>''])
<div>
    <div wire:ignore>
        <select {{ $attributes }} class="form-control selectFilter2 @error($error) is-invalid @enderror">
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
                $('.selectFilter2').select2({
                    theme: 'bootstrap4'
                }).on('change', function(e) {
                    @this.set('category_id', e.target.value);
                });
            })
        </script>
    @endpush
</div>
