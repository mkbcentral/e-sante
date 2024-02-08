 <aside class="main-sidebar sidebar-dark-primary bg-sidebar elevation-4">
     <a href="/" class="brand-link bg-color-secondary">
         <img src="{{ asset('afia-vector-white.png') }}" alt="myCare Logo" class="brand-image mt-1" style="opacity: .8">
         <strong> <span
                 class="brand-text font-weight-light text-bold h3 text-uppercase">{{ config('app.name') }}</span></strong>
     </a>
     <div class="sidebar mt-4">
         <nav class="mt-2">
             <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                 data-accordion="false">
                 <x-navigation.nav-link class="nav-link" href="{{ route('dashboard') }}" wire:navigate
                     :active="request()->routeIs('dashboard')">
                     <i class="fas fa-chart-bar    "></i>
                     <p>Dashboard</p>
                 </x-navigation.nav-link>
                 @if (Auth::user()->roles->pluck('name')->contains('Caisse'))
                     <x-navigation.nav-link class="nav-link" href="{{ route('bill.outpatient') }}" wire:navigate
                         :active="request()->routeIs(['bill.outpatient', 'bill.outpatient.rapport'])">
                         <i class="fas fa-file-invoice-dollar"></i>
                         <p>Factures abulantoire</p>
                     </x-navigation.nav-link>
                 @elseif (Auth::user()->roles->pluck('name')->contains('Pharma'))
                     <x-navigation.nav-link class="nav-link" href="{{ route('product.invoice') }}" wire:navigate
                         :active="request()->routeIs(['product.invoice', 'product.invoice.report'])">
                         <i class="fas fa-file-invoice-dollar"></i>
                         <p>Factures Amb. privé</p>
                     </x-navigation.nav-link>
                     <x-navigation.nav-link class="nav-link" href="{{ route('product.list') }}" wire:navigate
                         :active="request()->routeIs(['product.list'])">
                         <i class="fa fa-capsules" aria-hidden="true"></i>
                         <p>Stock principal</p>
                     </x-navigation.nav-link>
                     <x-navigation.nav-link class="nav-link" href="{{ route('product.supplies') }}" wire:navigate
                         :active="request()->routeIs(['product.supplies'])">
                         <i class="fa fa-capsules" aria-hidden="true"></i>
                         <p>Appro Médicament</p>
                     </x-navigation.nav-link>
                     <x-navigation.nav-link class="nav-link" href="{{ route('consultation.req') }}" wire:navigate
                         :active="request()->routeIs(['consultation.req', 'consultation.consult.patient'])">
                         <i class="fa fa-user-plus" aria-hidden="true"></i>
                         <p>Liste consulation</p>
                     </x-navigation.nav-link>
                     <x-navigation.nav-link class="nav-link" href="{{ route('consultation.hospitalize') }}"
                         wire:navigate :active="request()->routeIs(['consultation.hospitalize'])">
                         <i class="fa fa-bed" aria-hidden="true"></i>
                         <p>Patients hospitalisés</p>
                     </x-navigation.nav-link>
                 @elseif (Auth::user()->roles->pluck('name')->contains('Reception'))
                     <x-navigation.nav-link class="nav-link" href="{{ route('sheet') }}" wire:navigate
                         :active="request()->routeIs(['sheet', 'patient.folder'])">
                         <i class="fa fa-folder" aria-hidden="true"></i>
                         <p>Fiche de consultation</p>
                     </x-navigation.nav-link>
                     <x-navigation.nav-link class="nav-link" href="{{ route('consultation.req') }}" wire:navigate
                         :active="request()->routeIs(['consultation.req', 'consultation.consult.patient'])">
                         <i class="fa fa-user-plus" aria-hidden="true"></i>
                         <p>Liste consulation</p>
                     </x-navigation.nav-link>
                 @elseif (Auth::user()->roles->pluck('name')->contains('Finance'))
                 @else
                     <x-navigation.nav-link class="nav-link" href="{{ route('sheet') }}" wire:navigate
                         :active="request()->routeIs(['sheet', 'patient.folder'])">
                         <i class="fa fa-folder" aria-hidden="true"></i>
                         <p>Fiche de consultation</p>
                     </x-navigation.nav-link>
                     <x-navigation.nav-link class="nav-link" href="{{ route('tarification') }}" wire:navigate
                         :active="request()->routeIs(['tarification'])">
                         <i class="fa fa-folder" aria-hidden="true"></i>

                         <p>Tarification</p>
                     </x-navigation.nav-link>
                     <x-navigation.nav-link class="nav-link" href="{{ route('bill.outpatient') }}" wire:navigate
                         :active="request()->routeIs(['bill.outpatient', 'bill.outpatient.rapport'])">
                         <i class="fas fa-file-invoice-dollar"></i>
                         <p>Factures abulantoire</p>
                     </x-navigation.nav-link>
                     <x-navigation.nav-link class="nav-link" href="{{ route('consultation.req') }}" wire:navigate
                         :active="request()->routeIs(['consultation.req', 'consultation.consult.patient'])">
                         <i class="fa fa-user-plus" aria-hidden="true"></i>
                         <p>Liste consulation</p>
                     </x-navigation.nav-link>
                     <x-navigation.nav-link class="nav-link" href="{{ route('consultation.hospitalize') }}"
                         wire:navigate :active="request()->routeIs(['consultation.hospitalize'])">
                         <i class="fa fa-bed" aria-hidden="true"></i>
                         <p>Patients hospitalisés</p>
                     </x-navigation.nav-link>
                     <x-navigation.nav-link class="nav-link" href="{{ route('product.list') }}" wire:navigate
                         :active="request()->routeIs(['product.list'])">
                         <i class="fa fa-capsules" aria-hidden="true"></i>
                         <p>Liste Produits</p>
                     </x-navigation.nav-link>
                     <x-navigation.nav-link class="nav-link" href="{{ route('product.supplies') }}" wire:navigate
                         :active="request()->routeIs(['product.supplies'])">
                         <i class="fa fa-capsules" aria-hidden="true"></i>
                         <p>Appro Médicament</p>
                     </x-navigation.nav-link>
                     <x-navigation.nav-link class="nav-link" href="{{ route('product.invoice') }}" wire:navigate
                         :active="request()->routeIs(['product.invoice', 'product.invoice.report'])">
                         <i class="fas fa-file-invoice-dollar"></i>
                         <p>Factures pharmacie</p>
                     </x-navigation.nav-link>
                     <x-navigation.nav-link class="nav-link" href="{{ route('admin') }}" wire:navigate
                         :active="request()->routeIs(['admin'])">
                         <i class="fa fa-user-cog" aria-hidden="true"></i>
                         <p>Administration</p>
                     </x-navigation.nav-link>
                     <x-navigation.nav-link class="nav-link" href="{{ route('configuration') }}" wire:navigate
                         :active="request()->routeIs(['configuration'])">
                         <i class="fa fa-cog" aria-hidden="true"></i>
                         <p>Configuration</p>
                     </x-navigation.nav-link>
                     <x-navigation.nav-link class="nav-link" href="{{ route('localization') }}" wire:navigate
                         :active="request()->routeIs(['localization'])">
                         <i class="fa fa-globe" aria-hidden="true"></i>
                         <p>Localisation</p>
                     </x-navigation.nav-link>
                     <x-navigation.nav-link class="nav-link" href="{{ route('navigation') }}" wire:navigate
                         :active="request()->routeIs(['navigation'])">
                         <i class="fa fa-link" aria-hidden="true"></i>
                         <p>Navigation</p>
                     </x-navigation.nav-link>
                     <x-navigation.nav-link class="nav-link" href="{{ route('files') }}" wire:navigate
                         :active="request()->routeIs(['files'])">
                         <i class="fas fa-file    "></i>
                         <p>Gestion des fichiers</p>
                     </x-navigation.nav-link>
                 @endif
                 <x-navigation.nav-link class="nav-link" href="{{ route('tarification.prices') }}" wire:navigate
                     :active="request()->routeIs(['tarification.prices'])">
                     <i class="fa fa-folder" aria-hidden="true"></i>
                     <p>Grille tarifaire</p>
                 </x-navigation.nav-link>
             </ul>

         </nav>
     </div>

 </aside>
