<div>
    <x-navigation.bread-crumb icon='fa fa-link' label='NAVIGATION' color='text-secondary'>
        <x-navigation.bread-crumb-item label='Dashboard' link='dashboard' isLinked=true />
        <x-navigation.bread-crumb-item label='Configuration' />
    </x-navigation.bread-crumb>
    <x-content.main-content-page>
        <div class="card">
            <x-navigation.tab-header>
                <x-navigation.tab-link :icon="'fa fa-link'" :name="'Menu principal'" :link="'main-menu'" :active="'active'" />
                <x-navigation.tab-link :icon="'fa fa-link'" :name="'Sous menu'" :link="'sub-menu'" :active="''" />
            </x-navigation.tab-header>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="main-menu">
                        @livewire('application.navigation.screens.main-menu-view')
                    </div>

                    <div class="tab-pane" id="sub-menu">
                        @livewire('application.navigation.screens.sub-menu-view')
                    </div>
                </div>
            </div>
    </x-content.main-content-page>
</div>
