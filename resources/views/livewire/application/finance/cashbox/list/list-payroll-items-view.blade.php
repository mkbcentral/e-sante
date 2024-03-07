<div>
    <x-modal.build-modal-fixed idModal='list-pay-roll-items' bg='bg-success' size='xl'
        headerLabel="DETAIL ETAT DE PAIE" headerLabelIcon="fa fa-list">
        @if ($payroll)
            <div class="row">
                <div class="col-md-8">
                    <div class="card ">
                        <div class="card-body">
                            <h5 class="card-title"><span class="text-success text-bold">N°: </span>
                                {{ $payroll->number }}</h5><br>
                            <h5 class="card-title"><span class="text-success text-bold">Description: </span>
                                {{ $payroll->description }}</h5><br>
                            <h5 class="card-title"><span class="text-success text-bold">Date: </span>
                                {{ $payroll->created_at->format('d/m/Y H:i:s') }}</h5>
                        </div>
                    </div>
                    <table class="table table-striped table-sm">
                        <thead class="bg-success">
                            <tr class="text-uppercase">
                                <th>#</th>
                                <th>Nom</th>
                                <th class="text-center">Service</th>
                                <th class="text-right">Montant</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payroll->payRollItems as $index => $payRollItem)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $payRollItem->name }}</td>
                                    <td class="text-center">{{ $payRollItem->agentService->name }}</td>
                                    <td class="text-right">{{ $payRollItem->amount }}</td>
                                    <td class="text-center">
                                        <x-form.icon-button :icon="'fa fa-pen '" class="btn-sm btn-info"
                                            wire:click='edit({{ $payRollItem }})' />
                                        <x-form.icon-button :icon="'fa fa-trash '" class="btn-sm btn-danger"
                                            wire:confirm="Etes-vous sûre de supprimer ?"
                                            wire:click='delete({{ $payRollItem }})' />
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-md-4">
                    @livewire('application.finance.cashbox.forms.new-pay-roll-item-view', [
                        'payroll' => $payroll,
                    ])
                </div>
            </div>
        @endif
    </x-modal.build-modal-fixed>
    @push('js')
        <script type="module">
            //Open edit sheet modal
            window.addEventListener('close-list-pay-roll-items', e => {
                $('#list-pay-roll-items').modal('hide')
            });
        </script>
    @endpush
</div>
