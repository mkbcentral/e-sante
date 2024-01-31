<div>
    <x-modal.build-modal-fixed idModal='edit-product-supply-model' size='md' headerLabel="EDITER LA DEMANDE"
        headerLabelIcon='fa fa-folder-plus'>
        <form wire:submit='update'>
            @if ($productSupply != null)
                <div class="card p-2">
                    <div class="form-group">
                        <x-form.label value="{{ __('Date création') }}" />
                        <x-form.input type='date' wire:model.blur='created_at' :error="'created_at'" />
                        <x-errors.validation-error value='created_at' />
                    </div>
                    <div class=" d-flex justify-content-end">
                        <x-form.button class="btn-primary" type='submit'>
                            <div wire:loading wire:target='update' class="spinner-border spinner-border-sm text-white" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <i class="fa fa-save"></i>
                            Sauvegarder
                        </x-form.button>
                    </div>
                </div>
            @endif
        </form>
    </x-modal.build-modal-fixed>
    @push('js')
        <script type="module">
            //Open edit sheet modal
            window.addEventListener('close-edit-product-supply-model', e => {
                $('#edit-product-supply-model').modal('hide')
            });
        </script>
    @endpush
</div>
