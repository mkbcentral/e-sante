<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <div class="d-flex align-items-center mr-2">
                <x-form.label value="{{ __('Date') }}" class="mr-1" />
                <x-form.input type='date' wire:model.live='date_filter' :error="'date_filter'" />
            </div>
            <div class="d-flex align-items-center mr-2">
                <x-form.label value="{{ __('Mois') }}" class="mr-1" />
                <x-widget.list-fr-months wire:model.live='month' :error="'month'" />
            </div>
        </div>
        <div class="">
            <div class="">
                <p class="text-center h text-secondary">
                    <strong><i class="fas fa-chart-bar"></i>
                        {{ $month == '' ? ' TAUX DE FRAQUANTETION JOUNALIERE' : ' TAUX DE FRAQUANTETION MENSUELLE' }}
                    </strong>
                </p>
                <hr>
                <div class="d-flex justify-content-center pb-2">
                    <x-widget.loading-circular-md />
                </div>
                @if (!$requests->isEmpty())
                    <div class="row mt-2" wire:loading.class='d-none'>
                        @foreach ($requests as $req)
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="info-box bg-indigo">
                                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user"></i></span>
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
    </div>
</div>
