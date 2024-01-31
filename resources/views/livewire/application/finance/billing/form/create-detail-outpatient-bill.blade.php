<div>
    <x-modal.build-modal-fixed idModal='form-detail-outpatient-bill' bg='bg-navy' size='md'
        headerLabel="{{ $modalLabel }}" headerLabelIcon='fas fa-funnel-dollar'>
        <form wire:submit='handlerSubmit'>
            <div class="p-2">
                <div class="d-flex justify-content-center pb-2">
                    <x-widget.loading-circular-md />
                </div>
                <div class="mt-2">
                    <div class="form-group">
                        <x-form.label value="{{ __('Montant en franc') }}" />
                        <x-form.input type='text' placeholder="Montant en Franc" wire:model.blur='amount_cdf'
                            :error="'amount_cdf'" />
                        <x-errors.validation-error value='amount_cdf' />
                    </div>
                    <div class="form-group">
                        <x-form.label value="{{ __('Montant en dollar') }}" />
                        <x-form.input type='text' placeholder="Montant en Dollar" wire:model.blur='amount_usd'
                            :error="'amount_usd'" />
                        <x-errors.validation-error value='amount_usd' />
                    </div>
                    <div class=" d-flex justify-content-end">
                        <x-form.button class="btn-dark" type='submit'><i class="fa fa-save"></i>
                            Sauvegarder</x-form.button>
                    </div>
                </div>

            </div>
        </form>
    </x-modal.build-modal-fixed>
    @push('js')
        <script type="module">
            //Open edit sheet modal
            window.addEventListener('open-form-detail-outpatient-bill', e => {
                $('#form-detail-outpatient-bill').modal('show')
            });
        </script>
    @endpush
</div>
