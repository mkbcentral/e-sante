<x-print-layout>
    <div>
        <div class="text-center"><img src="{{ public_path('entete.png') }}" alt="Heder Image"></div>
        <div class="text-right"><span>Fait à Lubumbashi, Le {{ date('d/m/Y') }}</span></div>
        <h4 class="text-center text-bold mt-2">BORDEREAU DE VERSEMENT AMBULATOIRE</h4>

        <table class="table table-bordered  table-sm">
            <thead class="bg-secondary text-white text-uppercase">
                <tr>
                    <th class="text-center">#</th>
                    <th>Date admise</th>
                    <th class="text-center">N° Fracture</th>
                    <th>Cleint</th>
                    <th class="text-right">MT USD</th>
                    <th class="text-right">MT CDF</th>
                </tr>
            </thead>
            <tbody>
                @if ($listBill->isEmpty())
                    <tr>
                        <td colspan="5" class="text-center">Aucune données trpuvée</td>
                    </tr>
                @else
                    @foreach ($listBill as $index => $bill)
                        <tr style="cursor: pointer;" id="row1" class="border border-dark">
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $bill->created_at->format('d-m-Y H:i:s') }}</td>
                            <td class="text-center">{{ $bill->bill_number }}</td>
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
                    <tr class="text-uppercase text-bold h4">
                        <td colspan="4" class="text-right">Total</td>
                        <td class="text-right">{{ app_format_number($total_usd, 1) }}</td>
                        <td class="text-right">{{ app_format_number($total_cdf, 1) }}</td>
                    </tr>
                @endif
            </tbody>
        </table>
        <table class="table table-light page-break">
            <tr>
                <td>PERECEPTION</td>
                <td class="text-right">CAISSE</td>
            </tr>
            <tr>
                <td>{{ Auth::user()->name }}</td>
                <td class="text-right">GEORGETTE KAMWANYA</td>
            </tr>
        </table>
    </div>
    <div>
        <div class="text-center"><img src="{{ public_path('entete.png') }}" alt="Heder Image"></div>
        <div class="text-right"><span>Fait à Lubumbashi, Le {{ date('d/m/Y') }}</span></div>
        <h4 class="text-center text-bold mt-2">BORDEREAU DE VERSEMENT HOSPITALISES</h4>

        <table class="table table-bordered  table-sm">
            <thead class="bg-secondary text-white text-uppercase">
                <tr>
                    <th class="text-center">#</th>
                    <th>Date</th>
                    <th class="text-center">N° Fracture</th>
                    <th>Cleint</th>
                    <th class="text-right">MT USD</th>
                    <th class="text-right">MT CDF</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($consultationRequests as $index => $consultationRequest)
                    <tr style="cursor: pointer;" id="row1" class="border border-dark">
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $consultationRequest->created_at->format('d-m-Y H:i:s') }}</td>
                        <td class="text-center">{{ $consultationRequest->getRequestNumberFormatted() }}</td>
                        <td>{{ $consultationRequest->consultationSheet->name }}</td>
                        <td class="text-right money_format">
                            @if ($consultationRequest->currency)
                                @if ($consultationRequest->currency->name == 'USD')
                                    {{ app_format_number($consultationRequest->getTotalInvoiceUSD(), 1) }}
                                @else
                                    -
                                @endif
                            @else
                                @if ($consultationRequest->consultationRequestCurrency)
                                    {{ app_format_number($consultationRequest->consultationRequestCurrency->amount_usd, 1) }}
                                @else
                                    -
                                @endif
                            @endif
                        </td>
                        <td class="text-right money_format">
                            @if ($consultationRequest->currency)
                                @if ($consultationRequest->currency->name == 'CDF')
                                    {{ app_format_number($consultationRequest->getTotalInvoiceCDF(), 1) }}
                                @else
                                    -
                                @endif
                            @else
                                @if ($consultationRequest->consultationRequestCurrency)
                                    {{ app_format_number($consultationRequest->consultationRequestCurrency->amount_cdf, 1) }}
                                @else
                                    -
                                @endif
                            @endif

                        </td>
                    </tr>
                @endforeach
                <tr class="text-uppercase text-bold h4">
                    <td colspan="4" class="text-right">Total</td>
                    <td class="text-right">{{ app_format_number($total_cons_usd, 1) }}</td>
                    <td class="text-right">{{ app_format_number($total_cons_cdf, 1) }}</td>
                </tr>
            </tbody>
        </table>
        <table class="table table-light">
            <tr>
                <td>PERECEPTION</td>
                <td class="text-right">CAISSE</td>
            </tr>
            <tr>
                <td>{{ Auth::user()->name }}</td>
                <td class="text-right">GEORGETTE KAMWANYA</td>
            </tr>
        </table>
    </div>
</x-print-layout>
