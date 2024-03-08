<x-print-layout>
    <div class="text-center"><img src="{{ public_path('entete.png') }}" alt="Heder Image"></div>
    <h4 class="text-center text-bold mt-2">BORDEREAU DE VERSEMENT PHARMACIE</h4>
    <h6 class="text-right">Fait à Lubumbashi, Le {{ $dateToMorrow->format('d/m/Y') }}</h6>
    <table class="table table-striped table-sm">
        <thead class="table-dark">
            <tr class="">
                <th class="text-center">#</th>
                <th>Date</th>
                <th class="text-center">N° FACT</th>
                <th>NOM CLIENT</th>
                <th class="text-right">MONTANT</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listInvoices as $index => $invoice)
                <tr style="cursor: pointer;" id="row1">
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="">{{ $invoice->created_at->format('d/m/Y') }}</td>
                    <td style="width: 80px" class="text-center">{{ $invoice->number }}-PS</td>
                    <td>{{ $invoice->client }}</td>
                    <td class="text-right">
                        {{ app_format_number($invoice->getTotalInvoice(), 1) }} Fc
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="5" class="text-right text-bold h4">Total: {{  app_format_number($totalInvoice, 1) }}</td>
            </tr>
        </tbody>
    </table>
    <table class="table table-light">
            <tr>
                <td>PHARMACIE</td>
                <td class="text-right">CAISSE</td>
            </tr>
            <tr>
                <td></td>
                <td class="text-right">GEORGETTE KAMWANYA</td>
            </tr>
        </table>
</x-print-layout>
