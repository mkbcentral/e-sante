<div>
    <x-modal.build-modal-fixed idModal='list-outpatient-bill-by-date-modal' size='lg' bg='bg-pink'
        headerLabel="LISTE DES FACTURES" headerLabelIcon='fa fa-file'>
        <div>
            <div class="d-flex justify-content-between align-content-center">
                <div >
                    <h3 wire:loading.class="d-none">Total: {{ app_format_number($totalBills, 1) }} {{ $currencyName }}</h3>
                </div>
                <div class="d-flex align-items-center">
                    <div class="d-flex align-items-center mr-2">
                        <x-form.label value="{{ __('Date') }}" class="mr-1" />
                        <x-form.input type='date' wire:model.live='date_filter' :error="'date_filter'" />
                    </div>
                    <div class="d-flex align-items-center">
                        <x-form.label value="{{ __('Devise') }}" class="mr-1" />
                        @livewire('application.finance.widget.currency-widget')
                    </div>
                </div>

            </div>
            <div class="d-flex justify-content-center pb-2">
                <x-widget.loading-circular-md />
            </div>
            <div wire:loading.class='d-none'>
                <table class="table table-borderless table-sm table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>N° Fracture</th>
                            <th>Cleint</th>
                            <th class="text-right">Montant</th>
                            <th class="text-lg-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($listBill->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center">Aucune données trpuvée</td>
                            </tr>
                        @else
                            @foreach ($listBill as $index => $bill)
                                <tr style="cursor: pointer;" id="row1" wire:click="edit({{ $bill }})">
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $bill->bill_number }}</td>
                                    <td>{{ $bill->client_name }}</td>
                                    <td class="text-right">
                                        {{ $currencyName == 'CDF'
                                            ? app_format_number($bill->getTotalOutpatientBillCDF(), 1) . 'Fc'
                                            : app_format_number($bill->getTotalOutpatientBillUSD(), 0) . '$' }}
                                    </td>
                                    <td class="text-center">
                                        <x-form.delete-button-icon wire:confirm="Etes-vous de supprimer?"
                                            wire:click="delete({{ $bill }})" class="btn-sm" />
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
            window.addEventListener('close-list-outpatient-bill-by-date-modal', e => {
                $('#list-outpatient-bill-by-date-modal').modal('hide')
            });
        </script>
    @endpush
</div>
