<div>
    <x-modal.build-modal-fixed idModal='form-product-requisition-detail' size='lg' bg='bg-olive'
        headerLabel="LISTE PRODUITS REQUISITIONNES" headerLabelIcon='fa fa-capsules'>
        <div class="d-flex justify-content-center pb-2">
            <x-widget.loading-circular-md />
        </div>
        @if ($productRequisition != null)
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class=""><span class="text-info">#Num:</span> {{ $productRequisition->number }}
                            </h5>
                            <h5 class="text-uppercase
                            "><span
                                    class="text-info">Service:</span>
                                {{ $productRequisition->agentService->name }}</h5>
                        </div>
                        <div>
                            <h5 class=""><span class="text-info">Produits:</span>
                                {{ $productRequisition->productRequistionProducts->count() }}</h5>
                            <h5 class=""><span class="text-info">Date:</span>
                                {{ $productRequisition->created_at->format('d/m/Y') }}</h5>
                        </div>
                    </div>


                </div>
            </div>
            <table class="table table-striped table-sm ">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>Désignation</th>
                        <th class="text-center">Quantité</th>
                        <th class="text-right">P.U</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productRequisition->productRequistionProducts as $index => $productRequistionProduct)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $productRequistionProduct?->product?->name }}</td>

                            <td class="text-center">
                                @if ($isEditing == true && $productRequistionProductId == $productRequistionProduct->id)
                                    <x-form.input type='text' style="width: 70px;text-align: center"
                                        wire:model='quantity' wire:keydown.enter='update' :error="'quantity'" />
                                @else
                                    {{ $productRequistionProduct->quantity }}
                                @endif
                            </td>
                            <td class="text-right">{{ $productRequistionProduct?->product?->price }}</td>
                            <td class="text-center">
                                @if ($productRequisition->is_valided)
                                    <span class="text-success">Livré</span>
                                @else
                                    <x-form.edit-button-icon wire:click="edit({{ $productRequistionProduct }})"
                                        class="btn-sm btn-primary" />
                                    <x-form.delete-button-icon wire:confirm="Etes-vous sûr de supprimer ?"
                                        wire:click="delete({{ $productRequistionProduct }})"
                                        class="btn-sm btn-danger" />
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        @endif
    </x-modal.build-modal-fixed>
    @push('js')
        <script type="module">
            //Open edit sheet modal
            window.addEventListener('close-form-product-requisition-detail', e => {
                $('#form-product-requisition-detail').modal('hide')
            });
        </script>
    @endpush
</div>
