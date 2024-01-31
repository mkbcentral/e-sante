<select {{ $attributes }}>
    <option value="">Choisir...</option>
    @foreach ($listSubscription as $subscription)
        @if ($subscription->name != 'PRIVE')
            <option value="{{ $subscription->id }}">{{ $subscription->name }}</option>
        @endif
    @endforeach
</select>
