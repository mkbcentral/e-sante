<div>
    <x-modal.build-modal-fixed idModal='form-caution' size='md' headerLabel="{{ $formLabel }}"
        headerLabelIcon='fa fa-plus-square'>
        <form wire:submit='handlerSubmit'>
            @if ($consultationRequest != null)
                <div class="card p-2">
                    <div class="card-body">
                        <x-widget.patient.simple-patient-info :consultationSheet='$consultationRequest->consultationSheet' />
                        <hr>
                        <div class="form-group">
                            <x-form.label value="{{ __('Montant caution') }}" />
                            <x-form.input wire:model.blur='amount' :error="'amount'" />
                            <x-errors.validation-error value='amount' />
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        @if ($consultationRequest->caution)
                            <x-form.button class="btn-danger" type='button' wire:confirm='Etês-vous sûr de supprimer'
                                wire:click='delete'>
                                <i class="fa fa-times"></i> Annuler
                            </x-form.button>
                        @endif
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
            window.addEventListener('close-form-caution', e => {
                $('#form-caution').modal('hide')
            });
        </script>
    @endpush
</div>
