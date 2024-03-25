<dibv class="card" wire:poll.15s>
    <div class="card-body">
        <h3 class="text-uppercase text-secondary">
            <i class="fa fa-calendar" aria-hidden="true"></i> Recettes jounalières pharmacie
        </h3>
        <div class="form-group">
            <label for="date_filter">Date</label>
            <x-form.input type='date' wire:model.live='date_filter' :error="'date_filter'" />
        </div>
        <div class="row">
            <div class="col-lg-6 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <x-widget.loading-circular-md :color="'text-white'" />
                        <h2 wire:loading.class='d-none'>{{ app_format_number($totalInvoice, 1) }} CDF</h2>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ route('payroll') }}" wire:navigate class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</dibv>
