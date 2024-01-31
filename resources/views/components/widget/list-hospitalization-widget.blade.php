@props(['error'])
<select {{ $attributes }} class="form-control @error($error) is-invalid @enderror">
    <option value="">Choisir</option>
    @foreach ($listRooms as $room)
        <option value="{{ $room->id }}">{{ $room->name }}</option>
    @endforeach
</select>
