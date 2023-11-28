@props(['error'])
<select {{ $attributes }} class="form-control @error($error) is-invalid @enderror">
    <option value="" disabled selected>Choisir</option>
    <option value="">Tout</option>
    @foreach ($listFamily as $family)
        <option class="text-uppercase" value="{{$family->id}}">{{ $family->name }}</option>
    @endforeach
</select>
