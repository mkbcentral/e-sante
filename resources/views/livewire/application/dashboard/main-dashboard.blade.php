<div>
    <x-navigation.bread-crumb icon='fas fa-chart-area' label='TABLEAU DE BORD' color='text-secondary'>
        <x-navigation.bread-crumb-item label='Dashboard' />
    </x-navigation.bread-crumb>
    <x-content.main-content-page>
        <div class="d-flex justify-content-between mb-2">
            <div class="d-flex align-items-center mr-2">
                <x-form.label value="{{ __('Date') }}" class="mr-1" />
                <x-form.input type='date' wire:model.live='date' :error="'date_filter'" />
            </div>
            <div class="d-flex align-items-center">
                <div class="d-flex align-items-center mr-2">
                    <x-form.label value="{{ __('Mois') }}" class="mr-1" />
                    <x-widget.list-french-month wire:model.live='month' :error="'month'" />
                </div>
                <div class="d-flex align-items-center mr-2">
                    <x-form.label value="{{ __('Année') }}" class="mr-1" />
                    <x-widget.list-years wire:model.live='year' :error="'year'" />
                </div>
                <div>
                    <button type="button" class="btn btn-link dropdown-icon" data-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fa fa-print" aria-hidden="true"></i>
                        Impression
                    </button>
                    <div class="dropdown-menu" role="menu" style="">
                        @if ($date != '')
                            <a class="dropdown-item" target="_blank"
                                href="{{ route('monthly.frequentation.hospitalize', [$date, $year]) }}">
                                <i class="fa fa-file-pdf" aria-hidden="true"></i> Freq journalière
                            </a>
                        @elseif ($month != '')
                            <a class="dropdown-item" target="_blank"
                                href="{{ route('monthly.frequentation.hospitalize', [$month, $year]) }}">
                                <i class="fa fa-file-pdf" aria-hidden="true"></i> Freq Mensuelle
                            </a>
                        @endif
                        <a class="dropdown-item" target="_blank"
                            href="{{ route('monthly.frequentation.hospitalize', [$month, $year]) }}">
                            <i class="fa fa-file-pdf" aria-hidden="true"></i> Hospitalisés
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @can('finance-view')
            <div class="row mt-2">
                <div class="col-md-6">
                    @livewire('application.dashboard.finance.dash-outpaient-bil', [
                        'date' => $date,
                        'month' => $month,
                        'year' => $year,
                    ])
                    @livewire('application.dashboard.product.dash-invoice-product', [
                        'date' => $date,
                        'month' => $month,
                        'year' => $year,
                    ])
                    @livewire('application.dashboard.finance.dash-consultation-request-finance-private-hospilize', [
                        'date' => $date,
                        'month' => $month,
                        'year' => $year,
                    ])
                    @livewire('application.dashboard.frequentation.dash-consultation-request-hospitalized', [
                        'date' => $date,
                        'month' => $month,
                        'year' => $year,
                    ])
                </div>
                <div class="col-md-6">
                    @livewire('application.dashboard.finance.dash-consultation-request-finance', [
                        'date' => $date,
                        'month' => $month,
                        'year' => $year,
                    ])
                </div>
            </div>
        @endcan
        @can('money-box-view')
            <div class="row">
                <div class="col-md-6">
                    @livewire('application.dashboard.finance.dash-outpaient-bil', [
                        'date' => $date,
                        'month' => $month,
                        'year' => $year,
                    ])
                    @livewire('application.dashboard.finance.dash-consultation-request-finance-private-hospilize', [
                        'date' => $date,
                        'month' => $month,
                        'year' => $year,
                    ])
                    @livewire('application.dashboard.product.dash-invoice-product', [
                        'date' => $date,
                        'month' => $month,
                        'year' => $year,
                    ])
                </div>
                <div class="col-md-6">
                    @livewire('application.dashboard.frequentation.dash-consultation-request-frequentation', [
                        'date' => $date,
                        'month' => $month,
                        'year' => $year,
                    ])
                    @livewire('application.dashboard.frequentation.dash-consultation-request-hospitalized', [
                        'date' => $date,
                        'month' => $month,
                        'year' => $year,
                    ])
                </div>
            </div>
        @endcan
        @can('pharma-actions')
            <div class="row">
                <div class="col-md-6">
                    @livewire('application.dashboard.product.dash-invoice-product', [
                        'date' => $date,
                        'month' => $month,
                        'year' => $year,
                    ])
                </div>
                <div class="col-md-6">
                    @livewire('application.dashboard.frequentation.dash-consultation-request-frequentation', [
                        'date' => $date,
                        'month' => $month,
                        'year' => $year,
                    ])
                    @livewire('application.dashboard.frequentation.dash-consultation-request-hospitalized', [
                        'date' => $date,
                        'month' => $month,
                        'year' => $year,
                    ])
                </div>
            </div>
        @endcan
        @can('reception-actions')
            <div class="row">
                <div class="col-md-6">
                    @livewire('application.dashboard.frequentation.dash-consultation-request-frequentation', [
                        'date' => $date,
                        'month' => $month,
                        'year' => $year,
                    ])
                </div>
                <div class="col-md-6">

                    @livewire('application.dashboard.frequentation.dash-consultation-request-hospitalized', [
                        'date' => $date,
                        'month' => $month,
                        'year' => $year,
                    ])
                </div>
            </div>
        @endcan
        @can('nurse-actions')
            <div class="row">
                <div class="col-md-6">
                    @livewire('application.dashboard.frequentation.dash-consultation-request-frequentation', [
                        'date' => $date,
                        'month' => $month,
                        'year' => $year,
                    ])
                </div>
                <div class="col-md-6">

                    @livewire('application.dashboard.frequentation.dash-consultation-request-hospitalized', [
                        'date' => $date,
                        'month' => $month,
                        'year' => $year,
                    ])
                </div>
            </div>
        @endcan
        @can('labo-actions')
            <div class="row">
                <div class="col-md-6">
                    @livewire('application.dashboard.frequentation.dash-consultation-request-frequentation', [
                        'date' => $date,
                        'month' => $month,
                        'year' => $year,
                    ])
                </div>
                <div class="col-md-6">

                    @livewire('application.dashboard.frequentation.dash-consultation-request-hospitalized', [
                        'date' => $date,
                        'month' => $month,
                        'year' => $year,
                    ])
                </div>
            </div>
        @endcan
        @can('deposit-pharma')
            <div class="row">
                <div class="col-md-6">
                    @livewire('application.dashboard.frequentation.dash-consultation-request-frequentation', [
                        'date' => $date,
                        'month' => $month,
                        'year' => $year,
                    ])
                </div>
                <div class="col-md-6">

                    @livewire('application.dashboard.frequentation.dash-consultation-request-hospitalized', [
                        'date' => $date,
                        'month' => $month,
                        'year' => $year,
                    ])
                </div>
            </div>
        @endcan
    </x-content.main-content-page>
</div>
