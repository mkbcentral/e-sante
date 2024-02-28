<div class="card"  wire:poll.15s>
    <div class="card-header bg-pink">
        <div class="d-flex justify-content-between">
            <p class="text-center h4">
                <strong><i class="fas fa-chart-bar"></i>
                    RECETTES MENSUELLE DES ABONNES
                </strong>
            </p>
            <div class="d-flex align-items-center mr-2">
                <x-form.label value="{{ __('Mois') }}" class="mr-1" />
                <x-widget.list-fr-months wire:model.live='month' :error="'month'" />
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="">
            <div class="d-flex justify-content-center pb-2">
                <x-widget.loading-circular-md />
            </div>
            <div id="charte"></div>
            @if (!$subscriptions->isEmpty())
                <div class="row mt-2" >
                    @foreach ($subscriptions as $subscription)
                        @if ($subscription->getAmountUSDBySubscription($month, $year) != 0)
                            <div class="col-12 col-sm-6 col-md-6">
                                <div class="info-box bg-pink">
                                    <span class="info-box-icon bg-primary elevation-1"><i
                                            class="fas fa-user"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text text-bold h4">{{ $subscription->name }}</span>
                                        <span class="info-box-number h3">
                                            USD
                                            {{ app_format_number($subscription->getAmountUSDBySubscription($month, $year), 1) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @else
                <x-errors.data-empty />
            @endif
        </div>

    </div>
</div>
@push('js')
    <script type="module">
        var options = {
            chart: {
                type: 'area'
            },

            series: [{
                name: 'Recettes',
                data: @json($dataChart)
            }],
            xaxis: {
                categories: @json($labelsChart)
            }
        }

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    </script>
@endpush
</div>
