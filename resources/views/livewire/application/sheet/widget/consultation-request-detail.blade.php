<div>
    <x-modal.build-modal-fixed idModal='consultation-detail' size='lg' headerLabel="DETAILS DE LA CONSULTATION"
        headerLabelIcon='fa fa-folder-plus'>
        <div class="d-flex justify-content-center pb-2">
            <x-widget.loading-circular-md />
        </div>
        <div class="card-primary" wire:loading.class='d-none'>

            @if($consultationRequest != null)
            <div class="card-body">
                <div class="d-flex justify-content-end">
                    <div class="form-group d-flex align-items-center w-25">
                        <label class="mr-2">Devise</label>
                        @livewire('application.finance.widget.currency-widget')
                    </div>
                </div>

                <x-widget.patient.card-patient-info :consultationSheet='$consultationRequest->consultationSheet' />
                <h5 class="text-danger text-bold">CONSULTATION</h5>
                @livewire('application.sheet.widget.consultation-detail-widget',['consultationRequest'=>$consultationRequest])
                @foreach($categoriesTarif as $index => $category)
                @if(!$category->getConsultationTarifItemls($consultationRequest,$category)->isEmpty())
                <h5 class="text-danger text-bold">{{$category->name}}</h5>
                @livewire('application.sheet.widget.item-tarif-by-category-widget',
                ['categoryTarif'=>$category,'consultationRequest'=>$consultationRequest])
                @endif
                @endforeach
                @if(!$consultationRequest->products->isEmpty())
                <h5 class="text-danger text-bold">MEDICATION</h5>
                @livewire('application.product.widget.products-with-consultation-item-widget',
                ['consultationRequest'=>$consultationRequest])
                @endif

            </div>
            <div class="card-footer">
                <h4 class="text-bold text-right">Total: @livewire('application.finance.widget.total-invoice-wiget',[
                    'consultationRequest'=>$consultationRequest
                    ])
                </h4>
            </div>
            @endif
        </div>
    </x-modal.build-modal-fixed>
</div>