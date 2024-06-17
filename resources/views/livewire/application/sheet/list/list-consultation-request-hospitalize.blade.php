<div>
    @livewire('application.sheet.form.add-viatl-sign')
    @livewire('application.sheet.form.medical-prescription')
    @livewire('application.sheet.widget.consultation-request-detail')
    @livewire('application.sheet.form.edit-consultation-request-info')
    @livewire('application.sheet.form.edit-consultation-request-currency')
    @livewire('application.finance.make-caution')
    <div class="card card-primary card-outline ">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mt-2">
                <div class="d-flex  align-items-center">
                    <div class="mr-2 w-100">
                        <x-form.input-search wire:model.live.debounce.500ms="q" />
                    </div>
                    <x-widget.list-french-month wire:model.live='month_name' :error="'month_name'" />
                </div>
                @if (Auth::user()->roles->pluck('name')->contains('Pharma') ||
                        Auth::user()->roles->pluck('name')->contains('Ag') ||
                        Auth::user()->roles->pluck('name')->contains('Admin') ||
                        Auth::user()->roles->pluck('name')->contains('Caisse') ||
                        Auth::user()->roles->pluck('name')->contains('Finance'))
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
            <div class="d-flex justify-content-center pb-2">
                <x-widget.loading-circular-md />
            </div>
            @if ($listConsultationRequest->isEmpty())
                <x-errors.data-empty />
            @else
                <table class="table table-striped table-sm">
                    <thead class="bg-primary">
                        <tr>
                            <th class="text-center"></th>
                            <th class="" wire:click="sortSheet('consultation_requests.created_at')">
                                <span>Date</span>
                                <x-form.sort-icon sortField="consultation_requests.created_at" :sortAsc="$sortAsc"
                                    :sortBy="$sortBy" />
                            </th>
                            <th class="text-center" wire:click="sortSheet('request_number')">
                                <span>
                                    @if (Auth::user()->roles->pluck('name')->contains('Admin') ||
                                            Auth::user()->roles->pluck('name')->contains('Ag') ||
                                            Auth::user()->roles->pluck('name')->contains('Caisse') ||
                                            Auth::user()->roles->pluck('name')->contains('Finance'))
                                        N° FACTURE
                                    @else
                                        N° FICHE
                                    @endif
                                </span>
                                <x-form.sort-icon sortField="request_number" :sortAsc="$sortAsc" :sortBy="$sortBy" />
                            </th>
                            <th wire:click="sortSheet('consultation_sheets.name')">
                                <span>NOM COMPLET</span>
                                <x-form.sort-icon sortField="consultation_sheets.name" :sortAsc="$sortAsc"
                                    :sortBy="$sortBy" />
                            </th>
                            <th class="text-center">GENGER</th>
                            <th class="text-center">AGE</th>
                            @if (Auth::user()->roles->pluck('name')->contains('Pharma') ||
                                    Auth::user()->roles->pluck('name')->contains('Ag') ||
                                    Auth::user()->roles->pluck('name')->contains('Admin') ||
                                    Auth::user()->roles->pluck('name')->contains('Caisse') ||
                                    Auth::user()->roles->pluck('name')->contains('Finance'))
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
                                @if ($consultationRequest->paid_at != null && $consultationRequest->paid_at == date('Y-m-d')) class="bg-warning"
                                data-toggle="tooltip" data-placement="top" title="Facture soldée ajoud'hui"
                                @elseif ($consultationRequest->is_paid == true) class="bg-pink" @endif>
                                <td class="text-start">
                                    @if ($consultationRequest->is_finished == true && Auth::user()->roles->pluck('name')->contains('Caisse'))
                                        <x-others.dropdown title=""
                                            icon="{{ $consultationRequest->is_paid == true ? 'fa fa-check text-success' : 'fa fa-ellipsis-v' }}">
                                            @if ($consultationRequest->paid_at == null)
                                                <x-others.dropdown-link iconLink='fa fa-plus-circle'
                                                    labelText='Ajouter auborderau' href="#"
                                                    wire:confirm="Etes-vous de réaliser l'operation?"
                                                    class="text-primary"
                                                    wire:click='addToBordereau({{ $consultationRequest }})' />
                                            @else
                                                <x-others.dropdown-link iconLink='fa fa-times'
                                                    labelText='Retirer au borderau' href="#" class="text-danger"
                                                    wire:confirm="Etes-vous de réaliser l'operation?"
                                                    wire:click='deleteToBordereau({{ $consultationRequest }})' />
                                                <x-others.dropdown-link iconLink='fa fa-dollar-sign'
                                                    labelText='Changer ladévise' href="#"
                                                    wire:confirm="Etes-vous de réaliser l'operation?"
                                                    wire:click='showEditCurrency({{ $consultationRequest }})' />
                                            @endif
                                            <x-others.dropdown-link iconLink='fa fa-plus-square'
                                                labelText=' Passer caution' href="#"
                                                wire:click='openCautionModal({{ $consultationRequest }})' />
                                        </x-others.dropdown>
                                    @endif
                                </td>

                                <td class="text-start">{{ $consultationRequest->created_at->format('d/m/Y h:i') }}</td>
                                @if (Auth::user()->roles->pluck('name')->contains('Pharma') ||
                                        Auth::user()->roles->pluck('name')->contains('Ag') ||
                                        Auth::user()->roles->pluck('name')->contains('Admin') ||
                                        Auth::user()->roles->pluck('name')->contains('Caisse') ||
                                        Auth::user()->roles->pluck('name')->contains('Finance'))
                                    <td class="text-center">{{ $consultationRequest->getRequestNumberFormatted() }}
                                    </td>
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
                                        Auth::user()->roles->pluck('name')->contains('Admin') ||
                                        Auth::user()->roles->pluck('name')->contains('Caisse') ||
                                        Auth::user()->roles->pluck('name')->contains('Finance'))
                                    <td class="text-right text-bold">
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
                                    class="text-center  {{ $consultationRequest->is_finished == true ? 'bg-success  ' : 'text-danger ' }}">
                                    {{ $consultationRequest->is_finished == true ? 'Terminé' : 'En cours' }}
                                </td>
                                <td
                                    class="text-center {{ $consultationRequest->is_printed == true ? 'bg-success' : '' }}"">
                                    @if ($consultationRequest->is_printed == true)
                                        Cloturé
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
                                                href="{{ route('labo.subscriber', $consultationRequest) }}"
                                                wire:navigate :icon="'fa fa-microscope'" class="btn btn-sm  btn-secondary" />
                                        @elseif(Auth::user()->roles->pluck('name')->contains('Caisse') || Auth::user()->roles->pluck('name')->contains('Admin'))
                                            @if ($consultationRequest->is_finished == true)
                                                <x-navigation.link-icon
                                                    href="{{ route('consultation.request.private.invoice', $consultationRequest->id) }}"
                                                    :icon="'fa fa-print'" class="btn btn-sm   btn-secondary" />
                                            @endif
                                        @else
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
            window.addEventListener('open-consultation-detail', e => {
                $('#consultation-detail').modal('show')
            });
            //Open detail consultation  modal
            window.addEventListener('open-edit-consultation-request-currency', e => {
                $('#edit-consultation-request-currency').modal('show')
            });
            //Open detail consultation  modal
            window.addEventListener('open-form-caution', e => {
                $('#form-caution').modal('show')
            });
        </script>
    @endpush
</div>
