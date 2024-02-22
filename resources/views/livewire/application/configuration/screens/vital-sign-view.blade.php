<div >
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <h4 class="text-secondary"><i class="fa fa-list" aria-hidden="true"></i> SIGNE VITAUX</h4>
                <table class="table table-bordered table-sm">
                    <thead class="bg-pink">
                        <tr>
                            <th>#</th>
                            <th>Designation</th>
                            <th class="text-center">Unités</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($vitalsigns->isEmpty())
                            <tr>
                                <td colspan="3" class="text-center">
                                    <x-errors.data-empty />
                                </td>
                            </tr>
                        @else
                            @foreach ($vitalsigns as $index => $vitalSign)
                                <tr style="cursor: pointer;" id="row1">
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $vitalSign->name }}</td>
                                    <td class="text-center">{{ $vitalSign->unit }}</td>
                                    <td class="text-center">
                                        <x-form.edit-button-icon wire:click="edit({{ $vitalSign }})"
                                            class="btn-sm btn-primary" />
                                        <x-form.delete-button-icon wire:confirm="Etes-vous de supprimer?"
                                            wire:click="delete({{ $vitalSign }})" class="btn-sm btn-danger" />
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card-header b bg-pink">
                <h5>{{$formLabel}}</h5>
            </div>
            <div class="card p-2">
                <form wire:submit='handlerSubmit'>
                    <div class="form-group">
                        <x-form.label value="{{ __('Description') }}" />
                        <x-form.input placeholder='Saisir la désignation ici et cliquer sur Entre/Enter' type='text'
                            wire:model='name' :error="'name'" />
                        <x-errors.validation-error value='name' />
                    </div>
                    <div class="form-group">
                        <x-form.label value="{{ __('Unité de mésure') }}" />
                        <x-form.input placeholder='Saisir Unité de mesure ici et cliquer sur Entre/Enter' type='text'
                            wire:model='unit' :error="'unit'" />
                        <x-errors.validation-error value='unit' />
                    </div>

                    <div class="card-footer d-flex justify-content-end">
                        <x-form.button class="btn-primary" type='submit'><i class="fa fa-save"></i> Sauvegarder</x-form.button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
