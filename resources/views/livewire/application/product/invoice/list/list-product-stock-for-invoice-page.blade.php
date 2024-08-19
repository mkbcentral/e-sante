<div>
    <x-navigation.bread-crumb icon='fa fa-capsules' label='PRODUITS PHARMACEUTIQUES' color="text-pink">
        <x-navigation.bread-crumb-item label='Dashboard' link='dashboard' isLinked=true />
        <x-navigation.bread-crumb-item label='Produits pharmaceutique' />
    </x-navigation.bread-crumb>
    <x-content.main-content-page>
        <div class="card card-pink">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3><i class="fas fa-list"></i>SORTIES PERIODIQUE EN CASH</h3>
                    <x-form.input-search :bg="'btn-secondary'" wire:model.live.debounce.500ms="q" />
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-center">
                    <x-widget.loading-circular-md />
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="mr-2">
                        <x-form.input type='date' wire:model.live='date_filter' :error="'date_filter'" />
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="d-flex align-items-center mr-4">
                            <x-form.label value="{{ __('Du') }}" class="mr-2"/>
                            <x-form.input type='date' wire:model.live='start_date' :error="'start_date'" />
                        </div>
                        <div class="d-flex align-items-center">
                            <x-form.label value="{{ __('Au') }}" class="mr-2"/>
                            <x-form.input type='date' wire:model.live='end_date' :error="'end_date'" />
                        </div>
                    </div>
                </div>
                <table class="table table-bordered mt-2">
                    <thead class="bg-pink text-white">
                        <tr class="">
                            <th>#</th>
                            <th class="">
                                <x-form.button class="text-bold text-white"
                                    wire:click="sortProduct('name')">DEISIGNATION
                                </x-form.button>
                                <x-form.sort-icon sortField="name" :sortAsc="$sortAsc" :sortBy="$sortBy" />
                            </th>
                            <th class="text-center">
                                QT SORTIE
                            </th>

                            <th class="text-right">
                                <x-form.button class="text-bold text-white" wire:click="sortProduct('price')">P.U FC
                                </x-form.button>
                                <x-form.sort-icon sortField="price" :sortAsc="$sortAsc" :sortBy="$sortBy" />
                            </th>
                            <th class="text-right">
                                <x-form.button class="text-bold text-white"
                                    wire:click="sortProduct('expiration_date')">DATE
                                    EXPIRATION
                                </x-form.button>
                                <x-form.sort-icon sortField="expiration_date" :sortAsc="$sortAsc" :sortBy="$sortBy" />
                            </th>
                            <th class="text-center">CETEGORIE</th>

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
                            @foreach ($products as $index => $product)
                                @if ($product->getNumberProductInvoiceByPeriod($date_filter, null, null) == 0)
                                @else
                                    <tr style="cursor: pointer;" class="">
                                        <td class="text-center">
                                            {{ $index + 1 }}
                                        </td>
                                        <td class="text-uppercase">
                                            {{ $product->name }}
                                            <span class="text-bold text-pink">{{ $product->abbreviation }}</span>
                                        </td>

                                        <td class="text-center">
                                            {{ $product->getNumberProductInvoiceByPeriod($date_filter, $start_date, $end_date) }}
                                        </td>
                                        <td class="text-right">{{ $product->price }} Fc</td>
                                        <td class="text-right">{{ $product->expiration_date }}</td>
                                        <td
                                            class="text-right text-uppercase {{ !$product->productCategory ? 'bg-dark' : '' }} ">
                                            {{ $product->productCategory ? $product->productCategory?->name : 'Non categorisé' }}
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </x-content.main-content-page>

</div>
