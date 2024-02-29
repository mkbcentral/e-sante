<div class="card" wire:poll.30s>
    <div class="card-body bg-success">
        <div class="">
            <div class="mt-2">
                <p class="text-center h4">
                    <strong><i class="fas fa-chart-bar"></i>
                        {{ $month == '' ? ' RECETTES JOURNALIERES HOSPITALISES' : ' TAUX DE RECETTES MENSUELLES HOSPITALISES' }}
                    </strong>
                </p>
                <hr>
                <div class="d-flex justify-content-center pb-2">
                    <x-widget.loading-circular-md :color="'text-white'" />
                </div>
                @if (!$tota_cdf != 0 || $tota_usd != 0)
                    <div class="row mt-2" >
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
