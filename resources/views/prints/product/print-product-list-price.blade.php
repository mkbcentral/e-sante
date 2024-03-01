<x-print-layout>
    <div class="text-center"><img src="{{ public_path('entete.png') }}" alt="Heder Image"></div>
    <h4 class="text-center text-bold mt-2">LISTE DES PRIX DES MEDICAMENTS</h4>

    <table class="table table-striped table-sm">
        <thead class="table-dark">
            <tr class="">
                <th>#</th>
                <th>DESIGNATION</th>
                <th class="text-right">PRIX UNITAIRE</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $index => $product)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $product->name }}</td>
                    <td class="text-right">
                         {{app_format_number( $product->price,0) }} Fc
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
</x-print-layout>
