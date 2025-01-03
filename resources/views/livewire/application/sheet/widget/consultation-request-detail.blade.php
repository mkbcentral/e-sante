<div>
    <x-modal.build-modal-fixed idModal='consultation-detail' size='xl' headerLabel="DETAILS DE LA CONSULTATION"
        headerLabelIcon='fa fa-folder-plus'>
        <div class="d-flex justify-content-center">
            <x-widget.loading-circular-md />
        </div>
        <div class="card-primary" wire:loading.class='d-none'>
            @if ($consultationRequest != null)
                <div class="card-body">
                    @can('pharma-actions')
                        @if (!$consultationRequest->products->isEmpty())
                            <h5 class="text-danger text-bold">MEDICATION</h5>
                            @livewire('application.product.widget.products-with-consultation-item-widget', ['consultationRequest' => $consultationRequest])
                        @endif
                    @endcan
                    <x-widget.patient.card-patient-info :consultationSheet='$consultationRequest->consultationSheet' />
                    <div class="d-flex justify-content-end">
                        <h5 class="text-bold text-primary"><i class="fa fa-calendar"></i> Date:
                            {{ $consultationRequest?->created_at->format('d/M/Y') }}</h5>
                    </div>
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
                </div>
                @can('finance-view')
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
                @endcan
            @endif
        </div>
    </x-modal.build-modal-fixed>
</div>
