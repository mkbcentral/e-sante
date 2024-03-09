 <div class="d-flex justify-content-between align-items-center">
     <div>
         <h4 class="">
             <span class="text-bold">
                 <i class="fa fa-user" aria-hidden="true"></i>
             </span>
             {{ $outpatientBill->client_name }}
         </h4>
         <h4><i class="fas fa-funnel-dollar"></i>
             <span>
                 {{ $outpatientBill->currency == null ? 'USD & CDF' : $outpatientBill->currency->name }}</span>
             @if ($outpatientBill->currency == null)
                 <x-form.icon-button :icon="'fa fa-pen'" class="btn-info" wire:click="openAddDetailFormModal" 2
                     data-toggle="tooltip" data-placement="top" title="Modifier" />
             @else
                 <x-form.icon-button :icon="'fa fa-pen'" class="btn-danger" wire:click="openNewOutpatientBillModal"
                     data-toggle="tooltip" data-placement="top" title="Modifier" />
             @endif
         </h4>
         <h4 class="">
             <span class="text-bold"><i class="fa fa-calendar" aria-hidden="true"></i></span>
             {{ $outpatientBill->created_at }}
         </h4>
     </div>
     <div>
         <h4><span class="text-bold"># Invoice :</span> <span>{{ $outpatientBill->bill_number }}</span></h4>
         <h4 class="text-bold">
             <i class="fa fa-user-check" aria-hidden="true"></i>
             {{ Auth::user()?->name }}
         </h4>
     </div>
 </div>
