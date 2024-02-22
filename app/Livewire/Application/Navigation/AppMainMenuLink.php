<?php

namespace App\Livewire\Application\Navigation;

use Livewire\Component;

class AppMainMenuLink extends Component
{
    public function makeLoadingState()
    {
    }
    public function render()
    {
        return view('livewire.application.navigation.app-main-menu-link');
    }
}
