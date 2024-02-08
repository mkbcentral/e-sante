<?php

namespace App\Livewire\Application\Navigation\Screens;

use App\Models\Hospital;
use App\Models\SubMenu;
use Exception;
use Livewire\Attributes\Rule;
use Livewire\Component;

class SubMenuView extends Component
{
    #[Rule('required', message: 'Désignation obligatoire', onUpdate: false)]
    public $name;
    #[Rule('required', message: 'Désignation obligatoire', onUpdate: false)]
    public $icon;
    #[Rule('required', message: 'Désignation obligatoire', onUpdate: false)]
    public $link;

    public ?SubMenu $subMenuToEdit = null;
    public string $formLabel = 'CREATION SOUS MENU';
    public function store()
    {
        $this->validate();
        try {
            SubMenu::create([
                'name' => $this->name,
                'icon' => $this->icon,
                'link' => $this->link,
                'hospital_id' => Hospital::DEFAULT_HOSPITAL()
            ]);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function edit(?SubMenu $subMenu)
    {
        $this->subMenuToEdit = $subMenu;
        $this->name = $this->subMenuToEdit->name;
        $this->icon = $this->subMenuToEdit->icon;
        $this->link = $this->subMenuToEdit->link;
        $this->formLabel = 'EDITION SOUS MENU';
    }
    public function update()
    {
        $this->validate();
        try {
            $this->subMenuToEdit->name = $this->name;
            $this->subMenuToEdit->icon = $this->icon;
            $this->subMenuToEdit->link = $this->link;
            $this->subMenuToEdit->update();
            $this->subMenuToEdit = null;
            $this->formLabel = 'CREATION SOUS MENU';
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function handlerSubmit()
    {
        if ($this->subMenuToEdit == null) {
            $this->store();
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
        } else {
            $this->update();
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        }
        $this->name = '';
        $this->link = '';
        $this->icon = '';
    }
    public function delete(SubMenu $subMenu)
    {
        try {
            if ($subMenu->mainMenuUsers->isEmpty()) {
                $subMenu->delete();
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
        return view('livewire.application.navigation.screens.sub-menu-view',[
            'subMenus'=>SubMenu::query()
                ->where('hospital_id', Hospital::DEFAULT_HOSPITAL())
                ->get()
        ]);
    }
}
