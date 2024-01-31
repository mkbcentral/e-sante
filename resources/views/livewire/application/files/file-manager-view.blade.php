<div>
    <x-navigation.bread-crumb icon='fa fa-globe' label='LOCALISATION' color='text-secondary'>
        <x-navigation.bread-crumb-item label='Dashboard' link='dashboard' isLinked=true />
        <x-navigation.bread-crumb-item label='Localisation' />
    </x-navigation.bread-crumb>
    <x-content.main-content-page>
        <div class="card">
            <x-navigation.tab-header>
                <x-navigation.tab-link :icon="'fas fa-capsules'" :name="'Produit'" :link="'product'" :active="''" />
                <x-navigation.tab-link :icon="'fa fa-file'" :name="'Fiches privés'" :link="'private'" :active="''" />
                <x-navigation.tab-link :icon="'fa fa-file'" :name="'Fiches abonné'" :link="'subscriber'" :active="''" />
                <x-navigation.tab-link :icon="'fa fa-file'" :name="'Fiches agent'" :link="'agent'" :active="'active'" />
            </x-navigation.tab-header>

            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane " id="product">
                        @livewire('application.files.screens.product-files')
                    </div>
                    <div class="tab-pane " id="private">
                        @livewire('application.files.screens.import-private-sheet-view')
                    </div>
                    <div class="tab-pane " id="subscriber">
                        @livewire('application.files.screens.import-subscriber-sheet-view')
                    </div>
                    <div class="tab-pane active" id="agent">
                        @livewire('application.files.screens.import-agent-sheet-view')
                    </div>
                </div>
            </div>
    </x-content.main-content-page>
</div>
