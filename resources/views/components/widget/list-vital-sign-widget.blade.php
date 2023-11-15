@props(['error'])
<select {{ $attributes }} class="form-control @error($error) is-invalid @enderror">
    <option>Choisir</option>
    @foreach ($listVitalSign as $vital)
        <option value="{{$vital->id}}">{{ $vital->name }}</option>
    @endforeach
</select>
