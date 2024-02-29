<div>
    @livewire('application.product.form.product-form-view')
    <x-navigation.bread-crumb icon='fa fa-capsules' label='GESTION DES APPROS EN MEDICAMENTS' color="text-pink">
        <x-navigation.bread-crumb-item label='Dashboard' link='dashboard' isLinked=true />
        <x-navigation.bread-crumb-item label='Appro médicaments' />
    </x-navigation.bread-crumb>
    <x-content.main-content-page>
        <div class="row">
            <div class="col-md-6">
                <div class="card card-indigo">
                    <div class="card-header d-flex justify-content-between">
                      <span>  <i class="fa fa-list" aria-hidden="true"></i> LISTTE DE DEMANDE</span>
                    </div>
                    <div class="card-body">
                        @livewire('application.product.supply.list-supplies-view')
                    </div>
                </div>
            </div>
            <div class="col-md-6">
               <div class="card card-navy">
                 <div class="card-header">
                        <i class="fa fa-list" aria-hidden="true"></i> REQUISITION DES PRODUITS
                    </div>
                <div class="card-body">
                    @livewire('application.product.requisition.main-product-requisition-view')
                </div>
               </div>
            </div>
        </div>
    </x-content.main-content-page>
</div>
