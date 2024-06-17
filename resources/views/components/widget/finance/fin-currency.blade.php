@php
    $currencies = App\Models\Currency::all();
@endphp
<div class="row">
    @foreach ($currencies as $currency)
        <div class="col-md-6">
            <!-- radio -->
            <div class="form-group clearfix">
                <div class="icheck-success d-inline">
                    <input {{ $attributes }} type="radio" value="{{ $currency->id }}" id="{{ $currency->name }}">
                    <label for="{{ $currency->name }}">
                        {{ $currency->name }}
                    </label>
                </div>
            </div>
        </div>
    @endforeach
</div>
