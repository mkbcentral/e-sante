<div wire:poll.15s>
    @livewire('application.product.requisition.form.new-product-requisition')
    <x-navigation.bread-crumb icon='fa fa-capsules' label='REQUISITION DES  MEDICAMENTS' color="text-success">
        <x-navigation.bread-crumb-item label='Dashboard' link='dashboard' isLinked=true />
        <x-navigation.bread-crumb-item label='Appro médicaments' />
    </x-navigation.bread-crumb>
    <x-content.main-content-page>
        <div class="card card-olive">
            <div class="card-header d-flex justify-content-between">
                <span> <i class="fa fa-list" aria-hidden="true"></i> LISTTE DES REQUISITIONS</span>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <x-form.button :icon="'fa fa-user-plus'" type="button" class="btn-success" wire:click='openAddModal'>
                            <i class="fa fa-plus-circle" aria-hidden="true"></i> Nouvelle demande
                        </x-form.button>
                        @if (Auth::user()->roles->pluck('name')->contains('Depot-Pharma'))
                            <x-form.button type="button" class="btn-primary" wire:click='refreshList'>
                                <i class="fa fa-sync" aria-hidden="true  "></i> Actualiser
                            </x-form.button>
                        @endif

                    </div>
                    <x-widget.loading-circular-md />
                    <div class="d-flex justify-content-between align-items-center">
                        @if (Auth::user()->roles->pluck('name')->contains('Depot-Pharma'))
                            <div class="form-group mt-1 d-flex align-items-center">
                                <x-form.label value="{{ __('Service') }}" class="mr-1" />
                                <x-widget.list-agent-service-widget wire:model.live='agent_service_id'
                                    :error="'agent_service_id'" />
                            </div>
                        @endif
                        <div class="form-group mt-1 d-flex align-items-center">
                            <x-form.label value="{{ __('Mois') }}" class="mr-1" wire:model.live='month' />
                            <x-widget.list-fr-months wire:model.live='month' :error="'month'" />
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-sm mt-0">
                    <thead class="bg-olive">
                        <tr>
                            <th class="text-center">#</th>
                            <th>DATE</th>
                            <th>CODE</th>
                            <th class="text-center">PRODUCTS</th>
                            <th class="text-center">SERVICE</th>
                            <th class="text-center">STATUS</th>
                            <th class="text-center">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($productRequisitions->isEmpty())
                            <tr>
                                <td colspan="7" class="text-center"> <x-errors.data-empty /></td>
                            </tr>
                        @else
                            @foreach ($productRequisitions as $index => $requisition)
                                <tr wire:key='{{ $requisition->id }}'>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $requisition->created_at->format('d/m/Y à H:i:s') }}</td>
                                    <td class="text-center">{{ $requisition->number }}</td>
                                    <td class="text-center">{{ $requisition->productRequistionProducts->count() }}
                                    </td>
                                    <td class="text-center">{{ $requisition->agentService->name }}</td>
                                    <td class="text-center {{ $requisition->is_valided ? 'text-success ' : '' }}">
                                        {{ $requisition->is_valided ? 'Livré' : 'En cours' }}</td>
                                    <td class="text-center">
                                        @if ($requisition->is_valided)
                                            @if (Auth::user()->roles->pluck('name')->contains('Depot-Pharma'))
                                                <x-form.button
                                                    class=" {{ $requisition->is_valided ? 'btn-warning  ' : 'btn-secondary  ' }} btn-sm"
                                                    type='button' wire:click='changeStatus({{ $requisition }})'
                                                    wire:confirm="Etes-vous sûre de cette action ?">
                                                    <i
                                                        class="{{ $requisition->is_valided ? 'fa fa-times ' : 'fa fa-check' }}"></i>
                                                </x-form.button>
                                            @endif
                                        @else
                                            @if (Auth::user()->roles->pluck('name')->contains('Depot-Pharma'))
                                                <x-navigation.link-icon class="btn btn-sm btn-primary"
                                                    href="{{ route('product.requisition', $requisition) }}"
                                                    wire:navigate :icon="'fa fa-eye'" />
                                            @else
                                                <x-navigation.link-icon class="btn btn-sm btn-primary"
                                                    href="{{ route('product.requisition', $requisition) }}"
                                                    wire:navigate :icon="'fa fa-plus-circle'" />
                                            @endif

                                            <x-form.icon-button :icon="' fa fa-edit '" class="btn-sm btn-info"
                                                wire:click='edit({{ $requisition }})' />
                                            <x-form.icon-button :icon="'fa fa-trash '" class="btn-sm btn-danger"
                                                wire:confirm="Etes-vous sûre de supprimer ?"
                                                wire:click='delete({{ $requisition }})' />
                                            @if (Auth::user()->roles->pluck('name')->contains('Depot-Pharma'))
                                                <x-form.button
                                                    class=" {{ $requisition->is_valided ? 'btn-warning  ' : 'btn-secondary  ' }} btn-sm"
                                                    type='button' wire:click='changeStatus({{ $requisition }})'
                                                    wire:confirm="Etes-vous sûre de cette action ?">
                                                    <i
                                                        class="{{ $requisition->is_valided ? 'fa fa-times ' : 'fa fa-check' }}"></i>
                                                </x-form.button>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                {{ $productRequisitions->links('livewire::bootstrap') }}
            </div>
        </div>
    </x-content.main-content-page>
    @push('js')
        <script type="module">
            //Open  add new requisition model modal
            window.addEventListener('open-new-requisition-modal', e => {
                $('#new-requisition-modal').modal('show')
            });
        </script>
    @endpush
</div>
