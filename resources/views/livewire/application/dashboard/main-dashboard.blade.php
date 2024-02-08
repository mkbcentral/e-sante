<div>
    <x-navigation.bread-crumb icon='fas fa-chart-area' label='TABLEAU DE BORD' color='text-secondary'>
        <x-navigation.bread-crumb-item label='Dashboard' />
    </x-navigation.bread-crumb>
    <x-content.main-content-page>
        <div class="row">
            <div class="col-md-6">
                @livewire('application.dashboard.frequentation.dash-consultation-request-frequentation')
                @livewire('application.dashboard.frequentation.dash-consultation-request-hospitalized')
            </div>
            <div class="col-md-6">
                @if (Auth::user()->roles->pluck('name')->contains('Ag') ||
                        Auth::user()->roles->pluck('name')->contains('Finance') ||
                        Auth::user()->roles->pluck('name')->contains('Caisse') ||
                        Auth::user()->roles->pluck('name')->contains('Admin'))
                    @livewire('application.dashboard.finance.dash-outpaient-bil')
                @endif
                @if (Auth::user()->roles->pluck('name')->contains('Ag') || Auth::user()->roles->pluck('name')->contains('Admin'))
                    @livewire('application.dashboard.finance.dash-consultation-request-finance')
                @endif

            </div>
        </div>
    </x-content.main-content-page>
</div>
