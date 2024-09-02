@props(['error'])
<select {{ $attributes }} class="form-control text-uppercase @error($error) is-invalid @enderror">
    <option value="" disabled>Choisir</option>
    <option value="0">Tout</option>
    @foreach ($listServices as $listService)
        <option value="{{$listService->id}}" >{{ $listService->name }}</option>
    @endforeach
</select>
