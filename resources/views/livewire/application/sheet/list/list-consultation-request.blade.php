<div>
    @livewire('application.sheet.form.add-viatl-sign')
    <div class="card mt-2">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mt-2">
                <x-form.input-search wire:model.live.debounce.500ms="q" />
            </div>
            <div class="d-flex justify-content-center pb-2">
                <x-widget.loading-circular-md/>
            </div>
            @if($listConsultationRequest->isEmpty())
                <x-errors.data-empty/>
            @else
                <table class="table table-striped table-sm"   wire:poll.15s.keep-alive>
                    <thead class="bg-primary">
                    <tr>
                        <th class="text-center">
                            <x-form.button class="text-white" wire:click="sortSheet('number_sheet')">Date</x-form.button>
                            <x-form.sort-icon sortField="number_sheet"  :sortAsc="$sortAsc"  :sortBy="$sortBy" />
                        </th>
                        <th class="text-center">
                            <x-form.button class="text-white" wire:click="sortSheet('number_sheet')">N° FICHE</x-form.button>
                            <x-form.sort-icon sortField="number_sheet"  :sortAsc="$sortAsc"  :sortBy="$sortBy" />
                        </th>
                        <th>
                            <x-form.button class="text-white"  wire:click="sortSheet('name')">NOM COMPLET</x-form.button>
                            <x-form.sort-icon sortField="name"  :sortAsc="$sortAsc"  :sortBy="$sortBy" />
                        </th>
                        <th class="text-center">GENGER</th>
                        <th class="text-center">AGE</th>
                        <th class="text-center">SUSCRIPTION</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($listConsultationRequest as $consultationRequest)
                        <tr style="cursor: pointer;">
                            <td class="text-center">{{$consultationRequest->created_at->format('d/m/Y h:i')}}</td>
                            <td class="text-center">{{$consultationRequest->consultationSheet->number_sheet}}</td>
                            <td class="text-uppercase">{{$consultationRequest->consultationSheet->name}}</td>
                            <td class="text-center fa fadoc">{{$consultationRequest->consultationSheet->gender}}</td>
                            <td class="text-center">{{$consultationRequest->consultationSheet->getPatientAge()}}</td>
                            <td class="text-center text-bold text-uppercase">{{$consultationRequest->consultationSheet->subscription->name}}</td>
                            <td class="text-center">
                                <x-form.icon-button :icon="'fa fa-user-plus text-primary'"
                                                        wire:click="openVitalSignForm({{$consultationRequest}})"  class="btn-sm"/>
                                <x-navigation.link-icon href="{{route('consultation.consult.patient',$consultationRequest->id)}}"
                                                        wire:navigate :icon="'fas fa-notes-medical text-primary'"/>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
                <div  class="mt-4 d-flex justify-content-center align-items-center">{{$listConsultationRequest->links('livewire::bootstrap')}}</div>
            @endif
        </div>

    </div>
    @push('js')
        <script type="module">
            //Open edit sheet modal
            window.addEventListener('open-vital-sign-form',e=>{
                $('#form-vital-sign').modal('show')
            });
        </script>
    @endpush
</div>
