 <aside class="main-sidebar sidebar-dark-primary bg-sidebar elevation-4">
     <a href="/" class="brand-link bg-color-secondary">
         <img src="{{ asset('defautl-user.jpg') }}" alt="myCare Logo" class="brand-image" style="opacity: .8">
         <strong> <span class="brand-text font-weight-light text-bold">{{ config('app.name') }}</span></strong>
     </a>
     <div class="sidebar mt-4">
         <nav class="mt-2">
             <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                 data-accordion="false">
                 <x-navigation.nav-link class="nav-link" href="{{ route('dashboard') }}" wire:navigate :active="request()->routeIs('dashboard')">
                     &#x1F4C8;
                     <p>Dashboard</p>
                 </x-navigation.nav-link>
                 <x-navigation.nav-link class="nav-link" href="{{ route('sheet') }}" wire:navigate :active="request()->routeIs(['sheet','patient.folder'])">
                   <i class="fa fa-folder" aria-hidden="true"></i>
                    <p>Fiche de consultation</p>
                </x-navigation.nav-link>
                 <x-navigation.nav-link class="nav-link" href="{{ route('tarification') }}" wire:navigate :active="request()->routeIs(['tarification'])">
                     <i class="fa fa-folder" aria-hidden="true"></i>
                     <p>Tarification</p>
                 </x-navigation.nav-link>
                 <x-navigation.nav-link class="nav-link" href="{{ route('tarification.prices') }}" wire:navigate :active="request()->routeIs(['tarification.prices'])">
                     <i class="fa fa-folder" aria-hidden="true"></i>
                     <p>Grille tarifaire</p>
                 </x-navigation.nav-link>
                 <x-navigation.nav-link class="nav-link" href="{{ route('consultation.req') }}" wire:navigate :active="request()->routeIs(['consultation.req','consultation.consult.patient'])">
                     <i class="fa fa-user-plus" aria-hidden="true"></i>
                     <p>List consulation</p>
                 </x-navigation.nav-link>
             </ul>

         </nav>
     </div>

 </aside>
