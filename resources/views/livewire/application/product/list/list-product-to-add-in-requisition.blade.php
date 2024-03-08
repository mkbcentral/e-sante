<div>
    @livewire('application.product.form.add-product-to-requisition')
    <div class="card card-olive">
        <div class="card-header h4">
            <i class="fa fa-list" aria-hidden="true"></i> LISTE DES PRODUITS
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <x-form.input-search :bg="'btn-success'" wire:model.live.debounce.500ms="q" />
                <x-widget.loading-circular-md />
            </div>

            <table class="table table-bordered table-sm mt-0">
                <thead class="bg-olive">
                    <tr class="">

                        <th class="">
                            DEISIGNATION
                        </th>
                        <th class="text-right">
                            EXP.
                        </th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($products->isEmpty())
                        <tr>
                            <td colspan="7">
                                <x-errors.data-empty />
                            </td>
                        </tr>
                    @else
                        @foreach ($products as $product)
                            <tr style="cursor: pointer;">
                                <td class="text-uppercase">{{ $product->name }} <span
                                        class="text-bold text-pink">{{ $product->abbreviation }}</span></td>

                                <td class="text-right">{{ $product->expiration_date }}</td>
                                <td class="text-center">
                                    <x-form.icon-button :icon="'fa fa-plus-circle '" class="btn-sm btn-info"
                                        wire:click='addNewProduct({{ $product }})' />
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            <div class="mt-4 d-flex justify-content-center align-items-center">
                {{ $products->links('livewire::bootstrap') }}
            </div>
        </div>
    </div>
    @push('js')
        <script type="module">
            //Open  add modal
            window.addEventListener('open-add-to-product-requisition-modal', e => {
                $('#add-to-product-requisition-modal').modal('show')
            });
        </script>
    @endpush
</div>
