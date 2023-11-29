@props(['error'])
<select {{ $attributes }} class="form-control @error($error) is-invalid @enderror">
    <option value="">Choisir</option>
    @foreach ($listProduct as $product)
        <option class="text-uppercase" value="{{$product->id}}">{{ $product->name }}</option>
    @endforeach
</select>
