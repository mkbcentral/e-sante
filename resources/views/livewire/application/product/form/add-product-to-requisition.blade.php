<div>
    <x-modal.build-modal-fixed idModal='add-to-product-requisition-modal' bg='bg-navy' size='md'
        headerLabel="AJOUT PRODUIT  A LA REQUISITION" headerLabelIcon='fa fa-capsules'>
        <form wire:submit='handlerSubmit'>
            @if ($productRequisition != null && $product != null)
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><span class="text-bold">N° Req:</span>:{{ $productRequisition->number }}
                        </h5><br>
                        <h5 class="card-title"><span class="text-bold">Service
                                :</span>:{{ $productRequisition->agentService->name }} </h5>
                        <h5 class="card-title"><span class="text-bold">Produit</span>:{{ $product->name }} </h5>
                    </div>
                </div>
                <div class="card p-2">
                    <div class="form-group">
                        <x-form.label value="{{ __('Quantité') }}" />
                        <x-form.input type='number' wire:model.blur='quantity' :error="'quantity'" />
                        <x-errors.validation-error value='quantity' />
                    </div>
                    <div class=" d-flex justify-content-end">
                        <x-form.button class="btn-dark" type='submit'>
                            <div wire:loading wire:target='handlerSubmit'
                                class="spinner-border spinner-border-sm text-white" role="status">
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
            window.addEventListener('close-add-to-product-requisition-modal', e => {
                $('#add-to-product-requisition-modal').modal('hide')
            });
        </script>
    @endpush
</div>
