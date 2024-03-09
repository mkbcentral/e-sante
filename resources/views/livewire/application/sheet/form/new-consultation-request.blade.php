<div>
    <x-modal.build-modal-fixed idModal='form-new-request' size='md' headerLabel="DEMANDER UNE CONSULTATION"
        headerLabelIcon='fa fa-folder-plus'>
        <form wire:submit='store'>
            @if ($consultationSheet != null)
                <div class="card p-2">
                    <div class="card-body">
                        <x-widget.patient.simple-patient-info :consultationSheet='$consultationSheet' />
                        <hr>
                        <div class="form-group">
                            <x-form.label value="{{ __('Type consultation') }}" />
                            <x-widget.list-consultation-widget wire:model.blur='consultation_id' :error="'consultation_id'" />
                            <x-errors.validation-error value='consultation_id' />
                        </div>
                        @if ($consultationSheet->subscription?->is_subscriber)
                            <div class="my-2"> <span class="text-bold text-md text-info mr-2">Avec bon ?</span>
                                <div class="icheck-primary d-inline">
                                    <input wire:model.live='has_a_shipping_ticket' type="checkbox"
                                        id="checkboxPrimary2">
                                    <label for="checkboxPrimary2">
                                        {{ $has_a_shipping_ticket == false ? 'Oui' : 'Non' }}
                                    </label>
                                </div>
                            </div>
                        @endif

                    </div>
                    <div class="card-footer d-flex justify-content-end">
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
            window.addEventListener('close-request-form', e => {
                $('#form-new-request').modal('hide')
            });

        </script>
    @endpush
</div>
