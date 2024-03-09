<div class="mx-2">
    @livewire('application.product.invoice.form.product-invoice-create-and-update')
    @livewire('application.product.invoice.list.list-invoice-by-date')
    <x-navigation.bread-crumb icon='fas fa-capsules' label='FACTURATION AMBULATOIRE' color='text-secondary'>
        <x-navigation.bread-crumb-item label='Dashboard' link='dashboard' isLinked=true />
        <x-navigation.bread-crumb-item label='Facturation ambulatoire' />
    </x-navigation.bread-crumb>
    <x-content.main-content-page>
        <div class="row">
            <div class="col-md-2">
                @if ($productInvoice && $isEditing)
                    <div class="p-1 rounded bg-info mt-1"
                    style="cursor: pointer;" wire:click='openNewProductInvoice'>
                        <div class="text-center">
                            <h4><i class="fas fa-pen    "></i> Editer</h4>
                        </div>
                    </div>
                    <div class=" bg-dark rounded bg-secondary p-1 mt-1" style="cursor: pointer"
                        wire:click='openListListProductInvoice'>
                        <div class="text-center">
                            <h4><i class="far fa-folder-open"></i> Mes factures</h4>
                        </div>
                    </div>

                    @if ($productInvoice->is_valided == false && $productInvoice)
                        <div class="rounded bg-pink p-1 mt-1" style="cursor: pointer"
                            wire:click='setProductInvoiceToNull' wire:confirm="Etes-vous d'annuler?">
                            <div class="text-center">
                                <h4><i class="far fa-times-circle"></i> Annuler</h4>
                            </div>
                        </div>
                        <div class="rounded bg-danger p-1 mt-1" style="cursor: pointer"
                            wire:click='deleteProductInvoice' wire:confirm="Etes-vous de supprimer?">
                            <div class="text-center">
                                <h4><i class="fa fa-trash"></i> Supprimer</h4>
                            </div>
                        </div>
                    @else
                        <div class="rounded bg-primary p-1 mt-1" style="cursor: pointer"
                            wire:click='setProductInvoiceToNull' wire:confirm="Etes-vous d'annuler?">
                            <div class="text-center">
                                <h4><i class="fa fa-check-double"></i> Terminer</h4>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="p-1 rounded bg-secondary" style="cursor: pointer;" wire:click='openNewProductInvoice'>
                        <div class="text-center">
                            <h4><i class="fa fa-plus " aria-hidden="true"></i> Créer...</h4>
                        </div>
                    </div>
                    <div class=" bg-dark rounded bg-secondary p-1 mt-1" style="cursor: pointer"
                        wire:click='openListListProductInvoice'>
                        <div class="text-center">
                            <h4><i class="far fa-folder-open"></i> Mes factures</h4>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-md-10">
                @if ($productInvoice)
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card {{ $isEditing == true ? 'bg-navy' : 'bg-indigo' }}">
                                @include('components.widget.outpatientbill.product-invoice-info', [
                                    'productInvoice' => $productInvoice,
                                ])
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    @livewire('application.product.invoice.list.list-product-to-make-invoice', [
                                        'productInvoice' => $productInvoice,
                                    ])
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-indigo p-2 ">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4> RECETTE/JOUR</h4>
                                        <h3 class="text-bold">Total: {{ app_format_number($totalInvoice, 1) }} Fc</h3>
                                    </div>
                                    <h1 class="mr-4"><i class="fa fa-hand-holding-usd"></i></h1>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    @livewire('application.product.invoice.list.list-items-invoice', [
                                        'productInvoice' => $productInvoice,
                                    ])
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="d-flex justify-content-center">
                        <h3 class="mt-4 text-success"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                            Veuillez créer
                            une facture SVP</h3>
                    </div>
                @endif
            </div>
        </div>
    </x-content.main-content-page>
    @push('js')
        <script type="module">
            //Open edit sheet modal
            window.addEventListener('open-form-product-invoice', e => {
                $('#form-product-invoice').modal('show')
            });
            //Open edit sheet modal
            window.addEventListener('open-list-product-invoice-by-date-modal', e => {
                $('#list-product-invoice-by-date-modal').modal('show')
            });
        </script>
    @endpush
</div>
