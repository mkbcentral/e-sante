<div>
    @livewire('application.sheet.widget.antecedent-medical')
    <x-navigation.bread-crumb icon='fa fa-stethoscope' label="CONSULTATION MEDICALE">
        <x-navigation.bread-crumb-item label='Dashboard' link='dashboard' isLinked=true />
        <x-navigation.bread-crumb-item label='Liste patients' link='consultations.request.list' isLinked=true />
        <x-navigation.bread-crumb-item label='Consultation patient' />
    </x-navigation.bread-crumb>
    <x-content.main-content-page>
        <div class="row">
            <div class="col-md-7 card">
                <x-form.button wire:click="openAntecedentMedicalModal" class="btn-dark" type='button'>
                    <i class="fa fa-file"></i>
                    Antecedents médicaux
                </x-form.button>
                @livewire('application.sheet.form.new-consultation-comment', ['consultationRequest' => $consultationRequest])
                <div class="d-flex justify-content-end">
                      @livewire('application.widgets.input-check-box-hospitalize-widget', ['consultationRequest' => $consultationRequest])
                </div>
                @livewire('application.diagnostic.diagnostic-for-consultation', ['consultationRequest' => $consultationRequest])
                @livewire('application.sheet.form.consult-patient', ['consultationRequest' => $consultationRequest])
            </div>
            <div class="col-md-5">
                <div class="card mt-2">
                    <div class="card-body">
                        @if ($consultationSheet != null)
                            <x-widget.patient.card-patient-info :consultationSheet='$consultationSheet' />
                        @endif
                        @livewire('application.sheet.widget.vital-sign-items-widget', ['consultationRequest' => $consultationRequest])

                        @livewire('application.sheet.widget.dignostic-itmes-widget', ['consultationRequest' => $consultationRequest])
                        @livewire('application.sheet.widget.doctor-tarif-items-with-consultation-widget', [
                            'consultationRequest' => $consultationRequest,
                        ])
                        @livewire('application.sheet.form.doctor-medical-prescription', ['consultationRequest' => $consultationRequest])
                    </div>
                </div>
            </div>
        </div>
    </x-content.main-content-page>

    @push('js')
        <script type="module">
            //Open detail consultation  modal
            window.addEventListener('open-details-consultation', e => {
                $('#consultation-detail').modal('show')
            });
            //Open antecedent medical  modal
            window.addEventListener('open-antecedent-medical', e => {
                $('#antecedent-medical').modal('show')
            });
            //Open medical prescription modal
            window.addEventListener('open-consultation-request-nursing', e => {
                $('#form-consultation-request-nursing').modal('show')
            });
        </script>
    @endpush
</div>
