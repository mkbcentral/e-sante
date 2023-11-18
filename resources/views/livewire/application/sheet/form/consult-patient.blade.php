<div>
    <div class="row">
        <div class="col-md-8 card">
            <div class="d-flex justify-content-between">
                <x-form.input-search wire:model.live.debounce.500ms="q" />
                <x-form.button class="btn-primary ml-2" wire:click="addItemsToConsultation">
                    <x-icons.icon-plus-circle/> Ajouter à la consultation
                </x-form.button>
            </div>
            <hr>
            <div>
                <x-form.button class="btn btn-secondary btn-sm" wire:click="sortTarif('name')">Trier
                    <x-form.sort-icon sortField="name"  :sortAsc="$sortAsc"  :sortBy="$sortBy" />
                </x-form.button>
            </div>
            <div class="d-flex justify-content-center pb-2">
                <x-widget.loading-circular-md/>
            </div>
            <div class="row mt-3">
                @foreach($tarifs as $tarif)
                    <div class="col-sm-3">
                        <!-- checkbox -->
                        <div class="form-group clearfix">
                            <div  class="icheck-primary d-inline">
                                <input type="checkbox" id="{{str_replace(' ', '',$tarif->name)}}"
                                       wire:model="itemsSelected" value="{{$tarif->id}}">
                                <label for="{{str_replace(' ', '',$tarif->name)}}"
                                       class="">
                                    {{$tarif->name}}
                                </label>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary"><h5>Autres diagnostics</h5></div>
                <div class="card-body">

                </div>
            </div>
        </div>
    </div>
</div>
