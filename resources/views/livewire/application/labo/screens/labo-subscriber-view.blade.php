<div>
    <x-navigation.bread-crumb icon='fa fa-folder' color='text-success' label='EXEMENS DE LABORATOIRE'>
        <x-navigation.bread-crumb-item label='Dashboard' link='dashboard' isLinked=true />
       <x-navigation.bread-crumb-item label='Liste patients' link='labo.main' isLinked=true />
        <x-navigation.bread-crumb-item label='Examen de labo' />
    </x-navigation.bread-crumb>
    <x-content.main-content-page>
        <div class="row ">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><span class="text-bold">Nom: </span>{{$consultationRequest->consultationSheet->name}}</h5><br>
                        <h5 class="card-title"><span class="text-bold">Age: </span> {{ $consultationRequest->consultationSheet->getPatientAge()}}</h5><br>
                        <h5 class="card-title"><span class="text-bold">Type: </span> {{ $consultationRequest->consultationSheet->subscription->name}}</h5><br>
                        <h5 class="card-title"><span class="text-bold">Date: </span> {{ $consultationRequest->created_at->format('d/m/Y H:i:s') }}</h5>
                    </div>
                </div>
                <div class="card card-success card-outline">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <x-form.input-search wire:model.live.debounce.500ms="q" bg='bg-success' />
                            <x-form.button class="btn btn-success btn-sm" wire:click="sortTarif('name')">Trier
                                <x-form.sort-icon sortField="name" :sortAsc="$sortAsc" :sortBy="$sortBy" />
                            </x-form.button>
                        </div>
                        <div class="d-flex justify-content-center pb-2">
                            <x-widget.loading-circular-md />
                        </div>
                        <div class="row mt-3">
                            @foreach ($tarifs as $tarif)
                                <div class="col-md-5">
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
            <div class="col-md-7">
                @livewire('application.labo.screens.list-items-labo',['consultationRequest'=>$consultationRequest])
            </div>
        </div>
    </x-content.main-content-page>
</div>
