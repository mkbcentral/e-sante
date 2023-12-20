<div>
    @livewire('application.finance.billing.form.create-outpatient-bill')
    <x-navigation.bread-crumb icon='fa fa-file' label='FACTURATION AMBULATOIRE' color='text-secondary'>
        <x-navigation.bread-crumb-item label='Dashboard' link='dashboard' isLinked=true />
        <x-navigation.bread-crumb-item label='Facturation ambulatoire' />
    </x-navigation.bread-crumb>
    <x-content.main-content-page>
        <div class="row">
            <div class="col-md-2">
                <div class="p-1 rounded bg-secondary" 
                    style="cursor: pointer; background-color:rgba(4, 21, 48, 0.267);"
                    wire:click='openNewOutpatientBillModal'>
                    <div class="text-center">
                        <h4><i class="fa fa-plus " aria-hidden="true"></i> Créer...</h4>
                    </div>
                </div>
                <div class=" bg-dark card p-1 mt-1" style="cursor: pointer" wire:click='openNewOutpatientBillModal'>
                    <div class="text-center">
                        <h4><i class="far fa-folder-open"></i> Mes factures</h4>
                    </div>
                </div>
                @if ($outpatientBill != null)
                    <div class=" bg-pink card p-2">
                        <h3 class="text-bold ">TOTAL <i class="far fa-sack-dollar"></i></h4>
                            <ul>
                                <li>
                                    <h4 class="text-bold">
                                        @livewire('application.finance.billing.form.widget.usd-amount-outpatient-bill-widget', [
                                            'outpatientBill' => $outpatientBill,
                                        ])$
                                    </h4>
                                </li>
                                <li>
                                    <h4 class="text-bold">
                                        @livewire('application.finance.billing.form.widget.cdf-amount-outpatient-bill-widget', [
                                            'outpatientBill' => $outpatientBill,
                                        ]) Fc
                                    </h4>
                                </li>
                            </ul>
                    </div>
                @endif
            </div>
            <div class="col-md-6">
                @if ($outpatientBill != null)
                    @livewire('application.finance.billing.form.create-outpatient-items', [
                        'outpatientBill' => $outpatientBill,
                    ])
                @endif
            </div>
            <div class="col-md-4">
                @if ($outpatientBill != null)
                    @livewire('application.finance.billing.list.list-items-tarif-outpatient-bill', [
                        'outpatientBill' => $outpatientBill,
                    ])
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
        </script>
    @endpush
</div>
