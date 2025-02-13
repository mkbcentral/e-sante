<div>
    <x-navigation.bread-crumb icon='fa fa-folder' label='DEMANDES DE CONSULTATION'>
        <x-navigation.bread-crumb-item label='Dashboard' link='dashboard' isLinked=true />
        <x-navigation.bread-crumb-item label='Demande de consultation' />
    </x-navigation.bread-crumb>
    <x-content.main-content-page>
        <div class="card-header p-2">
            <ul class="nav nav-pills">
                @foreach ($subscriptions as $subscription)
                    <li class="nav-item">
                        <a wire:click='changeIndex({{ $subscription }})'
                            class="nav-link {{ $selectedIndex == $subscription->id ? 'active' : '' }} "
                            href="#inscription" data-toggle="tab">
                            &#x1F4C2; {{ $subscription->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="card card-primary card-outline">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <x-others.btn-change-consulation wire:click='makeIsByDate' isSelected='{{ $isByDate }}' />
                        <x-others.btn-change-consulation wire:click=' makeIsByMonth' isSelected='{{ $isByMonth }}'
                            label='Mensuelle' />
                        <x-others.btn-change-consulation wire:click='makeIsByPeriod' isSelected='{{ $isByPeriod }}'
                            label='Périodique' />
                    </div>
                    @if (Auth::user()->roles->pluck('name')->contains('ADMIN') ||
                            Auth::user()->roles->pluck('name')->contains('AG') ||
                            Auth::user()->roles->pluck('name')->contains('PHARMA') ||
                            Auth::user()->roles->pluck('name')->contains('FINANCE'))
                        @livewire('application.finance.widget.amount-consultation-request-by-month-widget', [
                            'selectedIndex' => $selectedIndex,
                            'isByDate' => $isByDate,
                            'isByMonth' => $isByMonth,
                            'isByPeriod' => $isByPeriod,
                        ])
                    @endif

                </div>
                <div class="d-flex justify-content-center pb-2">
                    <x-widget.loading-circular-md />
                </div>
                @if ($isByDate == true)
                    @livewire('application.sheet.list.list-consultation-request', ['selectedIndex' => $selectedIndex])
                @elseif ($isByMonth == true)
                    @livewire('application.sheet.list.list-consultation-request-by-month', ['selectedIndex' => $selectedIndex])
                @elseif ($isByPeriod == true)
                    @livewire('application.sheet.list.list-consultation-request-by-period', ['selectedIndex' => $selectedIndex])
                @endif
            </div>
        </div>
    </x-content.main-content-page>
</div>
