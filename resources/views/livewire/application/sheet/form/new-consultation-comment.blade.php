<div>
    <div class="card p-2" wire:ignore>
        <div class="card-body">
            <div class="form-group " >
                <x-form.input-editor wire:ignore  :id="'body'" wire:model="body" />
                <x-errors.validation-error value='body' />
            </div>
            <div class=" d-flex justify-content-end">
                @if($consultationRequest != null)
                    <x-form.button wire:click="handlerSubmit"
                                   class="btn-dark" type='button'>
                        <i class="fa fa-plus-circle"></i> Ajouter à la consultation</x-form.button>
                @endif
            </div>
        </div>

    </div>
</div>
