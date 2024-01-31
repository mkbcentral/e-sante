<div>
    <x-modal.build-modal-fixed idModal='form-vital-sign' bg='bg-indigo' size='xl' headerLabel="PRISE SIGNES VITAUX ET AUTRES"
        headerLabelIcon='fas fa-stethoscope'>
        @if ($consultationRequest != null)
            <div class="card p-2">
                <div class="card-body">
                    <div class="d-flex  justify-content-lg-between ">
                        <div class=" ">
                            <h4 class="text-primary"><i class="fa fa-user-nurse"></i> INDETITES</h4>
                            <x-widget.patient.simple-patient-info :consultationSheet='$consultationRequest->consultationSheet' />
                        </div>
                        <div class="">
                            <div class="my-2"> <span class="text-bold text-md text-danger mr-2">
                                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Cas à hospitalisé
                                    ?</span>
                                <div class="icheck-danger d-inline">
                                    <input wire:model.live='is_hospitalized' type="checkbox" id="checkboxHospitalize">
                                    <label for="checkboxHospitalize">
                                        {{ $is_hospitalized == false ? 'Non' : 'Oui' }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            @foreach ($vitalSignForm as $index => $vital)
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <x-form.label value="{{ __('Signe vital') }}" />
                                            <x-widget.list-vital-sign-widget
                                                wire:model.blur='vitalSignForm.{{ $index }}.vital_sign_id'
                                                :error="'vitalSignForm.{{ $index }}.vital_sign_id'" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center">
                                            <div class="form-group">
                                                <x-form.label value="{{ __('Value') }}" />
                                                <x-form.input type='text'
                                                    wire:model.blur='vitalSignForm.{{ $index }}.value'
                                                    wire:keydown.escape='removeVitalSignToForm({{ $index }})'
                                                    wire:keydown.enter='addVitalSignItems'
                                                    wire:keydown.shift='addNewVitalSignToForm' :error="'vitalSignForm.{{ $index }}.value'" />
                                            </div>
                                            <x-form.icon-button :icon="'fa fa-times '"
                                                wire:click="removeVitalSignToForm({{ $index }})"
                                                class="btn-danger mt-3 ml-2" />
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="card bg-indigo p-2 col-md-6 ">
                            <div class="row">
                                @foreach ($medicalOffices as $medicalOffice)
                                    <div class="col-md-6 p-1" style="cursor: pointer;"
                                        wire:click="selectedMedicalOffice({{ $medicalOffice }})">
                                        <div
                                            class="card  {{ $selectedMedicalOfficeIndex == $medicalOffice->id ? 'bg-primary' : 'bg-white' }}   p-4 mx-auto my-auto text-center ">
                                            <h5 class="card-title">{{ $medicalOffice->name }}</h5>
                                            <p class="card-text"><i class="fa fa-user"> Dr Test (Occupé)</i></p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @if ($is_hospitalized == true)
                        <hr>
                        @livewire('application.sheet.form.add-new-hospitalization', ['consultationRequest' => $consultationRequest])
                    @endif

                </div>
                <div class="card-footer d-flex justify-content-end">
                    @if ($itemsVitalSignSend)
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
            window.addEventListener('close-vital-sign-form', e => {
                $('#form-vital-sign').modal('hide')
            });
        </script>
    @endpush
</div>
