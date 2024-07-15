<div>
    @livewire('application.product.invoice.form.form-quantity-product-to-invoice')
    <div>
        <h4 class="text-secondary"><i class="fa fa-list" aria-hidden="true"></i> LISTE DES PRODUITS</h4>
        <div class="d-flex justify-content-between align-items-center">
            <x-form.input-search :bg="'btn-secondary'" wire:model.live.debounce.500ms="q" />
            <x-widget.loading-circular-md />
        </div>
        <table class="table table-bordered table-hover table-sm">
            <thead class="bg-pink">
                <tr>
                    <th class="text-center">N°</th>
                    <th>
                        <x-form.button class="text-bold text-white" wire:click="sortProduct('name')">PRODUITS
                        </x-form.button>
                        <x-form.sort-icon sortField="name" :sortAsc="$sortAsc" :sortBy="$sortBy" />
                    </th>
                    <th class="text-center">STOCK</th>
                    <th class="text-right">
                        <x-form.button class="text-bold text-white" wire:click="sortProduct('expiration_date')">DATE
                            EXPIRATION
                        </x-form.button>
                        <x-form.sort-icon sortField="expiration_date" :sortAsc="$sortAsc" :sortBy="$sortBy" />
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $index => $product)
                    <tr wire:key='{{ $product->id }}' class="cursor-hand" data-toggle="modal"
                        data-target="#form-quntity-product-invoice"
                        wire:click='openFormQuantityModal({{ $product }})' data-toggle="tooltip"
                        data-placement="top" title="({{ $product->name }})">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ strlen($product->name) > 20 ? substr($product->name, 0, 20) . '...' : $product->name }}
                        </td>
                        <td class="{{ $product->getStockPharma() <= 5 ? 'bg-danger ' : '' }} text-center">
                            {{ $product->getStockPharma() <= 0 ? 0 : $product->getStockPharma() }}</td>
                        <td class="text-right">{{ $product->created_at->format('d/M/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4 d-flex justify-content-center align-items-center">
            {{ $products->links('livewire::bootstrap') }}</div>
    </div>
    <script type="module">
        //Open  new sheet form modal
        window.addEventListener('open-form-quntity-product-invoice', e => {
            $('#form-quntity-product-invoice').modal('show')
        });
    </script>
</div>
