<div>
    <x-modal.build-modal-fixed idModal='form-quntity-product-invoice' size='md' headerLabel="QUANTITE"
        headerLabelIcon='fa fa-capsules'>
        <form wire:submit='addProductToInvoice'>
            @if ($product != null)
                <div class="card p-2">
                    <h6><span class="text-primary h4 text-bold">Produit: </span>  {{ $product->name }}</h6>
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
        </form>
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
