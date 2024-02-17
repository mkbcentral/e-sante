<?php

namespace App\Livewire\Application\Admin\User;

use App\Models\User;
use App\Repositories\User\GetUserRepository;
use Exception;
use Livewire\Attributes\Url;
use Livewire\Component;

class UserView extends Component
{

    protected $listeners = [
        'refreshUserList' => '$refresh',
        'deleteUserListener'=>'delete'
    ];
    public ?User $user;
    //
    #[Url(as: 'q')]
    public $q = '';
    #[Url(as: 'sortBy')]
    public $sortBy = 'name';
    #[Url(as: 'sortAsc')]
    public $sortAsc = true;

    public function edit(?User $user){
        $this->dispatch('selectedUser',$user);
    }
    public function showDeleteDialog(User $user){
        $this->user=$user;
        $this->dispatch('delete-user-dialog');
    }

    public function openRoleViewModal(){
        $this->dispatch('open-form-role');
    }
    public function openRoleUserViewModal(User $user)
    {
        $this->user=$user;
        $this->dispatch('roleUser',$user);
        $this->dispatch('open-form--user-role');
    }

    public function openUserLinkViewModal(User $user)
    {
        $this->user = $user;
        $this->dispatch('userLink', $user);
        $this->dispatch('open-user-link-modal');
    }

    public function delete(){
        try {
            $this->user->delete();
            $this->dispatch('user-deleted', ['message' => 'Action bien réalisée']);
        } catch (Exception $ex) {
            $this->dispatch('error', ['message' => $ex->getMessage()]);
        }
    }
    /**
     * Sort user (Asc or Desc
     * @param $value
     * @return void
     */
    public function sortUser($value): void
    {
        if ($value == $this->sortBy) {
            $this->sortAsc = !$this->sortAsc;
        }
        $this->sortBy = $value;
    }
    public function render()
    {
        return view('livewire.application.admin.user.user-view',[
            'users'=>GetUserRepository::getListUsers($this->q,$this->sortBy,$this->sortAsc)
        ]);
    }
}
