<div>
    <x-modal.build-modal-fixed idModal='edit-consultation-request' size='md' headerLabel="EDITION DEMANDE"
        headerLabelIcon='fa fa-pen'>
        <form wire:submit='update'>
            @if ($consultationRequest != null)

                <div class="card p-2">
                    <div class="d-flex justify-content-center pb-2">
                        <x-widget.loading-circular-md />
                    </div>
                    <x-widget.patient.simple-patient-info :consultationSheet='$consultationRequest->consultationSheet' />
                    <hr>
                    <div class="form-group">
                        <x-form.label value="{{ __('Type consultation') }}" />
                        <x-widget.list-consultation-widget wire:model='consultation_id' :error="'sheet_id'" />
                        <x-errors.validation-error value='sheet_id' />
                    </div>
                    <div class="form-group">
                        <x-form.label value="{{ __('Numero') }}" />
                        <x-form.input type='text' wire:model='request_number' :error="'request_number'" />
                        <x-errors.validation-error value='request_number' />
                    </div>
                    <div class="form-group">
                        <x-form.label value="{{ __('Date création') }}" />
                        <x-form.input type='date' wire:model='created_at' :error="'created_at'" />
                        <x-errors.validation-error value='created_at' />
                    </div>
                    @if ($consultationRequest->consultationSheet->subscription?->is_subscriber)
                        <div class="my-2"> <span class="text-bold text-md text-info mr-2">Avec bon ?</span>
                            <div class="icheck-primary d-inline">
                                <input wire:model.live='has_a_shipping_ticket' type="checkbox" id="checkboxPrimary2">
                                <label for="checkboxPrimary2">
                                    {{ $has_a_shipping_ticket == false ? 'Oui' : 'Non' }}
                                </label>
                            </div>
                        </div>
                    @endif
                    <div class=" d-flex justify-content-end">
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
            window.addEventListener('close-open-edit-consultation', e => {
                $('#edit-consultation-request').modal('hide')
            });
        </script>
    @endpush
</div>
