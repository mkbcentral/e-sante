@props(['error'])
<select {{ $attributes }} class="form-control @error($error) is-invalid @enderror">
    <option value="" disabled selected>Choisir</option>
    <option value="">Tout</option>
    @foreach ($listCategory as $category)
        <option class="text-uppercase" value="{{$category->id}}">{{ $category->name }}</option>
    @endforeach
</select>
