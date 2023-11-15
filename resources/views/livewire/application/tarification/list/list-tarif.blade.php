<div>
    <div class="card mt-2">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mt-2">
                <x-form.input-search wire:model.live.debounce.500ms="q" />
            </div>
            <div class="d-flex justify-content-center pb-2">
                <x-widget.loading-circular-md/>
            </div>
            @if($tarifs->isEmpty())
                <x-errors.data-empty/>
            @else
                <table class="table table-striped table-sm">
                    <thead class="bg-primary">
                    <tr>
                        <th>
                            <x-form.button class="text-white"  wire:click="sortTarif('name')">NOM TARIF</x-form.button>
                            <x-form.sort-icon sortField="name"  :sortAsc="$sortAsc"  :sortBy="$sortBy" />
                        </th>
                        <th class="text-center">
                            <x-form.button class="text-white"  wire:click="sortTarif('abbreviation')">ABBREVIATION</x-form.button>
                            <x-form.sort-icon sortField="name"  :sortAsc="$sortAsc"  :sortBy="$sortBy" />
                        </th>
                        <th class="text-center">PRIX PRIVES</th>
                        <th class="text-center">PRIX ABONNES</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tarifs as $tarif)
                        <tr style="cursor: pointer;">
                            <td class="text-uppercase">
                                @if($isEditing && $idSelected==$tarif->id)
                                    <x-form.input type='text' wire:model='name' wire:keydown.enter='update' :error="'name'" />
                                @else
                                    {{$tarif->name}}
                                @endif
                            </td>
                            <td class="text-uppercase text-center">
                                @if($isEditing && $idSelected==$tarif->id)
                                    <x-form.input  placeholder="Abbreviation" type='text' wire:model='abbreviation' wire:keydown.enter='update' :error="'abbreviation'" />
                                @else
                                    {{$tarif->abbreviation==null?'-':$tarif->abbreviation}}
                                @endif
                            </td>
                            <td class="text-center">
                                @if($isEditing && $idSelected==$tarif->id)
                                    <x-form.input type='text' wire:model='price_private' wire:keydown.enter='update' :error="'price_private'" />
                                @else
                                    {{$tarif->price_private}}
                                @endif
                            </td>
                            <td class="text-center">
                                @if($isEditing==true && $idSelected==$tarif->id)
                                    <x-form.input type='text' wire:model='subscriber_price' wire:keydown.enter='update' :error="'subscriber_price'" />
                                @else
                                    {{$tarif->subscriber_price}}
                                @endif
                            </td>
                            <td class="text-center">
                                <x-form.edit-button-icon wire:click="edit({{$tarif}})" class="btn-sm"/>
                                <x-form.delete-button-icon wire:click="showDeleteDialog({{$tarif}})" class="btn-sm"/>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div  class="mt-4 d-flex justify-content-center align-items-center">{{$tarifs->links('livewire::bootstrap')}}</div>
            @endif
        </div>
    </div>
    @push('js')
        <script type="module">
            //Confirmation dialog for delete role
            window.addEventListener('delete-tarif-dialog', event => {
                Swal.fire({
                    title: 'Voulez-vous vraimant ',
                    text: "retirer ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText:'Non'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.dispatch('deleteTarifListener');
                    }
                })
            });
            window.addEventListener('tarif-deleted', event => {
                Swal.fire(
                    'Action !',
                    event.detail[0].message,
                    'success'
                );
            });
        </script>
    @endpush
</div>
