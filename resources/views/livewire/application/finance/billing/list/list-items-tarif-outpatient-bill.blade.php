<div>
    <div class="card card-pink">
        <div class="card-header">
            Détail factures
        </div>
        <div class="card-body">
            <table class="table table-bordered table-sm">
                <thead>
                    <tr class="text-uppercase text-primary">
                        <th>Designation</th>
                        <th class="text-center">Nbre</th>
                        <th class="text-right">PU</th>
                        <th class="text-right">PT</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-danger text-bold">
                        <td class="">{{ $outpatientBill->consultation->name }}</td>
                        <td colspan="3" class="text-right">{{ $outpatientBill->consultation->price_private }}</td>
                    </tr>
                    @foreach ($outpatientBill->tarifs as $index => $tarif)
                        <tr>
                            <td>{{ $tarif->name }}/<span class="text-bold">{{ $tarif->categoryTarif->name }}</span>
                            </td>
                            <td class="text-center">
                                @if ($isEditing && $idSelected == $tarif->pivot->id)
                                    <x-form.input type='text' wire:model='qty' wire:keydown.enter='update'
                                        :error="'qty'" />
                                @else
                                    {{ $tarif->pivot->qty }}
                                @endif
                            </td>
                            <td class="text-right">{{ $tarif->price_private }}</td>
                            <td class="text-right">{{ $tarif->price_private * $tarif->pivot->qty }}</td>
                            <td>
                                <x-form.edit-button-icon
                                    wire:click="edit({{ $tarif->pivot->id }},{{ $tarif->pivot->qty }})"
                                    class="btn-sm" />
                                <x-form.delete-button-icon wire:confirm="Etes-vous de supprimer?"
                                    wire:click="delete({{ $tarif->pivot->id }})" class="btn-sm" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
