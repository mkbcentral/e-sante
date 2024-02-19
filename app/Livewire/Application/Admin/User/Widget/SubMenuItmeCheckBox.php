<?php

namespace App\Livewire\Application\Admin\User\Widget;

use App\Models\SubMenu;
use App\Models\User;
use Exception;
use Livewire\Component;

class SubMenuItmeCheckBox extends Component
{

    public $subMenuItems = [];
    public User $user;

    public function saveSubMenu()
    {
        try {
            if ($this->subMenuItems != []) {
                $this->user->subMenus()->detach($this->subMenuItems);
                $this->user->subMenus()->sync($this->subMenuItems);
                $this->dispatch('added', ['message' => 'Action bien réalisée']);
            } else {
                $this->dispatch('error', ['message' => 'Veuillez selectionner des éléments ']);
            }
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function mount(User $user){
        $this->user=$user;
        $this->subMenuItems = $user->subMenus()->pluck('sub_menu_id')->map(function ($id) {
            return (string) $id;
        });
    }

    public function render()
    {
        return view(
            'livewire.application.admin.user.widget.sub-menu-itme-check-box',
            [
                'subMenus' => SubMenu::all()
            ]
        );
    }
}
