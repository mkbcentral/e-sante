<div class="mx-2">
    @php
        $amount = 0;
        $total = 0;
        $amount_hosp = 0;
    @endphp
    <x-navigation.bread-crumb icon='fas fa-file-invoice-dollar' label='RAPPORT FINANCIER PHARMACIE' color='text-primary'>
        <x-navigation.bread-crumb-item label='Dashboard' link='dashboard' isLinked=true />
        <x-navigation.bread-crumb-item label=' Rapport financier' />
    </x-navigation.bread-crumb>
    <x-content.main-content-page>
        <div class="card card-outline card-navy">
            <div class="card-body">
                <table class="table table-bordered table-sm">
                    <thead class="">
                        <tr>
                            <th>SUSCRIPTION</th>
                            @foreach ($months as $month)
                                <th class="text-right"><a target="_blank" href="{{ route('print.product.finance.repport', $month['number']) }}">{{ $month['name'] }}</a></th>
                            @endforeach

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subsctiptions as $subsctiption)
                            <tr>
                                <td class="text-uppercase text-bold">{{ $subsctiption->name }}</td>
                                @foreach ($months as $month)
                                    @php
                                        $amount = App\Repositories\Product\Get\GetConsultationRequestProductAmountRepository::getProductAmountByMonth(
                                            $month['number'],
                                            '2024',
                                            $subsctiption->id,
                                            'CDF',
                                        );

                                    @endphp
                                    <td class="text-right money_format {{ $amount == 0 ? 'bg-danger ' : '' }}">
                                        {{ $amount == 0 ? '-' : app_format_number($amount, 1) }}
                                    </td>
                                @endforeach

                            </tr>
                        @endforeach
                        <tr>
                            <td class="text-uppercase text-bold">PRIVE HOSPITALISE</td>
                            @foreach ($months as $month)
                                @php
                                    $amount_hosp = App\Repositories\Product\Get\GetConsultationRequestProductAmountRepository::
                                    getProductAmountHospitalize(
                                        $month['number'],
                                        '2024',
                                        1,
                                        'CDF',
                                    );
                                @endphp
                                <td class="text-right money_format  {{ $amount_hosp == 0 ? 'bg-danger ' : '' }}">
                                    {{ $amount_hosp == 0 ? '-' : app_format_number($amount_hosp, 1) }}
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="text-uppercase text-bold">PRIVE AMBULANT</td>
                            @foreach ($months as $month)
                                @php
                                    $amount_amb = 0;
                                @endphp
                                <td class="text-right money_format {{ $amount_amb == 0 ? 'bg-danger ' : '' }}">
                                    {{ $amount_amb == 0 ? '-' : app_format_number($amount_amb, 1) }}
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="text-uppercase text-bold bg-primary">TOTAL</td>
                            @foreach ($months as $month)
                                <td class="text-right money_format">
                                    {{ $total == 0 ? '-' : app_format_number($total, 1) }}
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </x-content.main-content-page>

</div>
