<div>
    @livewire('application.sheet.form.new-consultation-sheet')
    @livewire('application.sheet.form.new-consultation-request')
    <div class="card mt-2">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mt-2">
                <x-form.input-search wire:model.live.debounce.500ms="q" />
                <div>
                    <div class="btn-group">
                        <button  type="button" class="btn btn-secondary">
                            <span class="mr-1">Total</span>
                            <span class="badge badge-pill badge-danger">
                            @livewire('application.sheet.widget.count-sheet-by-subscription',['subscriptionId'=>$selectedIndex])
                        </span>
                        </button>
                    </div>
                    <x-form.button class="btn-primary" wire:click="newSheet"><x-icons.icon-plus-circle/> Nouvelle fiche</x-form.button>
                </div>
            </div>
            <div class="d-flex justify-content-center pb-2">
                <x-widget.loading-circular-md/>
            </div>
            @if($sheets->isEmpty())
                <x-errors.data-empty/>
            @else
                <table class="table table-striped table-sm">
                    <thead class="bg-primary">
                    <tr>
                        <th class="text-center">
                            <x-form.button class="text-white" wire:click="sortSheet('number_sheet')">NUMERO</x-form.button>
                            <x-form.sort-icon sortField="number_sheet"  :sortAsc="$sortAsc"  :sortBy="$sortBy" />
                        </th>
                        <th>
                            <x-form.button class="text-white"  wire:click="sortSheet('name')">NOM COMPLET</x-form.button>
                            <x-form.sort-icon sortField="name"  :sortAsc="$sortAsc"  :sortBy="$sortBy" />
                        </th>
                        <th class="text-center">GENGER</th>
                        <th class="text-center">AGE</th>
                        <th class="text-right">TELEPHONE</th>
                        <th class="text-right">SUSCRIPTION</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($sheets as $sheet)
                        <tr style="cursor: pointer;">
                            <td class="text-center">{{sprintf("%03d", $sheet->number_sheet)}}</td>
                            <td class="text-uppercase">{{$sheet->name}}</td>
                            <td class="text-center">{{$sheet->gender}}</td>
                            <td class="text-center">{{$sheet->getPatientAge()}}</td>
                            <td class="text-right">{{$sheet->phone}}</td>
                            <td class="text-right text-bold text-uppercase">{{$sheet->subscription}}</td>
                            <td class="text-center">
                                <x-form.icon-button :icon="'fa fa-user-plus text-info'" wire:click="newRequestForm({{$sheet}})" class="btn-sm"/>
                                <x-form.edit-button-icon wire:click="edit({{$sheet}})" class="btn-sm"/>
                                <x-navigation.link-icon href="{{route('patient.folder',$sheet->id)}}" wire:navigate :icon="'fa fa-folder-open text-warning'"/>
                                <x-form.delete-button-icon wire:click="showDeleteDialog({{$sheet}})" class="btn-sm"/>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
                <div  class="mt-4 d-flex justify-content-center align-items-center">{{$sheets->links('livewire::bootstrap')}}</div>
            @endif
        </div>

    </div>
    @push('js')
        <script type="module">
            //Open  new sheet form modal
            window.addEventListener('open-form-new',e=>{
                $('#new-sheet-form').modal('show')
            });
            //Open edit sheet modal
            window.addEventListener('open-new-request-form',e=>{
                $('#form-new-request').modal('show')
            });
            //Confirmation dialog for delete role
            window.addEventListener('delete-sheet-dialog', event => {
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
                        Livewire.dispatch('deleteSheetListener');
                    }
                })
            });
            window.addEventListener('sheet-deleted', event => {
                Swal.fire(
                    'Action !',
                    event.detail[0].message,
                    'success'
                );
            });
        </script>
    @endpush
</div>
