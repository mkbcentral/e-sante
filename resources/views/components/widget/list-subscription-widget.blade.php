<select {{ $attributes }} class="form-control">
    <option value="">Choisir...</option>
    @foreach ($listSubscription as $subscription)
        <option value="{{$subscription->id}}">{{ $subscription->name }}</option>
    @endforeach
</select>
