@props(['error'])
<select {{ $attributes() }} class="form-control @error($error) is-invalid @enderror">
    <option value="">Choisir</option>
    @foreach ($listCategories as $category)
        <option value="{{$category->id}}">{{ $category->name }}</option>
    @endforeach
</select>
