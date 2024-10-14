<div>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="d-flex justify-content-between align-items-center">
                   <h4 class="text-secondary"><i class="fa fa-list" aria-hidden="true"></i> SYMPTOMES ET PLAINTES</h4>
                    <div class="form-group d-flex align-items-center">
                        <x-form.label class="mr-2" value="{{ __('Categorie') }}" for='cat-id-filter' />
                        <select class="form-control" wire:model.live='category_filter' id="cat-id-filter">
                            <option disabled>Choisir.... </option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <table class="table table-bordered table-sm">
                    <thead class="bg-dark">
                        <tr>
                            <th>#</th>
                            <th>Designation</th>
                            <th>Categorie</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($symptoms->isEmpty())
                            <tr>
                                <td colspan="4" class="text-center">
                                    <x-errors.data-empty />
                                </td>
                            </tr>
                        @else
                            @foreach ($symptoms as $index => $symptom)
                                <tr style="cursor: pointer;" id="row1">
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $symptom->name }}</td>
                                    <td>{{ $symptom?->categoryDiagnostic?->name }}</td>
                                    <td class="text-center">
                                        <x-form.edit-button-icon wire:click="edit({{ $symptom }})"
                                            class="btn-sm btn-primary" />
                                        <x-form.delete-button-icon wire:confirm="Etes-vous de supprimer?"
                                            wire:click="delete({{ $symptom }})" class="btn-sm btn-danger" />
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="mt-4 d-flex justify-content-center align-items-center">
                    {{ $symptoms->links('livewire::bootstrap') }}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-header b bg-dark">
                <h5>{{ $formLabel }}</h5>
            </div>
            <div class="card p-2">
                <form wire:submit='handlerSubmit'>
                    <div class="form-group">
                        <x-form.label value="{{ __('Categorie') }}" for='cat-id' />
                        <select class="form-control" wire:model='category_diagnostic_id' id="cat-id">
                            <option disabled>Choisir.... </option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                            <x-errors.validation-error value='category_diagnostic_id' />
                        </select>
                    </div>
                    <div class="form-group">
                        <x-form.label value="{{ __('Description') }}" />
                        <x-form.input placeholder='Saisir le symptome ici et cliquer sur Entre/Enter' type='text'
                            wire:model='name' :error="'name'" />
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
