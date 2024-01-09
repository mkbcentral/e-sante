<div>
    @livewire('application.admin.user.role-view')
    @livewire('application.admin.user.list-role-for-user')
    <div class="row">
        <div class="col-md-8">
            <div class="d-flex justify-content-center pb-2">
                <x-widget.loading-circular-md />
            </div>
            <div class="d-flex justify-content-between">
                <x-form.input-search :bg='"bg-teal"' wire:model.live.debounce.500ms="q" />
                <div>
                    <x-form.button type="button" class="btn-info" wire:click='openRoleViewModal'>
                        <i class="fas fa-fingerprint" aria-hidden="true"></i> Roles
                    </x-form.button>
                </div>
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
                                <td class="text-center">
                                    <img src="{{ asset('defautl-user.jpg') }}" width="30px" alt="Avatar" class="img-circle">
                                </td>
                                <td class="text-center">
                                    <x-form.button type="button" class="btn-link "
                                        wire:click='openRoleUserViewModal({{ $user }})'>
                                        <i class="fa fa-key" aria-hidden="true"></i>
                                    </x-form.button>
                                    <x-form.edit-button-icon wire:click="edit({{ $user }})" class="btn-sm" />
                                    <x-form.delete-button-icon wire:click="showDeleteDialog({{ $user }})"
                                        class="btn-sm" />
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <div class="col-md-4">
            @livewire('application.admin.user.create-and-update-user')
        </div>
    </div>
    @push('js')
        <script type="module">
            //Open  role modal
            window.addEventListener('open-form-role', e => {
                $('#form-role').modal('show')
            });
            //Open role user modal
            window.addEventListener('open-form--user-role', e => {
                $('#form--user-role').modal('show')
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
