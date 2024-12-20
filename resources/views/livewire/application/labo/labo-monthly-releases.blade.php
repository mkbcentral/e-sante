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
                    <h5>Année:2023</h5>
                    <div class="d-flex align-items-center">
                        <div class="form-group d-flex mr-2">
                            <x-form.label value="{{ __('Type ') }}" class="mr-2" />
                            <x-widget.list-subscription-widget wire:model.live='subscription_id' :error="'subscription_id'" />
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
                                @foreach ($months as $month)
                                    <th>{{ $month['name'] }}</th>
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
                                    @foreach ($months as $month)
                                        @php
                                            //Privé hospitalisés et abonnées
                                            $n1 = App\Repositories\Labo\MonthlyReleaseRepository::getConsultationRequestReleaseByMonth(
                                                $subscription_id,
                                                $month['number'],
                                                $tarif->id,
                                            );
                                            //Privé hambulatoire
                                            $n2 = App\Repositories\Labo\MonthlyReleaseRepository::getOutpatientReleaseByMonth(
                                                $month['number'],
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
                                            App\Repositories\Labo\MonthlyReleaseRepository::getConsultationRequestReleaseByYear(
                                                $subscription_id,
                                                '2024',
                                                $tarif->id,
                                            ) +
                                            App\Repositories\Labo\MonthlyReleaseRepository::getOutpatientReleaseByYear(
                                                '2024',
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
