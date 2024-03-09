 <div class="card-body">
     <div class="d-flex justify-content-between">
         <div>
             <h5>#Invoice:{{ $productInvoice->number }}</h5>
             <h5>
                 <i class="fa fa-user" aria-hidden="true"></i> {{ $productInvoice->client }}
             </h5>
             <h5>
                 <i class="fa fa-calendar" aria-hidden="true"></i>
                 {{ $productInvoice->created_at->format('d/m/Y H:i:s') }}
             </h5>
             <h5>
                 <i class="fa fa-user-check" aria-hidden="true"></i> {{ $productInvoice?->user?->name }}
             </h5>
         </div>
         <div>
            <x-form.button class="btn-primary" wire:click='editForm'>
                <i class="fa fa-edit" aria-hidden="true"></i>
            </x-form.button>
         </div>
     </div>
 </div>
