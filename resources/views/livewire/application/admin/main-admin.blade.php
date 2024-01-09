<div>
    @livewire('application.product.invoice.form.product-invoice-create-and-update')
    @livewire('application.product.invoice.list.list-invoice-by-date')
    <x-navigation.bread-crumb icon='fas fa-user-cog' label='ADMINISTRATION' color='text-secondary'>
        <x-navigation.bread-crumb-item label='Dashboard' link='dashboard' isLinked=true />
        <x-navigation.bread-crumb-item label='Administration' />
    </x-navigation.bread-crumb>
    <x-content.main-content-page>
        <div class="card">
            <x-navigation.tab-header>
                <x-navigation.tab-link :icon="'fa fa-users'" :name="'Utilisateurs'" :link="'user'" :active="'active'">

                </x-navigation.tab-link>
            </x-navigation.tab-header>
            <x-navigation.tab-body :active='"active"' :link='"user"'>
                @livewire('application.admin.user.user-view')
            </x-navigation.tab-body>
        </div>
    </x-content.main-content-page>
</div>
