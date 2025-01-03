<div class="card" wire:poll.15s>
    <div class="card-body">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <p class="text-center h4">
                    {{ $month == '' ? ' RECETTES JOURNALIERES HOSPITALISES' : ' TAUX DE RECETTES MENSUELLES HOSPITALISES' }}
                </p>
            </div>

        </div>
        <div class="row mt-2">
            <div class="col-12 col-sm-6 col-md-6">
                <div class="info-box bg-teal">
                    <div class="info-box-content">
                        <x-widget.loading-circular-md :color="'text-white'" />
                        <div wire:loading.class='d-none'>
                            <span class="info-box-text text-bold h4">CDF</span>
                            <span class="info-box-number h3">
                                {{ app_format_number($tota_cdf, 1) }}
                            </span>
                        </div>
                    </div>
                    <a href="{{ route('consultation.hospitalize') }}" wire:navigate class="small-box-footer">Voir
                        détails
                        <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-6">
                <div class="info-box bg-teal">
                    <div class="info-box-content">
                        <x-widget.loading-circular-md :color="'text-white'" />
                        <div wire:loading.class="d-none">
                            <span class="info-box-text text-bold h4">USD</span>
                            <span class="info-box-number h3">
                                {{ app_format_number($tota_usd, 1) }}
                            </span>
                        </div>
                    </div>
                    <a href="{{ route('consultation.hospitalize') }}" wire:navigate class="small-box-footer">Voir
                        détails
                        <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
