<div>
    <x-modal.build-modal-fixed idModal='list-product-purcharse-modal' bg='bg-indigo' size='xl'
        headerLabel="LISTE DES PRODUIS A ACHATER" headerLabelIcon='fas fa-capsules'>
        @if ($productPurchase != null)
        <div>
             <x-form.input-search :bg="'btn-secondary'" wire:model.live.debounce.500ms="q" />
        </div>
            <table class="table table-bordered table-sm">
                <thead class="bg-indigo">
                    <tr>
                        <th>#</th>
                        <th>DESIGNATION</th>
                        <th class="text-center">QUANTITE INIT</th>
                        <th class="text-center">QUANTITE DMD</th>
                        <th>ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $index => $product)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $product->name }}</td>
                            <td class="text-center">{{ $product->pivot->quantity_stock }}</td>
                            <td class="text-center">{{ $product->pivot->quantity_to_order }}</td>
                            <td>

                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
            <div class="mt-4 d-flex justify-content-center align-items-center">
                {{ $products->links('livewire::bootstrap') }}</div>
        @endif
    </x-modal.build-modal-fixed>
    @push('js')
        <script type="module">
            //close elist product purcharse modal
            window.addEventListener('close-list-product-purcharse-modal', e => {
                $('#list-product-purcharse-modal').modal('hide')
            });
        </script>
    @endpush
</div>
