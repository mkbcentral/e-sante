@php
  $categories=App\Models\CategorySpendMoney::
    where('hospital_id',App\Models\Hospital::DEFAULT_HOSPITAL())->get();
@endphp

@props(['error'])
<select {{ $attributes }} class="form-control text-uppercase @error($error) is-invalid @enderror">
    <option value="">Choisir</option>
    @foreach ($categories as $category)
        <option value="{{$category->id}}" >{{ $category->name }}</option>
    @endforeach
</select>
