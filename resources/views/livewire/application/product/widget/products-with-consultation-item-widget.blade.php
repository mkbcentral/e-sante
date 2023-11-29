<div>
    @if($consultationRequest)
        <table class="table table-striped table-sm">
            <thead class="bg-primary">
            <tr>
                <th class="">PRODUIT</th>
                <th class="text-center">QTY</th>
                <th class="text-center">POSOLOGIE</th>
                <th class="text-center">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($consultationRequest->products as $index => $product)
                <tr style="cursor: pointer;">
                    <td class="text-uppercase">- {{$product->name}}</td>
                    <td class="text-center">
                        @if($isEditing && $idSelected==$product->pivot->id)
                            <x-form.input type='text' style="width: 70px;text-align: center"
                                          wire:model='qty' wire:keydown.enter='update'
                                          :error="'qty'"/>
                        @else
                            {{$product->pivot->qty}}
                        @endif

                    </td>
                    <td class="text-center">{{$product->pivot->dosage}}</td>
                    <td class="text-center">
                        <x-form.edit-button-icon
                            wire:click="edit({{$product->pivot->id}},{{$product->pivot->qty}},{{$product->id}})"
                            class="btn-sm"/>
                        <x-form.delete-button-icon wire:click="delete({{$product->pivot->id}})" class="btn-sm"/>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>
