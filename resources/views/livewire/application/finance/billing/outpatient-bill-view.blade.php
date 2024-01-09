<div class="mx-2">
    @livewire('application.finance.billing.form.create-outpatient-bill')
    @livewire('application.finance.billing.list.list-outpatient-bill-by-date')
    <x-navigation.bread-crumb icon='fas fa-file-invoice-dollar' label='FACTURATION AMBULATOIRE' color='text-secondary'>
        <x-navigation.bread-crumb-item label='Dashboard' link='dashboard' isLinked=true />
        <x-navigation.bread-crumb-item label='Facturation ambulatoire' />
    </x-navigation.bread-crumb>
    <x-content.main-content-page>
        <div class="row">
            <div class="col-md-2">
                @if ($isEditing)
                    <div class="p-1 rounded bg-blue" style="cursor: pointer;" wire:click='openNewOutpatientBillModal'>
                        <div class="text-center">
                            <h4><i class="fas fa-pen    "></i> Editer</h4>
                        </div>
                    </div>
                @else
                    <div class="p-1 rounded bg-secondary" style="cursor: pointer;"
                        wire:click='openNewOutpatientBillModal'>
                        <div class="text-center">
                            <h4><i class="fa fa-plus " aria-hidden="true"></i> Créer...</h4>
                        </div>
                    </div>
                @endif

                <div class=" bg-dark rounded bg-secondary p-1 mt-1" style="cursor: pointer"
                    wire:click='openListListOutpatientBillModal'>
                    <div class="text-center">
                        <h4><i class="far fa-folder-open"></i> Mes factures</h4>
                    </div>
                </div>
                @if ($outpatientBill != null)
                    <div class=" bg-indigo rounded bg-secondary p-1 mt-1" style="cursor: pointer"
                        wire:click='openListListOutpatientBillModal'>
                        <div class="text-center">
                            <h4><i class="fa fa-print"></i> Imprimer</h4>
                        </div>
                    </div>
                @endif
                <a class="mt-2" href="{{ route('bill.outpatient.rapport') }}" wire:navigate>
                    <div class=" bg-danger rounded bg-secondary p-1 mt-2">
                        <div class="text-center">
                            <h4><i class="far fa-folder"></i> Rapport</h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                @if ($outpatientBill != null)
                    @livewire('application.finance.billing.form.create-outpatient-items', [
                        'outpatientBill' => $outpatientBill,
                    ])
                    @else
                    <div class="d-flex justify-content-center">
                        <h3 class="mt-4 text-success"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                            Veuillez créer
                            une facture SVP</h3>
                    </div>
                @endif
            </div>
            <div class="col-md-4">
                @if ($outpatientBill != null)
                    @livewire('application.finance.billing.list.list-items-tarif-outpatient-bill', [
                        'outpatientBill' => $outpatientBill,
                    ])
                    <div class="small-box bg-indigo">
                        <div class="inner">
                            <h3 class="text-bold">TOTAL FACTURE <i class="far fa-sack-dollar"></i></h4>
                                <ul>
                                    <li>
                                        <h4 class="text-bold">
                                            @livewire('application.finance.billing.widget.usd-amount-outpatient-bill-widget', [
                                                'outpatientBill' => $outpatientBill,
                                            ])$
                                        </h4>
                                    </li>
                                    <li>
                                        <h4 class="text-bold">
                                            @livewire('application.finance.billing.widget.cdf-amount-outpatient-bill-widget', [
                                                'outpatientBill' => $outpatientBill,
                                            ]) Fc
                                        </h4>
                                    </li>
                                </ul>
                        </div>
                        <div class="icon">
                            <i class="fas fa-money-check-alt text-gray"></i>
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </x-content.main-content-page>
    @push('js')
        <script type="module">
            //Open edit sheet modal
            window.addEventListener('open-new-outpatient-bill', e => {
                $('#form-new-outpatient-bill').modal('show')
            });
            //Open edit sheet modal
            window.addEventListener('open-list-outpatient-bill-by-date-modal', e => {
                $('#list-outpatient-bill-by-date-modal').modal('show')
            });
        </script>
    @endpush
</div>
