<x-print-layout>
    <div class="text-center"><img src="{{ public_path('entete.png') }}" alt="Heder Image"></div>
    <h2 class="text-center text-bold mt-2">GRILLE TARIFAIRE {{ $categoryTarif ? $categoryTarif->name : '' }} </h2>

    <div class="h4 text-secondary text-left">CONSULTATION</span></div>
    <table class="table table-striped table-sm">
        <thead class="table-dark">
            <tr class="border border-1">
                <th class="text-center">#</th>
                <th>DESIGNATION</th>
                @if ($type_data == 'all')
                    <th class="text-right">PRIX PRIVE USD</th>
                    <th class="text-right">PRIX ABONNE USD</th>
                @elseif ($type_data == 'private')
                    <th class="text-right">PRIX PRIVE USD</th>
                @else
                    <th class="text-right">PRIX ABONNE USD</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($consultations as $index => $consultations)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $consultations->name }}</td>
                    @if ($type_data == 'all')
                        <td class="text-right">{{ $consultations->price_private }}</td>
                        <td class="text-right">{{ $consultations->subscriber_price }}</td>
                    @elseif ($type_data == 'private')
                        <td class="text-right">{{ $consultations->price_private }}</td>
                    @else
                        <td class="text-right">{{ $consultations->subscriber_price }}</td>
                    @endif

                </tr>
            @endforeach
        </tbody>
    </table>
    @if ($categoryTarif == null)
        @foreach ($categoryTarifs as $index => $categoryData)
            <div class="h4 text-secondary text-left"><span>{{ $index + 1 }}.{{ $categoryData->name }}</span></div>
            <table class="table table-striped table-sm">
                <thead class="table-dark">
                    <tr class="border border-1">
                        <th class="text-center">#</th>
                        <th>DESIGNATION</th>
                        @if ($type_data == 'all')
                            <th class="text-right">PRIX PRIVE USD</th>
                            <th class="text-right">PRIX ABONNE USD</th>
                        @elseif ($type_data == 'private')
                            <th class="text-right">PRIX PRIVE USD</th>
                        @else
                            <th class="text-right">PRIX ABONNE USD</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categoryData->tarifs()->orderBy('name', 'ASC')->where('is_changed', false)->get() as $index => $tarif)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $tarif->name }}</td>
                            @if ($type_data == 'all')
                                <td class="text-right">{{ $tarif->price_private }}</td>
                                <td class="text-right">{{ $tarif->subscriber_price }}</td>
                            @elseif ($type_data == 'private')
                                <td class="text-right">{{ $tarif->price_private }}</td>
                            @else
                                <td class="text-right">{{ $tarif->subscriber_price }}</td>
                            @endif

                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach
    @else
        <table class="table table-striped table-sm">
            <thead class="table-dark">
                <tr class="border border-1">
                    <th class="text-center">#</th>
                    <th>DESIGNATION</th>
                    <th class="text-right">PRIX PRIVE USD</th>
                    <th class="text-right">PRIX ABONNE USD</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categoryTarif->tarifs as $index => $tarif)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $tarif->name }}</td>
                        <td class="text-right">{{ $tarif->price_private }}</td>
                        <td class="text-right">{{ $tarif->subscriber_price }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    <div class="h4 text-secondary text-left">HOSPITALISATION</span></div>
    <table class="table table-striped table-sm">
        <thead class="table-dark">
            <tr class="border border-1">
                <th class="text-center">#</th>
                <th>DESIGNATION</th>
                @if ($type_data == 'all')
                    <th class="text-right">PRIX PRIVE USD</th>
                    <th class="text-right">PRIX ABONNE USD</th>
                @elseif ($type_data == 'private')
                    <th class="text-right">PRIX PRIVE USD</th>
                @else
                    <th class="text-right">PRIX ABONNE USD</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($hospitalizations as $index => $hospitalizations)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $hospitalizations->name }}</td>
                    @if ($type_data == 'all')
                        <td class="text-right">{{ $hospitalizations->price_private }}</td>
                        <td class="text-right">{{ $hospitalizations->subscriber_price }}</td>
                    @elseif ($type_data == 'private')
                        <td class="text-right">{{ $hospitalizations->price_private }}</td>
                    @else
                        <td class="text-right">{{ $hospitalizations->subscriber_price }}</td>
                    @endif

                </tr>
            @endforeach
        </tbody>
    </table>

</x-print-layout>
