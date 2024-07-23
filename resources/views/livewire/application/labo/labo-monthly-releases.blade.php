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
            $total_count = 0;
            $item_count = 0;
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
                                href="{{ route('print.labo.monthly.releases', [$month_name, $subscription_id]) }}"><i
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
                                <th class="text-center">NBRE</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tarifs as $tarif)
                                <tr data-toggle="tooltip" data-placement="top"
                                    title="{{ $tarif->getNameOrAbbreviation() }}">
                                    <td>
                                        {{ strlen($tarif->getNameOrAbbreviation()) > 10 ? substr($tarif->getNameOrAbbreviation(), 0, 10) . '...' : $tarif->getNameOrAbbreviation() }}
                                    </td>
                                    @foreach ($days as $i => $r_day)
                                        @php
                                            $n1 = App\Repositories\Labo\MonthlyReleaseRepository::getConsultationRequestReleaseByDay(
                                                $subscription_id,
                                                $r_day,
                                                $tarif->id,
                                            );
                                            $n2 = App\Repositories\Labo\MonthlyReleaseRepository::getOutpatientReleaseByDay(
                                                $r_day,
                                                $tarif->id,
                                            );
                                            $total = $n1 + $n2;
                                        @endphp
                                        <td>
                                            {{ $total == 0 ? '-' : $total }}
                                        </td>
                                    @endforeach
                                    @php
                                        $item_count =
                                            App\Repositories\Labo\MonthlyReleaseRepository::getConsultationRequestReleaseByMonth(
                                                $subscription_id,
                                                $month_name,
                                                $tarif->id,
                                            ) +
                                            App\Repositories\Labo\MonthlyReleaseRepository::getOutpatientReleaseByMonth(
                                                $month_name,
                                                $tarif->id,
                                            );
                                        $total_count += $item_count;
                                    @endphp
                                    <td class="text-center bg-danger">{{ $item_count }}</td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <H2>Nombre: {{ $total_count }}</H2>
            </div>
        </div>
    </x-content.main-content-page>

</div>
