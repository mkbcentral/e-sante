<div>
    <div>
        <div class="border border-1 p-2 mt-4">
            <div class="d-flex justify-content-between align-items-center">
                <span class="h5 text-indigo">Hospitalisé(s)</span>
                <h5 class="border border-2 p-2 text-bold" wire:loading.class="d-none"><span>Total</span>
                    <span class="money_format">CDF: {{ app_format_number($total_cdf, 1) }}</span> |
                    <span class="money_format">USD: {{ app_format_number($total_usd, 1) }}</span>
                </h5>
            </div>
            <div>
                <table class="table table-striped table-sm">
                    <thead class="bg-primary">
                        <tr>
                            <th class="text-center"></th>
                            <th class="">Date</th>
                            <th class=""> N° FACTURE</th>
                            <th>NOM COMPLET</th>
                            <th class="text-right">MT.USD</th>
                            <th class="text-right">MT.CDF</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6" class="text-center">
                                <x-widget.loading-circular-md />
                            </td>
                        </tr>
                        @if ($listHospitalize->isEmpty())
                            <tr wire:loading.class='d-none'>
                                <td colspan="6" class="text-center">Aucune facture réalisé</td>
                            </tr>
                        @else
                            @foreach ($listHospitalize as $index => $consultationRequest)
                                <tr wire:loading.class='d-none' style="cursor: pointer;" data-toggle="tooltip"
                                    data-placement="top" title="Facture soldée ajoud'hui">
                                    <td class="text-start">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="text-start">{{ $consultationRequest->created_at->format('d/m/Y h:i') }}
                                    </td>
                                    <td class="text-start">{{ $consultationRequest->getRequestNumberFormatted() }}
                                    </td>
                                    <td class="text-uppercase">
                                        {{ $consultationRequest->consultationSheet->name }}</td>
                                    </td>
                                    <td class="text-right">
                                        @if ($consultationRequest->currency != null)
                                            {{ $consultationRequest->currency->name == 'USD'
                                                ? app_format_number($consultationRequest->getTotalInvoiceUSD(), 1)
                                                : '-' }}
                                        @else
                                            {{ app_format_number($consultationRequest->consultationRequestCurrency->amount_usd, 1) }}
                                        @endif

                                    </td>
                                    <td class="text-right">
                                        @if ($consultationRequest->currency != null)
                                            {{ $consultationRequest->currency->name == 'CDF'
                                                ? app_format_number($consultationRequest->getTotalInvoiceCDF(), 1)
                                                : '-' }}
                                        @else
                                            {{ app_format_number($consultationRequest->consultationRequestCurrency->amount_cdf, 1) }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="h5">
                    ({{ $listHospitalize->count() > 1 ? $listHospitalize->count() . ' Facture réalisée' : $listHospitalize->count() . ' Factured réalisées' }})
                </div>
            </div>
        </div>
    </div>
</div>
