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
        <div class="card">
            <div class="card-body">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" wire:click='makeIsByDate'
                        class="btn {{ $isByDate == true ? 'btn-secondary' : '' }}">Journalière</button>
                    <button type="button" wire:click='makeIsByMonth'
                        class="btn {{ $isByMonth == true ? 'btn-secondary' : '' }}">Mensuelle</button>
                    <button type="button" wire:click='makeIsByPeriod'
                        class="btn {{ $isByPeriod == true ? 'btn-secondary' : '' }}">Périodique</button>
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
