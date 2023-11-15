<div>
    <x-modal.build-modal-fixed
        idModal='form-new-request'
        size='md' headerLabel="DEMANDER UNE CONSULTATION"
        headerLabelIcon='fa fa-folder-plus'>
        <form wire:submit='store'>
            @if($consultationSheet != null)
                <div class="card p-2">
                    <div class="card-body">
                        <div>
                            <span><span class="text-bold">Nom:</span> {{$consultationSheet->name}}</span><br>
                            <span><span class="text-bold">Genre:</span> {{$consultationSheet->gender}}</span><br>
                            <span><span class="text-bold">Age:</span> {{$consultationSheet->getPatientAge()}}</span><br>
                            <span><span class="text-bold">Type:</span> {{$consultationSheet->subscription->name}}</span>
                        </div>
                        <hr>
                        <div class="form-group">
                            <x-form.label value="{{ __('Type consultation') }}" />
                            <x-widget.list-consultation-widget wire:model.blur='sheet_id' :error="'sheet_id'" />
                            <x-errors.validation-error value='sheet_id' />
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <x-form.button class="btn-primary" type='submit'><i class="fa fa-save"></i> Sauvegarder</x-form.button>
                    </div>
                </div>
            @endif
        </form>
    </x-modal.build-modal-fixed>
    @push('js')
        <script type="module">
            //Open edit sheet modal
            window.addEventListener('close-request-form',e=>{
                $('#form-new-request').modal('hide')
            });
        </script>
    @endpush
</div>
