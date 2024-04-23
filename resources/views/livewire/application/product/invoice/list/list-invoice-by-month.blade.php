<div class="card card-primary card-outline py-2 px-4">
    <div class="d-flex justify-content-between align-items-center mt-2 ">
        <div class="d-flex align-items-center">
            <h3 class="ml-2 text-uppercase text-bold text-indigo">Total: {{ app_format_number($totalInvoice, 1) }} Fc
            </h3>
        </div>

    </div>
    <div class="d-flex justify-content-center pb-2">
        <x-widget.loading-circular-md />
    </div>

    <div wire:loading.class='d-none'>
        <div class="d-flex justify-content-between items-center">
            <div class="d-flex">
                <div class="form-group d-flex align-items-center">
                    <x-form.label value="{{ __('Date') }}" class="mr-2" />
                    <x-form.input type='date' wire:model.live='date_filter' :error="'date_filter'" />
                </div>
                <div class="form-group d-flex align-items-center">
                    <x-form.label value="{{ __('Mois') }}" class="mr-2 ml-2" />
                    <x-widget.list-french-month wire:model.live='month' :error="'month'" />
                </div>
            </div>
            <div class="d-flex align-items-center">
                <div class="form-group d-flex align-items-center ml-2">
                    <x-form.label value="{{ __('Date versment') }}" class="mr-1" />
                    <x-form.input type='date' wire:model.live='date_versement' :error="'date_versement'" />
                </div>
                <div>
                    @if ($isByDate == true)
                        <a href="{{ route('product.invoice.rapport.date.print', [$date_filter,$date_versement,$isByDate]) }}" target="_blank"
                            class="ml-2"><i class="fa fa-print" aria-hidden="true"></i> Imprimer</a>
                    @else
                        <a href="{{ route('product.invoice.rapport.month.print', [$month,$date_versement,$isByDate]) }}" target="_blank"
                            class="ml-2"><i class="fa fa-print" aria-hidden="true"></i> Imprimer</a>
                    @endif
                </div>
            </div>
        </div>
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
