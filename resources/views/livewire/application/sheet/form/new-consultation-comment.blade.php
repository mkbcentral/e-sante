<div>
    <div>
        <div class="form-group " wire:ignore >
            <x-form.input-editor   wire:model="note" :id="'note'" value="{{$note}}" />
            <x-errors.validation-error value='note' />
        </div>
        <div class=" d-flex justify-content-between">
            <x-form.button wire:click="addNewDiagnostic"
                           class="btn-secondary" type='button'>
                <i class="fa fa-file"></i> Autres</x-form.button>
            @if($consultationRequest != null && $note != '')
                <x-form.button wire:click="handlerSubmit"
                               class="btn-dark" type='button'>
                    <i class="fa fa-plus-circle"></i>
                    Ajouter à la consultation
                </x-form.button>
            @endif
        </div>
    </div>
    @push('js')
        <script type="module">
            //Open edit sheet modal
            window.addEventListener('open-diagnostic-items',e=>{
                $('#diagnostic-items').modal('show')
            });
        </script>
    @endpush
</div>
