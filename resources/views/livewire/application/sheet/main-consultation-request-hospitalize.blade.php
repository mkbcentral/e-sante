<div>
    <x-navigation.bread-crumb icon='fa fa-bed' label='GESTIONNAIRE DES HOSPITALISATION'>
        <x-navigation.bread-crumb-item label='Dashboard' link='dashboard' isLinked=true />
        <x-navigation.bread-crumb-item label='Liste hospitalisation' />
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
                @livewire('application.sheet.list.list-consultation-request-hospitalize', ['selectedIndex' => $selectedIndex])
            </div>
        </div>
    </x-content.main-content-page>
</div>
