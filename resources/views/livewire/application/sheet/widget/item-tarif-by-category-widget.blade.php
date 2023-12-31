<div>
    <table class="table table-bordered table-sm">
        <thead class="bg-primary">
            <tr>
                <th class="">DESIGNATION</th>
                <th class="text-center">NOMBRE</th>
                <th class="text-right">P.U CDF</th>
                <th class="text-right">P.T CDF</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categoryTarif->getConsultationTarifItemls($consultationRequest,$categoryTarif) as $item)
            <tr style="cursor: pointer;" wire:key="{{$item->id}}">
                <td class="text-uppercase">
                    @if($isEditing && $idSelected==$item->id)
                    <select class="form-control" wire:model.live='idTarif'>
                        @foreach ($tarifs as $tarif)
                        <option value="{{$tarif->id}}" class="text-uppercase">
                            {{ $tarif->abbreviation==null?$tarif->name:$tarif->abbreviation }}
                        </option>
                        @endforeach
                    </select>
                    @else
                    - {{$item->name}}
                    @endif
                </td>
                <td class="text-uppercase text-center">
                    @if($isEditing && $idSelected==$item->id)
                    <x-form.input type='text' wire:model='qty' wire:keydown.enter='update' :error="'qty'" />
                    @else
                    {{$item->qty}}
                    @endif
                </td>
                <td class="text-right">
                    {{app_format_number($currencyName=='USD'?$categoryTarif->getUnitPriceUSD($consultationRequest,$item->id_tarif):
                    $categoryTarif->getUnitPriceCDF($consultationRequest,$item->id_tarif),1)}}
                </td>
                <td class="text-right">
                    {{app_format_number($currencyName=='USD'?
                    $categoryTarif->getTotalPriceUSD($consultationRequest,$item->qty,$item->id_tarif):
                    $categoryTarif->getTotalPriceCDF($consultationRequest,$item->qty,$item->id_tarif),1)}}
                </td>
                <td class="text-center">
                    <x-form.edit-button-icon
                        wire:click="edit({{$item->id}},{{$item->qty}},{{$item->category_id}},{{$item->id_tarif}})"
                        class="btn-sm" />
                    <x-form.delete-button-icon wire:click="delete({{$item->id}})" class="btn-sm" />
                </td>
            </tr>
            @endforeach
            <tr class="bg-secondary">
                <td colspan="4" class="text-right">
                    <span class="text-bold text-lg"> TOTAL:
                        {{app_format_number($currencyName=='USD'?
                        $categoryTarif->getTotalTarifInvoiceByCategoryUSD($consultationRequest,$categoryTarif):
                        $categoryTarif->getTotalTarifInvoiceByCategoryCDF($consultationRequest,$categoryTarif),1)}}</span>
                </td>
            </tr>
        </tbody>
    </table>
</div>