<div>
    <div class="card p-1">
        <form wire:submit='handlerSubmit'>
            <div class="card-body">
                <div class="form-group">
                    <x-form.label value="{{ __('Nom complet') }}" />
                    <x-form.input type='text' wire:model.blur='name' :error="'name'" />
                    <x-errors.validation-error value='name' />
                </div>
                <div class="form-group">
                    <x-form.label value="{{ __('Montant') }}" />
                    <x-form.input type='text' wire:model.blur='amount' :error="'amount'" />
                    <x-errors.validation-error value='amount' />
                </div>
                <div class="form-group">
                    <x-form.label value="{{ __('Service') }}" />
                    <x-widget.list-agent-service-widget wire:model.blur='agent_service_id' :error="'agent_service_id'" />
                    <x-errors.validation-error value='agent_service_id' />
                </div>
                <div class=" d-flex justify-content-end">
                    <x-form.button class="btn-success" type='submit'><i class="fa fa-save"></i> Sauvegarder
                    </x-form.button>
                </div>
            </div>
        </form>
    </div>
</div>
