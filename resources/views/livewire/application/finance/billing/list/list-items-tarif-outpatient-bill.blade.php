<div>
    <div class="card card-indigo">
        <div class="card-header">
            <h3>Détail factures</h3>
        </div>
        <div class="card-body">
            <table class="table table-borderless bg-indigo">
                <tbody>
                    <tr class=" text-bold">
                        <td class="">{{ $outpatientBill->consultation->name }}</td>
                        <td colspan="5" class="text-right">{{ $outpatientBill->consultation->price_private }}</td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered table-sm">
                <thead>
                    <tr class="text-uppercase text-primary">
                        <th>Designation</th>
                        <th class="text-center">Nbre</th>
                        <th class="text-right">PU {{ $currencyName }}</th>
                        <th class="text-right">PT {{ $currencyName }}</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($outpatientBill->tarifs as $index => $tarif)
                    <tr>
                        <td>{{ $tarif->name }}
                        </td>
                        <td class="text-center">
                            @if ($isEditing && $idSelected == $tarif->pivot->id)
                            <x-form.input type='text' style="width: 50px" wire:model='qty' wire:keydown.enter='update' :error="'qty'" />
                            @else
                            {{ $tarif->pivot->qty }}
                            @endif
                        </td>
                        <td class="text-right">{{ $currencyName!='CDF'?
                           app_format_number($tarif->getPricePrivateOutpatientBillUSD(),1):
                            app_format_number($tarif->getPricePrivateOutpatientBillCDF($outpatientBill,$tarif->pivot->qty),1) }}
                        </td>
                        <td class="text-right">
                            {{ $currencyName!='CDF'?
                               app_format_number($tarif->getPricePrivateOutpatientBillCaculateUSD($outpatientBill,$tarif->pivot->qty),1):
                               app_format_number($tarif->getPricePrivateOutpatientBillCalculateCDF($outpatientBill,$tarif->pivot->qty),1)
                            }}
                        </td>
                        <td>
                            <x-form.edit-button-icon wire:click="edit({{ $tarif->pivot->id }},{{ $tarif->pivot->qty }})"
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
