<div>
    <div class="row">
        <div class="col-md-9 card">
           <div class="card-header">
               <div class="d-flex justify-content-between mt-3">
                   <x-form.input-search wire:model.live.debounce.500ms="q" />
               </div>
           </div>
            <div class="card-body">
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
            <div class="card-footer d-flex justify-content-end">
                <x-form.button class="btn-dark ml-2" wire:click="addItemsToConsultation">
                    <x-icons.icon-plus-circle/> Ajouter à la consultation
                </x-form.button>
            </div>
        </div>
        <div class="col-md-3">
            <div class="">
                <x-form.button class="btn-info w-100"
                               wire:click="addItemsToConsultation">
                    <i class="fa fa-capsules"></i> Nouvelle ordonnance
                </x-form.button>
                <x-form.button class="btn-danger w-100 mt-1 mb-2" wire:click="addItemsToConsultation">
                    <i class="fa fa-comment"></i> Commenter
                </x-form.button>
            </div>
            <div class="card">
                <div class="card-header bg-primary"><h5>Autres diagnostics</h5></div>
                <div class="card-body">
                    @foreach($diagnostics as $diagnostic)
                        <!-- checkbox -->
                        <div class="form-group clearfix">
                            <div  class="icheck-primary d-inline">
                                <input type="checkbox" id="{{str_replace(' ', '',$diagnostic->name)}}"
                                       wire:model="diagnosticsSelected" value="{{$diagnostic->id}}">
                                <label for="{{str_replace(' ', '',$diagnostic->name)}}"
                                       class="">
                                    {{$diagnostic->name}}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
