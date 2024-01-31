<div>
    <table class="table table-light">
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
                    <td>{{ $consultationRequestNursing->name }}</td>
                    <td class="text-center">{{ $consultationRequestNursing->number }}</td>
                    <td class="text-right">
                        {{ $consultationRequestNursing->amount }}
                    </td>
                    <td class="text-right">
                        {{ $consultationRequestNursing->amount }}
                    </td>
                    <td>
                        <x-form.edit-button-icon
                            wire:click="edit({{ $consultationRequestHospitalization->id }},
                                 {{ $consultationRequestHospitalization->number_of_day }})"
                            class="btn-sm" />
                        <x-form.delete-button-icon wire:confirm="Etes-vous sûre de supprimer ?"
                            wire:click="delete({{ $consultationRequestHospitalization->id }})" class="btn-sm" />
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
