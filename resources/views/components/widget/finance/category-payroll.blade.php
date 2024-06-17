@props(['error'])
@php
  $categories=  App\Models\CategorySpendMoney::all();
@endphp
<select {{ $attributes }} class="form-control @error($error) is-invalid @enderror">
    <option>Choisir</option>
    @foreach ($categories as $category)
        <option value="{{$category->id}}">{{ $category->name }}</option>
    @endforeach
</select>
