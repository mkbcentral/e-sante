<div>
    <x-modal.build-modal-fixed idModal='form-role' bg='bg-indigo' size='md' headerLabel="GESTION DES ROLES"
        headerLabelIcon='fas fa-fingerprint'>
        <div class="d-flex justify-content-center ">
            <x-widget.loading-circular-md />
        </div>
        <form wire:submit='handlerSubmit'>
            <div class="card">
                <div class="form-group">
                    <x-form.label value="{{ __('Nom du rôle à ajouter') }}" />
                    <x-form.input placeholder='Saisir le role ici et cliquer sur Entre/Enter' type='text' wire:model='name' :error="'name'" />
                    <x-errors.validation-error value='name' />
                </div>
            </div>
        </form>
        <table class="table table-bordered table-hover table-sm">
            <thead class="bg-indigo">
                <tr>
                    <th>#</th>
                    <th>Role</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if ($roles->isEmpty())
                <tr>
                    <td colspan="3" class="text-center">
                        <x-errors.data-empty />
                    </td>
                </tr>
                @else
                @foreach ($roles as $index => $role)
                <tr style="cursor: pointer;" id="row1">
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $role->name }}</td>
                    <td class="text-center">
                        <x-form.edit-button-icon wire:click="edit({{$role}})" class="btn-sm btn-primary " />
                        <x-form.delete-button-icon wire:confirm="Etes-vous de supprimer?" wire:click="delete({{ $role }})" class="btn-sm btn-danger " />
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
        <div class="mt-4 d-flex justify-content-center align-items-center">
            {{ $roles->links('livewire::bootstrap') }}
        </div>
    </x-modal.build-modal-fixed>
    @push('js')
        <script type="module">
            //Open edit sheet modal
            window.addEventListener('close-form-role', e => {
                $('#form-role').modal('hide')
            });
        </script>
    @endpush
</div>
