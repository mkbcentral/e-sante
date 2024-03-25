<div  class="card" >
    @livewire('application.finance.cashbox.list.list-payroll-items-view')
    <x-navigation.bread-crumb icon='fa fa-file' label='ETAT DE PAIE' color="text-success">
        <x-navigation.bread-crumb-item label='Dashboard' link='dashboard' isLinked=true />
        <x-navigation.bread-crumb-item label='Etat de paie' />
    </x-navigation.bread-crumb>
    <x-content.main-content-page>
        <div class="card card-success">
            <div class="card-header">
                <H4><i class="fa fa-list" aria-hidden="true"></i> RAPPORT ETATS DE PAIE MENSUEL</H4>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="badge badge-info">
                        <h3 class="text-uppercase">Total: {{ app_format_number($totalUSD, 1) }} USD | {{ app_format_number($totalCDF, 1) }} CDF</h3>
                    </div>
                    <div class="mr-2">
                        <x-widget.list-fr-months wire:model.live='month' :error="'month'" />
                    </div>
                </div>
                <div class="d-flex justify-content-center pb-2 mt-2">
                    <x-widget.loading-circular-md />
                </div>
                <table class="table table-striped mt-1 table-sm">
                    <thead class="bg-success">
                        <tr class="text-uppercase">
                            <th>#</th>
                            <th>Date</th>
                            <th class="text-center">Numéro</th>
                            <th>Description</th>
                            <th class="text-center">Nbre</th>
                            <th class="text-right">Montant</th>
                                <th class="text-center">STATUS</th>
                            <th class=" text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($payRolls->isEmpty())
                            <tr>
                                <td colspan="8"> <x-errors.data-empty /></td>
                            </tr>
                        @else
                            @foreach ($payRolls as $index => $payRoll)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $payRoll->created_at->format('d/m/Y H:i:s') }}</td>
                                    <td class="text-center">{{ $payRoll->number }}</td>
                                    <td>{{ $payRoll->description }}</td>
                                    <td class="text-center">{{ $payRoll->getCouterPayRollItems() }}</td>
                                    <td class="text-right">{{ app_format_number($payRoll->getPayrollTotalAmount(), 1) }}
                                        {{ $payRoll->currency->name }}</td>
                                    <td class="text-center">
                                        @if ($payRoll->is_valided == true)
                                            <span class="badge badge-success">Cloturé</span>
                                        @else
                                            <span class="badge badge-warning">En cours</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                         <x-form.icon-button :icon="'fa fa-sync '" class="btn-sm btn-info"
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
