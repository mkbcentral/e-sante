<div>
    @livewire('application.product.form.product-form-view')
    <x-navigation.bread-crumb icon='fa fa-capsules' label='GESTION DES APPROS EN MEDICAMENTS' color="text-primary">
        <x-navigation.bread-crumb-item label='Dashboard' link='dashboard' isLinked=true />
        <x-navigation.bread-crumb-item label='Appro médicaments' />
    </x-navigation.bread-crumb>
    <x-content.main-content-page>
        <div class="card card-primary">
            <div class="card-header d-flex justify-content-between">
                <span> <i class="fa fa-list" aria-hidden="true"></i> LISTTE DES ENTREES</span>
            </div>
            <div class="card-body">
                @livewire('application.product.supply.list-supplies-view')
            </div>
        </div>
    </x-content.main-content-page>
</div>
