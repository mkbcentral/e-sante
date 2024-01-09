<div>
    <x-modal.build-modal-fixed idModal='tarif-consultation-page' bg='bg-navy' size='xl' headerLabel="CONSULTATION TARIF"
        headerLabelIcon='fa fa-folder'>
        <div class="row">
            <div class="col-md-8">

                <table class="table table-striped table-sm">
                    <thead class="bg-navy">
                        <tr>
                            <th class="">DESIGNATION</th>
                            <th class="text-center">PU USD</th>
                            <th class="text-center">P.U USD</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($consultations->isEmpty())
                            <tr>
                                <td colspan="4" class="text-center">
                                    <x-errors.data-empty />
                                </td>
                            </tr>
                        @else
                            @foreach ($consultations as $consultation)
                                <tr style="cursor: pointer;">
                                    <td class="">{{ $consultation->name }}</td>
                                    <td class="text-center  ">{{ $consultation->price_private }}</td>
                                    <td class="text-center  ">{{ $consultation->subscriber_price }}</td>
                                    <td class="text-center">
                                        <x-form.edit-button-icon wire:click="edit({{ $consultation }})"
                                            class="btn-sm" />
                                        <x-form.delete-button-icon wire:confirm="Etes-vous de supprimer?"
                                            wire:click="delete({{ $consultation }})" class="btn-sm" />
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                    </tbody>
                </table>


            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-navy">
                        <h5>{{ $formLabel }}</h5>
                    </div>
                    <form wire:submit='handlerSubmit'>
                        <div class="card-body">
                            <div class="form-group">
                                <x-form.label value="{{ __('Designation') }}" />
                                <x-form.input type='text' wire:model='name' :error="'name'" />
                                <x-errors.validation-error value='name' />
                            </div>
                             <div class="form-group">
                                <x-form.label value="{{ __('Prix privé') }}" />
                                <x-form.input type='text' wire:model='price_private' :error="'price_private'" />
                                <x-errors.validation-error value='price_private' />
                            </div>
                             <div class="form-group">
                                <x-form.label value="{{ __('PRivé abonné') }}" />
                                <x-form.input type='text' wire:model='subscriber_price' :error="'subscriber_price'" />
                                <x-errors.validation-error value='subscriber_price' />
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end">
                            @if ($isEditing)
                                <x-form.button class="btn-primary" type='submit'><i class="fa fa-sync"></i> Mettre à
                                    jour</x-form.button>
                            @else
                                <x-form.button class="btn-primary" type='submit'><i class="fa fa-save"></i>
                                    Sauvegarder</x-form.button>
                            @endif

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-modal.build-modal-fixed>
</div>
