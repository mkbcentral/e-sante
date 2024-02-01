<div>
    @livewire('application.product.form.product-form-view')
    <div class="card card-cyan">
        <div class="card-header">
            LISTE PRODUITS DEMANDES
        </div>
        <div class="card-body">
            <table class="table table-bordered table-sm mt-2">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>DESIGNATION</th>
                        <th class="text-center">Q.T DMD</th>
                        <th class="text-center">Q.T RECU</th>
                        <th class="text-center">OBS</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($productProductSupplies->isEmpty())
                         <tr>
                                <td colspan="7" class="text-center"> <x-errors.data-empty/></td>
                            </tr>
                    @else
                         @foreach ($productProductSupplies as $index => $productProductSupply)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $productProductSupply->product->name }}</td>
                            <td class="text-center">{{ $productProductSupply->quantity }}</td>
                            <td class="text-center">{{ $productProductSupply->quantity }}</td>
                            <td class="text-center">0</td>
                            <td class="text-center">
                                <x-form.icon-button :icon="'fa fa-pen '" class="btn-sm btn-info"
                                    wire:click='edit({{ $productProductSupply->product }})' />
                                <x-form.icon-button :icon="'fa fa-trash '" class="btn-sm btn-danger"
                                    wire:confirm="Etes-vous sûre de supprimer ?"
                                    wire:click='delete({{ $productProductSupply }})' />
                            </td>
                        </tr>
                    @endforeach
                    @endif

                </tbody>
            </table>
        </div>
    </div>
</div>
