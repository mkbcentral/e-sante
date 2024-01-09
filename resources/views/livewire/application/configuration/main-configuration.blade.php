<div>
    <x-navigation.bread-crumb icon='fas fa-user-cog' label='CONFIGURATION' color='text-secondary'>
        <x-navigation.bread-crumb-item label='Dashboard' link='dashboard' isLinked=true />
        <x-navigation.bread-crumb-item label='Configuration' />
    </x-navigation.bread-crumb>
    <x-content.main-content-page>
        <div class="card">
            <x-navigation.tab-header>
                <x-navigation.tab-link :icon="'fa fa-file'" :name="'Taux echange'" :link="'user'" :active="'active'" />
                <x-navigation.tab-link :icon="'fa fa-users'" :name="'Suscription'" :link="'subscription'" :active="''" />
                <x-navigation.tab-link :icon="'fas fa-capsules'" :name="'Categorie produits'" :link="'categoryProduct'" :active="''" />
                <x-navigation.tab-link :icon="'fa fa-pills'" :name="'Famille Produits'" :link="'familyProduct'" :active="''" />
                <x-navigation.tab-link :icon="'fas fa-user-check'" :name="'Goupe sanguin'" :link="'bloodGroup'" :active="''" />
                <x-navigation.tab-link :icon="'fa fa-user-circle'" :name="'Genre'" :link="'gender'" :active="''" />
            </x-navigation.tab-header>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="user">
                        @livewire('application.configuration.screens.rate-view')
                    </div>
                    <div class="tab-pane" id="subscription">
                        @livewire('application.configuration.screens.subscription-view')
                    </div>
                    <div class="tab-pane" id="categoryProduct">
                        @livewire('application.configuration.screens.category-product-view')
                    </div>
                    <div class="tab-pane" id="familyProduct">
                        @livewire('application.configuration.screens.family-product-view')
                    </div>
                    <div class="tab-pane" id="bloodGroup">
                        @livewire('application.configuration.screens.blood-group-view')
                    </div>
                    <div class="tab-pane" id="gender">
                        @livewire('application.configuration.screens.gender-view')
                    </div>
                </div>
            </div>
    </x-content.main-content-page>
</div>
