@props(['error'])
<select {{ $attributes }} class="form-control @error($error) is-invalid @enderror">
    @foreach ($listMonths as $month)
    <option value="{{$month['number']}}">{{ $month['name'] }}</option>
    @endforeach
</select>
