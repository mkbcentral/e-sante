<div>
    @livewire('application.sheet.form.add-viatl-sign')
    @livewire('application.sheet.form.medical-prescription')
    @livewire('application.sheet.widget.consultation-request-detail')
    @livewire('application.sheet.form.edit-consultation-request-info')
    <div class="card mt-2">
        <div class="card-body">
            <div class="d-flex justify-content-between align-content-center">
                <div class="h5 text-secondary">
                    ({{ $request_number > 1
                        ? $request_number .
                            ' Factures                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       réalisées'
                        : $request_number . ' Facture réalisée' }})
                </div>
                <div class="d-flex align-items-center">
                    <div class=" w-100">
                        <x-form.input-search wire:model.live.debounce.500ms="q" />
                    </div>
                    <x-widget.list-french-month wire:model.live='month_name' :error="'month_name'" />
                </div>
                <div class="mr-4" style="margin-right: 40px">
                    <div class="btn-group">
                        <button type="button" class="btn btn-link dropdown-icon" data-toggle="dropdown"
                            aria-expanded="false">
                            <i class="fa fa-print" aria-hidden="true"></i>
                            Impression
                        </button>
                        <div class="dropdown-menu" role="menu" style="">
                            <a class="dropdown-item" target="_blank"
                                href="{{ route('consultation.request.month.all.print', [$selectedIndex, $month_name]) }}">
                                <i class="fa fa-file-pdf" aria-hidden="true"></i> Toute les factures
                            </a>
                            <a class="dropdown-item" target="_blank"
                                href="{{ route('consultation.request.lits.has_a_shipping_ticket', [$selectedIndex, $month_name]) }}">
                                <i class="fa fa-file-pdf" aria-hidden="true"></i> Liste sans bon
                            </a>
                            <a class="dropdown-item" target="_blank"
                                href="{{ route('list.invoices.month', [$selectedIndex, $month_name]) }}">
                                <i class="fa fa-file-excel" aria-hidden="true"></i> Relevé des factures
                            </a>
                        </div>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-link dropdown-icon" data-toggle="dropdown"
                            aria-expanded="false">
                            <i class="fas fa-cogs"></i>
                            Autes options
                        </button>
                        <div class="dropdown-menu" role="menu" style="">
                            <a class="dropdown-item" wire:confirm="Est-vous sur de réaliser l'opération" href="#"
                                wire:click='fixNumerotation'>
                                <i class="fas fa-list-ol"></i> Numéroter
                            </a>
                            <a class="dropdown-item" wire:confirm="Est-vous sur de réaliser l'opération" href="#"
                                wire:click='fixWithCurrentRate'>
                                <i class="fas fa-dollar-sign"></i> Fixer taux
                            </a>
                            <a class="dropdown-item" wire:confirm="Est-vous sur de réaliser l'opération" href="#"
                                wire:click='closeBilling'>
                                <i class="fa {{ $isClosing == true ? 'fa-times' : 'fa-check-double' }}"
                                    aria-hidden="true"></i>
                                {{ $isClosing == true ? 'Annuler clorture' : 'Cloturer' }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center pb-2">
                <x-widget.loading-circular-md />
            </div>
            @if ($listConsultationRequest->isEmpty())
                <x-errors.data-empty />
            @else
                <table class="table table-striped table-sm">
                    <thead class="bg-primary">
                        <tr>
                            <th>#</th>
                            <th class="text-center">
                                <x-form.button class="text-white"
                                    wire:click="sortSheet('consultation_requests.created_at')">Date
                                </x-form.button>
                                <x-form.sort-icon sortField="created_at" :sortAsc="$sortAsc" :sortBy="$sortBy" />
                            </th>
                            <th class="text-center">
                                <x-form.button class="text-white" wire:click="sortSheet('consultation_requests.id')">
                                    @if (Auth::user()->roles->pluck('request_number')->contains('Admin') ||
                                            Auth::user()->roles->pluck('name')->contains('Ag'))
                                        N° FACTURE
                                    @else
                                        N° FICHE
                                    @endif

                                </x-form.button>
                                <x-form.sort-icon sortField="request_number" :sortAsc="$sortAsc" :sortBy="$sortBy" />
                            </th>
                            <th>
                                <x-form.button class="text-white" wire:click="sortSheet('consultation_sheets.name')">NOM
                                    COMPLET</x-form.button>
                                <x-form.sort-icon sortField="name" :sortAsc="$sortAsc" :sortBy="$sortBy" />
                            </th>
                            <th class="text-center">GENGER</th>
                            <th class="text-center">AGE</th>
                            @if (Auth::user()->roles->pluck('name')->contains('Pharma') ||
                                    Auth::user()->roles->pluck('name')->contains('Ag') ||
                                    Auth::user()->roles->pluck('name')->contains('Admin'))
                                <th class="text-right">MONTANT</th>
                            @endif
                            <th class="text-center">SUSCRIPTION</th>
                            <th class="text-center">STATUS</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listConsultationRequest as $index => $consultationRequest)
                            <tr style="cursor: pointer;"
                                {{ $consultationRequest?->consultationSheet?->name == $consultationRequest[$index + 1]?->consultationSheet?->name ? 'bg-dark ' : '' }}>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="text-center"><a href="#"
                                        wire:click="openDetailConsultationModal({{ $consultationRequest }})">{{ $consultationRequest->created_at->format('d/m/Y h:i') }}</a>
                                </td>
                                @if (Auth::user()->roles->pluck('name')->contains('Pharma') ||
                                        Auth::user()->roles->pluck('name')->contains('Ag') ||
                                        Auth::user()->roles->pluck('name')->contains('Admin') ||
                                        Auth::user()->roles->pluck('name')->contains('Labo'))
                                    <td class="text-center">{{ $consultationRequest->getRequestNumberFormatted() }}/
                                        <span
                                            class="text-danger">{{ $consultationRequest->consultationSheet->source->name }}</span>
                                    </td>
                                @else
                                    <td class="text-center">{{ $consultationRequest->consultationSheet->number_sheet }}
                                    </td>
                                @endif
                                <td class="text-uppercase">
                                    <a href="#" class="text-decoration-underline"
                                        wire:click="openDetailConsultationModal({{ $consultationRequest }})">
                                        {{ $consultationRequest->consultationSheet->name }}</a>

                                </td>
                                <td class="text-center">{{ $consultationRequest->consultationSheet->gender }}</td>
                                <td class="text-center">{{ $consultationRequest->consultationSheet->getPatientAge() }}
                                </td>
                                @if (Auth::user()->roles->pluck('name')->contains('Pharma') ||
                                        Auth::user()->roles->pluck('name')->contains('Ag') ||
                                        Auth::user()->roles->pluck('name')->contains('Admin'))
                                    <td
                                        class="text-right {{ $consultationRequest->getTotalInvoiceCDF() == 28000 ? 'bg-danger' : '' }}">
                                        @if (Auth::user()->roles->pluck('name')->contains('Pharma'))
                                            {{ app_format_number(
                                                $currencyName == 'CDF' ? $consultationRequest->getTotalProductCDF() : $consultationRequest->getTotalProductUSD(),
                                                1,
                                            ) .
                                                ' ' .
                                                $currencyName }}
                                        @else
                                            {{ app_format_number(
                                                $currencyName == 'CDF' ? $consultationRequest->getTotalInvoiceCDF() : $consultationRequest->getTotalInvoiceUSD(),
                                                1,
                                            ) .
                                                ' ' .
                                                $currencyName }}
                                        @endif
                                    </td>
                                @endif
                                <td class="text-center text-bold text-uppercase">
                                    <a href="#" class="text-decoration-underline"
                                        wire:click="openDetailConsultationModal({{ $consultationRequest }})">
                                    </a>
                                    {{ $consultationRequest->subscription_name }}
                                </td>
                                <td
                                    class="text-center  {{ $consultationRequest->is_finished == true ? 'text-success  ' : 'text-danger ' }}">
                                    {{ $consultationRequest->is_finished == true ? 'Terminé' : 'En cours' }}
                                </td>
                                <td
                                    class="text-center {{ $consultationRequest->is_printed == true ? 'bg-success' : '' }}">
                                    @if ($consultationRequest->is_printed == true)
                                        Cloturé
                                        <x-navigation.link-icon
                                            href="{{ route('consultation.request.private.invoice', $consultationRequest->id) }}"
                                            :icon="'fa fa-print'" class="btn btn-sm   btn-secondary" />
                                    @else
                                     @if (Auth::user()->roles->pluck('name')->contains('Pharma'))
                                        <x-form.icon-button :icon="'fas fa-capsules'"
                                            wire:click="openPrescriptionMedicalModal({{ $consultationRequest }})"
                                            class="btn-primary btn-sm" />
                                    @elseif(Auth::user()->roles->pluck('name')->contains('Nurse'))
                                        <x-form.icon-button :icon="'fa fa-user-plus '"
                                            wire:click="openVitalSignForm({{ $consultationRequest }})"
                                            class="btn-sm btn-info " />
                                        <x-form.icon-button :icon="'fa fa-eye '"
                                            wire:click="openDetailConsultationModal({{ $consultationRequest }})"
                                            class="btn-sm btn-primary " />
                                        <x-navigation.link-icon
                                            href="{{ route('consultation.consult.patient', $consultationRequest->id) }}"
                                            wire:navigate :icon="'fas fa-notes-medical'" class="btn btn-sm  btn-success " />
                                    @elseif(Auth::user()->roles->pluck('name')->contains('Labo'))
                                        <x-navigation.link-icon
                                            href="{{ route('labo.subscriber', $consultationRequest) }}" wire:navigate
                                            :icon="'fa fa-microscope'" class="btn btn-sm  btn-secondary" />
                                    @else
                                        <x-form.icon-button :icon="'fa fa-pen '" data-toggle="modal"
                                            data-target="#edit-consultation-request"
                                            wire:click="edit({{ $consultationRequest }})" class="btn-sm btn-info " />
                                        <x-navigation.link-icon
                                            href="{{ route('consultation.consult.patient', $consultationRequest->id) }}"
                                            wire:navigate :icon="'fas fa-notes-medical'" class="btn btn-sm  btn-success " />
                                        <x-navigation.link-icon
                                            href="{{ route('consultation.request.private.invoice', $consultationRequest->id) }}"
                                            :icon="'fa fa-print'" class="btn btn-sm   btn-secondary" />
                                        <x-form.icon-button :icon="'fa fa-trash '" wire:confirm='Est-vous sur de supprimer'
                                            wire:click="delete({{ $consultationRequest }})"
                                            class="btn-sm btn-danger " />
                                    @endif
                                    @endif

                                </td>

                            </tr>
                        @endforeach

                    </tbody>
                </table>
                <div class="mt-4 d-flex justify-content-center align-items-center">
                    {{ $listConsultationRequest->links('livewire::bootstrap') }}</div>
            @endif
        </div>
    </div>
    @push('js')
        <script type="module">
            //Open edit sheet modal
            window.addEventListener('open-vital-sign-form', e => {
                $('#form-vital-sign').modal('show')
            });
            //Open medical prescription modal
            window.addEventListener('open-medical-prescription', e => {
                $('#form-medical-prescription').modal('show')
            });
            //Open detail consultation  modal
            window.addEventListener('open-details-consultation', e => {
                $('#consultation-detail').modal('show')
            });
            //Open edit consultation request modal
            window.addEventListener('open-edit-consultation-request', e => {
                console.log('ok');
                $('#edit-consultation-request').modal('show')
            });
        </script>
    @endpush
</div>
