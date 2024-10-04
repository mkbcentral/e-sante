<div>
    @if ($consultationRequest)
        <table class="table table-bordered table-sm">
            <thead class="bg-primary">
                <tr>
                    <th class="">PRODUIT</th>
                    <th class="text-center">NBRE</th>
                    <th class="text-center">Posologie</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($consultationRequest->products as $index => $product)
                    <tr style="cursor: pointer;" data-toggle="tooltip" data-placement="top"
                        title="({{ $product->name }}) Posologie:
                    {{ $product->pivot->dosage == null ? 'Nom défini' : $product->pivot->dosage }}">
                        <td class="text-uppercase">-
                            {{ strlen($product->name) > 20 ? substr($product->name, 0, 20) . '...' : $product->name }}
                        </td>
                        <td class="text-center">
                            @if ($isEditing && $idSelected == $product->pivot->id)
                                <x-form.input type='text' style="width: 70px;text-align: center" wire:model='qty'
                                    wire:keydown.enter='update' :error="'qty'" />
                            @else
                                {{ $product->pivot->qty }}
                            @endif

                        </td>
                        <td class="">
                            @if ($isEditing && $idSelected == $product->pivot->id)
                                <x-form.input type='text' wire:model='dosage' wire:keydown.enter='update'
                                    :error="'dosage'" />
                            @else
                                {{ $product->pivot->dosage == null ? 'Nom défini' : $product->pivot->dosage }}
                            @endif

                        </td>
                        <td class="text-center">
                            @if ($consultationRequest->is_printed == false)
                                <button class="btn btn-link btn-sm" wire:click="edit({{ $product->pivot->id }})">
                                    <i class="fa fa-pen text-info" aria-hidden="true"></i>
                                </button>
                                <button class="btn btn-link btn-sm" wire:click="delete({{ $product->pivot->id }})">
                                    <i class="fa fa-times text-danger" aria-hidden="true"></i>
                                </button>

                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
