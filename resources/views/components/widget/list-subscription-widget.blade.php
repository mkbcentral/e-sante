<select {{ $attributes }}>
    @foreach ($listSubscription as $subscription)
        <option value="{{$subscription->id}}">{{ $subscription->name }}</option>
    @endforeach
</select>
