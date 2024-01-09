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
                @if ($isEditing)
                <div class="p-1 rounded bg-indigo" style="cursor: pointer;" wire:click='newInvoice'>
                    <div class="text-center">
                        <h4><i class="fa fa-plus-circle" aria-hidden="true"></i> Nouveau</h4>
                    </div>
                </div>
                <div class="p-1 rounded bg-blue mt-1" style="cursor: pointer;" wire:click='openNewProductInvoice'>
                    <div class="text-center">
                        <h4><i class="fas fa-pen    "></i> Editer</h4>
                    </div>
                </div>
                @else
                <div class="p-1 rounded bg-secondary" style="cursor: pointer;" wire:click='openNewProductInvoice'>
                    <div class="text-center">
                        <h4><i class="fa fa-plus " aria-hidden="true"></i> Créer...</h4>
                    </div>
                </div>
                @endif
                <div class=" bg-dark rounded bg-secondary p-1 mt-1" style="cursor: pointer" wire:click='openListListProductInvoice'>
                    <div class="text-center">
                        <h4><i class="far fa-folder-open"></i> Mes factures</h4>
                    </div>
                </div>
                <div class="card mt-2 bg-indigo p-2">
                    <h4> RECETTE/JOUR</h4>
                    <h5 class="text-bold">Total: {{ app_format_number($totalInvoice, 1) }} Fc</h5>
                </div>
                <a href="{{ route('product.invoice.report') }}" wire:navigate>
                    <div class=" bg-danger rounded bg-secondary p-1">
                        <div class="text-center">
                            <h4><i class="far fa-folder"></i> Rapport</h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-10">
                @if ($productInvoice)
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card {{ $isEditing==true?'bg-indigo':'bg-pink' }}">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4 class="card-title"><span class="text-bold">N° Fact:
                                                </span>:{{ $productInvoice->number }}</h4><br>
                                            <h4 class="card-title"><span class="text-bold">Client:
                                                </span>:{{ $productInvoice->client }}</h4><br>
                                            <h4 class="card-title"><span class="text-bold">Date:
                                                </span>:{{ $productInvoice->created_at->format('d/m/Y') }}</h4>
                                        </div>
                                        <div>
                                            <h4 class="card-title"><span class="text-bold"><i class="fa fa-user" aria-hidden="true"></i>User:
                                                </span>:Use</h4><br>
                                        </div>
                                    </div>
                                </div>
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
                        <h3 class="mt-4 text-success"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Veuillez créer
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
