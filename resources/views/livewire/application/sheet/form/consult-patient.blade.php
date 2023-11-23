<div>
    <div class="card">
        <div class="card-header bg-primary ">
            <div class="d-flex  justify-content-between  align-items-center">
                <h4>LISTE DES EXAMENS PARACLINIQUES</h4>
            </div>
        </div>
        <div class="card-body">
            <div class="d-flex align-items-center">
                <x-form.input-search wire:model.live.debounce.500ms="q" />
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
                                       wire:model.live="tarifsSelected" value="{{$tarif->id}}">
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
    </div>
    @push('js')
        <script type="module">
            //Open edit sheet modal
            window.addEventListener('open-form-consultation-comment',e=>{
                $('#form-consultation-comment').modal('show')
            });
        </script>
    @endpush
</div>
