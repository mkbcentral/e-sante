<div>
    <x-navigation.bread-crumb icon='fas fa-chart-area' label='TABLEAU DE BORD' color='text-secondary'>
        <x-navigation.bread-crumb-item label='Dashboard' />
    </x-navigation.bread-crumb>
    <x-content.main-content-page>
        <div class="row">
            <div class="col-md-6">
                @if (Auth::user()->roles->pluck('name')->contains('Finance-F'))
                    @livewire('application.dashboard.finance.dash-payroll-by-date')
                @elseif (Auth::user()->roles->pluck('name')->contains('Ag') ||
                        Auth::user()->roles->pluck('name')->contains('Finance') ||
                        Auth::user()->roles->pluck('name')->contains('Admin'))
                    @livewire('application.dashboard.finance.dash-outpaient-bil')
                    @livewire('application.dashboard.product.dash-invoice-product')
                    @livewire('application.dashboard.finance.dash-consultation-request-finance-private-hospilize')
                @elseif (Auth::user()->roles->pluck('name')->contains('Caisse'))
                    @livewire('application.dashboard.finance.dash-outpaient-bil')
                    @livewire('application.dashboard.finance.dash-consultation-request-finance-private-hospilize')
                @else
                    @livewire('application.dashboard.frequentation.dash-consultation-request-frequentation')
                @endif
            </div>
            <div class="col-md-6">
                @if (
                    Auth::user()->roles->pluck('name')->contains('Ag') ||
                    Auth::user()->roles->pluck('name')->contains('Admin')
                )
                    @livewire('application.dashboard.finance.dash-consultation-request-finance')
                @else
                    @livewire('application.dashboard.frequentation.dash-consultation-request-hospitalized')
                @endif
            </div>
        </div>
    </x-content.main-content-page>
</div>
