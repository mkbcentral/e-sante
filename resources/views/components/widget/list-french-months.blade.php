<div>
    <div>
        @props(['error'])
        <select {{ $attributes }} class="form-control  @error($error) is-invalid @enderror">
            <option value="">Choisir</option>
            @foreach ($listMonths as $month)
                <option value="{{ $month['number'] }}">{{ $month['name'] }}</option>
            @endforeach
        </select>
    </div>
</div>
