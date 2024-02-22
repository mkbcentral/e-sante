<div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <h4 class="text-secondary"><i class="fa fa-list" aria-hidden="true"></i> CHAMBRE</h4>
                <table class="table table-bordered table-sm">
                    <thead class="bg-dark">
                        <tr>
                            <th>#</th>
                            <th class="text-center">Code</th>
                            <th>Chambre</th>
                            <th class="">Type</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($rooms->isEmpty())
                            <tr>
                                <td colspan="3" class="text-center">
                                    <x-errors.data-empty />
                                </td>
                            </tr>
                        @else
                            @foreach ($rooms as $index => $room)
                                <tr style="cursor: pointer;" id="row1">
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="text-center">{{ $room->code==null?'-':$room->name }}</td>
                                    <td>{{ $room->name }}</td>
                                    <td class="">{{ $room?->hospitalization?->name }}</td>
                                    <td class="text-center">
                                        <x-form.edit-button-icon wire:click="edit({{ $room }})"
                                            class="btn-sm btn-primary" />
                                        <x-form.delete-button-icon wire:confirm="Etes-vous de supprimer?"
                                            wire:click="delete({{ $room }})" class="btn-sm btn-danger" />
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
                    <div class="form-group">
                        <x-form.label value="{{ __('Code') }}" />
                        <x-form.input placeholder='Saisir le code ' type='text' wire:model='code'
                            :error="'code'" />
                        <x-errors.validation-error value='code' />
                    </div>
                    <div class="form-group">
                        <x-form.label value="{{ __('Nom chambre') }}" />
                        <x-form.input placeholder='Saisir le nom de la chambre' type='text' wire:model='name'
                            :error="'name'" />
                        <x-errors.validation-error value='name' />
                    </div>
                    <div class="form-group">
                        <x-form.label value="{{ __('Type hospitalisation') }}" />
                        <select wire:model='hospitalization_id'
                            class="form-control @error($hospitalization_id) is-invalid @enderror">
                            <option value="">Choisir</option>
                            @foreach ($hospitalizations as $hospitalization)
                                <option value="{{ $hospitalization->id }}">{{ $hospitalization->name }}</option>
                            @endforeach
                        </select>
                        <x-errors.validation-error value='hospitalization_id' />
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
