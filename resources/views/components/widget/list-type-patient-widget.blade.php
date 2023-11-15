<select {{ $attributes }}>
    <option>Choisir</option>
    @foreach ($listType as $type)
        <option value="{{$type->id}}">{{ $type->name }}</option>
    @endforeach
</select>
