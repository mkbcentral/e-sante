<div>
    @if ($productRequisition != null)
        <div class="card p-2">
            <div class="card-body">
                <div class="d-flex  justify-content-lg-between ">
                    <div class=" ">
                        <h4 ><span class="text-primary"> Req N°: </span> {{ $productRequisition->number }}
                        </h4>
                        <h4 > <span class="text-primary">Service: </span>{{ $productRequisition->agentService->name }}</h4>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        @livewire('application.product.list.list-product-to-add-in-requisition',['productRequisition'=>$productRequisition])
                    </div>
                    <div class="col-md-6 ">
                        @livewire('application.product.requisition.list.list-product-requisition',['productRequisition'=>$productRequisition])
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
