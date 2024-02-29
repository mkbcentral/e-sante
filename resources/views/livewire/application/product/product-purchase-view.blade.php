<div>
    @livewire('application.product.purcharse.list-product-purchase')
    <x-navigation.bread-crumb icon='fa fa-capsules' label='ACHAT DES PRODUITS' color="text-pink">
        <x-navigation.bread-crumb-item label='Dashboard' link='dashboard' isLinked=true />
        <x-navigation.bread-crumb-item label='Achat products' />
    </x-navigation.bread-crumb>
    <x-content.main-content-page>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-indigo">
                    <div class="card-header ">
                        <div class="d-flex justify-content-between">
                            <span> <i class="fa fa-list" aria-hidden="true"></i> LISTTE REQUISITION</span>
                            <x-form.button wire:click='showCreateProductPurcharseModal' type="button" class="btn-dark">
                                <x-icons.icon-plus-circle />
                                Créer...
                            </x-form.button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-center">
                            <x-widget.loading-circular-md />
                        </div>
                        <table class="table table-striped table-sm">
                            <thead class="bg-indigo">
                                <tr>
                                    <th>#</th>
                                    <th>CODE</th>
                                    <th class="text-center">PRODUUITS</th>
                                    <th>DATE</th>
                                    <th class="text-center">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productPurcharses as $index => $productPurcharse)
                                    <tr wire:key='{{ $productPurcharse->id }}'>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $productPurcharse->code }}</td>
                                        <td class="text-center">{{ $productPurcharse->products->count() }}</td>
                                        <td>{{ $productPurcharse->created_at }}</td>
                                        <td class="text-center">
                                            <x-form.icon-button :icon="'fas fa-sync'" class="btn-sm btn-dark"
                                                wire:click="addProductItems({{ $productPurcharse }})" />
                                            <x-form.icon-button :icon="'fas fa-eye'" class="btn-sm btn-primary"
                                                wire:click="openListProductItems({{ $productPurcharse }})" />
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </x-content.main-content-page>
    @push('js')
        <script type="module">
            //close elist product purcharse modal
            window.addEventListener('open-list-product-purcharse-modal', e => {
                $('#list-product-purcharse-modal').modal('show')
            });
            //Confirmation dialog for delete product
            window.addEventListener('create-product-purcharse-dialog', event => {
                Swal.fire({
                    title: 'Voulez-vous vraimant ',
                    text: "créer ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'Non'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('createdProductPurcharseListener');
                    }
                })
            });
            window.addEventListener('produc-purcharse-created', event => {
                Swal.fire(
                    'Action !',
                    event.detail[0].message,
                    'success'
                );
            });
        </script>
    @endpush
</div>
