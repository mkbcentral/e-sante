<div>
    <x-modal.build-modal-fixed idModal='list-product-purcharse-modal' bg='bg-indigo' size='xl'
        headerLabel="LISTE DES PRODUIS A ACHATER" headerLabelIcon='fas fa-capsules'>
        @if ($productPurchase != null)
            <div class="d-flex justify-content-between align-content-center">
                <div class="d-flex align-content-center ">
                    <span class="text-center text-bold text-success">({{ $productPurchase->products->count() }} Produits
                        )</span>
                    <x-form.input-search :bg="'btn-secondary'" wire:model.live.debounce.500ms="q" />
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-link dropdown-icon" data-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fa fa-download" aria-hidden="true"></i>
                        Exporter
                    </button>
                    <div class="dropdown-menu" role="menu" style="">
                        <a class="dropdown-item" target="_blank" href="{{ route('product.purcharse.print',$productPurchase) }}" >
                            <i class="fa fa-file-pdf" aria-hidden="true"></i> Fichier PDF
                        </a>
                        <a class="dropdown-item" href="#" wire:click='exportProductPurchase'>
                            <i class="fa fa-file-excel" aria-hidden="true"></i> Fichier Excel
                        </a>
                    </div>
                </div>
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
                            <td
                                class="text-center
                                {{ $product->pivot->quantity_stock <= 5 ? 'bg-danger ' : $product->pivot->quantity_stock }}">
                                {{ $product->pivot->quantity_stock }}</td>
                            <td class="text-center">
                                @if ($isEditing && $idProduct == $product->id)
                                    <x-form.input type='number' wire:model='quantity_to_order'
                                        wire:keydown.enter='update' :error="'quantity_to_order'" />
                                @else
                                    {{ $product->pivot->quantity_to_order }}
                                @endif
                            </td>
                            <td class="text-center">
                                <x-form.icon-button :icon="'fas fa-pen'" class="btn-sm btn-info"
                                    wire:click="edit({{ $product->id }})" />
                                <x-form.icon-button :icon="'fas fa-trash'" class="btn-sm btn-danger"
                                    wire:click="delete({{ $product->id }})"
                                    wire:confirm="Etes-vous sûr de supprimer ?" />
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
