<div class="mx-2">
    <x-navigation.bread-crumb icon='fas fa-file-invoice-dollar' label='CONSOMMATIONS MENSUELLES' color='text-primary'>
        <x-navigation.bread-crumb-item label='Dashboard' link='dashboard' isLinked=true />
        <x-navigation.bread-crumb-item label='Consommations mensuelles' />
    </x-navigation.bread-crumb>
    <x-content.main-content-page>
        @php
            $n1 = 0;
            $n2 = 0;
            $total = 0;
        @endphp

        <div class="card card-outline card-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h5>Mois de: {{ format_fr_month_name($month_name) . '/' . $subscriptionName }}</h5>
                    <div class="d-flex align-items-center">
                        <div class="form-group d-flex mr-2">
                            <x-form.label value="{{ __('Type ') }}" class="mr-2" />
                            <x-widget.list-subscription-widget wire:model.live='subscription_id' :error="'subscription_id'" />
                        </div>
                        <div class="form-group d-flex">
                            <label for="my-input " class="mr-2">Mois</label>
                            <x-widget.list-french-month wire:model.live='month_name' :error="'month_name'" />
                             <a class="ml-2" target="_blanck"
                                href="{{ route('print.labo.monthly.releases', [$month_name,$subscription_id]) }}"><i
                                    class="fas fa-print"></i> Imprimer</a>
                        </div>

                    </div>
                </div>
                <div class="d-flex justify-content-center pb-2">
                    <x-widget.loading-circular-md />
                </div>
                <div class="table-responsive table-sm ">
                    <table class="table table-bordered text-bold">
                        <thead class="bg-primary">
                            <tr>
                                <th>EXAMEN</th>
                                @foreach ($days as $day)
                                    <th>{{ (new DateTime($day))->format('d') }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tarifs as $tarif)
                                <tr data-toggle="tooltip" data-placement="top"
                                    title="{{ $tarif->getNameOrAbbreviation() }}">
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
                                        <td>
                                            {{ $total==0?'-':$total }}
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </x-content.main-content-page>

</div>
