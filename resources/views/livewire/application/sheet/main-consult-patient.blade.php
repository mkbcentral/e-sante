<div>
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
                <div class="row">
                    <div class="col-md-6">
                        @livewire('application.sheet.form.new-consultation-comment',['consultationRequest'=>$consultationRequest])
                    </div>
                    <div class="col-md-6">
                        @livewire('application.diagnostic.diagnostic-for-consultation',['consultationRequest'=>$consultationRequest])
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
