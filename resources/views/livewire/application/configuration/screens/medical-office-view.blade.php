<div >
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <h4 class="text-secondary"><i class="fa fa-list" aria-hidden="true"></i> CABINET MEDICAL</h4>
                <table class="table table-bordered table-sm">
                    <thead class="bg-navy">
                        <tr>
                            <th>#</th>
                            <th>Designation</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($medicalOffices->isEmpty())
                            <tr>
                                <td colspan="3" class="text-center">
                                    <x-errors.data-empty />
                                </td>
                            </tr>
                        @else
                            @foreach ($medicalOffices as $index => $medicalOffice)
                                <tr style="cursor: pointer;" id="row1">
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $medicalOffice->name }}</td>
                                    <td class="text-center">
                                        <x-form.edit-button-icon wire:click="edit({{ $medicalOffice }})"
                                            class="btn-sm" />
                                        <x-form.delete-button-icon wire:confirm="Etes-vous de supprimer?"
                                            wire:click="delete({{ $medicalOffice }})" class="btn-sm" />
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card-header b bg-navy">
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
