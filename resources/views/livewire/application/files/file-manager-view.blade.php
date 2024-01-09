<div>
    <x-navigation.bread-crumb icon='fa fa-globe' label='LOCALISATION' color='text-secondary'>
        <x-navigation.bread-crumb-item label='Dashboard' link='dashboard' isLinked=true />
        <x-navigation.bread-crumb-item label='Localisation' />
    </x-navigation.bread-crumb>
    <x-content.main-content-page>
        <div class="card">
            <x-navigation.tab-header>
                <x-navigation.tab-link :icon="'fas fa-capsules'" :name="'Produit'" :link="'product'" :active="'active'" />
                <x-navigation.tab-link :icon="'fa fa-file'" :name="'Fiches'" :link="'sheet'" :active="''" />
            </x-navigation.tab-header>

            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="product">
                      @livewire('application.files.screens.product-files')
                    </div>
                    <div class="tab-pane" id="sheet">
                        <h2>Sheet</h2>
                    </div>
                </div>
            </div>
    </x-content.main-content-page>
</div>
