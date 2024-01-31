<div>
    @livewire('application.diagnostic.diagnostic-for-consultation')
    @livewire('application.sheet.widget.consultation-request-detail')
    @livewire('application.sheet.widget.antecedent-medical')
    @livewire('application.sheet.form.medical-prescription')
    @livewire('application.sheet.form.new-consultation-request-nursing')
    <div>
        <x-navigation.bread-crumb icon='fas fa-notes-medical' label='CONSULTER UN PATIENT'>
            <x-navigation.bread-crumb-item label='Dashboard' link='dashboard' isLinked=true />
            <x-navigation.bread-crumb-item label='Liste patients' link='consultation.req' isLinked=true />
            <x-navigation.bread-crumb-item label='Consultation patient' />
        </x-navigation.bread-crumb>
        <x-content.main-content-page>
            @if ($consultationSheet != null)
                <x-widget.patient.card-patient-info :consultationSheet='$consultationSheet' />
            @endif
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex justify-content-between   align-items-center ">
                    <div class="my-2"> <span class="text-bold text-md text-danger mr-2">
                            <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Cas à hospitalisé ?</span>
                        <div class="icheck-danger d-inline">
                            <input wire:model.live='is_hospitalized' type="checkbox" id="checkboxHospitalize">
                            <label for="checkboxHospitalize">
                                {{ $is_hospitalized == false ? 'Non' : 'Oui' }}
                            </label>
                        </div>
                    </div>
                    <div class="bg-navy p-1 rounded-lg ml-2">
                        <h3 wire:loading.class="d-none"><span>Montant:</span>
                            <span class="money_format">
                                {{ app_format_number($consultationRequest->getTotalInvoiceCDF(), 0) }} FC</span> |
                            <span class="money_format">
                                {{ app_format_number($consultationRequest->getTotalInvoiceUSD(), 0) }} $</span>
                        </h3>
                    </div>
                </div>
                <div>
                    <x-form.button wire:click="openAntecedentMedicalModal" class="btn-danger  mr-1" type='button'>
                        <i class="fa fa-file"></i>
                        Antecedents médicaux
                    </x-form.button>
                    <x-form.button wire:click="openDetailConsultationModal" class="btn-secondary  mr-1" type='button'>
                        <i class="fa fa-eye"></i>
                        Visualiser
                    </x-form.button>
                     <x-form.button wire:click="openNursingModal" class="btn-secondary  mr-1" type='button'>
                        <i class="fa fa-eye"></i>
                        Nuering
                    </x-form.button>
                    @if ($consultationRequest->products->isEmpty())
                        <x-form.button wire:click="openPrescriptionMedicalModal" class="btn-primary " type='button'>
                            <i class="fa fa-capsules"></i>
                            Nouvelle ordonnance
                        </x-form.button>
                    @else
                        <x-form.button wire:click="openPrescriptionMedicalModal" class="btn-info " type='button'>
                            <i class="fa fa-capsules"></i>
                            Modfier ordonnace
                        </x-form.button>
                    @endif
                </div>
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
                        <div class="col-md-9">
                            @livewire('application.sheet.form.consult-patient', ['consultationRequest' => $consultationRequest, 'selectedIndex' => $selectedIndex])
                        </div>
                        <div class="col-md-3">
                            @livewire('application.sheet.widget.tarif-items-with-consultation-widget', [
                                'tarifId' => $selectedIndex,
                                'consultationRequestId' => $consultationRequest->id,
                            ])
                        </div>
                    </div>
                    <div>
                        @livewire('application.sheet.form.new-consultation-comment', ['consultationRequest' => $consultationRequest])
                    </div>
                </div>
            </div>
        </x-content.main-content-page>
    </div>
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
            window.addEventListener('open-medical-prescription', e => {
                $('#form-medical-prescription').modal('show')
            });
             //Open medical prescription modal
            window.addEventListener('open-consultation-request-nursing', e => {
                $('#form-consultation-request-nursing').modal('show')
            });
        </script>
    @endpush
</div>
