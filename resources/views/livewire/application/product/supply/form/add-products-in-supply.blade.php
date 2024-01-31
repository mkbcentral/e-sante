<div>
    @livewire('application.product.form.product-form-view')
    <x-navigation.bread-crumb icon='fa fa-capsules' label='PASSER UNE DEMANDE DES PRODUITS' color="text-pink">
        <x-navigation.bread-crumb-item label='Dashboard' link='dashboard' isLinked=true />
        <x-navigation.bread-crumb-item label='Liste des appros' link='product.supplies' isLinked=true />
        <x-navigation.bread-crumb-item label='Demande appro' />
    </x-navigation.bread-crumb>
    <x-content.main-content-page>
      <div>
    @if ($productSupply != null)
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-bold">N° APPRO: {{ $productSupply->code }}</h5>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                @livewire('application.product.list.list-product-with-item-adding',['productSupply'=>$productSupply])
            </div>
            <div class="col-md-6">
                @livewire('application.product.list-product-supply-item',['productSupply'=>$productSupply])
            </div>
        </div>
    @endif
</div>
    </x-content.main-content-page>
</div>

