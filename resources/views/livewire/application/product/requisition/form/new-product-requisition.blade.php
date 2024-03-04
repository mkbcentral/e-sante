<div>
    <x-modal.build-modal-fixed idModal='new-requisition-modal' size='md' headerLabel="NOUVELLE REQUISITION"
        headerLabelIcon='fa fa-pills'>
        <form wire:submit='handlerSubmit'>
            <div class="card p-2">
                <div class="form-group">
                    <x-form.label value="{{ __('Service') }}" />
                    <x-widget.list-agent-service-widget
                        wire:model.blur='agent_service_id' :error="'agent_service_id'" />
                    <x-errors.validation-error value='agent_service_id' />
                </div>
                 <div class="form-group">
                        <x-form.label value="{{ __('Date création') }}" />
                        <x-form.input type='date' wire:model.blur='created_at' :error="'created_at'" />
                        <x-errors.validation-error value='created_at' />
                    </div>
                <div class=" d-flex justify-content-end">
                    <x-form.button class="btn-primary" type='submit'>
                        <div wire:loading wire:target='update' class="spinner-border spinner-border-sm text-white"
                            role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <i class="fa fa-save"></i>
                        Sauvegarder
                    </x-form.button>
                </div>
            </div>
        </form>
    </x-modal.build-modal-fixed>
    @push('js')
        <script type="module">
            //Open edit sheet modal
            window.addEventListener('close-new-requisition-modal', e => {
                $('#new-requisition-modal').modal('hide')
            });
        </script>
    @endpush
</div>
