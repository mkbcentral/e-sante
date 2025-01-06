<div class="card" wire:poll.60s>
    <div class="card-header ">
        <div class="d-flex justify-content-between align-items-center">
            <p class="text-center h4">
                PATIENTS HOSPITALISES
            </p>
        </div>
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-center pb-2">
            <x-widget.loading-circular-md />
        </div>
        @if (!$requests->isEmpty())
            <div class="row mt-2" wire:loading.class='d-none'>
                @foreach ($requests as $req)
                    <div class="col-12 col-sm-6 col-md-6">
                        <x-others.card-info href="{{ route('consultation.hospitalize', $req->subscription_name) }}"
                            label='{{ $req->subscription_name }}' countValue='({{ $req->number }})' bg='success' />
                    </div>
                @endforeach
            </div>
        @else
            <x-errors.data-empty />
        @endif
    </div>
</div>
