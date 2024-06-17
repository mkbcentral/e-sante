<dibv class="card" wire:poll.15s>
    <div class="card-body">
        <h3 class="text-uppercase text-secondary">
            <i class="fa fa-calendar" aria-hidden="true"></i> Dépenses {{ $isByDate?'jounalières':'Mensuelles' }}
        </h3>
        <div class="form-group">
            <div class="d-flex justify-content-between">
                <div class="mr-2">
                    <label for="date_filter">Date</label>
                    <x-form.input type='date' wire:model.live='date_filter' :error="'date_filter'" />
                </div>
                <div>
                    <label for="date_filter">Mois</label>
                    <x-widget.list-french-month wire:model.live='month' :error="'month'" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <x-widget.loading-circular-md :color="'text-white'" />
                        <h2 wire:loading.class='d-none'>{{ app_format_number($totalUSD, 1) }} USD</h2>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ route($isByDate?'payroll':'payroll.month') }}" wire:navigate class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-6 col-6">
                <div class="small-box bg-indigo">
                    <div class="inner">
                        <x-widget.loading-circular-md :color="'text-white'" />
                        <h2 wire:loading.class='d-none'>{{ app_format_number($totalCDF, 1) }} CDF</h2>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ route($isByDate?'payroll':'payroll.month') }}" wire:navigate class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

        </div>
    </div>
</dibv>
