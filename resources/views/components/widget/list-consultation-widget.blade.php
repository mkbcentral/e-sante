@props(['error'])
<select {{ $attributes }} class="form-control @error($error) is-invalid @enderror">
    <option value="">Choisir</option>
    @foreach ($listConsultation as $consultation)
        <option value="{{$consultation->id}}">{{ $consultation->name }}</option>
    @endforeach
</select>
