<div>
    <x-modal.build-modal-fixed idModal='form-quntity-product-invoice' size='md' headerLabel="QUANTITE"
        headerLabelIcon='fa fa-capsules'>
        <div class="d-flex justify-content-center">
            <x-widget.loading-circular-md />
        </div>
        @if ($productInvoice)
            <form wire:submit='addProductToInvoice'>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Client: {{ $productInvoice->client }}</h5>
                    </div>
                </div>
                @if ($product != null)
                    @if ($product->getAmountStockGlobal() <= 0)
                        <div class="text-center">
                            <h3 class="text-bold text-danger">
                                <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error
                            </h3>
                            <h3 class="text-bold text-danger">
                                {{ $product->name }} Stock insufisant
                            </h3>
                        </div>
                    @else
                        <div class="card p-2">
                            <h6><span class="text-primary h4 text-bold">Produit: </span> {{ $product->name }}</h6>
                            <div class="form-group">
                                <x-form.label value="{{ __('Quantité') }}" />
                                <x-form.input type='number' wire:model.blur='quantity' :error="'quantity'" />
                                <x-errors.validation-error value='quantity' />
                            </div>

                            <div class="d-flex justify-content-end">
                                <x-form.button class="btn-primary" type='submit'><i class="fa fa-save"></i> Sauvegarder
                                </x-form.button>
                            </div>
                        </div>
                    @endif

                @endif

            </form>
        @endif

    </x-modal.build-modal-fixed>
    @push('js')
        <script type="module">
            //Open edit sheet modal
            window.addEventListener('close-form-quntity-product-invoice', e => {
                $('#form-quntity-product-invoice').modal('hide')
            });
        </script>
    @endpush
</div>
