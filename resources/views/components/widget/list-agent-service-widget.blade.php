@props(['error'])
<select {{ $attributes }} class="form-control @error($error) is-invalid @enderror">
    <option>Choisir</option>
    @foreach ($listServices as $listService)
        <option value="{{$listService->id}}">{{ $listService->name }}</option>
    @endforeach
</select>
