<div>
    @livewire('application.finance.cashbox.forms.new-pay-roll-view')
    @livewire('application.finance.cashbox.list.list-payroll-items-view')
    <x-navigation.bread-crumb icon='fa fa-capsules' label='ETAT DE PAIE' color="text-success">
        <x-navigation.bread-crumb-item label='Dashboard' link='dashboard' isLinked=true />
        <x-navigation.bread-crumb-item label='Etat de paie' />
    </x-navigation.bread-crumb>
    <x-content.main-content-page>
        <div class="card card-success">
            <div class="card-header">
                <span>LISTE DES ETATS DE PAIE</span>

            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-content-center">
                    <x-form.button :icon="'fa fa-user-plus'" type="button" class="btn-success" wire:click='openAddModal'>
                        <i class="fa fa-file" aria-hidden="true"></i> Créer...
                    </x-form.button>
                </div>

                <table class="table table-striped mt-1 table-sm">
                    <thead class="bg-success">
                        <tr class="text-uppercase">
                            <th>#</th>
                            <th>Date</th>
                            <th>Numéro</th>
                            <th>Description</th>
                            <th class="text-center">Nbre</th>
                            <th class="text-right">Montant</th>
                            <th class=" text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payRolls as $index => $payRoll)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $payRoll->created_at->format('d/m/Y H:i:s') }}</td>
                                <td>{{ $payRoll->number }}</td>
                                <td>{{ $payRoll->description }}</td>
                                <td class="text-center">{{ $payRoll->getCouterPayRollItems() }}</td>
                                <td class="text-right">{{ 0 }}</td>
                                <td class="text-center">
                                    <x-form.icon-button :icon="'fa fa-plus '" class="btn-sm btn-info"
                                        wire:click='addItems({{ $payRoll }})' />
                                    <x-form.icon-button :icon="'fa fa-pen '" class="btn-sm btn-info"
                                        wire:click='edit({{ $payRoll }})' />
                                    <x-form.icon-button :icon="'fa fa-trash '" class="btn-sm btn-danger"
                                        wire:confirm="Etes-vous sûre de supprimer ?"
                                        wire:click='delete({{ $payRoll }})' />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </x-content.main-content-page>
    @push('js')
        <script type="module">
            //Open  add new payroll modal
            window.addEventListener('open-form-pay-roll', e => {
                $('#form-pay-roll').modal('show')
            });
            //Open lits payroll items modal
            window.addEventListener('open-list-pay-roll-items', e => {
                $('#list-pay-roll-items').modal('show')
            });
        </script>
    @endpush
</div>
