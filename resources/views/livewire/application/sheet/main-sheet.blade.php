<div>
    <div>
        <x-navigation.bread-crumb icon='fa fa-folder' label='GESTIONNAIRE DES FICHES'>
            <x-navigation.bread-crumb-item label='Dashboard' link='dashboard' isLinked=true />
            <x-navigation.bread-crumb-item label='Fiche de consultation' />
        </x-navigation.bread-crumb>
        <x-content.main-content-page>
            <div class="card-header p-2" >
                <ul class="nav nav-pills">
                    @foreach ($subscriptions as $subscription)
                        <li class="nav-item">
                            <a wire:click='changeIndex({{ $subscription }})'
                               class="nav-link text-uppercase {{ $selectedIndex == $subscription->id ? 'active' : '' }} "
                               href="#inscription" data-toggle="tab">
                                &#x1F4C2; {{ $subscription->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            @livewire('application.sheet.list.list-sheet',['selectedIndex'=>$selectedIndex])
        </x-content.main-content-page>
    </div>
</div>
