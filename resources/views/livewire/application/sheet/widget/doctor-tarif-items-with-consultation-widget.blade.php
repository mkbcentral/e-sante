<div>
    <h4><i class="fa fa-file" aria-hidden="true"></i> Paraclinques</h4>
    <div class="card">
        <div class="card-body">
            @if ($tarifs->isEmpty())
                <span class=" text-danger">
                    <h6 class="text-center"> Aucun examen</h6>
                </span>
            @else
                <table class="table table-bordered table-sm">
                    <thead class="thead-light">
                        <tr>
                            <th>Examen</th>
                            <th class="text-center">Nbre</th>
                            <th>Résultat</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tarifs as $tarif)
                            <tr>
                                <td>
                                    {{ $tarif->abbreviation == null ? $tarif->name : $tarif->abbreviation }}
                                </td>
                                <td class="text-center">{{ $tarif->qty }}</td>
                                <td></td>
                                <td class="text-center">
                                    <x-form.delete-button-icon wire:confirm="Etes-vous sûr de supprimer ?"
                                        wire:click="showDeleteDialog({{ $tarif->id }})" class="btn-sm btn-danger" />

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        @push('js')
            <script type="module">
                //Confirmation dialog for delete role
                window.addEventListener('delete-item-dialog', event => {
                    Swal.fire({
                        title: 'Voulez-vous vraimant ',
                        text: "retirer ?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'Non'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Livewire.dispatch('deleteItemListener');
                        }
                    })
                });
                window.addEventListener('item-deleted', event => {
                    Swal.fire(
                        'Action !',
                        event.detail[0].message,
                        'success'
                    );
                });
            </script>
        @endpush
    </div>
</div>
