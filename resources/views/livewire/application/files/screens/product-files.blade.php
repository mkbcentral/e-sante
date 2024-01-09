<div>
    <div class="w-25">
        <div class="input-group">
            <input type="file" class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04"
                aria-label="Upload" wire:model='file'>
            <button class="btn btn-secondary" type="button" id="inputGroupFileAddon04" wire:click='importFile'> <i
                    class="fas fa-file-download "></i> Importer</button>
        </div>
        <x-errors.validation-error value='file' />
    </div>
</div>
