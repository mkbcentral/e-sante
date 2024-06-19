<x-print-layout>
    @php
        $total_cdf = 0;
        $total_usd = 0;
    @endphp
    <div class="text-center"><img src="{{ public_path('entete.png') }}" alt="Heder Image"></div>
    <h4 class="text-center text-bold mt-2">RELEVE CORRIGE DES FACTURES {{ $subscription->name }}
        {{ format_fr_month_name($month) }} 2024 </h4>
    <table class="table table-striped table-sm ">
        <thead class="bg-dark text-white text-uppercase ">
            <tr>
                <th class="text-center">#</th>
                <th>Date</th>
                <th>N° Facture</th>
                <th>Nom complet</th>
                <th class="text-right">MONTANT</th>
            </tr>
        </thead>
        <tbody>
            @if ($consultationRequests->isEmpty())
            @else
                @foreach ($consultationRequests as $index => $consultationRequest)
                    <tr class="money_format">
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $consultationRequest->created_at->format('d/m/Y') }}</td>
                        <td>{{ $consultationRequest->getRequestNumberFormatted() }}</td>
                        <td class="">{{ $consultationRequest->consultationSheet?->name }}</td>
                        <td class="text-right money_format">
                            @if ($subscription->name == 'CNSS')
                                {{ app_format_number($consultationRequest->getTotalInvoiceUSD(), 1) }}
                            @else
                                {{ app_format_number($consultationRequest->getTotalInvoiceCDF(), 1) }}
                        </td>
                @endif

                </tr>
                @php
                    $total_cdf += $consultationRequest->getTotalInvoiceCDF();
                    $total_usd += $consultationRequest->getTotalInvoiceUSD();
                @endphp
            @endforeach
            <tr>
                <td colspan="5" class="text-right bg-secondary text-white h5">TOTAL</td>
            </tr>
            @if ($subscription->name == 'CNSS')
                <tr>
                    <td colspan="5" class="text-right h6 text-bold">{{ app_format_number($total_usd, 1) }} USD</td>
                </tr>
            @else
                <tr>
                    <td colspan="5" class="text-right h6 text-bold">{{ app_format_number($total_cdf-8000, 1) }} CDF</td>
                </tr>
                <tr>
                    <td colspan="5" class="text-right h6 text-bold">{{ app_format_number($total_usd-2.85, 1) }} USD</td>
                </tr>
            @endif

            @endif
        </tbody>
    </table>
    <div class="text-left">
        @if ($subscription->name == 'CNSS')
            <h6>NB: {{ ucfirst(app_format_number_letter($total_usd-2.85)) }} Dollars américains </h6>
        @else
            <h6>NB: {{ ucfirst(app_format_number_letter($total_cdf-8000)) }} Fancs congolais </h6>
        @endif
    </div>
    <div class="text-right">
        Fait à Lubumbashi, Le {{ date('d/m/Y') }}
    </div>
    <div class="invoice-box">
        <table>
            <tr>
                <td colspan="3" style="border: none">
                    <table style="border: none">
                        <tr style="border: none">
                            <td style="border: none" class="text-bold text-left">
                                INFO&COM
                            </td>
                            <td style="border: none" class="text-right ">
                                A.G
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="border: none">
                    <table style="border: none">
                        <tr style="border: none">
                            <td style="border: none" class="text-bold text-center">

                            </td>
                            <td style="border: none; margin-right: ;" class="text-right mr-4">
                                Dady KALMERY
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</x-print-layout>
