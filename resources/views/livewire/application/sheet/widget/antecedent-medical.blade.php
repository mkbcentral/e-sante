<div>
    <x-modal.build-modal-fixed
        idModal='antecedent-medical'
        size='lg' headerLabel="ANTECTEDNTS MEDICAUX"
        headerLabelIcon='fa fa-folder-plus'>
        <div>
            @if($consultationRequest != null)
                <x-widget.patient.card-patient-info
                    :consultationSheet='$consultationRequest->consultationSheet' />
                <div>{!! htmlspecialchars_decode($consultationRequest?->consultationComment?->body)!!}</div>
            @endif
        </div>
    </x-modal.build-modal-fixed>
</div>
