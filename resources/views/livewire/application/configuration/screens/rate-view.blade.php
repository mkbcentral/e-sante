<div class="row">
    <div class="col-md-6">
        <h4>GESTION DU TAUX D'ECHANGE</h4>
        <div class="card p-2">
            <form wire:submit='handlerSubmit'>
                <div class="form-group">
                    <x-form.label value="{{ __('Taux') }}" />
                    <x-form.input placeholder='Saisir le taux ici et cliquer sur Entre/Enter' type='text'
                        wire:model='rate' :error="'rate'" />
                    <x-errors.validation-error value='rate' />
                </div>
            </form>
        </div>
        <table class="table table-bordered table-sm">
            <thead class="bg-indigo">
                <tr>
                    <th>#</th>
                    <th>Rate</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if ($rates->isEmpty())
                    <tr>
                        <td colspan="3" class="text-center">
                            <x-errors.data-empty />
                        </td>
                    </tr>
                @else
                    @foreach ($rates as $index => $rate)
                        <tr style="cursor: pointer;" id="row1">
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $rate->rate }}</td>
                            <td class="text-center">
                                <x-form.button type="button" class="btn-link "
                                    wire:confirm="Etes-vous sûre de réaliser l'opération ?"
                                    wire:click='changeStatus({{ $rate }})'>
                                    <i class="{{
                                    $rate->is_current == true ?
                                    'fa fa-times text-danger ' : 'fa fa-check-circle text-info ' }}"
                                        aria-hidden="true"></i>
                                </x-form.button>
                                <x-form.edit-button-icon wire:click="edit({{ $rate }})" class="btn-sm" />
                                <x-form.delete-button-icon wire:confirm="Etes-vous de supprimer?"
                                    wire:click="delete({{ $rate }})" class="btn-sm" />
                            </td>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
