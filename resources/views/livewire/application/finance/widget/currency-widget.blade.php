<select class="form-control" wire:model.live='currencyName'>
    @foreach ($currencies as $currency)
        <option value="{{$currency->name}}" class="text-uppercase">
            {{ $currency->name }}
        </option>
    @endforeach
</select>
