@props(['error'])
@php
  $sources=  App\Models\PayrollSource::all();
@endphp
<select {{ $attributes }} class="form-control @error($error) is-invalid @enderror">
    <option>Choisir</option>
    @foreach ($sources as $sources)
        <option value="{{$sources->id}}">{{ $sources->name }}</option>
    @endforeach
</select>
