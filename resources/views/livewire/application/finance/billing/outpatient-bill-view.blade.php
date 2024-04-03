<div class="mx-2">
    @livewire('application.finance.billing.form.create-outpatient-bill')
    @livewire('application.finance.billing.list.list-outpatient-bill-by-date')
    @livewire('application.finance.billing.form.create-detail-outpatient-bill')
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
                <div class=" rounded bg-secondary p-1 mt-1" style="cursor: pointer"
                    wire:click='openListListOutpatientBillModal'>
                    <div class="text-center">
                        <h4><i class="far fa-folder-open"></i> Mes factures</h4>
                    </div>
                </div>
                @if ($outpatientBill && $outpatientBill->currency == null)
                    <div wire:click='openAddDetailFormModal' class=" bg-navy rounded  p-1 mt-1" style="cursor: pointer">
                        <div class="text-center">
                            <h4><i class="fas fa-funnel-dollar"></i> Regler M.T</h4>
                        </div>
                    </div>
                @endif
                @if ($outpatientBill != null)
                    <a wire:click='printBill'
                        href="{{ route('outPatientBill.print', [$outpatientBill, $currencyName]) }}" target="_blanck">
                        <div class=" bg-indigo rounded bg-secondary p-1 mt-1" style="cursor: pointer">
                            <div class="text-center">
                                <h4><i class="fa fa-print"></i> Imprimer</h4>
                            </div>
                        </div>
                    </a>
                    @if ($outpatientBill->is_validated==false)
                        <div wire:click='cancelBill' wire:confirm="Etes-vous d'annuler?" class=" bg-pink rounded  p-1 mt-1"
                        style="cursor: pointer">
                        <div class="text-center">
                            <h4><i class="fas fa-times-circle"></i> Annuler</h4>
                        </div>
                    </div>
                    <div wire:click='delete' wire:confirm="Etes-vous de supprimer?"
                        class=" bg-danger rounded  p-1 mt-1" style="cursor: pointer">
                        <div class="text-center">
                            <h4><i class="fas fa-trash"></i> Supprimer</h4>
                        </div>
                    </div>
                    @endif
                @endif
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
                    <div class="small-box bg-indigo">
                        <div class="d-flex justify-content-center pb-2 pt-2">
                            <x-widget.loading-circular-md />
                        </div>
                        <div class="inner">
                            <h4 class="text-bold">TOTAL FACTURE <i class="far fa-sack-dollar"></i></h4>
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
                            <i class="fas fa-money-check-alt text-white"></i>
                        </div>
                    </div>
                    @livewire('application.finance.billing.list.list-items-tarif-outpatient-bill', [
                        'outpatientBill' => $outpatientBill,
                    ])
                    @if ($outpatientBill->otherOutpatientBill != null)
                        <div class="card">
                            <div class="card-body">
                                <h5 class="text-secondary text-uppercase ">Autres détails non tarifié</h5>
                                <table class="table  table-bordered  table-sm ">
                                    <thead class="text-info text-uppercase">
                                        <th>Designation</th>
                                        <th class="text-right">Montant</th>
                                        <th class="text-center">Action</th>
                                    </thead>
                                    <tr class="text-bold">
                                        <td>{{ $outpatientBill->otherOutpatientBill->name }}</td>
                                        <td class="text-right">
                                            {{ app_format_number($currencyName == 'CDF' ? $outpatientBill->getOtherOutpatientBillPriceCDF() : $outpatientBill->getOtherOutpatientBillPriceUSD(), 1) . ' ' . $currencyName }}
                                        </td>
                                        <td class="text-center">
                                            <x-form.icon-button :icon="'fa fa-pen '" class="btn-sm btn-info"
                                                wire:click='OpenOtherDetailOutpatientBill' data-toggle="modal"
                                                data-target="#form-new-other-detail-outpatient-bill" />
                                        </td>
                                    </tr>
                                </table>
                            </div>
                    @endif
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
            //Open edit sheet modal
            window.addEventListener('open-detail-outpatient-bill', e => {
                $('#detail-outpatient-bill').modal('show')
            });
            //Open outpatient bill other details
            window.addEventListener('open-form-new-other-detail-outpatient-bill', e => {
                $('#form-new-other-detail-outpatient-bill').modal('show')
            });
        </script>
    @endpush
</div>
