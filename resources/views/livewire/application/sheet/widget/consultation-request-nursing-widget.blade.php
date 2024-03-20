<div>
    <table class="table table-bordered table-sm">
        <thead class="thead-light">
            <tr>
                <th>DESIGNATION</th>
                <th class="text-center">NBRE</th>
                @if (Auth::user()->roles->pluck('name')->contains('Pharma') ||
                        Auth::user()->roles->pluck('name')->contains('Ag') ||
                        Auth::user()->roles->pluck('name')->contains('Admin'))
                    <th class="text-right">PU</th>
                    <th class="text-right">PT</th>
                @endif
                <th class="text-center">Actions</th>
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
                        @if (Auth::user()->roles->pluck('name')->contains('Pharma') ||
                                Auth::user()->roles->pluck('name')->contains('Ag') ||
                                Auth::user()->roles->pluck('name')->contains('Admin'))
                            <td>
                                <x-form.input type='text' wire:model='priceToEdit' wire:keydown.enter='update'
                                    :error="'priceToEdit'" />
                            </td>
                        @endif
                    @else
                        <td>{{ $consultationRequestNursing->name }}</td>
                        <td class="text-center" style="width: 50px">{{ $consultationRequestNursing->number }}</td>
                        @if (Auth::user()->roles->pluck('name')->contains('Pharma') ||
                                Auth::user()->roles->pluck('name')->contains('Ag') ||
                                Auth::user()->roles->pluck('name')->contains('Admin'))
                            <td class="text-right">
                                {{ app_format_number(
                                    $currencyName == 'USD' ? $consultationRequestNursing->getAmountUSD() : $consultationRequestNursing->getAmountCDF(),
                                    1,
                                ) }}
                            </td>
                        @endif
                    @endif
                    @if (Auth::user()->roles->pluck('name')->contains('Pharma') ||
                            Auth::user()->roles->pluck('name')->contains('Ag') ||
                            Auth::user()->roles->pluck('name')->contains('Admin'))
                        <td class="text-right">
                            {{ app_format_number(
                                $currencyName == 'USD'
                                    ? $consultationRequestNursing->getAmountUSD() * $consultationRequestNursing->number
                                    : $consultationRequestNursing->getAmountCDF() * $consultationRequestNursing->number,
                                1,
                            ) }}
                        </td>
                    @endif
                    <td class="text-center">
                        @if ($consultationRequest->is_printed == false)
                            <x-form.edit-button-icon
                                wire:click="edit({{ $consultationRequestNursing->id }},
                                 {{ $consultationRequestNursing->number }})"
                                class="btn-sm btn-primary" />
                            <x-form.delete-button-icon wire:confirm="Etes-vous sûre de supprimer ?"
                                wire:click="delete({{ $consultationRequestNursing }})" class="btn-sm btn-danger" />
                        @endif
                    </td>
                </tr>
            @endforeach
            @if (Auth::user()->roles->pluck('name')->contains('Pharma') ||
                    Auth::user()->roles->pluck('name')->contains('Ag') ||
                    Auth::user()->roles->pluck('name')->contains('Admin'))
                <tr class="bg-secondary">
                    <td colspan="4" class="text-right">
                        <span class="text-bold text-lg"> TOTAL:
                            {{ app_format_number(
                                $currencyName == 'USD' ? $consultationRequest->getNursingAmountUSD() : $consultationRequest->getNursingAmountCDF(),
                                1,
                            ) }}
                        </span>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
