<div>
    @if($consultationRequest)
    <table class="table table-bordered table-sm">
        <thead class="bg-primary">
            <tr>
                <th class="">PRODUIT</th>
                <th class="text-center">NOMBRE</th>
                <th class="text-right">P.U FC</th>
                <th class="text-right">P.T FC</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($consultationRequest->products as $index => $product)
            <tr style="cursor: pointer;" data-toggle="tooltip" data-placement="top" title="({{$product->name}}) Posologie:
                    {{$product->pivot->dosage==null?'Nom défini':$product->pivot->dosage}}">
                <td class="text-uppercase">- {{$product->name}}</td>
                <td class="text-center">
                    @if($isEditing && $idSelected==$product->pivot->id)
                    <x-form.input type='text' style="width: 70px;text-align: center" wire:model='qty'
                        wire:keydown.enter='update' :error="'qty'" />
                    @else
                    {{$product->pivot->qty}}
                    @endif

                </td>
                <td class="text-right">
                    {{app_format_number($product->price,1)}}
                </td>
                <td class="text-right">
                    {{app_format_number($product->price*$product->pivot->qty,1)}}
                </td>
                <td class="text-center">
                    <x-form.edit-button-icon
                        wire:click="edit({{$product->pivot->id}},{{$product->pivot->qty}},{{$product->id}})"
                        class="btn-sm" />
                    <x-form.delete-button-icon wire:click="delete({{$product->pivot->id}})" class="btn-sm" />
                </td>
            </tr>
            @endforeach
            <tr class="bg-secondary">
                <td colspan="4" class="text-right">
                    <span class="text-bold text-lg"> TOTAL:
                        {{app_format_number(
                        $currency=='USD'?$consultationRequest->getTotalProductUSD():
                        $consultationRequest->getTotalProductCDF(),1)}} Fc</span>
                </td>
            </tr>
        </tbody>
    </table>
    @endif
</div>