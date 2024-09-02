@props(['error'])
@php
  $categories=  App\Models\CategorySpendMoney::all();
@endphp
<select {{ $attributes }} class="form-control text-uppercase @error($error) is-invalid @enderror">
    <option disabled>Choisir</option>
    <option value="0" >Tout</option>
    @foreach ($categories as $category)
        <option value="{{$category->id}}">{{ $category->name }}</option>
    @endforeach
</select>
