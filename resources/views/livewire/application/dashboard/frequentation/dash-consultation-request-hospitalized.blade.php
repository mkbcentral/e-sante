<div class="card" wire:poll.60s>
    <div class="card-header bg-indigo">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <p class="text-center h4">
                    <strong><i class="fas fa-chart-bar"></i>
                        PATIENTS HOSPITALISES
                    </strong>
                </p>
            </div>
            <div class="d-flex align-items-center mr-2">
                <x-form.label value="{{ __('Mois') }}" class="mr-1" />
                <x-widget.list-french-month wire:model.live='month' :error="'month'" />
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-center pb-2">
            <x-widget.loading-circular-md />
        </div>
        <div class="d-flex justify-content-end" >
            <div>
                <button type="button" class="btn btn-link dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-print" aria-hidden="true"></i>
                Impression
            </button>
            <div class="dropdown-menu" role="menu" style="">
                <a class="dropdown-item" target="_blank" href="{{ route('monthly.frequentation.hospitalize', [$month, $year]) }}">
                    <i class="fa fa-file-pdf" aria-hidden="true"></i> Rapport de frequentation
                </a>
            </div>
            </div>
        </div>
        @if (!$requests->isEmpty())
            <div class="row mt-2" wire:loading.class='d-none'>
                @foreach ($requests as $req)
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="info-box bg-warning">
                            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-user"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text text-bold h4">{{ $req->subscription_name }}</span>
                                <span class="info-box-number h3">
                                    ({{ $req->number }})
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <x-errors.data-empty />
        @endif
    </div>
</div>
