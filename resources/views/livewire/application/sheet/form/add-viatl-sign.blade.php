<div>
    <x-modal.build-modal-fixed
        idModal='form-vital-sign'
        size='xl' headerLabel="PRISE SIGNES VITAUX ET AUTRES"
        headerLabelIcon='fa fa-folder-plus'>
        @if($consultationRequest != null)
            <div class="card p-2">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span><span class="text-bold">Nom:</span> {{$consultationRequest->consultationSheet->name}}</span><br>
                            <span><span class="text-bold">Genre:</span> {{$consultationRequest->consultationSheet->gender}}</span><br>
                            <span><span class="text-bold">Age:</span> {{$consultationRequest->consultationSheet->getPatientAge()}}</span><br>
                            <span><span class="text-bold">Type:</span> {{$consultationRequest->consultationSheet->subscription->name}}</span>
                        </div>
                        <div>
                            <h1><i class="fa fa-user-nurse text-primary"></i></h1>
                        </div>
                    </div>
                    <hr>
                    <div  class="row">
                        <div class="col-md-6">
                            @foreach($vitalSignForm as $index => $vital)
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <x-form.label value="{{ __('Signe vital') }}" />
                                            <x-widget.list-vital-sign-widget
                                                wire:model.blur='vitalSignForm.{{$index}}.vital_sign_id'
                                                :error="'vitalSignForm.{{$index}}.vital_sign_id'" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center">
                                            <div class="form-group">
                                                <x-form.label value="{{ __('Value') }}" />
                                                <x-form.input type='text'
                                                              wire:model.blur='vitalSignForm.{{$index}}.value'
                                                              wire:keydown.escape='removeVitalSignToForm({{ $index }})'
                                                              wire:keydown.enter='addVitalSignItems'
                                                              wire:keydown.shift='addNewVitalSignToForm'
                                                              :error="'vitalSignForm.{{$index}}.value'" />
                                            </div>
                                            <x-form.icon-button :icon="'fa fa-times '" wire:click="removeVitalSignToForm({{ $index }})"  class="btn-danger mt-3 ml-2"/>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="card p-2 col-md-6 bg-primary">
                            <div class="row">
                                @foreach($medicalOffices as $medicalOffice)
                                    <div class="col-md-6" style="cursor: pointer;"
                                         wire:click="selectedMedicalOffice({{$medicalOffice}})">
                                        <div class="card {{$selectedMedicalOfficeIndex==$medicalOffice->id?'bg-white':'bg-primary'}}   p-4 mx-auto my-auto text-center ">
                                            <h5 class="card-title">{{$medicalOffice->name}}</h5>
                                            <p class="card-text"><i class="fa fa-user"> Dr Test (Occupé)</i></p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    @if($itemsVitalSignSend )
                    <x-form.button wire:click="sendConsultationToDoctor" class="btn-primary" type='submit'>
                        <i class="fab fa-telegram"></i> Evoyer le consultation
                    </x-form.button>
                    @endif
                </div>
            </div>
        @endif
    </x-modal.build-modal-fixed>
    @push('js')
        <script type="module">
            //Open edit sheet modal
            window.addEventListener('close-vital-sign-form',e=>{
                $('#form-vital-sign').modal('hide')
            });
        </script>
    @endpush
</div>
