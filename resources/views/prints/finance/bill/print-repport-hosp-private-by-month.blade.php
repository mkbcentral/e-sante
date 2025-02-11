<x-print-layout>
    @php
        $total_cdf = 0;
        $total_usd = 0;
    @endphp
    <div class="text-center"><img src="{{ public_path('entete.png') }}" alt="Heder Image"></div>
    <h4 class="text-center text-bold mt-2">RAPPORT DES RECETTES MENSUELLES HOSPITALISES</h4>
    <div class="text-left"><span>Mois de: {{ format_fr_month_name($month) }}/2025</span></div>
    <table class="table table-striped table-sm">
        <thead class="bg-secondary text-white text-uppercase">
            <tr>
                <th class="text-center"></th>
                <th class="">Date</th>
                <th class=""> N° FACTURE</th>
                <th>NOM COMPLET</th>
                <th class="text-right">MT.USD</th>
                <th class="text-right">MT.CDF</th>
                <th class="text-right">User</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($listHospitalize as $index => $consultationRequest)
                @php
                    $amount_usd = 0;
                    $amount_cdf = 0;
                @endphp
                <tr wire:loading.class='d-none' style="cursor: pointer;" data-toggle="tooltip" data-placement="top"
                    title="Facture soldée ajoud'hui">
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
                            @if ($consultationRequest->currency->name == 'USD')
                                @php
                                    $amount_usd = $consultationRequest->getTotalInvoiceUSD();
                                    $total_usd += $amount_usd;
                                @endphp
                                {{ app_format_number($amount_usd, 1) }}
                            @else
                                -
                            @endif
                        @else
                            @php
                                $amount_usd = $consultationRequest->consultationRequestCurrency->amount_usd;
                                $total_usd += $amount_usd;
                            @endphp
                            {{ app_format_number($amount_usd, 1) }}
                        @endif
                    </td>
                    <td class="text-right">
                        @if ($consultationRequest->currency != null)
                            @if ($consultationRequest->currency->name == 'CDF')
                                @php
                                    $amount_cdf = $consultationRequest->getTotalInvoiceCDF();
                                    $total_cdf += $amount_cdf;
                                @endphp
                                {{ app_format_number($amount_cdf, 1) }}
                            @else
                                -
                            @endif
                        @else
                            @php
                                $amount_cdf = $consultationRequest->consultationRequestCurrency->amount_cdf;
                                $total_cdf += $amount_cdf;
                            @endphp
                            {{ app_format_number($amount_cdf, 1) }}
                        @endif
                    </td>
                    @php
                        $user = App\Models\User::find($consultationRequest->perceived_by);
                    @endphp
                    <td>{{ $user->name }}</td>
                </tr>
            @endforeach
            <tr class="text-uppercase bg-secondary text-white">
                <td colspan="4" class="text-right h4">Total</td>
                <td class="text-right h4">{{ app_format_number($total_usd, 1) }}</td>
                <td class="text-right h4">{{ app_format_number($total_cdf, 1) }}</td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <div class="text-right"><span>Fait à Lubumbashi, Le {{ date('d/m/Y') }}</span></div>
</x-print-layout>
