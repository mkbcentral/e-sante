<div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <h4 class="text-secondary"><i class="fa fa-list" aria-hidden="true"></i> QUARTIER</h4>
                <table class="table table-bordered table-sm">
                    <thead class="bg-dark">
                        <tr>
                            <th>#</th>
                            <th>Designation</th>
                            <th>Commune</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($areaRurals->isEmpty())
                            <tr>
                                <td colspan="3" class="text-center">
                                    <x-errors.data-empty />
                                </td>
                            </tr>
                        @else
                            @foreach ($areaRurals as $index => $areaRural)
                                <tr style="cursor: pointer;" id="row1">
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $areaRural->name }}</td>
                                    <td class="text-center">{{ $areaRural?->municipality?->name }}</td>
                                    <td class="text-center">
                                        <x-form.edit-button-icon wire:click="edit({{ $areaRural }})"
                                            class="btn-sm" />
                                        <x-form.delete-button-icon wire:confirm="Etes-vous de supprimer?"
                                            wire:click="delete({{ $areaRural }})" class="btn-sm" />
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <div  class="mt-4 d-flex justify-content-center align-items-center">{{$areaRurals->links('livewire::bootstrap')}}</div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card-header b bg-dark">
                <h5>{{ $formLabel }}</h5>
            </div>
            <div class="card p-2">
                <form wire:submit='handlerSubmit'>
                    <div class="form-group">
                        <x-form.label value="{{ __('Commune') }}" />
                        <select wire:model.blur='municipality_id' class="form-control  @error($municipality_id) is-invalid @enderror">
                            <option>Choisir</option>
                            @foreach ($listMunicipalities as $municipality)
                                <option value="{{ $municipality->id }}">{{ $municipality->name }}</option>
                            @endforeach
                        </select>
                        <x-errors.validation-error value='form.municipality' />
                    </div>
                    <div class="form-group">
                        <x-form.label value="{{ __('Description') }}" />
                        <x-form.input placeholder='Saisir le nom du cabinet ici et cliquer sur Entre/Enter'
                            type='text' wire:model='name' :error="'name'" />
                        <x-errors.validation-error value='name' />
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
