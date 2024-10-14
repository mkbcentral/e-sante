<div>
    <x-navigation.bread-crumb icon='fa fa-folder-open' label='DOSSIER DU PATIENT'>
        <x-navigation.bread-crumb-item label='Dashboard' link='dashboard' isLinked=true />
        <x-navigation.bread-crumb-item label='Fiche de consultation' link='sheet' isLinked=true />
        <x-navigation.bread-crumb-item label='Dossier du patient' />
    </x-navigation.bread-crumb>
    <x-content.main-content-page>

        @if ($consultationSheet != null)
            <x-widget.patient.card-patient-info title='DOSSIER' icon='fa fa-folder-open' :consultationSheet='$consultationSheet' />
            <div class="card">
                <div class="card-body">
                    <table class="table table-sm">
                        <tbody>
                            @foreach ($months as $month)
                                <tr>
                                    <td scope="row">
                                        <a wire:navigate href="{{ route('patient.folder.detail', [$consultationSheet->id,$month['number']]) }}"><i class="fa fa-calendar-day" aria-hidden="true"></i>
                                            {{ $month['name'] }}</a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </x-content.main-content-page>
</div>
