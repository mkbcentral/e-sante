<div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <h4 class="text-secondary"><i class="fa fa-list" aria-hidden="true"></i> HOPITAL</h4>
                <table class="table table-bordered table-sm">
                    <thead class="bg-dark">
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Téléphone</th>
                            <th>Email</th>
                            <th>Logo</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($hospitals->isEmpty())
                            <tr>
                                <td colspan="3" class="text-center">
                                    <x-errors.data-empty />
                                </td>
                            </tr>
                        @else
                            @foreach ($hospitals as $index => $hospital)
                                <tr style="cursor: pointer;" id="row1">
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $hospital->name }}</td>
                                    <td>{{ $hospital->phone }}</td>
                                    <td>{{ $hospital->email }}</td>
                                    <td></td>
                                    <td class="text-center">
                                        <x-form.edit-button-icon wire:click="edit({{ $hospital }})"
                                            class="btn-sm btn-primary" />
                                        <x-form.delete-button-icon wire:confirm="Etes-vous de supprimer?"
                                            wire:click="delete({{ $hospital }})" class="btn-sm btn-danger" />
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card-header b bg-dark">
                <h5>{{ $formLabel }}</h5>
            </div>
            <div class="card p-2">
                <form wire:submit='handlerSubmit'>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <x-form.label value="{{ __('Nom hopital') }}" />
                                <x-form.input placeholder='Saisir le nom ici'
                                    type='text' wire:model='name' :error="'name'" />
                                <x-errors.validation-error value='name' />
                            </div>
                        </div>
                         <div class="col-md-6">
                            <div class="form-group">
                                <x-form.label value="{{ __('Email') }}" />
                                <x-form.input placeholder='Saisir email ici'
                                    type='text' wire:model='email' :error="'email'" />
                                <x-errors.validation-error value='email' />
                            </div>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <x-form.label value="{{ __('Téléohone') }}" />
                                <x-form.input placeholder='Saisir le téléphone'
                                    type='text' wire:model='phone' :error="'phone'" />
                                <x-errors.validation-error value='phone' />
                            </div>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-end">
                        <x-form.button class="btn-primary" type='submit'><i class="fa fa-save"></i>
                            Sauvegarder</x-form.button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
