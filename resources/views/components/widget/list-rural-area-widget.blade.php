@props(['error'])
<select {{ $attributes }} class="form-control @error($error) is-invalid @enderror">
    <option>Choisir</option>
    @foreach ($listRuralArea as $ruralArea)
        <option value="{{$ruralArea->name}}">{{ $ruralArea->name }}</option>
    @endforeach
</select>
