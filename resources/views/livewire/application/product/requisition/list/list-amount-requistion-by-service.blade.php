<div>
    <x-modal.build-modal-fixed idModal='list-amount-requisition-by-service' size='lg'
        headerLabel="RECETTES PAR SERVICE" headerLabelIcon='fa fa-pills'>
        <form wire:submit='handlerSubmit'>
            <div class="card p-2">
                <table class="table table-light">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>SERVICE</th>
                            <th class="text-center">NBRE PRODUIT</th>
                            <th>MONTANT</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($agentServices as $index => $agentService)
                            @if ($agentService->productRequistions->count() > 0)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $agentService->name }}</td>
                                    <td class="text-center">{{ $agentService->productRequistions->count() }}</td>
                                    <td class="text-center">{{ $agentService->getAmountProduct() }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </form>
    </x-modal.build-modal-fixed>
    @push('js')
        <script type="module">
            //Open edit sheet modal
            window.addEventListener('close-list-amount-requisition-by-service', e => {
                $('#list-amount-requisition-by-service').modal('hide')
            });
        </script>
    @endpush
</div>
