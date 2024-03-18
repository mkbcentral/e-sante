<div>
    <x-modal.build-modal-fixed idModal='consultation-detail' size='lg' headerLabel="DETAILS DE LA CONSULTATION"
        headerLabelIcon='fa fa-folder-plus'>
        <div class="d-flex justify-content-center">
            <x-widget.loading-circular-md />
        </div>
        <div class="card-primary" wire:loading.class='d-none'>
            @if ($consultationRequest != null)
                <div class="card-body">
                    @if (Auth::user()->roles->pluck('name')->contains('Pharma'))
                        @if (!$consultationRequest->products->isEmpty())
                            <h5 class="text-danger text-bold">MEDICATION</h5>
                            @livewire('application.product.widget.products-with-consultation-item-widget', ['consultationRequest' => $consultationRequest])
                        @endif
                    @else
                        <x-widget.patient.card-patient-info :consultationSheet='$consultationRequest->consultationSheet' />
                        <h5 class="text-danger text-bold">CONSULTATION</h5>
                        @livewire('application.sheet.widget.consultation-detail-widget', ['consultationRequest' => $consultationRequest])
                        @livewire('application.sheet.widget.item-tarif-by-category-widget', ['consultationRequest' => $consultationRequest])
                        @if (!$consultationRequest->products->isEmpty())
                            <h5 class="text-danger text-bold">MEDICATION</h5>
                            @livewire('application.product.widget.products-with-consultation-item-widget', ['consultationRequest' => $consultationRequest])
                        @endif
                        @if (!$consultationRequest->consultationRequestNursings->isEmpty())
                            <h5 class="text-danger text-bold">NURSING & AUTRES</h5>
                            @livewire('application.sheet.widget.consultation-request-nursing-widget', ['consultationRequest' => $consultationRequest])
                        @endif
                        @if (!$consultationRequest->consultationRequestHospitalizations->isEmpty())
                            <h5 class="text-danger text-bold">SEJOUR</h5>
                            @livewire('application.sheet.widget.hospitalization-item-widget', ['consultationRequest' => $consultationRequest])
                        @endif
                    @endif
                </div>
                @if (Auth::user()->roles->pluck('name')->contains('Pharma') ||
                        Auth::user()->roles->pluck('name')->contains('Ag') ||
                        Auth::user()->roles->pluck('name')->contains('Admin'))
                    <div class="card-footer d-flex  justify-content-end">
                        <table>
                            <tbody>
                                <tr>
                                    <td class="h4 text-bold text-danger">Total:</td>
                                    <td class="h4 text-bold">
                                        {{ app_format_number($consultationRequest->getTotalInvoiceCDF(), 1) }} FC</td>
                                </tr>
                                <tr>
                                    <td class="h4 text-bold"></td>
                                    <td class="h4 text-bold">
                                        {{ app_format_number($consultationRequest->getTotalInvoiceUSD(), 1) }} $</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endif
            @endif
        </div>
    </x-modal.build-modal-fixed>
</div>
