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
                    <x-widget.list-fr-months wire:model.live='month_name' :error="'month_name'" />
                </div>
                @if (Auth::user()->roles->pluck('name')->contains('Pharma') ||
                        Auth::user()->roles->pluck('name')->contains('Ag') ||
                        Auth::user()->roles->pluck('name')->contains('Admin'))
                    <div class="bg-navy p-1 rounded-lg pr-2">
                        <h3 wire:loading.class="d-none"><i class="fas fa-coins ml-2"></i>
                            @if (Auth::user()->roles->pluck('name')->contains('Pharma'))
                                <span class="money_format">CDF:
                                    {{ app_format_number($total_product_amount_cdf, 1) }}</span>
                                |
                                <span class="money_format">USD:
                                    {{ app_format_number($total_product_amount_usd, 1) }}</span>
                            @else
                                <span class="money_format">CDF: {{ app_format_number($total_cdf, 1) }}</span> |
                                <span class="money_format">USD: {{ app_format_number($total_usd, 1) }}</span>
                            @endif
                        </h3>
                    </div>
                @endif
            </div>
            @if ($listConsultationRequest->isEmpty())
                <x-errors.data-empty />
            @else
                <div class="d-flex justify-content-between align-content-center mt-2">
                    <div class="h5 text-secondary">
                        ({{ $request_number > 1
                            ? $request_number .
                                ' Factures
                                                                                                                                                                                                                                                                                                                                                                                            réalisées'
                            : $request_number . ' Facture réalisée' }})
                    </div>

                    <div class="ml-2">
                        <button wire:click='fixNumerotation' class="btn btn-primary btn-sm" type="button">
                            <div wire:loading wire:target='fixNumerotation'
                                class="spinner-border spinner-border-sm text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            Numérotation
                        </button>
                        <a class="btn  btn-info btn-sm" target="_blank"
                            href="{{ route('consultation.request.month.all.print', [$selectedIndex, $month_name]) }}"><i
                                class="fa fa-file-pdf" aria-hidden="true"></i> Mes factures</a>
                    </div>
                </div>
                <div class="d-flex justify-content-center pb-2">
                    <x-widget.loading-circular-md />
                </div>
                <table class="table table-striped table-sm">
                    <thead class="bg-primary">
                        <tr>
                            <th>#</th>
                            <th class="text-center">
                                <x-form.button class="text-white" wire:click="sortSheet('created_at')">Date
                                </x-form.button>
                                <x-form.sort-icon sortField="created_at" :sortAsc="$sortAsc" :sortBy="$sortBy" />
                            </th>
                            <th class="text-center">
                                <x-form.button class="text-white" wire:click="sortSheet('request_number')">
                                    @if (Auth::user()->roles->pluck('name')->contains('Admin') || Auth::user()->roles->pluck('name')->contains('Ag'))
                                        N° FACTURE
                                    @else
                                        N° FICHE
                                    @endif

                                </x-form.button>
                                <x-form.sort-icon sortField="request_number" :sortAsc="$sortAsc" :sortBy="$sortBy" />
                            </th>
                            <th>
                                <x-form.button class="text-white" wire:click="sortSheet('name')">NOM
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
                            <tr style="cursor: pointer;">
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="text-center">{{ $consultationRequest->created_at->format('d/m/Y h:i') }}</td>
                                @if (Auth::user()->roles->pluck('name')->contains('Pharma') ||
                                        Auth::user()->roles->pluck('name')->contains('Ag') ||
                                        Auth::user()->roles->pluck('name')->contains('Admin'))
                                    <td class="text-center">{{ $consultationRequest->getRequestNumberFormatted() }}</td>
                                @else
                                    <td class="text-center">{{ $consultationRequest->consultationSheet->number_sheet }}
                                    </td>
                                @endif
                                <td class="text-uppercase">{{ $consultationRequest->consultationSheet->name }}</td>
                                <td class="text-center">{{ $consultationRequest->consultationSheet->gender }}</td>
                                <td class="text-center">{{ $consultationRequest->consultationSheet->getPatientAge() }}
                                </td>
                                @if (Auth::user()->roles->pluck('name')->contains('Pharma') ||
                                        Auth::user()->roles->pluck('name')->contains('Ag') ||
                                        Auth::user()->roles->pluck('name')->contains('Admin'))
                                    <td class="text-right">
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
                                    {{ $consultationRequest->consultationSheet->subscription->name }}</td>
                                <td
                                    class="text-center  {{ $consultationRequest->is_finished == true ? 'text-success  ' : 'text-danger ' }}">
                                    {{ $consultationRequest->is_finished == true ? 'Terminé' : 'En cours' }}
                                </td>
                                <td class="text-center">
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
                                    @else
                                        <x-form.icon-button :icon="'fa fa-pen '" data-toggle="modal"
                                            data-target="#edit-consultation-request"
                                            wire:click="edit({{ $consultationRequest }})" class="btn-sm btn-info " />
                                        <x-navigation.link-icon
                                            href="{{ route('consultation.consult.patient', $consultationRequest->id) }}"
                                            wire:navigate :icon="'fas fa-notes-medical'" class="btn btn-sm  btn-success " />
                                        <x-navigation.link-icon
                                            href="{{ route('consultation.request.private.invoice', $consultationRequest->id) }}"
                                            wire:navigate :icon="'fa fa-print'" class="btn btn-sm  btn-secondary" />
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
