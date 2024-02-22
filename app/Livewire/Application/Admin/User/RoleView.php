<?php

namespace App\Livewire\Application\Admin\User;

use App\Models\Role;
use Exception;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class RoleView extends Component
{
    use WithPagination;
    #[Rule('required', message: 'Username obligatoire', onUpdate: false)]
    public $name = '';
    public ?Role $roleToEdit=null;

    public function store(){
        $this->validate();
        try {
            Role::create([
                'name' => $this->name,
            ]);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function edit(?Role $role){
        $this->roleToEdit=$role;
        $this->name=$this->roleToEdit->name;
    }
    public function update(){
        $this->validate();
        try {
           $this->roleToEdit->name=$this->name;
           $this->roleToEdit->update();
           $this->roleToEdit=null;
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function handlerSubmit(){
        if($this->roleToEdit==null){
            $this->store();
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
        } else {
            $this->update();
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        }
        $this->name = '';
    }
    public function delete(Role $role){
        try {
            $role->delete();
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function render()
    {
        return view('livewire.application.admin.user.role-view',[
            'roles'=>Role::orderBy('name','ASC')->paginate(5)
        ]);
    }
}
