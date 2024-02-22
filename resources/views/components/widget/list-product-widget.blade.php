@props(['error'])
<select {{ $attributes }} class="form-control select2 select2-hidden-accessible @error($error) is-invalid @enderror">
    <option value="">Choisir</option>
    @foreach ($listProduct as $product)
        <option class="text-uppercase" value="{{ $product->id }}">{{ $product->name }}</option>
    @endforeach
</select>
