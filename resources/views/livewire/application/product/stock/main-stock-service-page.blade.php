<div wire:poll.15s>
    @livewire('application.product.requisition.form.new-product-requisition')
    @livewire('application.product.requisition.list.list-amount-requistion-by-service')
    @livewire('application.product.requisition.list-detail-product-requisition')
    <x-navigation.bread-crumb icon='fa fa-capsules' label='STOCK DES PRODUITS' color="text-success">
        <x-navigation.bread-crumb-item label='Dashboard' link='dashboard' isLinked=true />
        <x-navigation.bread-crumb-item label='Appro médicaments' />
    </x-navigation.bread-crumb>
    <x-content.main-content-page>
        <div class="card card-olive">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        @if (Auth::user()->stockService)
                            <x-form.button :icon="'fa fa-user-plus'" type="button" class="btn-primary"
                                wire:click='openAddProuctForm'>
                                <i class="fa fa-plus-circle" aria-hidden="true"></i> Ajouter les produits
                            </x-form.button>
                        @else
                            <x-form.button :icon="'fa fa-user-plus'" type="button" class="btn-success"
                                wire:click='createNewStock' wire:confirm='Etês-vous sure de créer le stock'>
                                <i class="fa fa-plus-circle" aria-hidden="true"></i> Créer mon stock
                            </x-form.button>
                        @endif

                    </div>
                    <div>
                        <x-form.input-search :bg="'btn-secondary'" wire:model.live.debounce.500ms="q" />
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <x-widget.loading-circular-md />
                </div>
                <table class="table table-bordered table-sm mt-2">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>DESIGNATION</th>
                            <th class="text-center">QT INITAILE</th>
                            <th class="text-center">ENTREES</th>
                            <th class="text-center">SORTIE</th>
                            <th class="text-center">QT DISPONIBLE</th>
                            <th class="text-right">PRIX</th>
                            <th class="text-center">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($products == null)
                         <tr>
                                <td colspan="8">
                                    <x-errors.data-empty />
                                </td>
                            </tr>
                        @else
                         @foreach ($products as $index => $product)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $product->name }}</td>
                                <td class="text-center">
                                    @if ($isEditing == true && $idProductToEdit == $product->id)
                                        <x-form.input type='number' wire:model='qtyToEdit' :error="'qtyToEdit'"
                                            wire:keydown.enter='update' />
                                    @else
                                        {{ $product->pivot->qty }}
                                    @endif
                                </td>
                                <td class="text-center">{{ $product->getGlobalInput() }}</td>
                                <td class="text-center">{{ $product->getGlobalOutput() }}</td>
                                <td class="text-center">{{ $product->getGlobalStock( $product->pivot->qty) }}</td>
                                <td class="text-right">{{ $product->price }} Fc</td>
                                <td class="text-center">
                                    <x-form.icon-button :icon="'fa fa-edit '" class="btn-sm btn-info"
                                        wire:click='edit({{ $product->id }},{{ $product->pivot->qty }})' />
                                    <x-form.icon-button :icon="'fa fa-trash '" class="btn-sm btn-danger" wire
                                        wire:confirm='Etês-vous sure de supprimer ?'
                                        wire:click="delete({{ $product->pivot->id }})" />
                                </td>
                            </tr>
                        @endforeach
                        @endif

                    </tbody>
                </table>
            </div>
            @if ($products != null)
                <div class="mt-4 d-flex justify-content-center align-items-center">
                {{ $products->links('livewire::bootstrap') }}</div>
            @endif

        </div>
    </x-content.main-content-page>
    @push('js')
        <script type="module">
            //Open  add new requisition model modal
            window.addEventListener('open-stock-service-product', e => {
                $('#form-stock-service-product').modal('show')
            })
        </script>
    @endpush
    @livewire('application.product.stock.form.add-product-to-stock-service-page')
</div>
