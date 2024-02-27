<div>
    <x-modal.build-modal-fixed idModal='form-new-other-detail-outpatient-bill' size='md' headerLabel="AUTRES DETAILS"
        headerLabelIcon='fa fa-file'>
        <form wire:submit='handlerSubmit'>
            <div class="card">
                <div class="d-flex justify-content-center pb-2">
                    <x-widget.loading-circular-md />
                </div>
                @if ($outpatientBill != null)
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><span class="text-bold">Client:</span> {{ $outpatientBill->client_name }}</h5><br>
                        <h5 class="card-title"><span class="text-bold">N°:</span> {{ $outpatientBill->bill_number }}</h5>
                    </div>
                </div>
                    <div class="card-body">
                        <div class="form-group">
                            <x-form.label value="{{ __('Description') }}" />
                            <x-form.input type='text' wire:keydown.enter='handlerSubmit' wire:model.blur='name'
                                :error="'name'" />
                            <x-errors.validation-error value='name' />
                        </div>
                        <div class="form-group">
                            <x-form.label value="{{ __('Montant') }}" />
                            <x-form.input type='text' wire:keydown.enter='handlerSubmit' wire:model.blur='amount'
                                :error="'amount'" />
                            <x-errors.validation-error value='amount' />
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <x-form.button class="btn-info" type='submit'><i class="fa fa-save"></i>
                            Sauvegarder</x-form.button>
                    </div>
                @endif

            </div>
        </form>
        @if ($otherOutpatientBill != null)
            <div class="d-flex justify-content-end">
            <x-form.button class="btn-danger" wire:click='delete' wire:confirm="Etes-vous d'annuler?" type='button'><i class="fa fa-times"></i>
                Annuler</x-form.button>
        </div>
        @endif
    </x-modal.build-modal-fixed>
    @push('js')
        <script type="module">
            //Open edit sheet modal
            window.addEventListener('close-form-new-other-detail-outpatient-bill', e => {
                $('#form-new-other-detail-outpatient-bill').modal('hide')
            });
        </script>
    @endpush
</div>
