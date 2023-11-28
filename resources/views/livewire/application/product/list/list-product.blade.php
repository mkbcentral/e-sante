<div>
    @livewire('application.product.form.product-form-view')
    <x-navigation.bread-crumb icon='fa fa-capsules' label='PRODUITS PHARMACEUTIQUES' color="text-pink">
        <x-navigation.bread-crumb-item label='Dashboard' link='dashboard' isLinked=true/>
            <x-navigation.bread-crumb-item label='Produits pharmaceutique'/>
    </x-navigation.bread-crumb>
    <x-content.main-content-page>
        <div class="card card-pink">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h6><i class="fas fa-list"></i> LISTE DES PRODUITS</h6>
                    <x-form.input-search :bg="'btn-secondary'" wire:model.live.debounce.500ms="q"/>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-center">
                    <x-widget.loading-circular-md/>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="form-group mr-2">
                            <x-form.label value="{{ __('Catégorie') }}" class="text-pink"/>
                            <x-widget.list-product-category-widget wire:model.live="category_id" :error="'category_id'"/>
                        </div>
                        <div class="form-group">
                            <x-form.label value="{{ __('Famille') }}" class="text-pink"/>
                            <x-widget.list-product-family-widget wire:model.live="family_id" :error="'family_id'"/>
                        </div>
                    </div>
                    <x-form.button class="btn-secondary" wire:click="openCreationModal"><x-icons.icon-plus-circle/> Nouveau produit</x-form.button>
                </div>
                <table class="table table-bordered table-sm mt-0">
                    <thead class="bg-pink text-white">
                    <tr class="">
                        <th>
                            <x-form.button class="text-bold text-white" wire:click="sortProduct('butch_number')">N° LOT
                            </x-form.button>
                            <x-form.sort-icon sortField="butch_number" :sortAsc="$sortAsc" :sortBy="$sortBy"/>
                        </th>
                        <th class="">
                            <x-form.button class="text-bold text-white" wire:click="sortProduct('name')">DEISIGNATION
                            </x-form.button>
                            <x-form.sort-icon sortField="name" :sortAsc="$sortAsc" :sortBy="$sortBy"/>
                        </th>
                        <th class="text-center">
                            <x-form.button class="text-bold text-white" wire:click="sortProduct('initial_quantity')">Q.T
                                DISPO
                            </x-form.button>
                            <x-form.sort-icon sortField="initial_quantity" :sortAsc="$sortAsc" :sortBy="$sortBy"/>
                        </th>
                        <th class="text-right">
                            <x-form.button class="text-bold text-white" wire:click="sortProduct('price')">P.U FC
                            </x-form.button>
                            <x-form.sort-icon sortField="price" :sortAsc="$sortAsc" :sortBy="$sortBy"/>
                        </th>
                        <th class="text-right">
                            <x-form.button class="text-bold text-white" wire:click="sortProduct('expiration_date')">DATE
                                EXPIRATION
                            </x-form.button>
                            <x-form.sort-icon sortField="expiration_date" :sortAsc="$sortAsc" :sortBy="$sortBy"/>
                        </th>
                        <th class="text-right">FAMILLE</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($products->isEmpty())
                        <tr>
                            <td colspan="7">
                                <x-errors.data-empty/>
                            </td>
                        </tr>
                    @else
                        @foreach($products as  $product)
                            <tr style="cursor: pointer;">
                                <td class="text-center">{{$product->butch_number}}</td>
                                <td class="text-uppercase">{{$product->name}} <span
                                        class="text-bold text-pink">{{$product->abbreviation}}</span></td>
                                <td class="text-center">{{$product->initial_quantity}}</td>
                                <td class="text-right">{{$product->price}}</td>
                                <td class="text-right">{{$product->expiration_date->format('d/M/y')}}</td>
                                <td class="text-right text-bold text-uppercase">{{$product->family}}</td>
                                <td class="text-center">
                                    <x-form.edit-button-icon wire:click="edit({{$product}})" class="btn-sm"/>
                                    <x-form.delete-button-icon wire:click="showDeleteDialog({{$product}})" class="btn-sm"/>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
                <div
                    class="mt-4 d-flex justify-content-center align-items-center">{{$products->links('livewire::bootstrap')}}</div>
            </div>
        </div>
    </x-content.main-content-page>
    @push('js')
        <script type="module">
            //Open  new sheet form modal
            window.addEventListener('open-form-product',e=>{
                $('#form-product').modal('show')
            });
            //Confirmation dialog for delete role
            window.addEventListener('delete-product-dialog', event => {
                Swal.fire({
                    title: 'Voulez-vous vraimant ',
                    text: "retirer ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText:'Non'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('deleteProductListener');
                    }
                })
            });
            window.addEventListener('product-deleted', event => {
                Swal.fire(
                    'Action !',
                    event.detail[0].message,
                    'success'
                );
            });
        </script>
    @endpush
</div>
