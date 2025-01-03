<div>
    <div>
        <x-navigation.bread-crumb icon='fa fa-folder' label='GRILLE TARIFAIRE'>
            <x-navigation.bread-crumb-item label='Dashboard' link='dashboard' isLinked=true />
            <x-navigation.bread-crumb-item label='Grille tarifaire' />
        </x-navigation.bread-crumb>
        <x-content.main-content-page>
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-content-between">
                        <div class="d-flex align-content-center">
                            <x-form.input-search wire:model.live.debounce.500ms="q" />
                            <span class="ml-2 d-flex align-items-center">
                                <span class="text-bold mr-2">Categorie</span>
                                <x-widget.list-category-tarif-widget wire:model.live="category" :error="'idCategory'" />
                            </span>
                        </div>
                        <div class="row mt-2">
                            @foreach ($rows as $row)
                                <div class="col-md-4">
                                    <!-- radio -->
                                    <div class="form-group clearfix">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" value="{{ $row['value'] }}" id=" {{ $row['value'] }}"
                                                wire:model.live="type_data">
                                            <label class="text-uppercase text-secondary" for=" {{ $row['value'] }}">
                                                {{ $row['label'] }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div>
                            @if ( Auth::user()->roles->pluck('name')->contains('ADMIN') || Auth::user()->roles->pluck('name')->contains('AG'))
                                <div class="btn-group">
                                    <button type="button" class="btn btn-link dropdown-icon " data-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="fa fa-download" aria-hidden="true"></i>
                                        Exporter
                                    </button>
                                    <div class="dropdown-menu" role="menu" style="">
                                        <a class="dropdown-item" target="_blank"
                                            href="{{ route('print.tarification.prices', [$type_data, $category]) }}">
                                            <i class="fa fa-file-pdf" aria-hidden="true"></i> Grille tarifaire
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="d-flex justify-content-center pb-2">
                        <x-widget.loading-circular-md />
                    </div>
                    @if (!$tarifs->isEmpty())
                        <table class="table table-bordered table-sm mt-2">
                            <thead class="bg-primary">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="">
                                        <x-form.button class="text-white" wire:click="sortTarif('name')">NOM
                                            TARIF</x-form.button>
                                        <x-form.sort-icon sortField="name" :sortAsc="$sortAsc" :sortBy="$sortBy" />
                                    </th>
                                    @if ($type_data == 'all')
                                        <th class="text-right">
                                            <x-form.button class="text-white"
                                                wire:click="sortTarif('price_private')">PRIX
                                                PRIVES</x-form.button>
                                            <x-form.sort-icon sortField="price_private" :sortAsc="$sortAsc"
                                                :sortBy="$sortBy" />
                                        </th>
                                        <th class="text-right">
                                            <x-form.button class="text-white"
                                                wire:click="sortTarif('subscriber_price')">PRIX
                                                ABONNES</x-form.button>
                                            <x-form.sort-icon sortField="subscriber_price" :sortAsc="$sortAsc"
                                                :sortBy="$sortBy" />
                                        </th>
                                    @elseif ($type_data == 'private')
                                        <th class="text-right">
                                            <x-form.button class="text-white"
                                                wire:click="sortTarif('price_private')">PRIX
                                                PRIVES</x-form.button>
                                            <x-form.sort-icon sortField="price_private" :sortAsc="$sortAsc"
                                                :sortBy="$sortBy" />
                                        </th>
                                    @else
                                        <th class="text-right">
                                            <x-form.button class="text-white"
                                                wire:click="sortTarif('subscriber_price')">PRIX
                                                ABONNES</x-form.button>
                                            <x-form.sort-icon sortField="subscriber_price" :sortAsc="$sortAsc"
                                                :sortBy="$sortBy" />
                                        </th>
                                    @endif

                                    <th class="text-right">CATEGORIE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tarifs as $idx => $tarif)
                                    <tr style="cursor: pointer;">
                                        <td class="text-center">{{ $idx + 1 }}</td>
                                        <td class="text-uppercase">
                                            {{ $tarif->abbreviation == null ? $tarif->name : $tarif->abbreviations }}
                                        </td>
                                        @if ($type_data == 'all')
                                            <td class="text-right">{{ $tarif->price_private }}</td>
                                            <td class="text-right">{{ $tarif->subscriber_price }}</td>
                                        @elseif ($type_data == 'private')
                                            <td class="text-right">{{ $tarif->price_private }}</td>
                                        @else
                                            <td class="text-right">{{ $tarif->subscriber_price }}</td>
                                        @endif

                                        <td class="text-right text-bold">{{ $tarif->category }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-4 d-flex justify-content-center align-items-center">
                            {{ $tarifs->links('livewire::bootstrap') }}</div>
                    @endif
                </div>
            </div>
        </x-content.main-content-page>
    </div>
</div>
