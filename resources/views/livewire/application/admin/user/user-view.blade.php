<div>
    @livewire('application.admin.user.role-view')
    @livewire('application.admin.user.list-role-for-user')
    @livewire('application.admin.user.user-links')
    @livewire('application.admin.user.create-and-update-user')
    <div class="">
        <div class="d-flex justify-content-between">
            <x-form.input-search :bg="'bg-teal'" wire:model.live.debounce.500ms="q" />
            <div class="d-flex  justify-content-end ">
                <x-form.button type="button" class="btn-info" wire:click='openRoleViewModal'>
                    <i class="fas fa-fingerprint" aria-hidden="true"></i> Mes roles
                </x-form.button>
                <x-form.button type="button" class="btn-dark  ml-2 " wire:click='openCreateUserViewModal'>
                    <i class="fas fa-user-plus" aria-hidden="true"></i> Nouvel utilisateur
                </x-form.button>
            </div>
        </div>
        <div class="d-flex justify-content-center pb-2">
            <x-widget.loading-circular-md />
        </div>
        <table class="table table-bordered table-sm">
            <thead class="bg-teal">
                <tr>
                    <th>#</th>
                    <th>
                        <x-form.button class="text-white" wire:click="sortUser('name')">Username</x-form.button>
                        <x-form.sort-icon sortField="name" :sortAsc="$sortAsc" :sortBy="$sortBy" />
                    </th>
                    <th class="text-center">
                        <x-form.button class="text-white" wire:click="sortUser('email')">Email</x-form.button>
                        <x-form.sort-icon sortField="email" :sortAsc="$sortAsc" :sortBy="$sortBy" />
                    </th>
                    <th class="text-right ">Source</th>
                    <th class="text-right ">Service</th>
                    <th class="text-center ">Avatr</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if ($users->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center">
                            <x-errors.data-empty />
                        </td>
                    </tr>
                @else
                    @foreach ($users as $index => $user)
                        <tr style="cursor: pointer;" id="row1">
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td class="text-right">{{ $user?->source?->name }}</td>
                            <td class="text-right">{{ $user?->agentService?->name }}</td>
                            <td class="text-center">
                                <img src="{{ asset('defautl-user.jpg') }}" width="30px" alt="Avatar"
                                    class="img-circle">
                            </td>
                            <td class="text-center">
                                <x-form.edit-button-icon wire:click="edit({{ $user }})"
                                    class="btn-sm btn-info text-white" />
                                <x-form.button type="button" class="btn-secondary btn-sm"
                                    wire:click='openRoleUserViewModal({{ $user }})'>
                                    <i class="fa fa-fingerprint" aria-hidden="true"></i>
                                </x-form.button>
                                <x-form.button type="button" class="btn-primary btn-sm "
                                    wire:click='openUserLinkViewModal({{ $user }})'>
                                    <i class="fa fa-link" aria-hidden="true"></i>
                                </x-form.button>
                                <x-form.delete-button-icon wire:click="showDeleteDialog({{ $user }})"
                                    class="btn-sm btn-danger text-white" />
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <div class="mt-4 d-flex justify-content-center align-items-center">
            {{ $users->links('livewire::bootstrap') }}
        </div>
    </div>
    @push('js')
        <script type="module">
            //Open  role modal
            window.addEventListener('open-form-role', e => {
                $('#form-role').modal('show')
            });
            //Open  create user modal
            window.addEventListener('open-form-create-user', e => {
                $('#form-create-user').modal('show')
            });
            //Open role user modal
            window.addEventListener('open-form--user-role', e => {
                $('#form--user-role').modal('show')
            });
            //Open open user link modal
            window.addEventListener('open-user-link-modal', e => {
                $('#user-link-modal').modal('show')
            });
            //Delete user dialog
            window.addEventListener('delete-user-dialog', event => {
                Swal.fire({
                    title: 'Voulez-vous vraimant ',
                    text: "supprimer ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'Non'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('deleteUserListener');
                    }
                })
            });
            window.addEventListener('user-deleted', event => {
                Swal.fire(
                    'Action !',
                    event.detail[0].message,
                    'success'
                );
            });
        </script>
    @endpush
</div>
