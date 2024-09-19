<div>
    <x-modal.build-modal-fixed idModal='form-stock-service-product' bg="bg-pink" size='md'
        headerLabel="AJOUTER UN PRODUIT" headerLabelIcon='fa fa-folder-plus'>
       <div class="d-lg-flex justify-content-center">
         <x-widget.loading-circular-md wire:target='addProduct' />
       </div>
        <form wire:submit='addProduct'>
            <div class="form-group">
                <label for="my-select">Product</label>
                <select id="my-select" class="form-control" name="product_id" wire:model.blur='product_id'>
                    <option >Choisir...</option>
                    @foreach ($peoducts as $peoduct)
                        <option value="{{ $peoduct->id }}">{{ $peoduct->name }}</option>
                    @endforeach
                </select>
                <x-errors.validation-error value='product_id' />
            </div>
            <div class="form-group">
                <x-form.label value="{{ __('Quatinté') }}" />
                <x-form.input type='number' wire:model.blur='qty' :error="'qty'" />
                <x-errors.validation-error value='qty' />
            </div>
            <div class="d-flex justify-content-end">
                <x-form.button class="btn-secondary" type='submit'><i class="fa fa-save"></i>
                    Sauvegarder</x-form.button>
            </div>
        </form>
    </x-modal.build-modal-fixed>
    @push('js')
        <script type="module">
            //Open create new sheet modal
            window.addEventListener('close-stock-service-product', e => {
                $('#form-stock-service-product').modal('hide')
            });
        </script>
    @endpush
</div>
