<x-print-layout>
    @php
        $total_cdf = 0;
        $total_usd = 0;
    @endphp
    <div class="text-center"><img src="{{ public_path('entete.png') }}" alt="Heder Image"></div>
    <h4 class="text-center text-bold mt-2">LISTE DE FREQUENTATION {{ $subscription->name }}
        {{ format_fr_month_name($month) }} 2024 </h4>
    <table class="table table-striped table-sm ">
        <thead class="bg-dark text-white text-uppercase ">
            <tr>
                <th class="text-center">#</th>
                <th>Date</th>
                <th>Nom complet</th>
                <th class="text-right">EXAMENS</th>
            </tr>
        </thead>
        <tbody>
            @if ($consultationRequests->isEmpty())
            @else
                @foreach ($consultationRequests as $index => $consultationRequest)
                    @if (!$categoryTarif->getConsultationTarifItems($consultationRequest, $categoryTarif)->isEmpty())
                        <tr class="money_format">
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $consultationRequest->created_at->format('d/m/Y') }}</td>
                            <td class="w-20">{{ $consultationRequest->consultationSheet?->name }}</td>
                            <td class="">
                                @foreach ($categoryTarif->getConsultationTarifItems($consultationRequest, $categoryTarif) as $tarif)
                                    {{ $tarif->abbreviation == null ? $tarif->name : $tarif->abbreviation }},
                                @endforeach
                            </td>
                        </tr>
                    @endif
                @endforeach
            @endif
        </tbody>
    </table>
    <div class="text-right">
        Fait à Lubumbashi, Le 04/08/2024
    </div>
</x-print-layout>
