<div>
    <x-navigation.bread-crumb icon='fa fa-globe' label='LOCALISATION' color='text-secondary'>
        <x-navigation.bread-crumb-item label='Dashboard' link='dashboard' isLinked=true />
        <x-navigation.bread-crumb-item label='Localisation' />
    </x-navigation.bread-crumb>
    <x-content.main-content-page>
        <div class="card">
            <x-navigation.tab-header>
                <x-navigation.tab-link :icon="'fa fa-map'" :name="'Commune'" :link="'municipality'" :active="'active'" />
                <x-navigation.tab-link :icon="'fa fa-map-pin'" :name="'Quartier'" :link="'rural'" :active="''" />
            </x-navigation.tab-header>

            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="municipality">
                        @livewire('application.localization.screens.municipality-view')
                    </div>
                    <div class="tab-pane" id="rural">
                        @livewire('application.localization.screens.area-rural-view')
                    </div>
                </div>
            </div>
    </x-content.main-content-page>
</div>
