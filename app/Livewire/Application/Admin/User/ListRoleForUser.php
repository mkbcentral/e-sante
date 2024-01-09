<?php

namespace App\Livewire\Application\Admin\User;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;

class ListRoleForUser extends Component
{
    protected $listeners = [
        'roleUser' => 'getUser',
    ];
    public ?User $user=null;
    public  $rolesItems=[];

    public function getUser(?User $user)
    {
        $this->user = $user;
        $this->rolesItems = $user->roles()->pluck('role_id')->map(function ($id) {
            return (string) $id;
        });
    }

    public function assignRoles()
    {
        if ($this->rolesItems != []) {
            $this->user->roles()->detach($this->rolesItems);
            $this->user->roles()->sync($this->rolesItems);
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
        } else {
            $this->dispatch('error', ['message' => 'Aucun élément selectionné']);
        }
    }


    public function render()
    {
        return view('livewire.application.admin.user.list-role-for-user',[
            'roles'=>Role::all()
        ]);
    }
}
