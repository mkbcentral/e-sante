<div>
    <x-modal.build-modal-fixed idModal='doctor-para-clinics' size='xl' headerLabel="PARACLINIQUES"
                               headerLabelIcon='fa fa-folder-plus'>

        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <x-form.input-search wire:model.live.debounce.500ms="q" />
                    <x-form.button class="btn btn-secondary btn-sm" wire:click="sortTarif('name')">Trier
                        <x-form.sort-icon sortField="name" :sortAsc="$sortAsc" :sortBy="$sortBy" />
                    </x-form.button>
                </div>
                <div class="d-flex justify-content-center pb-2">
                    <x-widget.loading-circular-md />
                </div>
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            @foreach ($categories as $category)
                                <li class="nav-item">
                                    <a wire:click='changeIndex({{ $category }})'
                                       class="nav-link {{ $selectedIndex == $category->id ? 'active' : '' }} "
                                       href="#inscription" data-toggle="tab">
                                        &#x1F4C2; {{ $category->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="row mt-2">
                                @foreach ($tarifs as $tarif)
                                    <div class="col-md-4">
                                        <!-- checkbox -->
                                        <div class="form-group clearfix">
                                            <div class="icheck-primary d-inline">
                                                <input wire:model.live="tarifsSelected" type="radio"
                                                       value="{{ $tarif->id }}"
                                                       id="{{ str_replace(' ', '', $tarif->name) }}">
                                                <label for="{{ str_replace(' ', '', $tarif->name) }}">
                                                    {{ $tarif->getNameOrAbbreviation() }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </x-modal.build-modal-fixed>

</div>
