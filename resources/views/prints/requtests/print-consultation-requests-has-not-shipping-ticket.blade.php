<x-print-layout>
    @php
        $total_cdf = 0;
        $total_usd = 0;
    @endphp
    <div class="text-center"><img src="{{ public_path('entete.png') }}" alt="Heder Image"></div>
    <h4 class="text-center text-bold mt-2">LISTE DE FREQUENTATION {{ $subscription->name }} JUIN 2024/{{ Auth::user()->source->name }} </h4>
    <table class="table table-striped table-sm ">
        <thead class="bg-dark text-white text-uppercase ">
            <tr>
                <th class="text-center">#</th>
                <th>Date</th>
                <th>Nom complet</th>
                <th>Nom du responsable/agent</th>
                <th>N° Mat.</th>
                <th class="text-center">Type</th>
            </tr>
        </thead>
        <tbody>
            @if ($consultationRequests->isEmpty())
            @else
                @foreach ($consultationRequests as $index => $consultationRequest)
                    <tr class="money_format">
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $consultationRequest->created_at->format('d/m/Y') }}</td>
                        <td class="">{{ $consultationRequest->consultationSheet?->name }}</td>
                        <td></td>
                        <td></td>
                        <td class="text-center"></td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <div class="text-right">
        Fait à Lubumbashi, Le {{ date('d/m/Y') }}
    </div>
</x-print-layout>
