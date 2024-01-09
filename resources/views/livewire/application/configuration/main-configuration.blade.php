<div>
    @livewire('application.product.invoice.form.product-invoice-create-and-update')
    @livewire('application.product.invoice.list.list-invoice-by-date')
    <x-navigation.bread-crumb icon='fas fa-user-cog' label='CONFIGURATION' color='text-secondary'>
        <x-navigation.bread-crumb-item label='Dashboard' link='dashboard' isLinked=true />
        <x-navigation.bread-crumb-item label='Configuration' />
    </x-navigation.bread-crumb>
    <x-content.main-content-page>
        <div class="card">
            <x-navigation.tab-header>
                <x-navigation.tab-link :icon="'fa fa-users'" :name="'Taux echange'" :link="'user'" :active="'active'" />
                <x-navigation.tab-link :icon="'fa fa-users'" :name="'Suscription'" :link="'subqscription'" :active="''" />
            </x-navigation.tab-header>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="user">
                        @livewire('application.configuration.screens.rate-view')
                    </div>
                    <div class="tab-pane" id="subqscription">
                        @livewire('application.configuration.screens.subscription-view')
                    </div>
                </div>
            </div>
    </x-content.main-content-page>
</div>
