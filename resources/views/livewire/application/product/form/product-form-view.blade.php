<div>
    <x-modal.build-modal-fixed
        idModal='form-product' bg="bg-pink"
        size='lg' headerLabel="{!!$product==null?'CREER UN NOUVEAU PRODUIT':'METTRE A JOUR FICHE UN PRODUIT' !!}"
        headerLabelIcon='fa fa-folder-plus'>
        <form wire:submit='handlerSubmit'>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <x-form.label value="{{ __('N° Lot') }}" />
                        <x-form.input type='text' wire:model.blur='form.butch_number' :error="'form.butch_number'" />
                        <x-errors.validation-error value='form.butch_number' />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <x-form.label value="{{ __('Nom du produit') }}" />
                        <x-form.input type='text' wire:model.blur='form.name' :error="'form.name'" />
                        <x-errors.validation-error value='form.name' />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <x-form.label value="{{ __('Prix unitaire') }}" />
                        <x-form.input type='text' wire:model.blur='form.price' :error="'form.price'" />
                        <x-errors.validation-error value='form.price' />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <x-form.label value="{{ __('Quantité initiale') }}" />
                        <x-form.input type='text' wire:model.blur='form.initial_quantity' :error="'form.initial_quantity'" />
                        <x-errors.validation-error value='form.initial_quantity' />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">


                    <div class="form-group">
                        <x-form.label value="{{ __('Date Expiration') }}" />
                        <x-form.input type='date' wire:model.blur='form.expiration_date' :error="'form.expiration_date'" />
                        <x-errors.validation-error value='form.expiration_date' />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <x-form.label value="{{ __('Categorie') }}" />
                        <x-widget.list-product-category-widget wire:model.live="form.product_category_id" :error="'form.product_category_id'"/>
                        <x-errors.validation-error value='form.product_category_id' />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <x-form.label value="{{ __('Famille') }}" />
                        <x-widget.list-product-family-widget wire:model.live="form.product_family_id" :error="'form.product_family_id'"/>
                        <x-errors.validation-error value='form.product_family_id' />
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <x-form.button class="btn-secondary" type='submit'><i class="fa fa-save"></i> Sauvegarder</x-form.button>
            </div>
        </form>
    </x-modal.build-modal-fixed>
    @push('js')
        <script type="module">
            //Open create new sheet modal
            window.addEventListener('close-product-form',e=>{
                $('#form-product').modal('hide')
            });
        </script>
    @endpush
</div>
