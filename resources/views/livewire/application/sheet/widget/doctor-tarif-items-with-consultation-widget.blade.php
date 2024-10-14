<div>
    <h4><i class="fa fa-file" aria-hidden="true"></i> Paraclinques</h4>
    <div class="card">
        <ol>
            @if ($consultationRequest->tarifs->isEmpty())
            @else
                @foreach ($categories as $category)
                    @php
                        $tarifs = $consultationRequest
                            ->tarifs()
                            ->where('category_tarif_id', $category->id)
                            ->get();
                    @endphp
                    @if (!$tarifs->isEmpty())
                        <li>{{ $category->name }}</li>
                        <table class="table table-bordered table-sm">
                            <thead class="bg-primary">
                                <tr>
                                    <th>Examen</th>
                                    <th class="text-center">Nbre</th>
                                    <th>Résultat</th>
                                    <th>VN</th>
                                    <th>Unité</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tarifs as $tarif)
                                    <tr>
                                        <td>
                                            {{ $tarif->abbreviation == null ? $tarif->name : $tarif->abbreviation }}
                                        </td>
                                        <td class="text-center">{{ $tarif->pivot?->qty }}</td>
                                        <td>{{ $tarif->pivot?->result }}</td>
                                        <td>{{ $tarif->pivot?->normal_value }}</td>
                                        <td>{{ $tarif->pivot?->unit }}</td>

                                        <td class="text-center">
                                            @if ($tarif->result == null)
                                                <button class="btn btn-link btn-sm"
                                                    wire:click="showDeleteDialog({{ $tarif->id }})">
                                                    <i class="fa fa-times text-danger" aria-hidden="true"></i>
                                                </button>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                @endforeach
            @endif
        </ol>

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
