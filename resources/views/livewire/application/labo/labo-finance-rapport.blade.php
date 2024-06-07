<div class="mx-2">
    @php
        $amount = 0;
    @endphp
    <x-navigation.bread-crumb icon='fas fa-file-invoice-dollar' label='RAPPORT FINANCIER' color='text-primary'>
        <x-navigation.bread-crumb-item label='Dashboard' link='dashboard' isLinked=true />
        <x-navigation.bread-crumb-item label='Rapport financier' />
    </x-navigation.bread-crumb>
    <x-content.main-content-page>
        <div class="card card-outline card-primary">
            <div class="card-body">
                <table class="table table-striped">
                    <thead class="bg-primary">
                        <tr>
                            <th>NAME</th>
                            @foreach ($months as $month)
                                <th class="text-center">{{ $month['name'] }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subscriptions as $subscription)
                            <tr>
                                <td class="text-bold">{{ $subscription->name }}</td>
                                @foreach ($months as $month)
                                    @php
                                        $amount = App\Repositories\Tarif\GetAmountByTarif::getAmountByTarifByMonth(
                                            $month['number'],
                                            $subscription->id,
                                            1,
                                        );
                                    @endphp
                                    <td class="text-right money_format {{ $amount == 0 ? 'bg-danger ' : '' }}"b>
                                        {{ $amount == 0 ? '-' : app_format_number($amount, 1) }}
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                        <tr>
                            <td class="text-bold">PRIVE</td>
                            @foreach ($months as $month)
                                @php
                                    $n1 = App\Repositories\Tarif\GetAmountByTarif::getAmountByTarifByMonthHospitalizePrivate(
                                        $month['number'],
                                        1,
                                        1
                                    );
                                    $n2 = App\Repositories\Tarif\GetAmountByTarif::getAmountoutpatientByMonth(
                                        $month['number'],
                                        1,
                                    );
                                    $amount = $n1 + $n2;
                                @endphp
                                <td class="text-right money_format {{ $amount == 0 ? 'bg-danger ' : '' }}"b>
                                    {{ $amount == 0 ? '-' : app_format_number($amount, 1) }}
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </x-content.main-content-page>
</div>
