<div>
    @livewire('application.product.supply.form.edit-product-suplly-view')
    <div class="d-flex justify-content-between">
        <x-form.button type="button" class="btn-dark" wire:click='addNew'>
            <i class="fa fa-plus-circle" aria-hidden="true"></i> Nouvelle demande
        </x-form.button>
        <x-widget.loading-circular-md />
    </div>
    <div>
        <div class="d-flex justify-content-end ">
            <div class="form-group mt-1">
                <x-form.label value="{{ __('Mois') }}" class="mr-1" />
                <x-widget.list-fr-months wire:model.live='month' :error="'month'" />
            </div>
        </div>
        <table class="table table-bordered table-sm">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>DATE</th>
                    <th>CODE</th>
                    <th class="text-center">PRODUCTS</th>
                    <th class="text-center">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @if ($productSupplies->isEmpty())
                    <tr>
                        <td colspan="5" class="text-center"> <x-errors.data-empty /></td>
                    </tr>
                @else
                    @foreach ($productSupplies as $index => $productSupply)
                        <tr wire:key='{{ $productSupply->id }}'>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $productSupply->created_at->format('d/m/Y à H:i:s') }}</td>
                            <td class="text-center">{{ $productSupply->code }}</td>
                            <td class="text-center">{{ $productSupply->productSupplyProducts->count() }}</td>
                            <td class="text-center">
                                <x-navigation.link-icon class="btn btn-sm btn-primary"
                                    href="{{ route('product.supply.add.products', $productSupply->id) }}" wire:navigate
                                    :icon="'fa fa-plus-circle'" />
                                <x-form.icon-button :icon="'fa fa-edit '" class="btn-sm btn-info"
                                    wire:click='edit({{ $productSupply }})' />

                                <x-form.icon-button :icon="'fa fa-trash '" class="btn-sm btn-danger"
                                    wire:confirm="Etes-vous sûre de supprimer ?"
                                    wire:click='delete({{ $productSupply }})' />
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
    @push('js')
        <script type="module">
            //Open  edit modal
            window.addEventListener('open-edit-product-supply-model', e => {
                $('#edit-product-supply-model').modal('show')
            });
            //Open  add products modal
            window.addEventListener('open-add-products-on-supply-modal', e => {
                $('#add-products-on-supply-modal').modal('show')
            });
            //Show new Supply dialog
            window.addEventListener('new-product-supply-dialog', event => {
                Swal.fire({
                    title: 'Voulez-vous vraimant ',
                    text: "passer la demande ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'Non'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('newSupplyListener');
                    }
                })
            });
            window.addEventListener('product-supply-created-deleted', event => {
                Swal.fire(
                    'Action !',
                    event.detail[0].message,
                    'success'
                );
            });
        </script>
    @endpush
</div>
