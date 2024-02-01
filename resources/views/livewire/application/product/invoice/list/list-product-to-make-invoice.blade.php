<div wire:ignore.self>
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
                @foreach ($productProductSupplies as $index => $productProductSupplie)
                    <tr wire:key='{{ $productProductSupplie->id }}' class="cursor-hand"
                        wire:confirm="Etes-vous d'ajouter à la facure?"
                        wire:click='addproductProductSupplieToInvoice({{ $productProductSupplie->product }})'
                        ({{ $productProductSupplie->product }})>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $productProductSupplie->product_name }}</td>
                        <td class="text-center">0</td>
                        <td class="text-right">{{ $productProductSupplie->created_at->format('d/M/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4 d-flex justify-content-center align-items-center">
            {{ $productProductSupplies->links('livewire::bootstrap') }}</div>
    </div>
</div>
