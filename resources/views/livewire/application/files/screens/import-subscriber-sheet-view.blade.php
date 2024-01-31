<div>
    <div class="row" wire:ignore.self>
        <div class="col-md-6">
            <div class="form-group">
                <x-form.label value="{{ __('Société') }}" />
                <x-widget.list-subscription-except-private class="form-control" wire:model.blur='subscription_id'
                    :error="'subscription_id'" />
                <x-errors.validation-error value='subscription_id' />
            </div>
        </div>
        <div class="col-md-6">
            <x-form.label value="{{ __('Choisir le ficher') }}" />
            <div class="input-group">
                <input type="file" class="form-control" id="inputGroupFile04"
                    aria-describedby="inputGroupFileAddon04" aria-label="Upload" wire:model.live='file_subscriber'>
                <button class="btn btn-info" type="button" id="inputGroupFileAddon04"
                    wire:click='importSubscriberSheets'>
                    <i class="fas fa-file-download "></i>
                    Importer fiches occ
                </button>
            </div>
            <x-errors.validation-error value='file_subscriber' />
        </div>
    </div>
    <div class="d-flex justify-content-center">
        <div class="spinner-border spinner-border-sm" role="status" wire:loading>
            <span class="visually-hidden"></span>
        </div>
    </div>
</div>
