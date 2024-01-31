<div>
    <x-modal.build-modal-fixed idModal='form-consultation-request-nursing' size='md' headerLabel="NURSING ET AUTRES"
        headerLabelIcon='fa fa-folder-plus'>
        <form wire:submit='store'>
            @if ($consultationRequest != null)
                <div class="card p-1">
                    <div class="card-body">
                        <x-widget.patient.simple-patient-info :consultationSheet='$consultationRequest->consultationSheet' />
                        <hr>
                        <div class="form-group">
                            <x-form.label value="{{ __('DESIGNATION') }}" />
                            <x-form.input type='text' wire:model.blur='name' :error="'name'" />
                            <x-errors.validation-error value='name' />
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <x-form.label value="{{ __('Montant') }}" />
                                    <x-form.input type='text' wire:model.blur='amount' :error="'amount'" />
                                    <x-errors.validation-error value='amount' />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <x-form.label value="{{ __('Nombre') }}" />
                                    <x-form.input type='text' wire:model.blur='number' :error="'number'" />
                                    <x-errors.validation-error value='number' />
                                </div>
                            </div>
                        </div>

                        <div class="card mt-3 p-2">
                            <h5 class="pb-2">Devise</h5>
                            <div class="row">
                                @foreach ($currencies as $currency)
                                    <div class="col-md-2">
                                        <!-- radio -->
                                        <div class="form-group clearfix">
                                            <div class="icheck-primary d-inline">
                                                <input type="radio" value="{{ $currency->id }}"
                                                    id="{{ $currency->name }}" wire:model.blur="currency_id">
                                                <label for="{{ $currency->name }}">
                                                    {{ $currency->name }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class=" d-flex justify-content-end">
                            <x-form.button class="btn-primary" type='submit'><i class="fa fa-save"></i> Sauvegarder
                            </x-form.button>
                        </div>
                    </div>
                </div>
            @endif
        </form>
    </x-modal.build-modal-fixed>
    @push('js')
        <script type="module">
            //Open edit sheet modal
            window.addEventListener('close-form-consultation-request-nursing', e => {
                $('#form-consultation-request-nursing').modal('hide')
            });
        </script>
    @endpush
</div>
