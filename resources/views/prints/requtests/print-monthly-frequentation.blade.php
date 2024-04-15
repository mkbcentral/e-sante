<x-print-layout>
    @foreach ($sources as $source)
        @php
            $total = 0;

            $consultationRequests = App\Repositories\Product\Get\GetConsultationRequestGroupingCounterRepository::getConsultationRequestGroupingBySubscriptionByMonthBySource(
                $month,
                $year,
                $source->id,
            );
            foreach ($consultationRequests as $value) {
                $total += $value->number;
            }
        @endphp
        <div>
            <div class="text-center"><img src="{{ public_path('entete.png') }}" alt="Heder Image"></div>
            <h4 class="text-center text-bold mt-2">FREQUENTATION MENSUELLE {{ format_fr_month_name($month) }}
                {{ $year }} {{ $source->name }}
            </h4>
            <table class="table table-striped table-sm ">
                <thead class="bg-dark text-white text-uppercase ">
                    <tr>
                        <th class="text-center">#</th>
                        <th>TYPE</th>
                        <th class="text-right">TAUX</th>
                        <th class="text-right">%</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($consultationRequests as $index => $consultationRequest)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $consultationRequest->subscription_name }}</td>
                            <td class="text-right">{{ $consultationRequest->number }}</td>
                            <td class="text-right">
                                {{ app_format_number((100 * $consultationRequest->number) / $total, 1) }} %</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="page-break"></div>
        </div>
    @endforeach

    <div>
        @php
            $total_all=0;
            foreach ($consultationRequestsAll as $value) {
                $total_all += $value->number;
            }
        @endphp
        <div class="text-center"><img src="{{ public_path('entete.png') }}" alt="Heder Image"></div>
        <h4 class="text-center text-bold mt-2">FREQUENTATION MENSUELLE {{ format_fr_month_name($month) }}
            {{ $year }} TOUS
        <table class="table table-striped table-sm ">
            <thead class="bg-dark text-white text-uppercase ">
                <tr>
                    <th class="text-center">#</th>
                    <th>TYPE</th>
                    <th class="text-right">TAUX</th>
                    <th class="text-right">%</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($consultationRequestsAll as $index => $req)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $req->subscription_name }}</td>
                        <td class="text-right">{{ $req->number }}</td>
                        <td class="text-right">
                            {{ app_format_number((100 * $req->number) / $total_all, 1) }} %</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="page-break"></div>
    </div>
</x-print-layout>
