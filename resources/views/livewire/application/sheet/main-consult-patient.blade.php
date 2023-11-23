<div>
    @livewire('application.diagnostic.diagnostic-for-consultation')
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
                <div class="card p-2" >
                    <div class="card-body">
                       <div class="d-flex justify-content-end">
                           <x-form.button wire:click="handlerSubmit"
                                          class="btn-danger btn-sm mr-2" type='button'>
                               <i class="fa fa-file"></i>
                               Antecedents médicaux
                           </x-form.button>
                           <x-form.button wire:click="handlerSubmit"
                                          class="btn-primary btn-sm" type='button'>
                               <i class="fa fa-capsules"></i>
                               Nouvelle ordonnance
                           </x-form.button>
                       </div>
                        @livewire('application.sheet.form.new-consultation-comment',['consultationRequest'=>$consultationRequest])
                    </div>
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
                </div>
            </div>
        </x-content.main-content-page>
    </div>
</div>
