<table class="table table-sm table-bordered">
    <tr class="{{$consultationRequest->is_consultation_paid?'bg-danger':'bg-secondary'}}">
        <td class="text-uppercase">
            @if($isEditing)
                <select class="form-control" wire:model.live='idConsultation'>
                    @foreach ($consultations as $consultation)
                        <option value="{{$consultation->id}}" class="text-uppercase">
                            {{ $consultation->name }}
                        </option>
                    @endforeach
                </select>
            @else
                <span>
                    {{$consultationRequest->is_consultation_paid?'Paid':
                        $consultationRequest->consultation->name}}
                </span>
            @endif
        </td>
        <td class="text-right">
            {{$consultationRequest->is_consultation_paid?0.0:
                app_format_number($consultationRequest->getConsultationPrice(),1)}}
        </td>
        <td class="text-center">
            @if(!$consultationRequest->is_consultation_paid)
                <x-form.icon-button
                    :icon="'fa fa-edit text-white'"
                    wire:click="edit" class="btn-sm"/>
            @endif
            @if($consultationRequest->is_consultation_paid)
                <x-form.icon-button
                    :icon="'fa fa-times text-white'"
                    wire:click="makeIsPaid" class="btn-sm"/>
            @else
                <x-form.icon-button
                    :icon="'fa fa-check text-white'"
                    wire:click="makeIsPaid" class="btn-sm"/>
            @endif

        </td>
    </tr>
</table>
