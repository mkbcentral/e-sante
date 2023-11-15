<div>
    <x-navigation.bread-crumb icon='fa fa-folder-open' label='DOSSIER DU PATIENT'>
        <x-navigation.bread-crumb-item label='Dashboard' link='dashboard' isLinked=true />
        <x-navigation.bread-crumb-item label='Fiche de consultation' link='sheet' isLinked=true />
        <x-navigation.bread-crumb-item label='Dossier du patient' />
    </x-navigation.bread-crumb>
    <x-content.main-content-page>

        @if($consultationSheet != null)
            <x-widget.patient.card-patient-info :consultationSheet='$consultationSheet' />
        @endif
    </x-content.main-content-page>
</div>
