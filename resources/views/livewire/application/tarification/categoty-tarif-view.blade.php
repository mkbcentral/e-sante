<div>
    <x-modal.build-modal-fixed
        idModal='category-tarif-page'
        size='xl' headerLabel="CATEGORIE DE TARIFICATION"
        headerLabelIcon='fa fa-folder'>
        <div class="row">
            <div class="col-md-8">
                @if($categories->isEmpty())
                 <x-errors.data-empty />
                @else
                    <table class="table table-striped table-sm">
                        <thead class="bg-primary">
                        <tr>
                            <th class="">CATEGORIE</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $category)
                            <tr style="cursor: pointer;">
                                <td class="">{{$category->name}}</td>
                                <td class="text-center">
                                    <x-form.edit-button-icon wire:click="edit({{$category}})" class="btn-sm"/>
                                    <x-form.delete-button-icon wire:click="delete({{$category}})" class="btn-sm"/>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                @endif

            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-primary"><h5>
                            @if($isEditing)
                                <i class="fa fa-edit"></i> MODIFICATION TARIF</h5>
                            @else
                                <x-icons.icon-plus-circle/> CREATION TARIF</h5>
                            @endif

                    </div>
                    <form
                    @if($isEditing)
                        wire:submit='update'
                    @else
                        wire:submit='store'
                    @endif
                       >
                        <div class="card-body">
                            <div class="form-group">
                                <x-form.label value="{{ __('Category') }}" />
                                <x-form.input type='text' wire:model='name' :error="'name'" />
                                <x-errors.validation-error value='name' />
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end">
                            @if($isEditing)
                                <x-form.button class="btn-primary" type='submit'><i class="fa fa-sync"></i> Mettre à jour</x-form.button>
                            @else
                                <x-form.button class="btn-primary" type='submit'><i class="fa fa-save"></i> Sauvegarder</x-form.button>
                            @endif

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-modal.build-modal-fixed>
</div>
