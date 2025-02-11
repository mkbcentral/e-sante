<x-print-layout>
    @php
        $total = 0;
    @endphp
    <div class="text-center"><img src="{{ public_path('entete.png') }}" alt="Heder Image"></div>
    <h4 class="text-center text-bold mt-2">RAPPORT DES RECETTES MENSUELLES AMBULATOIRE</h4>
    <div class="text-left"><span>Mois de: {{ format_fr_month_name($month) }}/2025</span></div>
    <table class="table table-sm">
        <thead class="bg-dark text-white text-uppercase">
            <tr>
                <th class="text-center">#</th>
                <th>Date</th>
                <th class="text-center">N° Reçu</th>
                <th>Cleint</th>
                <th class="text-right">MT USD</th>
                <th class="text-right">MT CDF</th>
                <th class="text-right">User</th>
            </tr>
        </thead>
        <tbody>
            @if ($listBill->isEmpty())
                <tr>
                    <td colspan="7" class="text-center">Aucune données trouvée</td>
                </tr>
            @else
                @php
                    $currentDate = null;
                    $subtotalUSD = 0;
                    $subtotalCDF = 0;
                @endphp
                @foreach ($listBill as $index => $bill)
                    @if ($currentDate && $currentDate != $bill->created_at->format('d-m-Y'))
                        <tr class="text-uppercase bg-secondary text-white">
                            <td colspan="4" class="text-right">Sous-total pour {{ $currentDate }}</td>
                            <td class="text-right">{{ app_format_number($subtotalUSD, 1) }}</td>
                            <td class="text-right">{{ app_format_number($subtotalCDF, 1) }}</td>
                            <td></td>
                        </tr>
                        @php
                            $subtotalUSD = 0;
                            $subtotalCDF = 0;
                        @endphp
                    @endif
                    @php
                        $currentDate = $bill->created_at->format('d-m-Y');
                        $usdAmount =
                            $bill->currency && $bill->currency->name == 'USD'
                                ? $bill->getTotalOutpatientBillUSD()
                                : ($bill->detailOutpatientBill
                                    ? $bill->detailOutpatientBill->amount_usd
                                    : 0);
                        $cdfAmount =
                            $bill->currency && $bill->currency->name == 'CDF'
                                ? $bill->getTotalOutpatientBillCDF()
                                : ($bill->detailOutpatientBill
                                    ? $bill->detailOutpatientBill->amount_cdf
                                    : 0);
                        $subtotalUSD += $usdAmount;
                        $subtotalCDF += $cdfAmount;
                    @endphp
                    <tr style="cursor: pointer;" id="row1" class="border border-dark">
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $currentDate }}</td>
                        <td>{{ $bill->bill_number }}</td>
                        <td>{{ $bill->client_name }}</td>
                        <td class="text-right money_format">{{ app_format_number($usdAmount, 1) }}</td>
                        <td class="text-right money_format">{{ app_format_number($cdfAmount, 1) }}</td>
                        <td class="text-right">{{ $bill->user->name }}</td>
                    </tr>
                @endforeach
                <tr class="text-uppercase bg-secondary text-white">
                    <td colspan="4" class="text-right">Sous-total pour {{ $currentDate }}</td>
                    <td class="text-right">{{ app_format_number($subtotalUSD, 1) }}</td>
                    <td class="text-right">{{ app_format_number($subtotalCDF, 1) }}</td>
                    <td></td>
                </tr>
                <tr class="text-uppercase bg-secondary text-white">
                    <td colspan="4" class="text-right h4">Total</td>
                    <td class="text-right h4">{{ app_format_number($total_usd, 1) }}</td>
                    <td class="text-right h4">{{ app_format_number($total_cdf, 1) }}</td>
                    <td></td>
                </tr>
            @endif
        </tbody>
    </table>
    <div class="page-break text-right"><span>Fait à Lubumbashi, Le {{ date('d/m/Y') }}</span></div>

    <div class="text-center"><img src="{{ public_path('entete.png') }}" alt="Heder Image"></div>
    <h4 class="text-center text-bold mt-2">SYNTHESE DES RECETTES MENSUELLES AMBULATOIRE</h4>
    <div class="text-left"><span>Mois de: {{ format_fr_month_name($month) }}/2025</span></div>
    <table class="table table-sm">
        <thead class="bg-dark text-white text-uppercase">
            <tr>
                <th class="">DESCRIPTION</th>
                <th class="text-right">MONTANT</th>
            </tr>
        </thead>

        <tbody>

            @foreach ($synthesis as $index => $synthese)
                <tr>
                    <td>{{ $index }}</td>
                    <td class="text-right">{{ app_format_number($synthese, 1) }}</td>
                </tr>
                @php
                    $total += $synthese;
                @endphp
            @endforeach
            <tr class=" bg-secondary text-white">
                <td class="text-right h4 text-uppercase">Total</td>
                <td class="text-right h4">{{ app_format_number($total, 1) }}</td>
            </tr>
        </tbody>
    </table>
</x-print-layout>
