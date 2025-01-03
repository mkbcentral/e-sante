<div>
    <x-modal.build-modal-fixed idModal='list-outpatient-bill-by-date-modal' size='xl' bg='bg-navy'
        headerLabel="LISTE DES FACTURES" headerLabelIcon='fa fa-file'>
        <div>
            <div class="d-flex justify-content-between align-content-center">
                <div class="bg-navy p-1 rounded-lg pr-2">
                    <h3 wire:loading.class="d-none"><i class="fas fa-coins ml-2"></i><span>Recettes</span>
                        <span class="money_format">CDF: {{ app_format_number($tota_cdf, 1) }}</span> |
                        <span class="money_format">USD: {{ app_format_number($tota_usd, 1) }}</span>
                    </h3>
                </div>
                <div class="d-flex align-items-center">
                    <div class="d-flex align-items-center mr-2">
                        <x-form.label value="{{ __('Date') }}" class="mr-1" />
                        <x-form.input type='date' wire:model.live='date_filter' :error="'date_filter'" />
                    </div>
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
                            <th class="text-right">MT USD</th>
                            <th class="text-right">MT CDF</th>
                            <th class="text-center">STATUS</th>
                            <th class="text-lg-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($listBill->isEmpty())
                            <tr>
                                <td colspan="9" class="text-center"> <x-errors.data-empty /></td>
                            </tr>
                        @else
                            @foreach ($listBill as $index => $bill)
                                <tr style="cursor: pointer;" id="row1">
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $bill->created_at->format('d-m-Y H:i:s') }}</td>
                                    <td>{{ $bill->bill_number }}</td>
                                    <td>{{ $bill->client_name }}</td>
                                    <td class="text-right money_format">
                                        @if ($bill->currency != null)
                                            @if ($bill->currency->name == 'USD')
                                                {{ app_format_number($bill->getTotalOutpatientBillUSD(), 1) }}
                                            @else
                                                -
                                            @endif
                                        @else
                                            @if ($bill->detailOutpatientBill)
                                                {{ app_format_number($bill->detailOutpatientBill->amount_usd, 1) }}
                                            @else
                                                -
                                            @endif
                                        @endif

                                    </td>
                                    <td class="text-right money_format">
                                        @if ($bill->currency)
                                            @if ($bill->currency->name == 'CDF')
                                                {{ app_format_number($bill->getTotalOutpatientBillCDF(), 1) }}
                                            @else
                                                -
                                            @endif
                                        @else
                                            @if ($bill->detailOutpatientBill)
                                                {{ app_format_number($bill->detailOutpatientBill->amount_cdf, 1) }}
                                            @else
                                                -
                                            @endif
                                        @endif

                                    </td>
                                    <td class="text-center  {{ !$bill->is_validated ? '' : 'bg-success ' }}">
                                        {{ !$bill->is_validated ? 'En cours' : 'Terminé' }}
                                    </td>
                                    <td class="text-center">
                                        <x-form.edit-button-icon wire:click="edit({{ $bill }})"
                                            class="btn-sm btn-primary" />
                                        @if (!$bill->is_validated)
                                            <a wire:click='printBill({{ $bill }})'
                                                href="{{ route('outPatientBill.print', [$bill, $currencyName]) }}"
                                                class="btn btn-sm  btn-secondary" target="_blanck"><i
                                                    class="fa fa-print  " aria-hidden="true"></i></a>
                                            <x-form.delete-button-icon wire:confirm="Etes-vous de supprimer?"
                                                wire:click="delete({{ $bill }})" class="btn-sm btn-danger" />
                                        @else
                                            <x-form.button wire:click="changeStatus({{ $bill }})"
                                                class="btn-sm btn-warning">
                                                <i class="fa fa-times-circle" aria-hidden="true"></i>
                                            </x-form.button>
                                        @endif


                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="mt-4 d-flex justify-content-between align-items-center">
                    <div class="h5">
                        ({{ $counter_by_month > 1 ? $counter_by_month . ' Facture réalisée' : $counter_by_month . ' Factured réalisées' }})
                    </div>
                    {{ $listBill->links('livewire::bootstrap') }}
                </div>
            </div>
        </div>
    </x-modal.build-modal-fixed>
    @push('js')
        <script type="module">
            //Open edit sheet modal
            window.addEventListener('close-list-outpatient-bill-by-date-modal', e => {
                $('#list-outpatient-bill-by-date-modal').modal('hide')
            });
        </script>
    @endpush
</div>
