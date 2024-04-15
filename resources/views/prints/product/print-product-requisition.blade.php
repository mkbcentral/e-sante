<x-print-layout>
    <div class="text-center"><img src="{{ public_path('entete.png') }}" alt="Heder Image"></div>
    <h4 class="text-center text-bold mt-2">REQUISITION PRODUCT</h4>
    <div class="text-left">
        <span class=" mt-2"><span class="text-bold">N°:</span> {{ $productRequisition->number }}</span><br>
        <span><span class="text-bold">Service:</span> {{ $productRequisition->agentService->name }}</span><br>
        <span><span class="text-bold">Date:</span> {{ $productRequisition->created_at->format('d/m/Y') }}</span><br>
        <span><span class="text-bold">Products:</span> {{ $productRequisition->productRequistionProducts->count() }}</span>
    </div>
    <table class="table table-striped table-sm">
        <thead class="table-dark">
            <tr class="">
                <th>#</th>
                <th>DESIGNATION</th>
                <th class="text-right">Q.T DISPO</th>
                <th class="text-right">Q.T LIVREE</th>
            </tr>
        </thead>
        <tbody>
            @foreach ( $productRequisition->productRequistionProducts as $index => $productRequisitionProduct)
                <tr>
                    <td>{{ $index+1 }}</td>
                    <td>{{ $productRequisitionProduct->product->name }}</td>
                    <td class="text-right">{{ $productRequisitionProduct->quantity_available }}</td>
                    <td class="text-right">{{ $productRequisitionProduct->quantity }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-print-layout>
