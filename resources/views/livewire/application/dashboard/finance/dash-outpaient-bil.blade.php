<div class="card">
    <div class="card-body bg-secondary">
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
            <div class="mt-2">
                <p class="text-center h4">
                    <strong><i class="fas fa-chart-bar"></i>
                        {{ $month == '' ? ' RECETTES JOURNALIERES AMBULATOIRES' : ' TAUX DE RECETTES MENSUELLES AMBULATOIRES' }}
                    </strong>
                </p>
                <hr>
                <div class="d-flex justify-content-center pb-2">
                    <x-widget.loading-circular-md />
                </div>
                @if (!$tota_cdf != 0 || $tota_usd != 0)
                    <div class="row mt-2" wire:loading.class='d-none'>
                        <div class="col-12 col-sm-6 col-md-6">
                            <div class="info-box bg-navy">
                                <span class="info-box-icon bg-indigo elevation-1"><i class="fas fa-dollar-sign"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text text-bold h4">CDF</span>
                                    <span class="info-box-number h3">
                                        {{ app_format_number($tota_cdf, 1) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                         <div class="col-12 col-sm-6 col-md-6">
                            <div class="info-box bg-navy">
                                <span class="info-box-icon bg-indigo elevation-1"><i class="fas fa-dollar-sign"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text text-bold h4">USD</span>
                                    <span class="info-box-number h3">
                                        {{ app_format_number($tota_usd, 1) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <x-errors.data-empty />
                @endif
            </div>
        </div>
    </div>
</div>
