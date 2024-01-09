<div>
    <x-modal.build-modal-fixed idModal='list-product-invoice-by-date-modal' size='lg' bg='bg-pink'
        headerLabel="LISTE DES FACTURES" headerLabelIcon='fa fa-file'>
        <div>
            <div class="d-flex justify-content-between align-content-center">
                <div>
                    <h3 wire:loading.class="d-none">Total: {{ app_format_number($totalInvoice, 1) }} Fc
                    </h3>
                </div>
                <div class="d-flex align-items-center mr-2">
                    <x-form.label value="{{ __('Date') }}" class="mr-1" />
                    <x-form.input type='date' wire:model.live='date_filter' :error="'date_filter'" />
                </div>
            </div>
            <div class="d-flex justify-content-center pb-2">
                <x-widget.loading-circular-md />
            </div>

            <div wire:loading.class='d-none'>
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Date</th>
                            <th>N° Fracture</th>
                            <th>Cleint</th>
                            <th class="text-right">Montant</th>
                            <th class="text-lg-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($listInvoices->isEmpty())
                            <tr>
                                <td colspan="6" class="text-center"><x-errors.data-empty /></td>
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
                                    <td class="text-center">
                                        <x-form.edit-button-icon wire:click="edit({{$invoice}})" class="btn-sm" />
                                        <x-form.delete-button-icon wire:confirm="Etes-vous de supprimer?"
                                            wire:click="delete({{ $invoice }})" class="btn-sm" />
                                        <a href="#"><i class="fa fa-print" aria-hidden="true"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </x-modal.build-modal-fixed>
    @push('js')
        <script type="module">
            //Open edit sheet modal
            window.addEventListener('close-list-product-invoice-by-date-modal', e => {
                $('#list-product-invoice-by-date-modal').modal('hide')
            });
        </script>
    @endpush
</div>
