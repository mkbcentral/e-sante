<x-print-layout>
    @php
        $total_cdf = 0;
        $total_usd = 0;
    @endphp
    <div class="text-center"><img src="{{ public_path('entete.png') }}" alt="Heder Image"></div>
    <h4 class="text-center text-bold mt-2">LISTE DES FACTURES SANS BON {{ $subscription->name }} FEVRIER 2024 </h4>
    <table class="table table-striped table-sm ">
        <thead class="bg-dark text-white text-uppercase ">
            <tr>
                <th class="text-center">#</th>
                <th>Date</th>
                <th>Nom complet</th>
            </tr>
        </thead>
        <tbody>
            @if ($consultationRequests->isEmpty())
            @else
                @foreach ($consultationRequests as $index => $consultationRequest)
                    <tr class="money_format">
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $consultationRequest->consultationSheet->created_at->format('d/m/Y') }}</td>

                        <td class="">{{ $consultationRequest->consultationSheet?->name }}</td>

                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <div class="text-right">
        Fait à Lubumbashi, Le {{ date('d/m/Y') }}
    </div>
</x-print-layout>
