<div>
    @livewire('application.product.requisition.form.new-product-requisition')
    <div class="d-flex justify-content-between">
        <div>
             <x-widget.loading-circular-md />
        </div>
        <div>
            <x-form.button type="button" class="btn-dark" wire:click='openAddModal'>
                <i class="fa fa-plus-circle" aria-hidden="true"></i> Nouvelle demande
            </x-form.button>
            <x-form.button type="button" class="btn-primary" wire:click='refreshList'>
                <i class="fas fa-refresh" aria-hidden="true"></i> Actualiser
            </x-form.button>
        </div>
    </div>
    <div>
        <div class="d-flex justify-content-between ">
            <div>
                <div class="form-group mt-1">
                    <x-form.label value="{{ __('Service') }}" class="mr-1" />
                    <x-widget.list-agent-service-widget wire:model.live='agent_service_id' :error="'agent_service_id'" />
                </div>
            </div>
            <div class="form-group mt-1">
                <x-form.label value="{{ __('Mois') }}" class="mr-1" />
                <x-widget.list-fr-months wire:model.live='month' :error="'month'" />
            </div>
        </div>
        <table class="table table-bordered table-sm">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>DATE</th>
                    <th>CODE</th>
                    <th class="text-center">PRODUCTS</th>
                    <th class="text-center">SERVICE</th>
                    <th class="text-center">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @if ($productRequisitions->isEmpty())
                    <tr>
                        <td colspan="5" class="text-center"> <x-errors.data-empty /></td>
                    </tr>
                @else
                    @foreach ($productRequisitions as $index => $requisition)
                        <tr wire:key='{{ $requisition->id }}'>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $requisition->created_at->format('d/m/Y à H:i:s') }}</td>
                            <td class="text-center">{{ $requisition->number }}</td>
                            <td class="text-center">{{ $requisition->productRequistionProducts->count() }}</td>
                            <td class="text-center">{{ $requisition->agentService->name }}</td>
                            <td class="text-center">
                                <x-navigation.link-icon class="btn btn-sm btn-primary"
                                    href="{{ route('product.requisition', $requisition) }}" wire:navigate
                                    :icon="'fa fa-plus-circle'" />
                                <x-form.icon-button :icon="'fa fa-edit '" class="btn-sm btn-info"
                                    wire:click='edit({{ $requisition }})' />

                                <x-form.icon-button :icon="'fa fa-trash '" class="btn-sm btn-danger"
                                    wire:confirm="Etes-vous sûre de supprimer ?"
                                    wire:click='delete({{ $requisition }})' />
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        {{ $productRequisitions->links('livewire::bootstrap') }}
    </div>
    @push('js')
        <script type="module">
            //Open  add new requisition model modal
            window.addEventListener('open-new-requisition-modal', e => {
                $('#new-requisition-modal').modal('show')
            });
        </script>
    @endpush
</div>
