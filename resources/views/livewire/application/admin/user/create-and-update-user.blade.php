<div>
    <x-modal.build-modal-fixed idModal='form-create-user' bg='bg-indigo' size='md' headerLabel="{{ $formLabel }}"
        headerLabelIcon='fas fa-fingerprint'>
        <form wire:submit='handlerSubmit'>
            <div class="form-group">
                <x-form.label value="{{ __('Nom utilisateur') }}" />
                <x-form.input type='text' wire:model.blur='name' :error="'name'" />
                <x-errors.validation-error value='name' />
            </div>
            <div class="form-group">
                <x-form.label value="{{ __('Adresse email') }}" />
                <x-form.input type='email' wire:model.blur='email' :error="'email'" />
                <x-errors.validation-error value='email' />
            </div>
            <div class="form-group">
                <x-form.label value="{{ __('Source') }}" />
                <select wire:model.blur='source_id' class="form-control  @error($source_id) is-invalid @enderror">
                    <option>Choisir</option>
                    @foreach ($sources as $source)
                        <option value="{{ $source->id }}">{{ $source->name }}</option>
                    @endforeach
                </select>
                <x-errors.validation-error value='form.source_id' />
            </div>
            <div class="form-group">
                <x-form.label value="{{ __('Service') }}" />
                <x-widget.list-agent-service-widget wire:model.blur='agent_service_id' :error="'agent_service_id'" />
                <x-errors.validation-error value='agent_service_id' />
            </div>
            <div class="d-flex justify-content-end">
                <x-form.button class="btn-success" type='submit'><i class="fa fa-save"></i>
                    Sauvegarder</x-form.button>
            </div>
        </form>
    </x-modal.build-modal-fixed>
     @push('js')
        <script type="module">
          //Close  create user modal
            window.addEventListener('close-form-create-user', e => {
                $('#form-create-user').modal('hide')
            });
        </script>
    @endpush
</div>
