<div>
    <form wire:submit='handlerSubmit'>
        <div class="card card-teal">
            <div class="card-header">
                <h5 class="">{{ $formLabel }}</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-center pb-2">
                    <x-widget.loading-circular-md />
                </div>
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
            </div>
            <div class="card-footer d-flex justify-content-end">
                <x-form.button class="btn-success" type='submit'><i class="fa fa-save"></i> Sauvegarder</x-form.button>
            </div>
        </div>
    </form>
</div>
