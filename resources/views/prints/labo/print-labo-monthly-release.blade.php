<x-print-layout>
    @php
        $n1 = 0;
        $n2 = 0;
        $total = 0;
    @endphp
    <div class="text-center"><img src="{{ public_path('entete.png') }}" alt="Heder Image"></div>
    <h4 class="text-center text-bold mt-2">CONSOMMATION MENSUELLE LABORATOIRE</h4>
    <h6 class="text-left">Mois: {{ format_fr_month_name($month) }}</h6>
    <table class="table table-bordered table-sm text-bold">
        <thead class="bg-dark text-white ">
            <tr>
                <th>EXAMEN</th>
                @foreach ($days as $day)
                    <th>{{ (new DateTime($day))->format('d') }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($tarifs as $tarif)
                <tr data-toggle="tooltip" data-placement="top" title="{{ $tarif->getNameOrAbbreviation() }}">
                    <td>
                        {{ strlen($tarif->getNameOrAbbreviation()) > 10 ? substr($tarif->getNameOrAbbreviation(), 0, 10) . '...' : $tarif->getNameOrAbbreviation() }}
                    </td>
                    @foreach ($days as $day)
                        @php
                            if ($subscription_id != '') {
                                $n1 = DB::table('consultation_request_tarif')
                                    ->join(
                                        'consultation_requests',
                                        'consultation_requests.id',
                                        'consultation_request_tarif.consultation_request_id',
                                    )
                                    ->join(
                                        'consultation_sheets',
                                        'consultation_sheets.id',
                                        'consultation_requests.consultation_sheet_id',
                                    )
                                    ->where('consultation_sheets.subscription_id', $subscription_id)
                                    ->whereDate('consultation_requests.created_at', $day)
                                    ->where('consultation_request_tarif.tarif_id', $tarif->id)
                                    ->count();
                                if ($subscription_id == 1) {
                                    $n2 = DB::table('outpatient_bill_tarif')
                                        ->join(
                                            'outpatient_bills',
                                            'outpatient_bills.id',
                                            'outpatient_bill_tarif.outpatient_bill_id',
                                        )
                                        ->whereDate('outpatient_bills.created_at', $day)
                                        ->where('outpatient_bill_tarif.tarif_id', $tarif->id)
                                        ->count();
                                }
                                $total = $n1 + $n2;
                            } else {
                                $n1 = DB::table('consultation_request_tarif')
                                    ->join(
                                        'consultation_requests',
                                        'consultation_requests.id',
                                        'consultation_request_tarif.consultation_request_id',
                                    )
                                    ->whereDate('consultation_requests.created_at', $day)
                                    ->where('consultation_request_tarif.tarif_id', $tarif->id)
                                    ->count();
                                $n2 = DB::table('outpatient_bill_tarif')
                                    ->join(
                                        'outpatient_bills',
                                        'outpatient_bills.id',
                                        'outpatient_bill_tarif.outpatient_bill_id',
                                    )
                                    ->whereDate('outpatient_bills.created_at', $day)
                                    ->where('outpatient_bill_tarif.tarif_id', $tarif->id)
                                    ->count();
                                $total = $n1 + $n2;
                            }

                        @endphp
                        <td class="text-center ">
                            {{ $total == 0 ? '-' : $total }}
                        </td>
                    @endforeach
                </tr>
            @endforeach

        </tbody>
    </table>
</x-print-layout>
