<div>
    @livewire('application.sheet.form.add-viatl-sign')
    @livewire('application.sheet.form.medical-prescription')
    @livewire('application.sheet.widget.consultation-request-detail')
    @livewire('application.sheet.form.edit-consultation-request-info')
    <div class="card mt-2">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mt-2">
                <div class="d-flex align-items-center">
                    <div class="mr-2 w-100">
                        <x-form.input-search wire:model.live.debounce.500ms="q" />
                    </div>
                    <div class="mr-2">
                        <x-form.input type='date' wire:model.live='start_date' :error="'start_date'" />
                    </div>
                    <div class="mr-2">
                        <x-form.input type='date' wire:model.live='end_date' :error="'end_date'" />
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center pb-2">
                <x-widget.loading-circular-md />
            </div>
            @if ($listConsultationRequest->isEmpty())
                <x-errors.data-empty />
            @else
                <div class="d-flex justify-content-between align-content-center ">
                    <div class="h5 text-secondary">
                        ({{ $request_number > 1 ? $request_number . ' Factures réalisées' : $request_number . ' Facture réalisée' }})
                    </div>

                    <div class="ml-2">
                        <a class="btn  btn-info btn-sm" target="_blank"
                            href="{{ route('consultation.request.period.print', [$selectedIndex, $start_date, $end_date]) }}"><i
                                class="fa fa-file-pdf" aria-hidden="true"></i> Mes factures</a>
                    </div>
                </div>
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
                                @if (Auth::user()->roles->pluck('name')->contains('ADMIN') || Auth::user()->roles->pluck('name')->contains('AG'))
                                    N° FACTURE
                                @else
                                    N° FICHE
                                @endif
                                <x-form.sort-icon sortField="request_number" :sortAsc="$sortAsc" :sortBy="$sortBy" />
                            </th>
                            <th wire:click="sortSheet('consultation_sheets.name')">
                                <span>NOM COMPLET</span>
                                <x-form.sort-icon sortField="consultation_sheets.name" :sortAsc="$sortAsc"
                                    :sortBy="$sortBy" />
                            </th>
                            <th class="text-center">GENGER</th>
                            <th class="text-center">AGE</th>
                            @if (Auth::user()->roles->pluck('name')->contains('PHARMA') ||
                                    Auth::user()->roles->pluck('name')->contains('AG') ||
                                    Auth::user()->roles->pluck('name')->contains('ADMIN'))
                                <th class="text-right">MONTANT</th>
                            @endif
                            <th class="text-center">SUSCRIPTION</th>
                            <th class="text-center">STATUS</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listConsultationRequest as $index => $consultationRequest)
                            <tr style="cursor: pointer;">
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="text-center">{{ $consultationRequest->created_at->format('d/m/Y h:i') }}</td>
                                @if (Auth::user()->roles->pluck('name')->contains('PHARMA') ||
                                        Auth::user()->roles->pluck('name')->contains('AG') ||
                                        Auth::user()->roles->pluck('name')->contains('ADMIN'))
                                    <td class="text-center">{{ $consultationRequest->getRequestNumberFormatted() }}</td>
                                @else
                                    <td class="text-center">{{ $consultationRequest->consultationSheet->number_sheet }}
                                    </td>
                                @endif
                                <td class="text-uppercase">{{ $consultationRequest->consultationSheet->name }}</td>
                                <td class="text-center">{{ $consultationRequest->consultationSheet->gender }}</td>
                                <td class="text-center">{{ $consultationRequest->consultationSheet->getPatientAge() }}

                                </td>
                                @if (Auth::user()->roles->pluck('name')->contains('PHARMA') ||
                                        Auth::user()->roles->pluck('name')->contains('AG') ||
                                        Auth::user()->roles->pluck('name')->contains('ADMIN'))
                                    <td class="text-right">
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
                                @endif
                                <td class="text-center text-bold text-uppercase">
                                    {{ $consultationRequest->consultationSheet->subscription->name }}</td>
                                <td
                                    class="text-center  {{ $consultationRequest->is_finished == true ? 'text-success  ' : 'text-danger ' }}">
                                    {{ $consultationRequest->is_finished == true ? 'Terminé' : 'En cours' }}
                                </td>
                                <td
                                    class="text-center {{ $consultationRequest->is_printed == true ? 'bg-success' : '' }}"">
                                    @if ($consultationRequest->is_printed == true)
                                        Cloturé
                                    @else
                                        @if (Auth::user()->roles->pluck('name')->contains('PHARMA'))
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
                                        @elseif(Auth::user()->roles->pluck('name')->contains('LABO'))
                                            <x-navigation.link-icon
                                                href="{{ route('labo.subscriber', $consultationRequest) }}"
                                                wire:navigate :icon="'fa fa-microscope'" class="btn btn-sm  btn-secondary" />
                                        @elseif(Auth::user()->roles->pluck('name')->contains('Doctor'))
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
                                            <x-form.icon-button :icon="'fa fa-eye '"
                                                wire:click="openDetailConsultationModal({{ $consultationRequest }})"
                                                class="btn-sm btn-primary " />
                                            <x-navigation.link-icon
                                                href="{{ route('consultation.consult.patient', $consultationRequest->id) }}"
                                                wire:navigate :icon="'fas fa-notes-medical'" class="btn btn-sm  btn-success " />
                                            <x-navigation.link-icon
                                                href="{{ route('consultation.request.private.invoice', $consultationRequest->id) }}"
                                                wire:navigate :icon="'fa fa-print'" class="btn btn-sm  btn-secondary" />
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
        </script>
    @endpush
</div>
