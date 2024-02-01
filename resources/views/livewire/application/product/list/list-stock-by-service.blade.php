<div>
    <div class="card card-indigo">
        <div class="card-header">
            <i class="fas fa-pills"></i> MON STOCK
        </div>
        <div class="card-body">
            <table class="table table-bordered table-sm">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>DESIGNATION</th>
                        <th class="text-center">ENTRE</th>
                        <th class="text-center">SORTIES</th>
                        <th class="text-center">OBS</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productProductSupplies as $index => $productProductSupply)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $productProductSupply->product_name }}</td>
                            <td class="text-center">
                                {{ $productProductSupply->product->getTotalInputsByService($productProductSupply->product->id) }}
                            </td>
                            <td class="text-center">0</td>
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
                </tbody>
            </table>
        </div>
    </div>
</div>
