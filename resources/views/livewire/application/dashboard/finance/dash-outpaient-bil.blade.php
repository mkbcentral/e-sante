<div class="card" wire:poll.15s>
    <div class="card-header">
        <h4 class="text-secondary">
            <i class="fas fa-chart-bar"></i>
            {{ $month == '' ? ' RECETTES JOURNALIERES AMBULATOIRES' : ' TAUX DE RECETTES MENSUELLES AMBULATOIRES' }}
        </h4>
    </div>
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
        <div class="row mt-2">
            <div class="col-12 col-sm-6 col-md-6">
                <div class="info-box bg-navy">
                    <span class="info-box-icon bg-indigo elevation-1"><i class="fas fa-dollar-sign"></i></span>

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
                <div class="info-box bg-navy">
                    <span class="info-box-icon bg-indigo elevation-1"><i class="fas fa-dollar-sign"></i></span>
                    <div class="info-box-content">
                        <x-widget.loading-circular-md :color="'text-white'" />
                        <div wire:loading.class='d-none'>
                            <span class="info-box-text text-bold h4">USD</span>
                            <span class="info-box-number h3">
                                {{ app_format_number($tota_usd, 1) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="chart-outpatien-bill"></div>
    </div>
    @push('js')
        <script type="module">
            var options = {
                chart: {
                    type: 'donut'
                },
                series: @json($amounts),
                chartOptions: {
                    labels: ['CDF', 'USD']
                }
            }

            var chart = new ApexCharts(document.querySelector("#chart-outpatien-bill"), options);
            chart.render();
        </script>
    @endpush
</div>
