<div>
    <div class="card card-indigo">
        <div class="card-header">
            <h3 class="text-uppercase"><i class="fa fa-list" aria-hidden="true"></i> Détail factures</h3>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-center pb-2">
                <x-widget.loading-circular-md />
            </div>
            @if ($outpatientBill->consultation->price_private>0)
                <table class="table table-borderless bg-indigo">
                <tbody>
                    <tr class=" text-bold">
                        <td class="">{{ $outpatientBill->consultation->name }}</td>
                        <td colspan="5" class="text-right">
                            {{ $currencyName == 'CDF'
                                ? $outpatientBill->consultation->getAmountPrivateCDF()
                                : $outpatientBill->consultation->price_private }}
                            {{ $currencyName }}
                        </td>
                    </tr>
                </tbody>
            </table>
            @endif

            @if (!$tarifs->isEmpty())
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
                        @foreach ($tarifs as $index => $tarif)
                            <tr>
                                <td>{{ $tarif->abbreviation == null ? $tarif->name : $tarif->abbreviation }}
                                </td>
                                <td class="text-center">
                                    @if ($isEditing && $idSelected == $tarif->id)
                                        <x-form.input type='text' style="width: 50px" wire:model='qty'
                                            wire:keydown.enter='update' :error="'qty'" />
                                    @else
                                        {{ $tarif->qty }}
                                    @endif
                                </td>
                                <td class="text-right">
                                    {{ $currencyName == 'USD'
                                        ? app_format_number($tarif->price_private, 0)
                                        : app_format_number($tarif->price_private * $outpatientBill->rate->rate, 1) }}
                                </td>
                                <td class="text-right">
                                    {{ $currencyName == 'USD'
                                        ? app_format_number($tarif->price_private * $tarif->qty,0)
                                        : app_format_number($tarif->price_private * $tarif->qty * $outpatientBill->rate->rate, 1) }}
                                </td>
                                <td>
                                    <x-form.edit-button-icon wire:click="edit({{ $tarif->id }},{{ $tarif->qty }})"
                                        class="btn-sm" />
                                    <x-form.delete-button-icon wire:confirm="Etes-vous de supprimer?"
                                        wire:click="delete({{ $tarif->id }})" class="btn-sm" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
