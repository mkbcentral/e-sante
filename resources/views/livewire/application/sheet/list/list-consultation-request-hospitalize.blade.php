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
                    <div class="h5 text-secondary mr-2">
                        ({{ $request_number > 1
                            ? $request_number .
                                ' Hospitalisations                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       réalisées'
                            : $request_number . ' Hospitalisation réalisée' }})
                    </div>
                    <div>
                        <x-form.input-search wire:model.live.debounce.500ms="q" />
                    </div>
                </div>
                @can('finance-view')
                    <div class="bg-navy p-1 rounded-lg pr-2">
                        <h3 wire:loading.class="d-none"><i class="fas fa-coins ml-2"></i>
                            <span class="money_format">CDF: {{ app_format_number($total_cdf, 1) }}</span> |
                            <span class="money_format">USD: {{ app_format_number($total_usd, 1) }}</span>

                        </h3>
                    </div>
                @elsecan('money-box-view')
                    <div class="bg-navy p-1 rounded-lg pr-2">
                        <h3 wire:loading.class="d-none"><i class="fas fa-coins ml-2"></i>
                            <span class="money_format">CDF: {{ app_format_number($total_cdf, 1) }}</span> |
                            <span class="money_format">USD: {{ app_format_number($total_usd, 1) }}</span>
                        </h3>
                    </div>
                @endcan
                @can('pharma-actions')
                    <div class="bg-navy p-1 rounded-lg pr-2">
                        <h3 wire:loading.class="d-none"><i class="fas fa-coins ml-2"></i>
                            <span class="money_format">CDF:
                                {{ app_format_number($total_product_amount_cdf, 1) }}</span>
                            |
                            <span class="money_format">USD:
                                {{ app_format_number($total_product_amount_usd, 1) }}</span>
                        </h3>
                    </div>
                @endcan
                <div class="d-flex align-items-center">
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
                            <th class="text-center"></th>
                            <th class="" wire:click="sortSheet('consultation_requests.created_at')">
                                <span>Date</span>
                                <x-form.sort-icon sortField="consultation_requests.created_at" :sortAsc="$sortAsc"
                                    :sortBy="$sortBy" />
                            </th>
                            <th class="text-center" wire:click="sortSheet('request_number')">
                                <span>
                                    @can('finance-view')
                                        N° FACTURE
                                    @elsecan('money-box-view')
                                        N° FACTURE
                                    @else
                                        N° FICHE
                                    @endcan

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
                            @can('finance-hospitalize')
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
                                @if ($consultationRequest->paid_at != null && $consultationRequest->paid_at == date('Y-m-d')) class="bg-warning"
                                data-toggle="tooltip" data-placement="top" title="Facture soldée ajoud'hui"
                                @elseif ($consultationRequest->is_paid == true) class="bg-pink" @endif>
                                <td class="text-start">
                                    @if ($consultationRequest->is_finished == true && Auth::user()->roles->pluck('name')->contains('MONEY_BOX'))
                                        <x-others.dropdown title=""
                                            icon="{{ $consultationRequest->is_paid == true ? 'fa fa-check text-success' : 'fa fa-ellipsis-v' }}">
                                            @if ($consultationRequest->paid_at == null)
                                                <x-others.dropdown-link iconLink='fa fa-plus-circle'
                                                    labelText='Ajouter auborderau' href="#"
                                                    wire:confirm="Etes-vous de réaliser l'operation?"
                                                    class="text-primary"
                                                    wire:click='addToBordereau({{ $consultationRequest }})' />
                                            @elseif(Auth::user()->roles->pluck('name')->contains('Doctor'))
                                                <x-navigation.link-icon
                                                    href="{{ route('dr.consultation.consult.patient', $consultationRequest->id) }}"
                                                    wire:navigate :icon="'fas fa-stethoscope'" class="btn btn-sm  btn-success " />
                                                <x-navigation.link-icon
                                                    href="{{ route('patient.folder', $consultationRequest->consultationSheet->id) }}"
                                                    wire:navigate :icon="'fa fa-folder-open'" class="btn-sm btn-warning" />
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
                                @can('finance-view')
                                    <td class="text-center">{{ $consultationRequest->getRequestNumberFormatted() }}
                                    </td>
                                @else
                                    <td class="text-center">{{ $consultationRequest->consultationSheet->number_sheet }}
                                    </td>
                                @endcan
                                <td class="text-uppercase">{{ $consultationRequest->consultationSheet->name }}</td>
                                <td class="text-center">{{ $consultationRequest->consultationSheet->gender }}</td>
                                <td class="text-center">{{ $consultationRequest->consultationSheet->getPatientAge() }}
                                </td>
                                <td class="text-right">
                                    @can('finance-view')
                                        {{ app_format_number(
                                            $currencyName == 'CDF' ? $consultationRequest->getTotalProductCDF() : $consultationRequest->getTotalProductUSD(),
                                            1,
                                        ) .
                                            ' ' .
                                            $currencyName }}
                                    @elsecan('pharma-actions')
                                        {{ app_format_number(
                                            $currencyName == 'CDF' ? $consultationRequest->getTotalInvoiceCDF() : $consultationRequest->getTotalInvoiceUSD(),
                                            1,
                                        ) .
                                            ' ' .
                                            $currencyName }}
                                    @elsecan('money-box-view')
                                        {{ app_format_number(
                                            $currencyName == 'CDF' ? $consultationRequest->getTotalInvoiceCDF() : $consultationRequest->getTotalInvoiceUSD(),
                                            1,
                                        ) .
                                            ' ' .
                                            $currencyName }}
                                    @endcan
                                </td>

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
                                        @can('pharma-actions')
                                            <x-form.icon-button :icon="'fas fa-capsules'"
                                                wire:click="openPrescriptionMedicalModal({{ $consultationRequest }})"
                                                class="btn-primary btn-sm" />
                                        @elsecan('nurse-actions')
                                            <x-form.icon-button :icon="'fa fa-user-plus '"
                                                wire:click="openVitalSignForm({{ $consultationRequest }})"
                                                class="btn-sm btn-info " />
                                            <x-form.icon-button :icon="'fa fa-eye '"
                                                wire:click="openDetailConsultationModal({{ $consultationRequest }})"
                                                class="btn-sm btn-primary " />
                                            <x-navigation.link-icon
                                                href="{{ route('consultation.consult.patient', $consultationRequest->id) }}"
                                                wire:navigate :icon="'fas fa-notes-medical'" class="btn btn-sm  btn-success " />
                                        @elsecan('labo-actions')
                                            <x-navigation.link-icon
                                                href="{{ route('labo.subscriber', $consultationRequest) }}" wire:navigate
                                                :icon="'fa fa-microscope'" class="btn btn-sm  btn-secondary" />
                                        @elsecan('money-box-view')
                                            @if ($consultationRequest->is_finished == true)
                                                <x-navigation.link-icon
                                                    href="{{ route('consultation.request.private.invoice', $consultationRequest->id) }}"
                                                    :icon="'fa fa-print'" class="btn btn-sm   btn-secondary" />
                                            @endif
                                        @endcan
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
