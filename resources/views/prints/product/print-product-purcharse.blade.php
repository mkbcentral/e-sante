<x-print-layout>
    <div class="text-center"><img src="{{ public_path('entete.png') }}" alt="Heder Image"></div>
    <h4 class="text-center text-bold mt-2">REQUISITION ACHAT MEDICAMENTS</h4>
    <div class="text-left">
        <div><span class="text-bold">Mois:</span> {{ $productPurchase->created_at->format('M') }}</div>
        <div><span class="text-bold4">Nbre:</span> {{ $productPurchase->products->count() }}</div>
    </div>
    <table class="table table-striped table-sm">
        <thead class="table-dark">
            <tr class="border border-1">
                <th>#</th>
                <th>DESIGNATION</th>
                <th class="text-center">QUANTITE INIT</th>
                <th class="text-center">QUANTITE DMD</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($productPurchase->products as $index => $product)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $product->name }}</td>
                    <td
                        class="text-center
                                {{ $product->pivot->quantity_stock <= 5 ? 'bg-danger ' : $product->pivot->quantity_stock }}">
                        {{ $product->pivot->quantity_stock }}</td>
                    <td class="text-center">
                        {{ $product->pivot->quantity_to_order }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="text-right mt-4">Fait, Lubumabshi, Le {{ date('d/m/Y') }}</div>
</x-print-layout>
