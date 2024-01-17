<div>
    <div class="d-flex justify-content-between align-content-center">
        <div>
            <h4 wire:loading.class="d-none">
                <span class="text-indigo">Total: {{ app_format_number($totalBills, 1) }} {{ $currencyName }}</span>
            </h4>
        </div>
        <div class="d-flex align-items-center">
            <div class="d-flex align-items-center mr-2">
                <x-form.label value="{{ __('Date') }}" class="mr-1" />
                <x-widget.list-fr-months wire:model.live='month' :error="'month'" />
            </div>
            <div class="d-flex align-items-center">
                <x-form.label value="{{ __('Devise') }}" class="mr-1" />
                @livewire('application.finance.widget.currency-widget')
            </div>
        </div>

    </div>
    <div class="d-flex justify-content-center pb-2">
        <x-widget.loading-circular-md />
    </div>
    <div wire:loading.class='d-none'>
        <table class="table table-bordered table-sm ">
            <thead class="bg-indigo">
                <tr>
                    <th class="text-center">#</th>
                    <th>N° Fracture</th>
                    <th>Cleint</th>
                    <th class="text-right">Montant</th>
                    <th class="text-lg-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if ($listBill->isEmpty())
                    <tr>
                        <td colspan="5" class="text-center">
                            <x-errors.data-empty />
                        </td>
                    </tr>
                @else
                    @foreach ($listBill as $index => $bill)
                        <tr class="cursor-hand" id="row1">
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $bill->bill_number }}</td>
                            <td>{{ $bill->client_name }}</td>
                            <td class="text-right">
                                {{ $currencyName == 'CDF'
                                    ? app_format_number($bill->getTotalOutpatientBillCDF(), 1) . 'Fc'
                                    : app_format_number($bill->getTotalOutpatientBillUSD(), 0) . '$' }}
                            </td>
                            <td class="text-center">
                                <x-form.delete-button-icon wire:confirm="Etes-vous de supprimer?"
                                    wire:click="delete({{ $bill }})" class="btn-sm" />
                                <a href="{{ route('outPatientBill.print', [$bill,$currencyName]) }}" target="_blanck"><i
                                        class="fa fa-print" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
