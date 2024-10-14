<div>
    <div class="form-group " wire:ignore>
        <x-form.input-editor wire:model="note" :id="'note'" value="{{ $note }}" />
        <x-errors.validation-error value='note' />
    </div>
    <div class=" d-flex justify-content-end">
        @if ($consultationRequest != null && $note != '')
            <x-form.button wire:click="handlerSubmit" class="{{ $consultationRequest->consultationComment ==null ? 'btn-dark' : 'btn-info' }} " type='button'>
                <i class="{{ $consultationRequest->consultationComment ==null ? 'fa fa-plus-circle' : 'fas fa-sync' }} "></i>
                {{ $consultationRequest->consultationComment ==null ? 'Ajouter le commentaire' : 'Mettre à jour le commentaire' }}
            </x-form.button>
        @endif
    </div>
</div>
