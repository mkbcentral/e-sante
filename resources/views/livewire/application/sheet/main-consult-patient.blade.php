<div>
    @livewire('application.diagnostic.diagnostic-for-consultation')
    @livewire('application.sheet.widget.consultation-request-detail')
    @livewire('application.sheet.widget.antecedent-medical')
    <div>
        <x-navigation.bread-crumb icon='fas fa-notes-medical' label='CONSULTER UN PATIENT'>
            <x-navigation.bread-crumb-item label='Dashboard' link='dashboard' isLinked=true />
            <x-navigation.bread-crumb-item label='Liste patients' link='consultation.req' isLinked=true />
            <x-navigation.bread-crumb-item label='Consultation patient' />
        </x-navigation.bread-crumb>
        <x-content.main-content-page>
            @if($consultationSheet != null)
                <x-widget.patient.card-patient-info :consultationSheet='$consultationSheet' />
            @endif
                <div class="d-flex justify-content-end align-items-center">
                    <x-form.button wire:click="openAntecedentMedicalModal"
                                   class="btn-danger btn-sm mr-1" type='button'>
                        <i class="fa fa-file"></i>
                        Antecedents médicaux
                    </x-form.button>
                    <x-form.button wire:click="openDetailConsultationModal"
                                   class="btn-secondary btn-sm mr-1" type='button'>
                        <i class="fa fa-eye"></i>
                        Viesualiser
                    </x-form.button>
                    <x-form.button wire:click="handlerSubmit"
                                   class="btn-primary btn-sm" type='button'>
                        <i class="fa fa-capsules"></i>
                        Nouvelle ordonnance
                    </x-form.button>
                </div>
            <div class="card">
                <div class="card-header p-2" >
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
                    @livewire('application.sheet.form.consult-patient',['consultationRequest'=>$consultationRequest,'selectedIndex'=>$selectedIndex])
                    <div>
                        @livewire('application.sheet.form.new-consultation-comment',['consultationRequest'=>$consultationRequest])
                    </div>
                </div>
            </div>
        </x-content.main-content-page>
    </div>
    @push('js')
        <script type="module">
            //Open detail consultation  modal
            window.addEventListener('open-details-consultation',e=>{
                $('#consultation-detail').modal('show')
            });
            //Open antecedent medical  modal
            window.addEventListener('open-antecedent-medical',e=>{
                $('#antecedent-medical').modal('show')
            });
        </script>
    @endpush
</div>
