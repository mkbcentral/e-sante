<div>

    <div>
        <div class="border border-1 p-2">
            <div class="d-flex justify-content-between align-items-center">
                <span class="h5 text-indigo">Ambulatoire(s)</span>
                <h5 class="border border-2 p-2 text-bold" wire:loading.class="d-none"><span>Total</span>
                    <span class="money_format">CDF: {{ app_format_number($tota_cdf, 1) }}</span> |
                    <span class="money_format">USD: {{ app_format_number($tota_usd, 1) }}</span>
                </h5>
            </div>
            <div>
                <table class="table table-striped table-sm">
                    <thead class="bg-navy text-white text-uppercase">
                        <tr>
                            <th class="text-center">#</th>
                            <th>Date</th>
                            <th>#Invoice</th>
                            <th>Cleint</th>
                            <th class="text-right">M.T USD</th>
                            <th class="text-right">M.T CDF</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6" class="text-center">
                                <x-widget.loading-circular-md />
                            </td>
                        </tr>
                        @if ($listBill->isEmpty())
                            <tr wire:loading.class='d-none'>
                                <td colspan="6" class="text-center">Aucune facture réalisé</td>
                            </tr>
                        @else
                            @foreach ($listBill as $index => $bill)
                                <tr wire:loading.class='d-none' style="cursor: pointer;" id="row1">
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $bill->created_at->format('d/m/Y H:i:s') }}</td>
                                    <td>A-{{ $bill->bill_number }}-PS</td>
                                    <td>{{ $bill->client_name }}</td>
                                    <td class="text-right money_format">
                                        @if ($bill->currency != null)
                                            @if ($bill->currency->name == 'USD')
                                                {{ app_format_number($bill->getTotalOutpatientBillUSD(), 1) }}
                                            @else
                                                -
                                            @endif
                                        @else
                                            @if ($bill->detailOutpatientBill)
                                                {{ app_format_number($bill->detailOutpatientBill->amount_usd, 1) }}
                                            @else
                                                -
                                            @endif
                                        @endif

                                    </td>
                                    <td class="text-right money_format">
                                        @if ($bill->currency)
                                            @if ($bill->currency->name == 'CDF')
                                                {{ app_format_number($bill->getTotalOutpatientBillCDF(), 1) }}
                                            @else
                                                -
                                            @endif
                                        @else
                                            @if ($bill->detailOutpatientBill)
                                                {{ app_format_number($bill->detailOutpatientBill->amount_cdf, 1) }}
                                            @else
                                                -
                                            @endif
                                        @endif

                                    </td>

                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="mt-4 d-flex justify-content-between align-items-center">
                    <div class="h5">
                        ({{ $counter_by_month > 1 ? $counter_by_month . ' Facture réalisée' : $counter_by_month . ' Factured réalisées' }})
                    </div>
                    {{ $listBill->links('livewire::bootstrap') }}
                </div>
            </div>
        </div>
    </div>

</div>
