<div class="card">
    @livewire('application.finance.cashbox.list.list-payroll-items-view')
    <x-navigation.bread-crumb icon='fa fa-file' label='ETAT DE PAIE' color="text-indigo">
        <x-navigation.bread-crumb-item label='Dashboard' link='dashboard' isLinked=true />
        <x-navigation.bread-crumb-item label='Etat de paie' />
    </x-navigation.bread-crumb>
    <x-content.main-content-page>
        <div class="card card-indigo">
            <div class="card-header">
                <H4><i class="fa fa-list" aria-hidden="true"></i> RAPPORT ETATS DE PAIE MENSUEL</H4>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="mr-2 d-flex">
                        <div class="d-flex align-items-center">
                            <span class="mr-2">Mois</span>
                            <x-widget.list-french-month wire:model.live='month' :error="'month'" />
                        </div>
                        <div class="d-flex align-items-center ml-4">
                            <span class="mr-2">Source</span>
                            <x-widget.finance.source-payroll wire:model.live='source' :error="'source'" />
                        </div>
                        <div class="d-flex align-items-center ml-4">
                            <span class="mr-2">Categorie</span>
                            <x-widget.finance.category-payroll wire:model.live='category' :error="'category'" />
                        </div>
                        <div class="d-flex  ml-2 mt-4">
                            <span class="mr-2">Devise</span>
                            <x-widget.finance.fin-currency wire:model.live="currency_id" />
                        </div>
                        <x-others.dropdown title="Expoter" icon="fas fa-file-export">
                            <x-others.dropdown-link iconLink='fa fa-file-excel' labelText='Sous Excel' href="#"
                                wire:click='exportToExcel' />
                            <x-others.dropdown-link iconLink='fa fa-file-pdf' labelText='Sous pdf'
                                href="{{ route('print.payroll.month', [$month, $source, $category, $currency_id]) }}"
                                target='_blanck' />
                        </x-others.dropdown>
                    </div>
                    <div class="badge badge-primary">
                        <h3 class="text-uppercase"><i class="fas fa-coins    "></i> Total:
                            {{ app_format_number($totalUSD, 1) }} USD | {{ app_format_number($totalCDF, 1) }} CDF</h3>
                    </div>
                </div>
                <div class="d-flex justify-content-center pb-2 mt-2">
                    <x-widget.loading-circular-md />
                </div>
                <table class="table table-striped mt-1 table-sm">
                    <thead class="bg-indigo">
                        <tr class="text-uppercase">
                            <th>#</th>
                            <th>Date</th>
                            <th class="text-center">Numéro</th>
                            <th>Description</th>
                            <th class="text-center">Nbre</th>
                            <th class="text-right">M.T USD</th>
                            <th class="text-right">M.T CDF</th>
                            <th class="text-right">Source</th>
                            <th class="text-right">MOTIF</th>
                            <th class="text-center">STATUS</th>
                            <th class=" text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($payRolls->isEmpty())
                            <tr>
                                <td colspan="12"> <x-errors.data-empty /></td>
                            </tr>
                        @else
                            @foreach ($payRolls as $index => $payRoll)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $payRoll->created_at->format('d/m/Y H:i:s') }}</td>
                                    <td class="text-center">{{ $payRoll->number }}</td>
                                    <td>{{ $payRoll->description }}</td>
                                    <td class="text-center">{{ $payRoll->getCouterPayRollItems() }}</td>
                                    <td class="text-right">
                                        @if ($payRoll->currency->name == 'USD')
                                            {{ app_format_number($payRoll->getPayrollTotalAmount(), 1) }}
                                            {{ $payRoll->currency->name }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        @if ($payRoll->currency->name == 'CDF')
                                            {{ app_format_number($payRoll->getPayrollTotalAmount(), 1) }}
                                            {{ $payRoll->currency->name }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-right">{{ $payRoll->payrollSource->name }}</td>
                                    <td class="text-right">{{ $payRoll->categorySpendMoney->name }}</td>
                                    <td class="text-center">
                                        @if ($payRoll->is_valided == true)
                                            <span class="badge badge-success">Cloturé</span>
                                        @else
                                            <span class="badge badge-warning">En cours</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <x-form.icon-button :icon="'fa fa-eye '" class="btn-sm btn-primary"
                                            wire:click='addItems({{ $payRoll }})' />
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </x-content.main-content-page>
    @push('js')
        <script type="module">
            //Open lits payroll items modal
            window.addEventListener('open-list-pay-roll-items', e => {
                $('#list-pay-roll-items').modal('show')
            });
        </script>
    @endpush
</div>
