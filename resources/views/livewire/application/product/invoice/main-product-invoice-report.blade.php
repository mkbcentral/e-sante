<div>
    @livewire('application.product.invoice.form.product-invoice-create-and-update')
    @livewire('application.product.invoice.list.list-invoice-by-date')
    <x-navigation.bread-crumb icon='fas fa-capsules' label='RAPPORT PHARMA AMBULATOIRE  ' color='text-secondary'>
        <x-navigation.bread-crumb-item label='Dashboard' link='dashboard' isLinked=true />
        <x-navigation.bread-crumb-item label='Facturation' link='product.invoice' isLinked=true />
        <x-navigation.bread-crumb-item label='Facturation ambulatoire' />
    </x-navigation.bread-crumb>
    <x-content.main-content-page>
        <div class="row">
            <div class="col-md-6">
                @livewire('application.product.invoice.list.list-invoice-by-month')
            </div>
            <div class="col-md-6">
                <div class="progress vertical">
                    <div class="progress-bar bg-success" role="progressbar" aria-valuenow="40" aria-valuemin="0"
                        aria-valuemax="100" style="height: 40%">
                        <span class="sr-only">40%</span>
                    </div>
                </div>
            </div>
        </div>
    </x-content.main-content-page>
</div>