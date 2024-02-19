<?php

namespace App\Livewire\Application\Admin\User;

use App\Models\User;
use Livewire\Component;

class UserLinks extends Component
{
    protected $listeners = [
        'userLink' => 'getUser',
    ];
    public ?User $user = null;

    public function getUser(User $user){
        $this->user = $user;
    }
    public function render()
    {
        return view('livewire.application.admin.user.user-links');
    }
}
