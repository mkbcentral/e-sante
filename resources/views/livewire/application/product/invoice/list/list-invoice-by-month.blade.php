<div class="card card-primary card-outline py-2 px-4">
    <div class="d-flex justify-content-between align-items-center mt-2 ">
        <div class="d-flex align-items-center">
            <div>
                <x-widget.list-fr-months wire:model.live='month' :error="'month'" />
            </div>
            <h3 class="ml-4 text-bold text-indigo">Total: {{ app_format_number($totalInvoice, 1) }} Fc
            </h3>
        </div>
        <a href="" class="mr-2"><i class="fa fa-print" aria-hidden="true"></i> Imprimer</a>
    </div>
    <div class="d-flex justify-content-center pb-2">
        <x-widget.loading-circular-md />
    </div>

    <div wire:loading.class='d-none'>
        <h4 class="text-uppercase text-secondary mt-2">Liste ventes mensuelles</h4>
        <table class="table table-bordered table-sm">
            <thead class="bg-indigo">
                <tr>
                    <th class="text-center">#</th>
                    <th>Date</th>
                    <th>N° Fracture</th>
                    <th>Cleint</th>
                    <th class="text-right">Montant</th>
                </tr>
            </thead>
            <tbody>
                @if ($listInvoices->isEmpty())
                <tr>
                    <td colspan="6" class="text-center">
                        <x-errors.data-empty />
                    </td>
                </tr>
                @else
                @foreach ($listInvoices as $index => $invoice)
                <tr style="cursor: pointer;" id="row1">
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $invoice->created_at->format('d/M/Y') }}</td>
                    <td>{{ $invoice->number }}</td>
                    <td>{{ $invoice->client }}</td>
                    <td class="text-right">
                        {{ app_format_number($invoice->getTotalInvoice(), 1) }} Fc
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
