<div>
    <x-modal.build-modal-fixed idModal='form-new-outpatient-bill' size='md' headerLabel="{{ $modalLabel }}"
        headerLabelIcon='fa fa-file'>
        <form wire:submit='handlerSubmit'>
            <div class="card">
                <div class="d-flex justify-content-center pb-2">
                    <x-widget.loading-circular-md />
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <x-form.label value="{{ __('Nom du client') }}" />
                        <x-form.input type='text' wire:keydown.enter='handlerSubmit' wire:model.blur='client_name'
                            :error="'client_name'" />
                        <x-errors.validation-error value='client_name' />
                    </div>
                    <div class="form-group">
                        <x-form.label value="{{ __('Type consultation') }}" />
                        <x-widget.list-consultation-widget wire:model.blur='consultation_id' :error="'consultation_id'" />
                        <x-errors.validation-error value='consultation_id' />
                    </div>
                    <div class="form-group">
                        <x-form.label value="{{ __('Devise') }}" />
                        <select class="form-control " wire:model='currency_id'>
                            <option value="">Choisir</option>
                            @foreach ($currencies as $currency)
                                <option value="{{ $currency->id }}">
                                    {{ $currency->name }}
                                </option>
                            @endforeach
                             <option value="">Aucune</option>
                        </select>
                        <x-errors.validation-error value='currency_id' />
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <x-form.button class="btn-info" type='submit'><i class="fa fa-save"></i>
                        Sauvegarder</x-form.button>
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
