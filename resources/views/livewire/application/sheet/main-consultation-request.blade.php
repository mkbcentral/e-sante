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
                        <button type="button" wire:click='makeIsByDate'
                            class="btn {{ $isByDate == true ? 'btn-secondary' : '' }}">
                            <i class="fa fa-calendar-day text-secondary" aria-hidden="true"></i> Journalière</button>
                        <button type="button" wire:click='makeIsByMonth'
                            class="btn {{ $isByMonth == true ? 'btn-secondary' : '' }}">
                            <i class="fa fa-calendar-alt text-secondary" aria-hidden="true"></i> Mensuelle</button>
                        <button type="button" wire:click='makeIsByPeriod'
                            class="btn {{ $isByPeriod == true ? 'btn-secondary' : '' }}">
                            <i class="fa fa-calendar-minus text-secondary" aria-hidden="true"></i> Périodique</button>
                    </div>
                    @livewire('application.finance.widget.amount-consultation-request-by-month-widget', ['selectedIndex' => $selectedIndex, 'isByDate' => $isByDate, 'isByMonth' => $isByMonth, 'isByPeriod' => $isByPeriod])
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
