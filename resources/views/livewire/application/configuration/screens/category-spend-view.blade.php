<div >
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <h4 class="text-secondary"><i class="fa fa-list" aria-hidden="true"></i> SERVICES</h4>
                <table class="table table-bordered table-sm">
                    <thead class="bg-dark">
                        <tr>
                            <th>#</th>
                            <th>Designation</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($categorySpends->isEmpty())
                            <tr>
                                <td colspan="3" class="text-center">
                                    <x-errors.data-empty />
                                </td>
                            </tr>
                        @else
                            @foreach ($categorySpends as $index => $categorySpend)
                                <tr style="cursor: pointer;" id="row1">
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $categorySpend->name }}</td>
                                    <td class="text-center">
                                        <x-form.edit-button-icon wire:click="edit({{ $categorySpend }})"
                                            class="btn-sm btn-primary" />
                                        <x-form.delete-button-icon wire:confirm="Etes-vous de supprimer?"
                                            wire:click="delete({{ $categorySpend }})" class="btn-sm btn-danger" />
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
                <h5>{{$formLabel}}</h5>
            </div>
            <div class="card p-2">
                <form wire:submit='handlerSubmit'>
                    <div class="form-group">
                        <x-form.label value="{{ __('Description') }}" />
                        <x-form.input placeholder='Saisir le nom du cabinet ici et cliquer sur Entre/Enter' type='text'
                            wire:model='name' :error="'name'" />
                        <x-errors.validation-error value='name' />
                    </div>

                    <div class="card-footer d-flex justify-content-end">
                        <x-form.button class="btn-primary" type='submit'><i class="fa fa-save"></i> Sauvegarder</x-form.button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
