<x-print-layout>
    @php
        $amount_cdf = 0;
        $total_count = 0;
        $amount_hosp_cdf = 0;
        $total_amount = 0;
    @endphp
    <div class="text-center"><img src="{{ public_path('entete.png') }}" alt="Heder Image"></div>
    <h4 class="text-center text-bold mt-2">RAPPORT FINANCIER PHARMACIE
        {{ format_fr_month_name($month) . ' ' . date('Y') }}
    </h4>
    <table class="table table-striped table-sm">
        <thead class="table-dark">
            <tr class="">
                <th>SOCIETES</th>
                <th class="text-right">NOMBRE</th>
                <th class="text-right">MOTANT CDF</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($subscriptions as $subscription)
                <tr>
                    <td>{{ $subscription->name }}</td>
                    <td class="text-right">
                        @php
                            $number = App\Repositories\Product\Get\GetConsultationRequestProductAmountRepository::getProductCountByMonth(
                                $month,
                                '2024',
                                $subscription->id,
                            );
                            $total_count += $number;
                        @endphp
                        {{ $number }}
                    </td>
                    <td class="text-right">
                        @php
                            $amount_cdf = App\Repositories\Product\Get\GetConsultationRequestProductAmountRepository::getProductAmountByMonth(
                                $month,
                                '2024',
                                $subscription->id,
                                'CDF',
                            );
                            $total_amount += $amount_cdf;
                        @endphp
                        {{ app_format_number($amount_cdf, 1) }}
                    </td>
                </tr>
            @endforeach
            <tr>
                <td>PRIVE HOSP</td>
                <td class="text-right">
                    @php
                        $number_hosp = App\Repositories\Product\Get\GetConsultationRequestProductAmountRepository::getProductCountHospitalize(
                            $month,
                            '2024',
                            1,
                        );
                    @endphp
                    {{ $number_hosp }}
                </td>
                <td class="text-right">
                    @php
                        $amount_hosp_cdf = App\Repositories\Product\Get\GetConsultationRequestProductAmountRepository::getProductAmountHospitalize(
                            $month,
                            '2024',
                            1,
                            'CDF',
                        );
                    @endphp
                    {{ app_format_number($amount_hosp_cdf, 1) }}
                </td>
            </tr>
            <tr class="bg-dark text-white">
                <td>TOTAL</td>
                <td class="text-right">{{ $total_count + $number_hosp }}</td>
                <td class="text-right">{{ app_format_number($total_amount + $amount_hosp_cdf, 1) }}</td>
            </tr>
        </tbody>
    </table>
    <div class=" text-right mt-1">
        <span class="" sty>Fait àLubumbashi, Le {{ date('d/m/Y') }}</span>
    </div>
</x-print-layout>
