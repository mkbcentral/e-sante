<div>
    <x-modal.build-modal-fixed idModal='user-link-modal' bg='bg-indigo' size='xl'
        headerLabel="ATTRIBUTION MENU A UTILISATEUR" headerLabelIcon='fas fa-link'>
        @if ($user != null)
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"><span class="text-info text-bold"><i class="fa fa-user" aria-hidden="true"></i> User: </span> {{ $user->name }}</h4><br>
                <h4 class="card-title"><span class="text-info text-bold"><i class="fas fa-user-check    "></i> Service: </span> {{ $user->agentService->name }}</h4><br>
                <h4 class="card-title"><span class="text-info text-bold"><i class="fas fa-fingerprint    "></i> Roles: </span> {{ $user->roles()->pluck('name') }}</h4>
            </div>
        </div>
            <div class="row">
                <div class="col-md-6">
                    @livewire('application.admin.user.widget.main-menu-itme-check-box',['user'=>$user])
                </div>
                <div class="col-md-6">
                    @livewire('application.admin.user.widget.sub-menu-itme-check-box',['user'=>$user])
                </div>
            </div>
        @endif
    </x-modal.build-modal-fixed>
    @push('js')
        <script type="module">
            //Open close user link modal
            window.addEventListener('close-user-link-modal', e => {
                $('#user-link-modal').modal('hide')
            });
        </script>
    @endpush
</div>
