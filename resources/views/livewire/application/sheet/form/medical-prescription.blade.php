<div>
    <x-modal.build-modal-fixed idModal='form-medical-prescription' size='xl' headerLabel="PRESCRIPTION MEDICALE"
        headerLabelIcon='fa fa-folder-plus'>
        @if ($consultationRequest != null)
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <x-widget.patient.simple-patient-info :consultationSheet='$consultationRequest->consultationSheet' />
                        <div>
                            <h1><i class="fa fa-user-nurse text-primary"></i></h1>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-center pb-2">
                        <x-widget.loading-circular-md />
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-primary">
                                <div class="card-header"><span><i class="fas fa-list"></i> DETAILS PROESCRIPTION
                                        MEDICAL</span></div>
                                <div class="card-body">
                                    @if ($consultationRequest)
                                        @livewire('application.product.widget.products-with-consultation-item-widget', ['consultationRequest' => $consultationRequest])
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-primary">
                                <div class="card-header"><span><i class="fas fa-pen"></i>PRESCRIR UN PRODUIT</span>
                                </div>
                                <div CLASS="card-body">
                                    @foreach ($productsForm as $index => $prod)
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <x-form.label value="{{ __('Produits') }}" />
                                                    <x-widget.list-product-widget
                                                        wire:model.blur='productsForm.{{ $index }}.product_id'
                                                        :error="'productsForm.{{ $index }}.product_id'" />
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <x-form.label value="{{ __('Quantité') }}" />
                                                    <x-form.input type='text'
                                                        wire:model.blur='productsForm.{{ $index }}.qty'
                                                        wire:keydown.escape='removeProductToForm({{ $index }})'
                                                        wire:keydown.enter='addProductItems'
                                                        wire:keydown.shift='addNewProductToForm' :error="'productsForm.{{ $index }}.value'" />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="d-flex align-items-center">
                                                    @if (Auth::user()->roles->pluck('name')->contains('DOCTOR'))
                                                        <div class="form-group">
                                                            <x-form.label value="{{ __('Posologie') }}" />
                                                            <x-form.input type='text' placeholder="1x 1ce/jour"
                                                                wire:model.blur='productsForm.{{ $index }}.dosage'
                                                                wire:keydown.escape='removeProductToForm({{ $index }})'
                                                                wire:keydown.enter='addProductItems'
                                                                wire:keydown.shift='addNewProductToForm'
                                                                :error="'productsForm.{{ $index }}.dosage'" />
                                                        </div>
                                                    @else
                                                        <div class="form-group">
                                                            <x-form.label value="{{ __('Date Liv') }}" />
                                                            <x-form.input type='date'
                                                                wire:model.blur='productsForm.{{ $index }}.created_at'
                                                                wire:keydown.escape='removeProductToForm({{ $index }})'
                                                                wire:keydown.enter='addProductItems'
                                                                wire:keydown.shift='addNewProductToForm'
                                                                :error="'productsForm.{{ $index }}.created_at'" />
                                                        </div>
                                                    @endif

                                                    <x-form.icon-button :icon="'fa fa-times '"
                                                        wire:click="removeProductToForm({{ $index }})"
                                                        class="btn-danger mt-3 ml-2" />
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <x-form.icon-button :icon="'fa fa-plus '" wire:click="addNewProductToForm"
                                        class="btn-primary" />
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="card-footer d-flex justify-content-end">
                    <x-form.button wire:click="addProductItems" class="btn-primary" type='submit'>
                        <i class="fab fa-telegram"></i> Ajouter à la consultation
                    </x-form.button>
                </div>
            </div>
        @endif
    </x-modal.build-modal-fixed>
    @push('js')
        <script type="module">
            //Close modal
            window.addEventListener('close-prod-sign-form', e => {
                $('#form-medical-prescription').modal('hide')
            });

            //Close modal
            window.addEventListener('close-prod-sign-form', e => {
                $('#form-medical-prescription').modal('hide')
            });
        </script>
    @endpush
</div>
