<div class="container">
    <x-navigation.bread-crumb icon='fas fa-chart-area' label='DETAILS FACTRURE' color='text-secondary'>
        <x-navigation.bread-crumb-item label='Dashboard' link='dashboard' isLinked=true />
        <x-navigation.bread-crumb-item label='Rapport financier' />
    </x-navigation.bread-crumb>
    <x-content.main-content-page>
        @php
            $amount = 0;
            $amount_pharma = 0;
            $amount_consultation = 0;
            $amount_nursing = 0;
            $amount_hospitalization = 0;
            $total_tarif = 0;

            $amount_consultation = App\Repositories\Tarif\GetAmountByTarif::getAmountConsultationByMonth(
                $month,
                $year,
                $subscription->id,
            );

            $amount_nursing = App\Repositories\Tarif\GetAmountByTarif::getAmountNursingByMonth(
                $month,
                $year,
                $subscription->id,
            );

            $amount_hospitalization = App\Repositories\Tarif\GetAmountByTarif::getAmountHospitalizationByMonth(
                $month,
                $year,
                $subscription->id,
            );
            $amount_pharma = App\Repositories\Product\Get\GetConsultationRequestProductAmountRepository::getProductAmountByMonth(
                $month,
                $year,
                $subscription->id,
                'USD',
            );

        @endphp
        <div class="card card-outline card-indigo">
            <div class="card-body">
                <div>
                    <h4 class="text-secondary">Société: <span class="text-indigo">{{ $subscription->name }}</span>
                    </h4>
                    <h4 class="text-secondary">Mois: <span class="text-indigo">{{ $month }}</span>
                    </h4>
                </div>
                <table class="table table-striped table-sm">
                    <thead class="bg-indigo">
                        <tr>
                            <th>CATEGORIE</th>
                            <th class="text-right">MONTANT</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>CONSULTATION</td>
                            <td class="text-right">
                                {{ $amount_consultation == 0 ? '-' : app_format_number($amount_consultation, 1) }} USD
                            </td>
                        </tr>
                        @foreach ($categories as $index => $category)
                            @php
                                $amount_tarif = App\Repositories\Tarif\GetAmountByTarif::getAmountByTarifByMonth(
                                    $month,
                                    $subscription->id,
                                    $category->id,
                                );
                            @endphp
                            <tr>
                                <td>{{ $category->name }}</td>
                                <td class="text-right">
                                    {{ $amount_tarif == 0 ? '-' : app_format_number($amount_tarif, 1) }} USD
                                </td>
                            </tr>
                            @php
                                $total_tarif += $amount_tarif;
                            @endphp
                        @endforeach
                        <tr>
                            <td>PHARMACIE</td>
                            <td class="text-right">
                                {{ $amount_pharma == 0 ? '-' : app_format_number($amount_pharma, 1) }} USD
                            </td>
                        </tr>
                        <tr>
                            <td>HOSPITALISATION</td>
                            <td class="text-right">
                                {{ $amount_hospitalization == 0 ? '-' : app_format_number($amount_hospitalization, 1) }}
                                USD
                            </td>
                        </tr>
                        <tr>
                            <td>NURSING</td>
                            <td class="text-right">
                                {{ $amount_nursing == 0 ? '-' : app_format_number($amount_nursing, 1) }} USD
                            </td>
                        </tr>
                        <tr class="bg-dark text-bold h3">
                            <td class="text-right">TOTAL</td>
                            <td class="text-right">
                                {{ app_format_number(
                                    $total_tarif + $amount_pharma + $amount_consultation + $amount_nursing + $amount_hospitalization,
                                    1,
                                ) }}
                                USD
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </x-content.main-content-page>
</div>
