<div class="row">
    <div class="col-md-6">
        <h4>NOS COMMUNES</h4>
        <div class="card p-2">
            <form wire:submit='handlerSubmit'>
                <div class="form-group">
                    <x-form.label value="{{ __('Commune') }}" />
                    <x-form.input placeholder='Saisir la commune ici et cliquer sur Entre/Enter' type='text'
                        wire:model='name' :error="'name'" />
                    <x-errors.validation-error value='name' />
                </div>
            </form>
        </div>
        <table class="table table-bordered table-sm">
            <thead class="bg-indigo">
                <tr>
                    <th>#</th>
                    <th>Designation</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if ($municipalities->isEmpty())
                    <tr>
                        <td colspan="3" class="text-center">
                            <x-errors.data-empty />
                        </td>
                    </tr>
                @else
                    @foreach ($municipalities as $index => $municipality)
                        <tr style="cursor: pointer;" id="row1">
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $municipality->name }}</td>
                            <td class="text-center">
                                <x-form.edit-button-icon wire:click="edit({{ $municipality }})" class="btn-sm" />
                                <x-form.delete-button-icon wire:confirm="Etes-vous de supprimer?"
                                    wire:click="delete({{ $municipality }})" class="btn-sm" />
                            </td>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
