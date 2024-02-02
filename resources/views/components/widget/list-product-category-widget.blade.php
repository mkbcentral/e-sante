@props(['error'])
<select {{ $attributes }} class="form-control @error($error) is-invalid @enderror">
    <option value="">Choisir</option>
    @foreach ($categories as $cat)
        <option class="text-uppercase" value="{{$cat->id}}">{{ $cat->name }}</option>
    @endforeach
</select>
