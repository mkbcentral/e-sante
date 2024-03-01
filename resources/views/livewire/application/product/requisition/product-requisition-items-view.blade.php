<div>
    <x-navigation.bread-crumb icon='fa fa-capsules' color='text-success' label='AJOUT DES PRODUITS A LA REQUISITION'>
        <x-navigation.bread-crumb-item label='Dashboard' link='dashboard' isLinked=true />
        <x-navigation.bread-crumb-item label='Liste requistions' link='product.requisitions' isLinked=true />
        <x-navigation.bread-crumb-item label='Ajout des produits' />
    </x-navigation.bread-crumb>
    <x-content.main-content-page>
        @if ($productRequisition != null)
            <div class="card p-2">
                <div class="card-body">
                    <div class="d-flex  justify-content-lg-between ">
                        <div class=" ">
                            <span>
                                <span class="text-primary h5"> Req N°: </span>
                                <span class="text-bold text-secondary">{{ $productRequisition->number }}</span>
                            </span><br>
                            <span>
                                <span class="text-primary h5">Service:</span>
                                <span class="text-bold text-uppercase">{{ $productRequisition->agentService->name }}</span>
                            </span><br>
                            <span>
                                <span class="text-primary h5">Date:</span>
                                <span class="text-bold text-uppercase text-secondary">{{ $productRequisition->created_at->format('d/m/Y') }}</span>
                            </span>

                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            @livewire('application.product.list.list-product-to-add-in-requisition', ['productRequisition' => $productRequisition])
                        </div>
                        <div class="col-md-6 ">
                            @livewire('application.product.requisition.list.list-product-requisition', ['productRequisition' => $productRequisition])
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </x-content.main-content-page>
    @push('js')
        <script type="module">
            //Open  add new requisition model modal
            window.addEventListener('open-new-requisition-modal', e => {
                $('#new-requisition-modal').modal('show')
            });
        </script>
    @endpush
</div>
