<div>
    <div class="d-flex justify-content-end align-content-center">
        <div class="bg-navy p-1 rounded-lg pr-2">
            <h3 wire:loading.class="d-none"><i class="fas fa-coins ml-2"></i><span>Recettes</span>
                <span class="money_format">CDF: {{ app_format_number($tota_cdf, 1) }}</span> |
                <span class="money_format">USD: {{ app_format_number($tota_usd, 1) }}</span>
            </h3>
        </div>
        <div class="d-flex align-items-center">

        </div>
    </div>
    <div class="d-flex justify-content-center pb-2">
        <x-widget.loading-circular-md />
    </div>
    <div wire:loading.class='d-none'>
        <div class="d-flex justify-content-between align-items-center ">
            <div class="d-flex align-items-center">
                <div class="form-group d-flex align-items-center mr-2">
                    <x-form.label value="{{ __('Date') }}" class="mr-1" />
                    <x-form.input type='date' wire:model.live='date' :error="'date'" />
                </div>
                <div class="form-group d-flex align-items-center mr-2">
                    <x-form.label value="{{ __('Mois') }}" class="mr-1" />
                    <x-widget.list-french-month wire:model.live='month' :error="'month'" />
                </div>
            </div>
            <div class="d-flex align-items-center">
                <div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-secondary btn-sm"><i class="fas fa-print"></i>
                            Imprimer </button>
                        <button type="button" class="btn btn-secondary btn-sm dropdown-toggle dropdown-icon"
                            data-toggle="dropdown">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu" role="menu">
                            <a class="dropdown-item" target="_blanck"
                                href="{{ route('rapport.date.outPatientBill.print', [$date,$date_versement]) }}"><i
                                    class="fas fa-file-pdf"></i> Bordereau de versement</a>
                        </div>
                    </div>
                </div>
                <div class="form-group d-flex align-items-center ml-2">
                    <x-form.label value="{{ __('Date versment') }}" class="mr-1" />
                    <x-form.input type='date' wire:model.live='date_versement' :error="'date_versement'" />
                </div>

            </div>
        </div>
        <div wire:loading.class='d-none'>
            <table class="table table-striped table-sm">
                <thead class="bg-navy text-white text-uppercase">
                    <tr>
                        <th class="text-center">#</th>
                        <th>Date</th>
                        <th>#Invoice</th>
                        <th>Cleint</th>
                        <th class="text-right">M.T USD</th>
                        <th class="text-right">M.T CDF</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($listBill->isEmpty())
                        <tr>
                            <td colspan="5" class="text-center">Aucune données trpuvée</td>
                        </tr>
                    @else
                        @foreach ($listBill as $index => $bill)
                            <tr style="cursor: pointer;" id="row1">
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $bill->created_at->format('d/m/Y H:i:s') }}</td>
                                <td>A-{{ $bill->bill_number }}-PS</td>
                                <td>{{ $bill->client_name }}</td>
                                <td class="text-right money_format">
                                    @if ($bill->currency != null)
                                        @if ($bill->currency->name == 'USD')
                                            {{ app_format_number($bill->getTotalOutpatientBillUSD(), 1) }}
                                        @else
                                            -
                                        @endif
                                    @else
                                        @if ($bill->detailOutpatientBill)
                                            {{ app_format_number($bill->detailOutpatientBill->amount_usd, 1) }}
                                        @else
                                            -
                                        @endif
                                    @endif

                                </td>
                                <td class="text-right money_format">
                                    @if ($bill->currency)
                                        @if ($bill->currency->name == 'CDF')
                                            {{ app_format_number($bill->getTotalOutpatientBillCDF(), 1) }}
                                        @else
                                            -
                                        @endif
                                    @else
                                        @if ($bill->detailOutpatientBill)
                                            {{ app_format_number($bill->detailOutpatientBill->amount_cdf, 1) }}
                                        @else
                                            -
                                        @endif
                                    @endif

                                </td>

                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            <div class="mt-4 d-flex justify-content-between align-items-center">
                <div class="h5">
                    ({{ $counter_by_month > 1 ? $counter_by_month . ' Facture réalisée' : $counter_by_month . ' Factured réalisées' }})
                </div>
                {{ $listBill->links('livewire::bootstrap') }}
            </div>
        </div>
    </div>

</div>
