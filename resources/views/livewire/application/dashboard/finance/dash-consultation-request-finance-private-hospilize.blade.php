<div class="card" wire:poll.15s>
    <div class="card-body">
        <div class="card-header">
            <h4 class="text-secondary">
                <i class="fas fa-chart-bar"></i>
                {{ $month == '' ? ' RECETTES JOURNALIERES HOSPITALISES' : ' TAUX DE RECETTES MENSUELLES HOSPITALISES' }}
            </h4>
        </div>
        <div class="row mt-2">
            <div class="col-12 col-sm-6 col-md-6">
                <div class="info-box bg-teal">
                    <span class="info-box-icon bg-navy elevation-1"><i class="fas fa-dollar-sign"></i></span>
                    <div class="info-box-content">
                        <x-widget.loading-circular-md :color="'text-white'" />
                        <div wire:loading.class='d-none'>
                            <span class="info-box-text text-bold h4">CDF</span>
                            <span class="info-box-number h3">
                                {{ app_format_number($tota_cdf, 1) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-6">
                <div class="info-box bg-teal">
                    <span class="info-box-icon bg-navy elevation-1"><i class="fas fa-dollar-sign"></i></span>
                    <div class="info-box-content">
                        <x-widget.loading-circular-md :color="'text-white'" />
                        <div wire:loading.class="d-none">
                            <span class="info-box-text text-bold h4">USD</span>
                            <span class="info-box-number h3">
                                {{ app_format_number($tota_usd, 1) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
