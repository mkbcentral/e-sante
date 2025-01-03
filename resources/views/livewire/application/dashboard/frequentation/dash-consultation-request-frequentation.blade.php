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
        <div class="d-flex justify-content-end">
            <div>
                <button type="button" class="btn btn-link dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-print" aria-hidden="true"></i>
                    Impression
                </button>
                <div class="dropdown-menu" role="menu" style="">
                    <a class="dropdown-item" target="_blank"
                        href="{{ route('monthly.frequentation', [$month, $year]) }}">
                        <i class="fa fa-file-pdf" aria-hidden="true"></i> Rapport de frequentation
                    </a>
                </div>
            </div>
        </div>
        @if (!$requests->isEmpty())
            <div class="row mt-2">
                @foreach ($requests as $req)
                    <div class="col-12 col-sm-6 col-md-6">
                        <div class="info-box bg-warning">
                            <div class="info-box-content">
                                <span class="info-box-text text-bold h4">{{ $req->subscription_name }}</span>
                                <span class="info-box-number h3">
                                    ({{ $req->number }})
                                </span>
                            </div>
                            <a href="{{ route('consultations.request.list') }}" wire:navigate
                                class="small-box-footer">Voir
                                détails
                                <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <x-errors.data-empty />
        @endif
    </div>
</div>
