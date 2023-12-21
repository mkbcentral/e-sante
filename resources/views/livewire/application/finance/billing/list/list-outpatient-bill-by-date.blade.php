<div>
    <x-modal.build-modal-fixed idModal='list-outpatient-bill-by-date-modal' size='lg' bg='bg-pink'
        headerLabel="LISTE DES FACTURES" headerLabelIcon='fa fa-file'>
        <div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>N° Fracture</th>
                        <th>Cleint</th>
                        <th>Montant</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($listBill->isEmpty())
                        <tr>
                            <td colspan="5" class="text-center">Aucune données trpuvée</td>
                        </tr>
                    @else
                        @foreach ($listBill as $index => $bill)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $bill->bill_number }}</td>
                                <td>{{ $bill->client_name }}</td>
                                <td class="text-right">{{ $bill->getTotalOutpatientBillCDF() }} Fc</td>
                                <td>
                                    <x-form.edit-button-icon
                                        wire:click="edit({{ $bill}})"
                                        class="btn-sm" />
                                    <x-form.delete-button-icon wire:confirm="Etes-vous de supprimer?"
                                        wire:click="delete({{ $bill}})" class="btn-sm" />
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </x-modal.build-modal-fixed>
    @push('js')
        <script type="module">
            //Open edit sheet modal
            window.addEventListener('close-list-outpatient-bill-by-date-modal', e => {
                $('#list-outpatient-bill-by-date-modal').modal('hide')
            });
        </script>
    @endpush
</div>
