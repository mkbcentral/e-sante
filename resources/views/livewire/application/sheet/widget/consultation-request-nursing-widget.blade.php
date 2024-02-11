<div>
    <table class="table table-bordered">
        <thead class="thead-light">
            <tr>
                <th>DESIGNATION</th>
                <th class="text-center">NBRE</th>
                <th class="text-right">PU</th>
                <th class="text-right">PT</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($consultationRequest->consultationRequestNursings as $consultationRequestNursing)
                <tr>
                    @if ($isEditing == true && $idSelected == $consultationRequestNursing->id)
                        <td>
                            <x-form.input type='text' wire:model='nameToEdit' wire:keydown.enter='update'
                                :error="'nameToEdit'" />
                        </td>
                        <td>
                            <x-form.input type='text' wire:model='numberToEdit' wire:keydown.enter='update'
                                :error="'numberToEdit'" />
                        </td>
                        <td>
                            <x-form.input type='text' wire:model='priceToEdit' wire:keydown.enter='update'
                                :error="'priceToEdit'" />
                        </td>
                    @else
                        <td>{{ $consultationRequestNursing->name }}</td>
                        <td class="text-center">{{ $consultationRequestNursing->number }}</td>
                        <td class="text-right">
                            {{ app_format_number(
                                $currencyName == 'USD' ? $consultationRequestNursing->getAmountUSD() : $consultationRequestNursing->getAmountCDF(),
                                1,
                            ) }}
                        </td>
                    @endif
                    <td class="text-right">
                        {{ app_format_number(
                            $currencyName == 'USD'
                                ? $consultationRequestNursing->getAmountUSD() * $consultationRequestNursing->number
                                : $consultationRequestNursing->getAmountCDF() * $consultationRequestNursing->number,
                            1,
                        ) }}
                    </td>
                    <td>
                        <x-form.edit-button-icon
                            wire:click="edit({{ $consultationRequestNursing->id }},
                                 {{ $consultationRequestNursing->number }})"
                            class="btn-sm" />
                        <x-form.delete-button-icon wire:confirm="Etes-vous sûre de supprimer ?"
                            wire:click="delete({{ $consultationRequestNursing }})" class="btn-sm" />
                    </td>
                </tr>
            @endforeach
             <tr class="bg-secondary">
                <td colspan="4" class="text-right">
                    <span class="text-bold text-lg"> TOTAL:
                        {{ app_format_number(
                            $currencyName == 'USD'
                                ? $consultationRequest->getNursingAmountUSD()
                                : $consultationRequest->getNursingAmountCDF(),
                            1,
                        ) }}
                    </span>
                </td>
            </tr>
        </tbody>
    </table>
</div>
