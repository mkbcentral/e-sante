<x-print-layout>
    <div class="text-center"><img src="{{ public_path('entete.png') }}" alt="Heder Image"></div>
    <div class="text-right"><span>Fait à Lubumbashi, Le {{ date('d/m/Y') }}</span></div>
    <h4 class="text-center text-bold mt-2">BORDEREAU DE VERSEMENT</h4>

    <table class="">
        <thead class="bg-secondary text-white text-uppercase">
            <tr>
                <th class="text-center">#</th>
                <th>Date</th>
                <th class="text-center">#Invoice</th>
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
                        <td>{{ $bill->bill_number }}</td>
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
                <tr class="text-uppercase bg-secondary text-white">
                    <td colspan="4" class="text-right">Total</td>
                    <td class="text-right">{{ app_format_number($total_usd, 1) }}</td>
                    <td class="text-right">{{ app_format_number($total_cdf, 1) }}</td>
                </tr>
            @endif
        </tbody>
    </table>
    <table class="table table-light">
        <tr>
            <td>G</td>
            <td class="text-right">D</td>
        </tr>
        <tr>
            <td>G</td>
            <td class="text-right">D</td>
        </tr>
    </table>
</x-print-layout>
