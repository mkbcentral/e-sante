<div>
    <div class="card card-success">
        <div class="card-header">
            <h4>LISTE DES EXEMENS PRELEVES</h4>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-center pb-2">
                <x-widget.loading-circular-md />
            </div>
            <table class="table table-striped table-sm">
                <thead class="bg-success">
                    <tr>
                        <th>EXAMEN</th>
                        <th class="text-center">NBRE</th>
                        <th class="text-center">RESULTAT</th>
                        <th class="text-center">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($categroryTarif->getConsultationTarifItems($consultationRequest, $categroryTarif)->isEmpty())
                          <tr>
                                <td colspan="4" class="text-center"> <x-errors.data-empty /></td>
                            </tr>
                    @else
                         @foreach ($categroryTarif->getConsultationTarifItems($consultationRequest, $categroryTarif) as $tarif)
                        <tr>
                            <td>{{ $tarif->abbreviation == null ? $tarif->name : $tarif->abbreviation }}</td>
                            <td class="text-xl-center">
                                @if ($isEditing && $idTarif == $tarif->id)
                                    <x-form.input type='number' style="width: 70px;text-align: center" wire:model='qty' wire:keydown.enter='update'
                                        :error="'qty'" />
                                @else
                                    {{ $tarif->qty }}
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($isEditing && $idTarif == $tarif->id)
                                    <x-form.input type='text' wire:model='result' wire:keydown.enter='update'
                                        :error="'result'" />
                                @else
                                    {{ $tarif->result == null ? 'Aucun' : $tarif->result }}
                                @endif
                            </td>
                            <td class="text-center">
                                <x-form.edit-button-icon wire:click='edit({{ $tarif->id }})'
                                    class="btn-sm btn-primary" />
                                <x-form.delete-button-icon wire:click='delete({{ $tarif->id }})'
                                    wire:confirm="Etes-vous de supprimer?" class="btn-sm btn-danger" />
                            </td>
                        </tr>
                    @endforeach
                    @endif

                </tbody>
            </table>
        </div>
    </div>
</div>
