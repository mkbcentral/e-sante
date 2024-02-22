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
                 @if (Auth::user()->subMenus->isEmpty())
                     <x-navigation.nav-link class="nav-link" href="{{ route('admin') }}" wire:navigate
                         :active="request()->routeIs(['admin'])">
                       <i class="fa-solid fa-screwdriver-wrench"></i>
                         <p>Administration</p>
                     </x-navigation.nav-link>
                 @else
                     @foreach (Auth::user()->subMenus as $subMenu)
                         <x-navigation.nav-link class="nav-link" href="{{route($subMenu->link)}}"  wire:navigate
                             :active="request()->routeIs([$subMenu->link])">
                             <i class="{{ $subMenu->icon }}"></i>
                             <p>{{ $subMenu->name }}</p>
                         </x-navigation.nav-link>
                     @endforeach
                 @endif
             </ul>

         </nav>
     </div>
 </aside>
