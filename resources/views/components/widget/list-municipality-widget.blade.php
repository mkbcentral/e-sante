@props(['error'])
<select {{ $attributes }} class="form-control @error($error) is-invalid @enderror">
    <option>Choisir</option>
    @foreach ($listMunicipalities as $municipality)
        <option value="{{$municipality->name}}">{{ $municipality->name }}</option>
    @endforeach
</select>
