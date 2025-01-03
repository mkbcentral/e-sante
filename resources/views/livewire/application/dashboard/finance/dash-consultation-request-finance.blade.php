<div class="card" wire:poll.30s>
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <p class="text-center h4 text-secondary">
                RECETTES DES ABONNES
            </p>
        </div>
    </div>
    <div class="card-body">
        <div class="">
            <div class="d-flex justify-content-center pb-2">
                <x-widget.loading-circular-md />
            </div>
            @if (!$subscriptions->isEmpty())
                <div class="row mt-2">
                    @foreach ($subscriptions as $subscription)
                        @if ($subscription->getAmountUSDBySubscription($month, $year) != 0)
                            <div class="col-12 col-sm-6 col-md-6">
                                <a wire:navigate
                                    href="{{ route('finance.rapport.by.subscription', [$subscription, $month, $year]) }}">
                                    <div class="info-box bg-navy">

                                        <div class="info-box-content">
                                            <span class="info-box-text text-bold h4">{{ $subscription->name }}</span>
                                            <span class="info-box-number h3">
                                                USD
                                                {{ app_format_number($subscription->getAmountUSDBySubscription($month, $year), 1) }}
                                            </span>
                                        </div>
                                    </div>
                                </a>
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
            fill: {
                type: "gradient",
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.9,
                    stops: [0, 90, 100]
                }
            },
            xaxis: {
                categories: @json($labelsChart)
            }
        }

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    </script>
@endpush
</div>
