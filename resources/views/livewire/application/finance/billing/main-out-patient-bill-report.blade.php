<div>
    @livewire('application.product.invoice.form.product-invoice-create-and-update')
    @livewire('application.product.invoice.list.list-invoice-by-date')
    <x-navigation.bread-crumb icon='fas fa-file'
        label="SITUATION FINACIERE {{ $isByDate == true ? 'JOURNALIERE' : 'MENSUELLE' }}  " color='text-secondary'>
        <x-navigation.bread-crumb-item label='Dashboard' link='dashboard' isLinked=true />
        <x-navigation.bread-crumb-item label='Facturation' link='bill.outpatient' isLinked=true />
        <x-navigation.bread-crumb-item label='Facturation ambulatoire' />
    </x-navigation.bread-crumb>
    <x-content.main-content-page>
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center ">
                    <div class="d-flex align-items-center">
                        <div class="form-group d-flex align-items-center mr-2">
                            <x-form.label value="{{ __('Date') }}" class="mr-1" />
                            <x-form.input type='date' wire:model.live='date' :error="'date'" />
                        </div>
                        <div class=" d-flex align-items-center">
                            <div class="form-group d-flex align-items-center mr-2">
                                <x-form.label value="{{ __('Année') }}" class="mr-1" />
                                <x-widget.list-years wire:model.live='year' :error="'year'" />
                            </div>
                            <div class="form-group d-flex align-items-center mr-2">
                                <x-form.label value="{{ __('Mois') }}" class="mr-1" />
                                <x-widget.list-french-month wire:model.live='month' :error="'month'" />
                            </div>

                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="form-group d-flex align-items-center ml-2">
                            <x-form.label value="{{ __('Date versment') }}" class="mr-1" />
                            <x-form.input type='date' wire:model.live='date_versement' :error="'date_versement'" />
                        </div>
                        <div class="form-group align-items-center ml-2">
                            <div class="btn-group">
                                <button type="button" class="btn btn-secondary"><i class="fas fa-print"></i>
                                    Imprimer </button>
                                <button type="button" class="btn btn-secondary dropdown-toggle dropdown-icon"
                                    data-toggle="dropdown">
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu" role="menu">
                                    <a class="dropdown-item" target="_blanck"
                                        href="{{ route('rapport.date.outPatientBill.print', [$date, $date_versement]) }}"><i
                                            class="fas fa-file-pdf"></i> Bordereau de versement</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @livewire('application.finance.billing.list.list-outpatient-bill-by-month', ['date' => $date, 'month', $month, 'year' => $year])
                @livewire('application.finance.billing.list.hospitalization-private-repport', ['date' => $date, 'month', $month, 'year' => $year])
            </div>
        </div>
    </x-content.main-content-page>
</div>
