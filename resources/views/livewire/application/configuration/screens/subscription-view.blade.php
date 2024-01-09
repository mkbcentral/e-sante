<div>
    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header bg-navy">
                    <i class="fa fa-list" aria-hidden="true"></i> GESTION DE SOUSCRIPTION
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-sm">
                        <thead class="bg-navy">
                            <tr>
                                <th>#</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($subscriptions->isEmpty())
                                <tr>
                                    <td colspan="3" class="text-center">
                                        <x-errors.data-empty />
                                    </td>
                                </tr>
                            @else
                                @foreach ($subscriptions as $index => $subscription)
                                    <tr style="cursor: pointer;" id="row1">
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td class="text-uppercase">{{ $subscription->name }}</td>
                                        <td
                                            class="{{ $subscription->is_activated == true ? 'text-success ' : 'text-danger ' }}">
                                            {{ $subscription->is_activated == true ? 'Contrat Actif' : 'Contrat Résilié' }}
                                        </td>
                                        <td class="text-center">
                                            <x-form.button type="button" class="btn-link "
                                                wire:confirm="Etes-vous sûre de réaliser l'opération ?"
                                                wire:click='changeStatus({{ $subscription }})'>
                                                <i class="{{ $subscription->is_activated == true ? 'fa fa-times text-danger ' : 'fa fa-check-circle text-info ' }}"
                                                    aria-hidden="true"></i>
                                            </x-form.button>
                                            <x-form.edit-button-icon wire:click="edit({{ $subscription }})"
                                                class="btn-sm" />
                                            <x-form.delete-button-icon wire:confirm="Etes-vous de supprimer?"
                                                wire:click="delete({{ $subscription }})" class="btn-sm" />
                                        </td>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <div class="col-md-5">
            <div class="card p-2">
                <div class="card-header bg-navy">
                    <span><i class="fas fa-pen" aria-hidden="true"></i> {{ $formLabel }}</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($typeItems as $item)
                            <div class="col-md-4">
                                <label class="">
                                    <input type="radio" wire:model.live='type' value="{{ $item['slug'] }}">
                                    {{ $item['name'] }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <form wire:submit='handlerSubmit'>
                        <div class="form-group">
                            <x-form.label value="{{ __('Descriptipion') }}" />
                            <x-form.input placeholder='Saisir la souscription ici et cliquer sur Entre/Enter'
                                type='text' wire:model='name' :error="'name'" />
                            <x-errors.validation-error value='name' />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
