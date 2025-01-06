<div>
    @livewire('application.sheet.form.add-viatl-sign')
    @livewire('application.sheet.form.medical-prescription')
    @livewire('application.sheet.widget.consultation-request-detail')
    @livewire('application.sheet.form.edit-consultation-request-info')
    <div class="card mt-2">
        <div class="card-body">
            <div class="d-flex justify-content-between align-content-center">
                <div class="d-flex">
                    <div class="h5 text-secondary mr-2">
                        ({{ $request_number > 1
                            ? $request_number .
                                ' Demandes                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       réalisées'
                            : $request_number . ' Demande réalisée' }})
                    </div>
                    <div class=" ">
                        <x-form.input-search wire:model.live.debounce.500ms="q" />
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <div class="form-group d-flex align-items-center mr-2">
                        <x-form.label value="{{ __('Mois') }}" class="mr-1" />
                        <x-widget.list-french-month wire:model.live='month_name' :error="'month_name'" />
                    </div>
                    <div class="form-group d-flex align-items-center mr-2">
                        <x-form.label value="{{ __('Année') }}" class="mr-1" />
                        <x-widget.list-years wire:model.live='year' :error="'year'" />
                    </div>
                </div>

                <div class="mr-4" style="margin-right: 40px">
                    <x-others.dropdown title="Impressions" icon="fa fa-print">

                        @if (Auth::user()->roles->pluck('name')->contains('ADMIN'))
                            <x-others.dropdown-link iconLink='fa fa-file-pdf' labelText='Toute les factures'
                                href="{{ route('consultation.request.month.all.print', [$selectedIndex, $month_name, $year]) }}"
                                target='_blank' />
                            <x-others.dropdown-link iconLink='fa fa-file-pdf' labelText='Relevé des factures'
                                href="{{ route('list.invoices.month', [$selectedIndex, $month_name, $year]) }}"
                                target='_blank' />
                        @elseif (Auth::user()->roles->pluck('name')->contains('LABO'))
                            <x-others.dropdown-link iconLink='fa fa-file-pdf' labelText='Rapport labo'
                                href="{{ route('list.labo.month', [$selectedIndex, $month_name]) }}" target='_blank' />
                        @elseif (Auth::user()->roles->pluck('name')->contains('RECEPTION'))
                            <x-others.dropdown-link iconLink='fa fa-file-pdf' labelText='Liste sans bon'
                                href="{{ route('consultation.request.lits.has_a_shipping_ticket', [$selectedIndex, $month_name]) }}"
                                target='_blank' />
                            <a class="dropdown-item" target="_blank"
                                href="{{ route('monthly.frequentation', [$month_name, $year]) }}">
                                <i class="fa fa-file-pdf" aria-hidden="true"></i> Rapport de frequentation
                            </a>
                        @else
                            <a class="dropdown-item" target="_blank"
                                href="{{ route('monthly.frequentation', [$month_name, $year]) }}">
                                <i class="fa fa-file-pdf" aria-hidden="true"></i> Rapport de frequentation
                            </a>
                        @endif
                    </x-others.dropdown>
                    @if (Auth::user()->roles->pluck('name')->contains('ADMIN'))
                        <x-others.dropdown title="Autes options" icon="fas fa-cogs">
                            <x-others.dropdown-link iconLink='fas fa-list-ol' labelText='Numéroter'
                                wire:confirm="Est-vous sur de réaliser l'opération" href="#"
                                wire:click='fixNumerotation' />
                            <x-others.dropdown-link iconLink='fas fa-dollar-sign' labelText='Fixer taux'
                                wire:confirm="Est-vous sur de réaliser l'opération" href="#"
                                wire:click='fixWithCurrentRate' />
                            <x-others.dropdown-link
                                iconLink="fa {{ $isClosing == true ? 'fa-times' : 'fa-check-double' }}"
                                labelText="{{ $isClosing == true ? 'Annuler clorture' : 'Cloturer' }}"
                                wire:confirm="Est-vous sur de réaliser l'opération" href="#"
                                wire:click='closeBilling' />
                        </x-others.dropdown>
                    @endif
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
                        <tr class="cursor-hand">
                            <th class="text-center">#</th>
                            <th class="text-center" wire:click="sortSheet('consultation_requests.created_at')">
                                <span>Date</span>
                                <x-form.sort-icon sortField="consultation_requests.created_at" :sortAsc="$sortAsc"
                                    :sortBy="$sortBy" />
                            </th>
                            <th class="text-center" wire:click="sortSheet('request_number')">
                                @can('finance-view')
                                    N° FACTURE
                                @else
                                    N° FICHE
                                @endcan
                                <x-form.sort-icon sortField="request_number" :sortAsc="$sortAsc" :sortBy="$sortBy" />
                            </th>
                            <th wire:click="sortSheet('consultation_sheets.name')">
                                <span>NOM COMPLET</span>
                                <x-form.sort-icon sortField="consultation_sheets.name" :sortAsc="$sortAsc"
                                    :sortBy="$sortBy" />
                            </th>
                            <th class="text-center">GENGER</th>
                            <th class="text-center">AGE</th>
                            @can('finance-view')
                                <th class="text-right">MONTANT</th>
                            @endcan
                            <th class="text-center">SUSCRIPTION</th>
                            <th class="text-center">STATUS</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listConsultationRequest as $index => $consultationRequest)
                            <tr style="cursor: pointer;"
                                {{ $consultationRequest?->consultationSheet?->name == $consultationRequest[$index + 1]?->consultationSheet?->name ? 'bg-dark ' : '' }}>
                                <td class="text-center">
                                    {{ $index + 1 }}</td>
                                <td class="text-center"><a href="#"
                                        wire:click="openDetailConsultationModal({{ $consultationRequest }})">{{ $consultationRequest->created_at->format('d/m/Y h:i') }}</a>
                                </td>
                                @can('finance-view')
                                    <td class="text-center">{{ $consultationRequest->getRequestNumberFormatted() }}/
                                        <span
                                            class="text-danger">{{ $consultationRequest->consultationSheet->source->name }}</span>
                                    </td>
                                @else
                                    <td class="text-center">{{ $consultationRequest->consultationSheet->number_sheet }}
                                    </td>
                                @endcan

                                <td class="text-uppercase">
                                    <a href="#" class="text-decoration-underline"
                                        wire:click="openDetailConsultationModal({{ $consultationRequest }})">
                                        {{ $consultationRequest->consultationSheet->name }}</a>

                                </td>
                                <td class="text-center">{{ $consultationRequest->consultationSheet->gender }}</td>
                                <td class="text-center">{{ $consultationRequest->consultationSheet->getPatientAge() }}
                                </td>
                                @can('finance-view')
                                    <td class="text-right {{ $consultationRequest->getBgStatus() }}">
                                        @if (Auth::user()->roles->pluck('name')->contains('PHARMA'))
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
                                @endcan
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
                                        @if (Auth::user()->roles->pluck('name')->contains('PHARMA'))
                                            <x-form.icon-button :icon="'fas fa-capsules'"
                                                wire:click="openPrescriptionMedicalModal({{ $consultationRequest }})"
                                                class="btn-primary btn-sm" />
                                        @elseif(Auth::user()->roles->pluck('name')->contains('NURSE'))
                                            <x-form.icon-button :icon="'fa fa-user-plus '"
                                                wire:click="openVitalSignForm({{ $consultationRequest }})"
                                                class="btn-sm btn-info " />
                                            <x-form.icon-button :icon="'fa fa-eye '"
                                                wire:click="openDetailConsultationModal({{ $consultationRequest }})"
                                                class="btn-sm btn-primary " />
                                            <x-navigation.link-icon
                                                href="{{ route('consultation.consult.patient', $consultationRequest->id) }}"
                                                wire:navigate :icon="'fas fa-notes-medical'" class="btn btn-sm  btn-success " />
                                        @elseif(Auth::user()->roles->pluck('name')->contains('LABO'))
                                            <x-navigation.link-icon
                                                href="{{ route('labo.subscriber', $consultationRequest) }}"
                                                wire:navigate :icon="'fa fa-microscope'" class="btn btn-sm  btn-secondary" />
                                        @elseif(Auth::user()->roles->pluck('name')->contains('DOCTOR'))
                                            <x-navigation.link-icon
                                                href="{{ route('dr.consultation.consult.patient', $consultationRequest->id) }}"
                                                wire:navigate :icon="'fas fa-stethoscope'" class="btn btn-sm  btn-success " />
                                            <x-navigation.link-icon
                                                href="{{ route('patient.folder', $consultationRequest->consultationSheet->id) }}"
                                                wire:navigate :icon="'fa fa-folder-open'" class="btn-sm btn-warning" />
                                        @else
                                            <x-form.icon-button :icon="'fa fa-pen '" data-toggle="modal"
                                                data-target="#edit-consultation-request"
                                                wire:click="edit({{ $consultationRequest }})"
                                                class="btn-sm btn-info " />
                                            <x-navigation.link-icon
                                                href="{{ route('consultation.consult.patient', $consultationRequest->id) }}"
                                                wire:navigate :icon="'fas fa-notes-medical'" class="btn btn-sm  btn-success " />
                                            <x-navigation.link-icon
                                                href="{{ route('consultation.request.private.invoice', $consultationRequest->id) }}"
                                                :icon="'fa fa-print'" class="btn btn-sm   btn-secondary" />
                                            <x-form.icon-button :icon="'fa fa-trash '"
                                                wire:confirm='Est-vous sur de supprimer'
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
