<div>
    @if ($consultationRequest != null)
        <h4> <i class="fas fa-capsules"></i> Prescription médicale</h4>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <x-form.label value="{{ __('Produits à prescrire') }}" />
                            <x-widget.list-product-widget wire:model.blur='product_id' :error="'product_id'" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <x-form.label value="{{ __('Quantité') }}" />
                            <x-form.input type='number' wire:model.blur='qty' wire:keydown.enter='addProductItems'
                                :error="'value'" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex align-items-center">
                            <div class="form-group">
                                <x-form.label value="{{ __('Posologie') }}" />
                                <x-form.input type='text' placeholder="1x 1ce/jour" wire:model.blur='dosage'
                                    wire:keydown.enter='addProductItems' :error="'dosage'" />
                            </div>
                        </div>
                    </div>
                </div>
                @livewire('application.product.widget.doctor-products-consultation-widget', ['consultationRequest' => $consultationRequest])
            </div>
        </div>
    @endif
</div>
