<div>
    <x-modal.build-modal-fixed idModal='edit-consultation-request-currency' size='md' headerLabel="EDITION DEVISE"
        headerLabelIcon='fa fa-pen'>
        <form wire:submit='update'>
            @if ($consultationRequest != null)
                <div class="card mt-3 p-2">
                    <h5 class="pb-2">Devise</h5>
                    <div class="row">
                        @foreach ($currencies as $currency)
                            <div class="col-md-2">
                                <!-- radio -->
                                <div class="form-group clearfix">
                                    <div class="icheck-primary d-inline">
                                        <input type="radio" value="{{ $currency->id }}" id="{{ $currency->name }}"
                                            wire:model.live="currency_id">
                                        <label for="{{ $currency->name }}">
                                            {{ $currency->name }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="col-md-2">
                            <!-- radio -->
                            <div class="form-group clearfix">
                                <div class="icheck-primary d-inline">
                                    <input type="radio" value="" id="empty" wire:model.live="currency_id">
                                    <label for="empty">
                                        Aucune
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($consultationRequest->currency_id == null)
                    <div>
                        <div class="form-group">
                            <x-form.label value="{{ __('Montant USD') }}" />
                            <x-form.input type='text' wire:keydown.enter='save' wire:model.blur='amount_usd'
                                :error="'amount_usd'" />
                            <x-errors.validation-error value='amount_usd' />
                        </div>
                        <div class="form-group">
                            <x-form.label value="{{ __('Montant CDF') }}" />
                            <x-form.input type='text' wire:keydown.enter='save' wire:model.blur='amount_cdf'
                                :error="'amount_cdf'" />
                            <x-errors.validation-error value='amount_cdf' />
                        </div>
                        <div class=" d-flex justify-content-end">
                            <x-form.button class="btn-primary" wire:click='save' type='button'><i class="fa fa-save"></i> Sauvegarder
                            </x-form.button>
                        </div>
                    </div>
                @endif
            @endif
        </form>
    </x-modal.build-modal-fixed>
    @push('js')
        <script type="module">
            //Open edit sheet modal
            window.addEventListener('close-edit-consultation-currency', e => {
                $('#edit-consultation-request-currency').modal('hide')
            });
        </script>
    @endpush
</div>
