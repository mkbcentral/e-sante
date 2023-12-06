<div>
    <x-modal.build-modal-fixed
        idModal='consultation-detail'
        size='lg' headerLabel="DETAILS DE LA CONSULTATION"
        headerLabelIcon='fa fa-folder-plus'>
        <div class="card-primary">
           <div class="card-body">
               <div class="d-flex justify-content-end">
                   <div class="form-group d-flex align-items-center w-25">
                       <label class="mr-2">Devise</label>
                       @livewire('application.finance.widget.currency-widget')
                   </div>
               </div>
               @if($consultationRequest != null)
                   <x-widget.patient.card-patient-info
                       :consultationSheet='$consultationRequest->consultationSheet'/>
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
               @endif
           </div>
            <div class="card-footer">
                <h4 class="text-bold text-right">Total: {{$consultationRequest !=null?app_format_number($consultationRequest->getTotalInvoice(),1):0}}</h4>
            </div>
        </div>
    </x-modal.build-modal-fixed>
</div>
