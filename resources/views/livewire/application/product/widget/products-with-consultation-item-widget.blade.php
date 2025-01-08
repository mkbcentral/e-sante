<div>
    @if ($consultationRequest)
        <h4> <i class="fas fa-capsules"></i> Prescription médicale</h4>
        <table class="table table-bordered table-sm">
            <thead class="bg-primary">
                <tr>
                    <th class="">PRODUIT</th>
                    <th class="text-center">NBRE</th>
                    @if (Auth::user()->roles->pluck('name')->contains('PHARMA') || Auth::user()->roles->pluck('name')->contains('ADMIN'))
                        <th class="text-right">P.U</th>
                        <th class="text-right">P.T</th>
                    @endif
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
                        <td class="text-right">
                            {{ app_format_number($product->price, 1) }}
                        </td>
                        <td class="text-right">
                            {{ app_format_number($product->price * $product->pivot->qty, 1) }}
                        </td>
                        <td class="text-center">
                            @if ($consultationRequest->is_printed == false)
                                <x-form.edit-button-icon
                                    wire:click="edit({{ $product->pivot->id }},{{ $product->pivot->qty }},{{ $product->id }})"
                                    class="btn-sm btn-primary" />
                                <x-form.delete-button-icon wire:confirm="Etes-vous sûr de supprimer ?"
                                    wire:click="delete({{ $product->pivot->id }})" class="btn-sm btn-danger" />
                            @endif
                        </td>
                    </tr>
                @endforeach
                @can('finance-view')
                    <tr class="bg-secondary">
                        <td colspan="4" class="text-right">
                            <span class="text-bold text-lg"> TOTAL:
                                {{ app_format_number(
                                    $currency == 'USD' ? $consultationRequest->getTotalProductUSD() : $consultationRequest->getTotalProductCDF(),
                                    1,
                                ) }}
                                Fc</span>
                        </td>
                    </tr>
                @endcan
            </tbody>
        </table>
    @endif
</div>
