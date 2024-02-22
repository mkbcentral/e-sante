<?php

namespace App\Livewire\Application\Navigation\Screens;

use App\Models\Hospital;
use App\Models\MainMenu;
use Exception;
use Livewire\Attributes\Rule;
use Livewire\Component;

class MainMenuView extends Component
{
    #[Rule('required', message: 'Désignation obligatoire', onUpdate: false)]
    public $name;
    #[Rule('required', message: 'Désignation obligatoire', onUpdate: false)]
    public $icon;
    #[Rule('required', message: 'Désignation obligatoire', onUpdate: false)]
    public $link;
    #[Rule('required', message: 'Désignation obligatoire', onUpdate: false)]
    public $bg;

    public ?MainMenu $mainMenuToEdit = null;
    public string $formLabel = 'CREATION MENU PRINCIPAL';
    public function store()
    {
        $this->validate();
        try {
            MainMenu::create([
                'name' => $this->name,
                'icon' => $this->icon,
                'link' => $this->link,
                'bg' => $this->bg,
                'hospital_id' => Hospital::DEFAULT_HOSPITAL()
            ]);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function edit(?MainMenu $mainMenu)
    {
        $this->mainMenuToEdit = $mainMenu;
        $this->name = $this->mainMenuToEdit->name;
        $this->icon = $this->mainMenuToEdit->icon;
        $this->link = $this->mainMenuToEdit->link;
        $this->bg = $this->mainMenuToEdit->bg;
        $this->formLabel = 'EDITION MENU PRINCIPAL';
    }
    public function update()
    {
        $this->validate();
        try {
            $this->mainMenuToEdit->name = $this->name;
            $this->mainMenuToEdit->icon = $this->icon;
            $this->mainMenuToEdit->link = $this->link;
            $this->mainMenuToEdit->bg = $this->bg;
            $this->mainMenuToEdit->update();
            $this->mainMenuToEdit = null;
            $this->formLabel = 'CREATION MENU PRINCIPAL';
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function handlerSubmit()
    {
        if ($this->mainMenuToEdit == null) {
            $this->store();
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
        } else {
            $this->update();
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        }
        $this->name = '';
    }
    public function delete(MainMenu $mainMenu)
    {
        try {
            if ($mainMenu->users->isEmpty()) {
                $mainMenu->delete();
                $this->dispatch('updated', ['message' => 'Action bien réalisée']);
            } else {
                $this->dispatch('error', ['message' => 'Action impossible']);
            }
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function render()
    {
        return view('livewire.application.navigation.screens.main-menu-view',[
            'mainMenus'=>MainMenu::query()
                ->where('hospital_id',Hospital::DEFAULT_HOSPITAL())
                ->get()
        ]);
    }
}
