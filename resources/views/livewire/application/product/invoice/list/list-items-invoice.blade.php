<div>
    <div class="d-flex justify-content-center align-items-center py-2">
        <x-widget.loading-circular-md />
    </div>
    <h4 class="text-secondary"><i class="fa fa-list" aria-hidden="true"></i> DETAILS FACTURE</h4>
    <table class="table table-sm table-bordered table-hover">
        <thead class="bg-pink">
            <tr>
                <th>DESIGNATION</th>
                <th class="text-center">QTY</th>
                <th class="text-right">PU CDF</th>
                <th class="text-right">PT CDF</th>
                <th>Actions</th>
                </tr>
        </thead>
        <tbody>
            @foreach ($productInvoice->products as $product)
                <tr wire:key='{{ $product->pivot->id }}' class="cursor-hand">
                    <td>{{ $product->name }}</td>

                    <td class="text-center">
                        @if ($isEditing && $idSelected == $product->pivot->id)
                            <x-form.input type='text' style="width: 50px" wire:model='qty'
                                wire:keydown.enter='update' :error="'qty'" />
                        @else
                            {{ $product->pivot->qty }}
                        @endif
                    </td>
                    <td class="text-right">{{ app_format_number($product->price, 0) }}</td>
                    <td class="text-right">{{ app_format_number($product->pivot->qty * $product->price, 1) }}</td>
                    <td>
                        <x-form.edit-button-icon wire:click="edit({{ $product->pivot->id }},{{ $product->pivot->qty }})"
                            class="btn-sm" />
                        <x-form.delete-button-icon wire:confirm="Etes-vous de supprimer?"
                            wire:click="delete({{ $product->pivot->id }})" class="btn-sm" />
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-between align-content-center">
        <h3>Total: {{ app_format_number($productInvoice->getTotalInvoice(), 1) }} Fc</h3>
        <div class="d-inline ">
            <a href="{{ route('product.invoice.print',$productInvoice->id ) }}" target="_blanck" class="mr-2"><i class="fa fa-print" aria-hidden="true"></i> Imprimer</a>
            <button class="btn btn-link btn-sm" type="button" wire:click='validateInvoice'>
                <i class="{{ $productInvoice->is_valided==true?'fa fa-times':'fa fa-check'  }} " aria-hidden="true"></i>
                {{ $productInvoice->is_valided==true?'Annuler':'Valider'  }}
            </button>
        </div>
    </div>
</div>
