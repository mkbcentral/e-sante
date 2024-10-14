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
                <x-navigation.tab-link :icon="'fa fa-user'" :name="'Type patient'" :link="'typePatient'" :active="''" />
                <x-navigation.tab-link :icon="'fa fa-home'" :name="'Cabinet des médecins'" :link="'meidcalOffice'" :active="''" />
                <x-navigation.tab-link :icon="'fas fa-file-medical'" :name="'Signe vitaux'" :link="'vitalSign'" :active="''" />
                <x-navigation.tab-link :icon="'fas fa-list'" :name="'Services'" :link="'service'" :active="''" />
                <x-navigation.tab-link :icon="'fas fa-hospital'" :name="'Hospital'" :link="'hospital'" :active="''" />
                <x-navigation.tab-link :icon="'fas fa-hospital'" :name="'Source'" :link="'source'" :active="''" />
                <x-navigation.tab-link :icon="'fas fa-hospital'" :name="'Chambre'" :link="'room'" :active="''" />
                <x-navigation.tab-link :icon="'fa fa-bed'" :name="'Lit'" :link="'bed'" :active="''" />
                <x-navigation.tab-link :icon="'fa fa-hand-holding-usd'" :name="'Catégories depenses'" :link="'category-spend'" :active="''" />
                <x-navigation.tab-link :icon="'fa fa-wallet'" :name="'Type caisse'" :link="'cash-category'" :active="''" />
                <x-navigation.tab-link :icon="'fa fa-wallet'" :name="'Source dépense'" :link="'source-payroll'" :active="''" />
                <x-navigation.tab-link :icon="'fa fa-wallet'" :name="'Categoriie diagnostics'" :link="'cat-diagnostics'" :active="''" />
                <x-navigation.tab-link :icon="'fa fa-wallet'" :name="'Diagnostics'" :link="'diagnostics'" :active="''" />
                <x-navigation.tab-link :icon="'fa fa-wallet'" :name="'Symptome'" :link="'symptoms'" :active="''" />
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
                    <div class="tab-pane" id="typePatient">
                        @livewire('application.configuration.screens.type-patient-view')
                    </div>
                    <div class="tab-pane" id="meidcalOffice">
                        @livewire('application.configuration.screens.medical-office-view')
                    </div>
                    <div class="tab-pane" id="vitalSign">
                        @livewire('application.configuration.screens.vital-sign-view')
                    </div>
                    <div class="tab-pane" id="service">
                        @livewire('application.configuration.screens.agent-service-view')
                    </div>
                    <div class="tab-pane" id="hospital">
                        @livewire('application.configuration.screens.hospital-view')
                    </div>
                    <div class="tab-pane" id="source">
                        @livewire('application.configuration.screens.source-view')
                    </div>
                    <div class="tab-pane" id="room">
                        @livewire('application.configuration.screens.room-view')
                    </div>
                    <div class="tab-pane" id="bed">
                        @livewire('application.configuration.screens.bed-view')
                    </div>
                    <div class="tab-pane " id="category-spend">
                       @livewire('application.configuration.screens.category-spend-view')
                    </div>
                    <div class="tab-pane" id="cash-category">
                        @livewire('application.configuration.screens.cash-category-view')
                    </div>
                    <div class="tab-pane " id="source-payroll">
                        @livewire('application.configuration.screens.source-payroll-view')
                    </div>
                     <div class="tab-pane " id="cat-diagnostics">
                        @livewire('application.configuration.screens.category-diagnostic-view')
                    </div>
                     <div class="tab-pane " id="diagnostics">
                        @livewire('application.configuration.screens.diagnostic-view')
                    </div>
                    <div class="tab-pane " id="symptoms">
                        @livewire('application.configuration.screens.symptom-view')
                    </div>
                </div>
            </div>
    </x-content.main-content-page>
</div>
