<?php

namespace App\Livewire\Application\Admin\User;

use App\Models\Hospital;
use App\Models\Source;
use App\Models\User;
use Exception;
use Livewire\Attributes\Rule;
use Livewire\Component;

class CreateAndUpdateUser extends Component
{
    protected $listeners = [
        'selectedUser' => 'getUser',
    ];
    #[Rule('required', message: 'Adresse mail obligatoire', onUpdate: false)]
    #[Rule('email', message: 'Adresse mail invalide', onUpdate: false)]
    #[Rule('min:6', message: 'Taille Adresse faible', onUpdate: false)]
    public string $email;
    #[Rule('required', message: 'Username obligatoire', onUpdate: false)]
    public $name;
    #[Rule('required', message: 'Source obligatoire', onUpdate: false)]
    public $source_id ;

    #[Rule('required', message: 'Service obligatoire', onUpdate: false)]
    public $agent_service_id;

    public ?User $user=null;
    public string $formLabel = 'CREATION UTILISATEUR';
    public bool $isEditing = false;

    public function getUser(?User $user)
    {
        $this->user = $user;
        $this->isEditing = true;
        $this->formLabel = 'EDITION UTILISATEUR';
        $this->name = $user->name;
        $this->email = $user->email;
        $this->source_id = $user?->source?->id;
        $this->agent_service_id = $user?->agentService?->id;
    }

    public function store()
    {
        $this->validate();
        try {
            User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => bcrypt('password'),
                'source_id' => $this->source_id,
                'hospital_id'=>Hospital::DEFAULT_HOSPITAL(),
                'agent_service_id'=>$this->agent_service_id
            ]);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function update()
    {
        $this->validate();
        try {
            $this->user->name = $this->name;
            $this->user->email = $this->email;
            $this->user->source_id = $this->source_id;
            $this->user->hospital_id = Hospital::DEFAULT_HOSPITAL();
            $this->user->agent_service_id = $this->agent_service_id;;
            $this->user->update();
            $this->user = null;
            $this->isEditing = false;
            $this->formLabel = 'CREATION UTILISATEUR';

        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }

    public function handlerSubmit()
    {
        if ($this->user == null) {
            $this->store();
            $this->dispatch('added', ['message' => 'Action bien réalisée']);
        } else {
            $this->update();
            $this->dispatch('updated', ['message' => 'Action bien réalisée']);
        }

         $this->dispatch('refreshUserList');
         $this->dispatch('close-form-create-user');
        $this->name = '';
        $this->email = '';
    }


    public function render()
    {

        return view('livewire.application.admin.user.create-and-update-user',[
            'sources'=>Source::where('hospital_id',Hospital::DEFAULT_HOSPITAL())->get()
        ]);
    }
}
