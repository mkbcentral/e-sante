<div >
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <h4 class="text-secondary"><i class="fa fa-list" aria-hidden="true"></i> SERVICES</h4>
                <table class="table table-bordered table-sm">
                    <thead class="bg-dark">
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Icone</th>
                            <th>Lien</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($subMenus->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center">
                                    <x-errors.data-empty />
                                </td>
                            </tr>
                        @else
                            @foreach ($subMenus as $index => $subMenu)
                                <tr style="cursor: pointer;" id="row1">
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $subMenu->name }}</td>
                                    <td>{{ $subMenu->icon }}</td>
                                    <td>{{ $subMenu->link }}</td>
                                    <td class="text-center">
                                        <x-form.edit-button-icon wire:click="edit({{ $subMenu }})"
                                            class="btn-sm" />
                                        <x-form.delete-button-icon wire:confirm="Etes-vous de supprimer?"
                                            wire:click="delete({{ $subMenu }})" class="btn-sm" />
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-header b bg-dark">
                <h5>{{$formLabel}}</h5>
            </div>
            <div class="card p-2">
                <form wire:submit='handlerSubmit'>
                    <div class="form-group">
                        <x-form.label value="{{ __('Nom') }}" />
                        <x-form.input placeholder='Saisir le nom ici' type='text'
                            wire:model='name' :error="'name'" />
                        <x-errors.validation-error value='name' />
                    </div>
                     <div class="form-group">
                        <x-form.label value="{{ __('Icon') }}" />
                        <x-form.input placeholder='Saisir classe icon' type='text'
                            wire:model='icon' :error="'icon'" />
                        <x-errors.validation-error value='icon' />
                    </div>
                     <div class="form-group">
                        <x-form.label value="{{ __('Lien/Route') }}" />
                        <x-form.input placeholder='Saisir le nom de la route' type='text'
                            wire:model='link' :error="'link'" />
                        <x-errors.validation-error value='link' />
                    </div>

                    <div class="card-footer d-flex justify-content-end">
                        <x-form.button class="btn-primary" type='submit'><i class="fa fa-save"></i> Sauvegarder</x-form.button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
