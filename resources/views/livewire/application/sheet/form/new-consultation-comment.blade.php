<div>
    <div class="d-flex justify-content-end mb-2">
        <x-form.button wire:click="openModalToAddDiagnosticItems" class="btn-secondary" type='button'>
            <i class="fa fa-file"></i> Autres dignostics</x-form.button>

    </div>
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
    @push('js')
        <script type="module">
            //Open edit sheet modal
            window.addEventListener('open-diagnostic-items', e => {
                $('#diagnostic-items').modal('show')
            });
        </script>
    @endpush
</div>
