<div>
    @livewire('application.product.invoice.form.product-invoice-create-and-update')
    @livewire('application.product.invoice.list.list-invoice-by-date')
    <x-navigation.bread-crumb icon='fas fa-file' label='RAPPORT MENSUEL  AMBULATOIRE  ' color='text-secondary'>
        <x-navigation.bread-crumb-item label='Dashboard' link='dashboard' isLinked=true />
        <x-navigation.bread-crumb-item label='Facturation' link='bill.outpatient' isLinked=true />
        <x-navigation.bread-crumb-item label='Facturation ambulatoire' />
    </x-navigation.bread-crumb>
    <x-content.main-content-page>
        <div class="card">
            <div class="card-body">
                @livewire('application.finance.billing.list.list-outpatient-bill-by-month')
            </div>
        </div>
    </x-content.main-content-page>
</div>
