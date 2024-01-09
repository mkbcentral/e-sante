<div>
    <x-modal.build-modal-fixed idModal='form-product-invoice' size='md' headerLabel="{{ $modalLabel }}"
        headerLabelIcon='fa fa-file'>
        <form wire:submit='handlerSubmit'>
            <div class="card">
                <div class="d-flex justify-content-center pb-2">
                    <x-widget.loading-circular-md />
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <x-form.label value="{{ __('Nom du client') }}" />
                        <x-form.input type='text' wire:model.blur='client'
                            :error="'client'" />
                        <x-errors.validation-error value='client' />
                    </div>
                    @if ($productInvoice !=null)
                        <div class="form-group">
                            <x-form.label value="{{ __('Date création') }}" />
                            <x-form.input type='date' wire:model.blur='created_at' :error="'created_at'" />
                            <x-errors.validation-error value='created_at' />
                        </div>
                    @endif
                </div>
            </div>
        </form>
    </x-modal.build-modal-fixed>
    @push('js')
    <script type="module">
        //Open edit sheet modal
            window.addEventListener('close-form-product-invoice', e => {
                $('#form-product-invoice').modal('hide')
            });
    </script>
    @endpush
</div>
