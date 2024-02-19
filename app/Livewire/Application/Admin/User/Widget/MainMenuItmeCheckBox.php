<?php

namespace App\Livewire\Application\Admin\User\Widget;

use App\Models\MainMenu;
use App\Models\User;
use Exception;
use Livewire\Component;

class MainMenuItmeCheckBox extends Component
{
    public $mainMenuItems = [];
    public User $user;

    public function saveMainMenu()
    {
        try {
           if($this->mainMenuItems != []){
                $this->user->mainMenus()->detach($this->mainMenuItems);
                $this->user->mainMenus()->sync($this->mainMenuItems);
                $this->dispatch('added', ['message' => 'Action bien réalisée']);
           }else{
                $this->dispatch('error', ['message' =>'Veuillez selectionner des éléments ']);
           }
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function mount(User $user)
    {
        $this->user = $user;
        $this->mainMenuItems = $user->mainMenus()->pluck('main_menu_id')->map(function ($id) {
            return (string) $id;
        });
    }

    public function render()
    {
        return view('livewire.application.admin.user.widget.main-menu-itme-check-box',
        [
                'mainMenus' => MainMenu::all()
        ]);
    }
}
