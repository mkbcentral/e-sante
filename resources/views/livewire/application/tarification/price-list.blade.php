<div>
    <div>
        <x-navigation.bread-crumb icon='fa fa-folder' label='GRILLE TARIFAIRE'>
            <x-navigation.bread-crumb-item label='Dashboard' link='dashboard' isLinked=true />
            <x-navigation.bread-crumb-item label='Grille tarifaire' />
        </x-navigation.bread-crumb>
        <x-content.main-content-page>
            <div class="card p-2">
                <div class="d-flex">
                    <div class="d-flex">
                        <x-form.input-search  wire:model.live.debounce.500ms="q" />
                       <span class="ml-2 d-flex align-items-center">
                           <span class="text-bold">Categorie</span>
                           <x-widget.list-category-tarif-widget  wire:model.live="category" :error="'idCategory'"/>
                       </span>
                    </div>
                </div>
                <div class="d-flex justify-content-center pb-2">
                    <x-widget.loading-circular-md/>
                </div>
                @if(!$tarifs->isEmpty())
                    <table class="table table-bordered table-sm mt-2">
                        <thead class="bg-primary">
                        <tr>
                            <th class="text-center">#</th>
                            <th class="">
                                <x-form.button class="text-white"  wire:click="sortTarif('name')">NOM TARIF</x-form.button>
                                <x-form.sort-icon sortField="name"  :sortAsc="$sortAsc"  :sortBy="$sortBy" />
                            </th>
                            <th class="text-right">
                                <x-form.button class="text-white"  wire:click="sortTarif('price_private')">PRIX PRIVES</x-form.button>
                                <x-form.sort-icon sortField="price_private"  :sortAsc="$sortAsc"  :sortBy="$sortBy" />
                            </th>
                            <th class="text-right">
                                <x-form.button class="text-white"  wire:click="sortTarif('subscriber_price')">PRIX ABONNES</x-form.button>
                                <x-form.sort-icon sortField="subscriber_price"  :sortAsc="$sortAsc"  :sortBy="$sortBy" />
                            </th>
                            <th class="text-right">CATEGORIE</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tarifs as $idx => $tarif)
                            <tr style="cursor: pointer;">
                                <td class="text-center">{{$idx+1}}</td>
                                <td class="text-uppercase">{{$tarif->abbreviation==null?$tarif->name:$tarif->abbreviations}}</td>
                                <td class="text-right">{{$tarif->price_private}}</td>
                                <td class="text-right">{{$tarif->subscriber_price}}</td>
                                <td class="text-right text-bold">{{$tarif->category}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div  class="mt-4 d-flex justify-content-center align-items-center">{{$tarifs->links('livewire::bootstrap')}}</div>
                @endif
            </div>
        </x-content.main-content-page>
    </div>
</div>
