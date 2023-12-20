<div>
    <x-modal.build-modal-fixed idModal='form-new-outpatient-bill' size='md' headerLabel="CREATION NOUVELLE FACTURE"
        headerLabelIcon='fa fa-file'>
        <form wire:submit='store'>
            <div class="card">
                <div class="d-flex justify-content-center pb-2">
                    <x-widget.loading-circular-md/>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <x-form.label value="{{ __('Nom du client') }}" />
                        <x-form.input type='text' wire:model.blur='client_name' :error="'client_name'" />
                        <x-errors.validation-error value='client_name' />
                    </div>
                    <div class="form-group">
                        <x-form.label value="{{ __('Type consultation') }}" />
                        <x-widget.list-consultation-widget wire:model.live='consultation_id' :error="'consultation_id'" />
                        <x-errors.validation-error value='consultation_id' />
                    </div>
                </div>
            </div>
        </form>
    </x-modal.build-modal-fixed>
    @push('js')
        <script type="module">
            //Open edit sheet modal
            window.addEventListener('close-form-new-outpatient-bill', e => {
                $('#form-new-outpatient-bill').modal('hide')
            });
        </script>
    @endpush
</div>
