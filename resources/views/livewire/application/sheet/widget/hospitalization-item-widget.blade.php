<div>
    <table class="table table-light">
        <thead class="thead-light">
            <tr>
                <th>DESIGNATION</th>
                <th class="text dt-center">NBRE</th>
                <th>PU</th>
                <th>PT</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($consultationRequest->consultationRequestHospitalizations as $consultationRequestHospitalization)
                <tr>
                    @if ($isEditing==true && $idSelected == $consultationRequestHospitalization->id)
                        <td>
                            <x-widget.list-hospitalization-widget wire:model.blur='hospitalization_room_id'
                                :error="'hospitalization_room_id'" />
                        </td>
                        <td>
                            <x-form.input type='number' wire:model='numberOfDay'
                                wire:keydown.enter='update' :error="'numberOfDay'" />
                        </td>
                    @else
                        <td class="text-center">{{ $consultationRequestHospitalization->hospitalizationRoom->hospitalization->name }}</td>
                        <td>{{ $consultationRequestHospitalization->number_of_day }}</td>
                    @endif
                    <td>{{ $consultationRequestHospitalization->hospitalizationRoom->hospitalization->price_private }}
                    </td>
                    <td>{{ $consultationRequestHospitalization->hospitalizationRoom->hospitalization->price_private * $consultationRequestHospitalization->number_of_day }}
                    </td>
                    <td>
                        <x-form.edit-button-icon
                            wire:click="edit({{ $consultationRequestHospitalization->id }},
                                 {{ $consultationRequestHospitalization->number_of_day }})"
                            class="btn-sm" />
                        <x-form.delete-button-icon wire:confirm="Etes-vous sûre de supprimer ?" wire:click="delete({{ $consultationRequestHospitalization->id }})"
                            class="btn-sm" />
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
