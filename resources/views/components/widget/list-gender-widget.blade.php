@props(['error'])
<select {{ $attributes }} class="form-control @error($error) is-invalid @enderror">
    <option>Choisir</option>
    @foreach ($listGenders as $gender)
        <option value="{{$gender->slug}}">{{ $gender->name }}</option>
    @endforeach
</select>
