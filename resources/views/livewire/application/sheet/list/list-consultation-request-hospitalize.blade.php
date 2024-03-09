<div>
    @livewire('application.sheet.form.add-viatl-sign')
    @livewire('application.sheet.form.medical-prescription')
    @livewire('application.sheet.widget.consultation-request-detail')
    @livewire('application.sheet.form.edit-consultation-request-info')
    @livewire('application.sheet.form.edit-consultation-request-currency')
    <div class="card card-primary card-outline ">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mt-2">
                <div class="d-flex  align-items-center">
                    <div class="mr-2 w-100">
                        <x-form.input-search wire:model.live.debounce.500ms="q" />
                    </div>
                    <x-widget.list-fr-months wire:model.live='month_name' :error="'month_name'" />
                </div>
                @if (Auth::user()->roles->pluck('name')->contains('Pharma') ||
                        Auth::user()->roles->pluck('name')->contains('Ag') ||
                        Auth::user()->roles->pluck('name')->contains('Admin') ||
                        Auth::user()->roles->pluck('name')->contains('Caisse'))
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
                            <th class="text-center">
                                <x-form.button class="text-white" wire:click="sortSheet('created_at')">Date
                                </x-form.button>
                                <x-form.sort-icon sortField="created_at" :sortAsc="$sortAsc" :sortBy="$sortBy" />
                            </th>
                            <th class="text-center">
                                <x-form.button class="text-white" wire:click="sortSheet('request_number')">
                                    @if (Auth::user()->roles->pluck('name')->contains('Admin') ||
                                            Auth::user()->roles->pluck('name')->contains('Ag') ||
                                            Auth::user()->roles->pluck('name')->contains('Caisse'))
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
                                    Auth::user()->roles->pluck('name')->contains('Admin') ||
                                    Auth::user()->roles->pluck('name')->contains('Caisse'))
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
                            @if ($consultationRequest->paid_at != null && $consultationRequest->paid_at ==date('Y-m-d') )
                                class="bg-warning"
                                data-toggle="tooltip" data-placement="top" title="Facture soldée ajoud'hui"
                            @endif
                            >
                                <td class="text-center">
                                    @if ($consultationRequest->is_finished == true)
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-link dropdown-icon"
                                                data-toggle="dropdown" aria-expanded="false">
                                                @if ($consultationRequest->paid_at == true || $consultationRequest->consultationRequestCurrency)
                                                    <i class="fa fa-check text-success" aria-hidden="true"></i>
                                                @else
                                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                @endif
                                            </button>
                                            <div class="dropdown-menu" role="menu" style="">
                                                @if ($consultationRequest->paid_at == false)
                                                    <a class="dropdown-item" href="#"
                                                        wire:confirm="Etes-vous de réaliser l'operation?"
                                                        wire:click='addToBordereau({{ $consultationRequest }})'>
                                                        <i class="fa fa-arrow-right" aria-hidden="true"></i> Ajouter au
                                                        borderau
                                                    </a>
                                                @else
                                                    @if ($consultationRequest->paid_at == true && $consultationRequest->consultationRequestCurrency)
                                                        <a class="dropdown-item text-danger text-bold" href="#"
                                                            wire:click='deleteToBordereau({{ $consultationRequest }})'>
                                                            <i class="fa fa-times-circle" aria-hidden="true"></i>
                                                            Rétirer au
                                                            borderau
                                                        </a>
                                                    @else
                                                        <a class="dropdown-item text-primary text-bold" href="#"
                                                            wire:confirm="Etes-vous de réaliser l'operation?"
                                                            wire:click='showEditCurrency({{ $consultationRequest }})'>
                                                            <i class="fa fa-dollar-sign" aria-hidden="true"></i> Changer
                                                            la
                                                            dévise
                                                        </a>
                                                    @endif
                                            </div>
                                        </div>
                                    @endif
                        @endif
                        </td>
                        <td class="text-center">{{ $consultationRequest->created_at->format('d/m/Y h:i') }}</td>
                        @if (Auth::user()->roles->pluck('name')->contains('Pharma') ||
                                Auth::user()->roles->pluck('name')->contains('Ag') ||
                                Auth::user()->roles->pluck('name')->contains('Admin') ||
                                Auth::user()->roles->pluck('name')->contains('Caisse'))
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
                                Auth::user()->roles->pluck('name')->contains('Admin') ||
                                Auth::user()->roles->pluck('name')->contains('Caisse'))
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
                            class="text-center  {{ $consultationRequest->is_finished == true ? 'bg-success  ' : 'text-danger ' }}">
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
                            @elseif(Auth::user()->roles->pluck('name')->contains('Labo'))
                                <x-navigation.link-icon href="{{ route('labo.subscriber', $consultationRequest) }}"
                                    wire:navigate :icon="'fa fa-microscope'" class="btn btn-sm  btn-secondary" />
                            @elseif(Auth::user()->roles->pluck('name')->contains('Caisse') || Auth::user()->roles->pluck('name')->contains('Admin'))
                                @if ($consultationRequest->is_finished == true)
                                    <x-navigation.link-icon
                                        href="{{ route('consultation.request.private.invoice', $consultationRequest->id) }}"
                                        :icon="'fa fa-print'" class="btn btn-sm   btn-secondary" />
                                @endif
                            @else
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
        </script>
    @endpush
</div>
