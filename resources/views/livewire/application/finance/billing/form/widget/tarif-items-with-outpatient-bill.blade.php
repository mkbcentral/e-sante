<div>
    <div class="card card-indigo">
        <div class="card-header ">
            <div class="d-flex  justify-content-between  align-items-centersq">
                <h4><i class="fa fa-list" aria-hidden="true"></i> LISTE DES EXAMENS PARACLINIQUES</h4>
            </div>
        </div>
        <div class="card-body">
            <div class="d-flex align-items-center">
                <x-form.input-search wire:model.live.debounce.500ms="q" :bg="'bg-indigo'" />
                <x-form.button class="btn btn-secondary btn-sm" wire:click="sortTarif('name')">Trier
                    <x-form.sort-icon sortField="name"  :sortAsc="$sortAsc"  :sortBy="$sortBy" />
                </x-form.button>
            </div>
            <div class="d-flex justify-content-center pb-2 mt-2 ">
                <x-widget.loading-circular-md/>
            </div>
            <div class="row mt-3">
                @foreach($tarifs as $tarif)
                    <div class="col-md-6">
                        <!-- checkbox -->
                        <div class="form-group clearfix">
                            <div class="icheck-primary d-inline">
                                <input  wire:model.live="tarifsSelected" type="radio" value="{{$tarif->id}}"
                                       id="{{str_replace(' ', '',$tarif->name)}}" >
                                <label for="{{str_replace(' ', '',$tarif->name)}}">
                                    {{$tarif->getNameOrAbbreviation()}}
                                </label>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
