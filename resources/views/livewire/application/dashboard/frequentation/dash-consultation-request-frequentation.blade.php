<div class="card" wire:poll.15s>
    <div class="card-header">
        <p class="h4 text-secondary">
            {{ $month == '' ? ' TAUX DE FRAQUANTETION JOUNALIERE' : ' TAUX DE FRAQUANTETION MENSUELLE' }}
        </p>
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-center">
            <x-widget.loading-circular-md />
        </div>
        @if (!$requests->isEmpty())
            <div class="row mt-2" wire:loading.class='d-none'>
                @foreach ($requests as $req)
                    <div class="col-12 col-sm-6 col-md-6">
                        <x-others.card-info href="{{ route('consultations.request.list', $req->subscription_name) }}"
                            label='{{ $req->subscription_name }}' countValue='({{ $req->number }})' bg='warning' />
                    </div>
                @endforeach
            </div>
        @else
            <x-errors.data-empty />
        @endif
    </div>
</div>
