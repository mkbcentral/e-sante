<div wire:ignore.self>
    @foreach ($categoriesTarif as $index => $categoryTarif)
        @if (!$categoryTarif->getConsultationTarifItems($consultationRequest, $categoryTarif)->isEmpty())
            <div class="d-flex justify-content-between">
                <h5 class="text-danger text-bold">{{ $categoryTarif->name }}</h5>
                <x-form.button class="btn-warning btn-sm" type='button' wire:click='newTarifItem({{ $categoryTarif->id }})'>
                    <i class="fa fa-plus" aria-hidden="true"></i>
                </x-form.button>
            </div>
            @if ($categoryIdSelected == $categoryTarif->id && $is_add == true)
                <select class="form-control" wire:model.live='idTarifToAdd'>
                    @foreach ($categoryTarif->tarifs as $t)
                        <option value="{{ $t->id }}" class="text-uppercase">
                            {{ $t->abbreviation == null ? $t->name : $t->abbreviation }}
                        </option>
                    @endforeach
                </select>
            @endif
            <table class="table table-bordered table-sm">
                <thead class="bg-primary">
                    <tr>
                        <th class="">DESIGNATION</th>
                        <th class="text-center">NOMBRE</th>
                        @if (Auth::user()->roles->pluck('name')->contains('Pharma') ||
                                Auth::user()->roles->pluck('name')->contains('Ag') ||
                                Auth::user()->roles->pluck('name')->contains('Admin'))
                            <th class="text-right">P.U CDF</th>
                            <th class="text-right">P.T CDF</th>
                        @endif
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categoryTarif->getConsultationTarifItems($consultationRequest, $categoryTarif) as $item)
                        <tr style="cursor: pointer;" wire:key="{{ $item->id }}">
                            <td class="text-uppercase">
                                @if ($isEditing && $idSelected == $item->id)
                                    <select class="form-control" wire:model.live='idTarif'>
                                        @foreach ($tarifs as $tarif)
                                            <option value="{{ $tarif->id }}" class="text-uppercase">
                                                {{ $tarif->abbreviation == null ? $tarif->name : $tarif->abbreviation }}
                                            </option>
                                        @endforeach
                                    </select>
                                @else
                                    - {{ $item->abbreviation == '' ? $item->name : $item->abbreviation }}
                                @endif
                            </td>
                            <td class="text-uppercase text-center">
                                @if ($isEditing && $idSelected == $item->id)
                                    <x-form.input type='text' wire:model='qty' wire:keydown.enter='update'
                                        :error="'qty'" />
                                @else
                                    {{ $item->qty }}
                                @endif
                            </td>
                            @if (Auth::user()->roles->pluck('name')->contains('Pharma') ||
                                    Auth::user()->roles->pluck('name')->contains('Ag') ||
                                    Auth::user()->roles->pluck('name')->contains('Admin'))
                                <td class="text-right">
                                    {{ app_format_number(
                                        $currencyName == 'USD'
                                            ? $categoryTarif->getUnitPriceUSD($consultationRequest, $item->id_tarif)
                                            : $categoryTarif->getUnitPriceCDF($consultationRequest, $item->id_tarif),
                                        1,
                                    ) }}
                                </td>
                                <td class="text-right">
                                    {{ app_format_number(
                                        $currencyName == 'USD'
                                            ? $categoryTarif->getTotalPriceUSD($consultationRequest, $item->qty, $item->id_tarif)
                                            : $categoryTarif->getTotalPriceCDF($consultationRequest, $item->qty, $item->id_tarif),
                                        1,
                                    ) }}
                                </td>
                            @endif

                            <td class="text-center">
                                @if ($consultationRequest->is_printed == false)
                                    <x-form.edit-button-icon
                                        wire:click="edit({{ $item->id }},{{ $item->qty }},{{ $item->category_id }},{{ $item->id_tarif }})"
                                        class="btn-sm btn-primary" />
                                    <x-form.delete-button-icon wire:confirm="Etes-vous sûre de supprimer ?"
                                        wire:click="delete({{ $item->id }})" class="btn-sm btn-danger" />
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
                                        $currencyName == 'USD'
                                            ? $categoryTarif->getTotalTarifInvoiceByCategoryUSD($consultationRequest, $categoryTarif)
                                            : $categoryTarif->getTotalTarifInvoiceByCategoryCDF($consultationRequest, $categoryTarif),
                                        1,
                                    ) }}</span>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        @endif
    @endforeach
    @push('js')
        <script type="module">
            $(function() {
                //Initialize Select2 Elements
                $('.selectTarif2').select2({
                    theme: 'bootstrap4'
                }).on('change', function(e) {
                    console.log(e.target.value);
                    @this.set('idTarif', e.target.value);
                });
            })
        </script>
    @endpush
</div>
