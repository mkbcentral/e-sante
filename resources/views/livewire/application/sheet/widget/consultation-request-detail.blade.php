<div>
    <x-modal.build-modal-fixed idModal='consultation-detail' size='lg' headerLabel="DETAILS DE LA CONSULTATION"
        headerLabelIcon='fa fa-folder-plus'>
        <div class="d-flex justify-content-center">
            <x-widget.loading-circular-md />
        </div>
        <div class="card-primary" wire:loading.class='d-none'>
            @if ($consultationRequest != null)
                <div class="card-body">
                    <x-widget.patient.card-patient-info :consultationSheet='$consultationRequest->consultationSheet' />
                    <h5 class="text-danger text-bold">CONSULTATION</h5>
                    @livewire('application.sheet.widget.consultation-detail-widget', ['consultationRequest' => $consultationRequest])
                    @foreach ($categoriesTarif as $index => $category)
                        @if (!$category->getConsultationTarifItems($consultationRequest, $category)->isEmpty())
                            <h5 class="text-danger text-bold">{{ $category->name }}</h5>
                            @livewire('application.sheet.widget.item-tarif-by-category-widget', ['categoryTarif' => $category, 'consultationRequest' => $consultationRequest])
                        @endif
                    @endforeach
                    @if (!$consultationRequest->products->isEmpty())
                        <h5 class="text-danger text-bold">MEDICATION</h5>
                        @livewire('application.product.widget.products-with-consultation-item-widget', ['consultationRequest' => $consultationRequest])
                    @endif

                </div>
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
        </div>
    </x-modal.build-modal-fixed>
</div>
