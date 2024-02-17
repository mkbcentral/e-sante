<div>
    <div class="card card-cyan">
        <div class="card-header">
            LISTE PRODUITS DEMANDES
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center ">
                <x-form.input-search wire:model.live.debounce.500ms="q" />
                 <x-widget.loading-circular-md />
            </div>

            <table class="table table-bordered table-sm mt-2">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>DESIGNATION</th>
                        <th class="text-center">Q.T APPRO</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($productProductRequisitions->isEmpty())
                        <tr>
                            <td colspan="7" class="text-center"> <x-errors.data-empty /></td>
                        </tr>
                    @else
                        @foreach ($productProductRequisitions as $index => $productProductRequisition)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $productProductRequisition->product->name }}</td>
                                <td class="text-center">{{ $productProductRequisition->quantity }}</td>
                                <td class="text-center">
                                    <x-form.icon-button :icon="'fa fa-pen '" class="btn-sm btn-info"
                                        wire:click='edit({{ $productProductRequisition->product }})' />
                                    <x-form.icon-button :icon="'fa fa-trash '" class="btn-sm btn-danger"
                                        wire:confirm="Etes-vous sûre de supprimer ?"
                                        wire:click='delete({{ $productProductRequisition }})' />
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            <div class="mt-4 d-flex justify-content-center align-items-center">
                {{ $productProductRequisitions->links('livewire::bootstrap') }}</div>
        </div>
    </div>
</div>
