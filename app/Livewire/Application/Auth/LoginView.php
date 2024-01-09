<?php

namespace App\Livewire\Application\Auth;

use App\Repositories\User\AuthUserRepository;
use Livewire\Attributes\Rule;
use Livewire\Component;

class LoginView extends Component
{

    #[Rule('required', message: 'Adresse mail obligatoire', onUpdate: false)]
    #[Rule('email', message: 'Adresse mail invalide', onUpdate: false)]
    #[Rule('min:6', message: 'Taille Adresse faible', onUpdate: false)]
    public string $email='';
    #[Rule('required', message: 'Mot de passe obligatoire', onUpdate: false)]
    #[Rule('min:4', message: 'Mot de passe faible', onUpdate: false)]
    public $password = '';
    /**
     * Login user on login view
     * @return void|null
     */
    public function loginUser()
    {

        $data = $this->validate();
        try {
            if (AuthUserRepository::login($data)) {
                $this->dispatch('added', ['message' => "Connexion bien établie !"]);
                return $this->redirect('/', navigate: true);;
            } else {
                $this->dispatch('error', ['message' => "'Email ou mot de password incorrect.'"]);
            }
        } catch (\Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    public function render()
    {
        return view('livewire.application.auth.login-view');
    }
}
