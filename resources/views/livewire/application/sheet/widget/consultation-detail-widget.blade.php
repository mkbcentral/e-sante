<table class="table table-sm table-bordered">
    <tr class="{{ $consultationRequest->is_consultation_paid ? 'bg-danger' : 'bg-secondary' }}">
        <td class="text-uppercase">
            @if ($isEditing)
                <select class="form-control" wire:model.live='idConsultation'>
                    @foreach ($consultations as $consultation)
                        <option value="{{ $consultation->id }}" class="text-uppercase">
                            {{ $consultation->name }}
                        </option>
                    @endforeach
                </select>
            @else
                <span>
                    {{ $consultationRequest->is_consultation_paid ? 'Paid' : $consultationRequest->consultation->name }}
                </span>
            @endif
        </td>
        @if (Auth::user()->roles->pluck('name')->contains('Pharma') ||
                Auth::user()->roles->pluck('name')->contains('Ag') ||
                Auth::user()->roles->pluck('name')->contains('Admin'))
            <td class="text-right">
                @if ($consultationRequest->is_consultation_paid == true)
                    {{ app_format_number(0, 1) }}
                @else
                    {{ app_format_number(
                        $currencyName == 'USD'
                            ? $consultationRequest->getConsultationPriceUSD()
                            : $consultationRequest->getConsultationPriceCDF(),
                        1,
                    ) }}
                @endif
            </td>
        @endif
        <td class="text-center">
            @if (!$consultationRequest->is_consultation_paid)
                <x-form.icon-button :icon="'fa fa-edit text-white'" wire:click="edit" class="btn-sm" />
            @endif
            @if ($consultationRequest->is_consultation_paid)
                <x-form.icon-button :icon="'fa fa-times text-white'" wire:click="makeIsPaid" class="btn-sm" />
            @else
                <x-form.icon-button :icon="'fa fa-check text-white'" wire:click="makeIsPaid" class="btn-sm" />
            @endif

        </td>
    </tr>
</table>
