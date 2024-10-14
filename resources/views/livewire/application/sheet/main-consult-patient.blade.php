<div>
    @livewire('application.sheet.widget.consultation-request-detail')
    @livewire('application.sheet.form.medical-prescription')
    @livewire('application.sheet.form.new-consultation-request-nursing')
    <x-navigation.bread-crumb icon='fas fa-notes-medical' label="CONSULTATION DU PATIENT">
        <x-navigation.bread-crumb-item label='Dashboard' link='dashboard' isLinked=true />
        <x-navigation.bread-crumb-item label='Liste patients' link='consultations.request.list' isLinked=true />
        <x-navigation.bread-crumb-item label='Consultation patient' />
    </x-navigation.bread-crumb>
    <x-content.main-content-page>
        @if ($consultationSheet != null)
            <x-widget.patient.card-patient-info :consultationSheet='$consultationSheet' />
        @endif
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex justify-content-between   align-items-center ">
                @livewire('application.widgets.input-check-box-hospitalize-widget', ['consultationRequest' => $consultationRequest])
                @livewire('application.widgets.input-check-box-mark-finished-widget', ['consultationRequest' => $consultationRequest])
                @if (Auth::user()->roles->pluck('name')->contains('Pharma') ||
                        Auth::user()->roles->pluck('name')->contains('Ag') ||
                        Auth::user()->roles->pluck('name')->contains('Admin'))
                    <div class="bg-navy p-1 rounded-lg ml-2">
                        <h3 wire:loading.class="d-none"><span>Montant:</span>
                            <span class="money_format">
                                {{ app_format_number($consultationRequest->getTotalInvoiceCDF(), 0) }} FC</span>
                            |
                            <span class="money_format">
                                {{ app_format_number($consultationRequest->getTotalInvoiceUSD(), 0) }} $</span>
                        </h3>
                    </div>
                @endif
            </div>
            <div>
                @if (Auth::user()->roles->pluck('name')->contains('Doctor'))

                    <x-form.button wire:click="openNursingModal" class="btn-danger  mr-1" type='button'>
                        <i class="fa fa-eye"></i>
                        Nuering
                    </x-form.button>
                @else
                    <x-form.button wire:click="openDetailConsultationModal" class="btn-secondary  mr-1" type='button'>
                        <i class="fa fa-eye"></i>
                        Visualiser
                    </x-form.button>
                    <x-form.button wire:click="openNursingModal" class="btn-danger  mr-1" type='button'>
                        <i class="fa fa-eye"></i>
                        Nuering
                    </x-form.button>
                    @if (Auth::user()->roles->pluck('name')->contains('Pharma') ||
                            Auth::user()->roles->pluck('name')->contains('Ag') ||
                            Auth::user()->roles->pluck('name')->contains('Admin'))
                        <x-navigation.link-icon
                            href="{{ route('consultation.request.private.invoice', $consultationRequest->id) }}"
                            :icon="'fa fa-print'" class="btn btn-sm  btn-secondary" />
                    @endif
                @endif
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    @foreach ($categories as $category)
                        <li class="nav-item">
                            <a wire:click='changeIndex({{ $category }})'
                                class="nav-link {{ $selectedIndex == $category->id ? 'active' : '' }} "
                                href="#inscription" data-toggle="tab">
                                &#x1F4C2; {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        @if (Auth::user()->roles->pluck('name')->contains('Doctor'))
                            <div>
                                @livewire('application.sheet.form.new-consultation-comment', ['consultationRequest' => $consultationRequest])
                            </div>
                        @endif
                        <div class="mt-2">
                            @livewire('application.sheet.form.consult-patient', ['consultationRequest' => $consultationRequest, 'selectedIndex' => $selectedIndex])
                        </div>
                    </div>
                    <div class="col-md-6">
                        @livewire('application.sheet.widget.vital-sign-items-widget', ['consultationRequest' => $consultationRequest])
                        @if (Auth::user()->roles->pluck('name')->contains('Doctor'))
                            @livewire('application.sheet.widget.dignostic-itmes-widget', ['consultationRequest' => $consultationRequest])
                            @livewire('application.sheet.widget.doctor-tarif-items-with-consultation-widget', [
                                'tarifId' => $selectedIndex,
                                'consultationRequestId' => $consultationRequest->id,
                            ])
                        @else
                            @livewire('application.sheet.widget.tarif-items-with-consultation-widget', [
                                'tarifId' => $selectedIndex,
                                'consultationRequestId' => $consultationRequest->id,
                            ])
                        @endif

                        @livewire('application.sheet.form.doctor-medical-prescription', ['consultationRequest' => $consultationRequest])
                    </div>
                </div>

            </div>
        </div>
    </x-content.main-content-page>
    @push('js')
        <script type="module">
            //Open detail consultation  modal
            window.addEventListener('open-details-consultation', e => {
                $('#consultation-detail').modal('show')
            });
            //Open antecedent medical  modal
            window.addEventListener('open-antecedent-medical', e => {
                $('#antecedent-medical').modal('show')
            });
            //Open medical prescription modal
            window.addEventListener('open-medical-prescription', e => {
                $('#form-medical-prescription').modal('show')
            });
            //Open medical prescription modal
            window.addEventListener('open-consultation-request-nursing', e => {
                $('#form-consultation-request-nursing').modal('show')
            });
        </script>
    @endpush
</div>
