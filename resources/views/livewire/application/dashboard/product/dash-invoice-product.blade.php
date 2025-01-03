<dibv class="card" wire:poll.15s>
    <div class="card-body">
        <h4 class="text-secondary">
            <span>RECETTES {{ $month == '' ? '  JOURNALIERES ' : '  MENSUELLES ' }}PHARMACIE</span>
        </h4>
        <div class="row">
            <div class="col-lg-12 col-12">
                <div class="small-box bg-info">
                    <div class="inner">
                        <x-widget.loading-circular-md :color="'text-white'" />
                        <h2 wire:loading.class='d-none'>{{ app_format_number($total, 1) }} CDF</h2>
                    </div>
                    <a href="{{ route('product.invoice.report') }}" wire:navigate class="small-box-footer">Voir détails
                        <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</dibv>
