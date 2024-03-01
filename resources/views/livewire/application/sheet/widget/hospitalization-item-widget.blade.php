<div>
    <table class="table table-bordered table-sm">
        <thead class="thead-light">
            <tr>
                <th>DESIGNATION</th>
                <th class="text dt-center">NBRE</th>
                @if (Auth::user()->roles->pluck('name')->contains('Pharma') ||
                        Auth::user()->roles->pluck('name')->contains('Ag') ||
                        Auth::user()->roles->pluck('name')->contains('Admin'))
                    <th>PU</th>
                    <th>PT</th>
                @endif
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($consultationRequest->consultationRequestHospitalizations as $consultationRequestHospitalization)
                <tr>
                    @if ($isEditing == true && $idSelected == $consultationRequestHospitalization->id)
                        <td>
                            <x-widget.list-hospitalization-widget wire:model.blur='hospitalization_room_id'
                                :error="'hospitalization_room_id'" />
                        </td>
                        <td>
                            <x-form.input type='number' wire:model='numberOfDay' wire:keydown.enter='update'
                                :error="'numberOfDay'" />
                        </td>
                    @else
                        <td class="text-uppercase">-
                            {{ $consultationRequestHospitalization->hospitalizationRoom->hospitalization->name }}</td>
                        <td class="text-center" style="width: 50px">{{ $consultationRequestHospitalization->number_of_day }}</td>
                    @endif
                    @if (Auth::user()->roles->pluck('name')->contains('Pharma') ||
                            Auth::user()->roles->pluck('name')->contains('Ag') ||
                            Auth::user()->roles->pluck('name')->contains('Admin'))
                        <td>
                            {{ app_format_number(
                                $currencyName == 'USD'
                                    ? $consultationRequestHospitalization->hospitalizationRoom->hospitalization->getAmountPrivateUSD()
                                    : $consultationRequestHospitalization->hospitalizationRoom->hospitalization->getAmountPrivateCDF(),
                                1,
                            ) }}
                        </td>
                        <td>
                            {{ app_format_number(
                                $currencyName == 'USD'
                                    ? $consultationRequestHospitalization->hospitalizationRoom->hospitalization->getAmountPrivateUSD() *
                                        $consultationRequestHospitalization->number_of_day
                                    : $consultationRequestHospitalization->hospitalizationRoom->hospitalization->getAmountPrivateCDF() *
                                        $consultationRequestHospitalization->number_of_day,
                                1,
                            ) }}
                        </td>
                    @endif
                    <td class="text-center">
                        <x-form.edit-button-icon
                            wire:click="edit({{ $consultationRequestHospitalization->id }},
                                 {{ $consultationRequestHospitalization->number_of_day }})"
                            class="btn-sm btn-primary" />
                        <x-form.delete-button-icon wire:confirm="Etes-vous sûre de supprimer ?"
                            wire:click="delete({{ $consultationRequestHospitalization->id }})"
                             class="btn-sm btn-danger" />
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
                                $currencyName == 'USD'
                                    ? $consultationRequest->getHospitalizationAmountUSD()
                                    : $consultationRequest->getHospitalizationAmountCDF(),
                                1,
                            ) }}
                        </span>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
