<div>
    <x-modal.build-modal-fixed idModal='antecedent-medical' size='lg' headerLabel="ANTECTEDNTS MEDICAUX"
        headerLabelIcon='fa fa-folder-plus'>
        <div>
            @if ($consultationSheet != null)
                @foreach ($consultationSheet->consultationRequests as $c)
                    <h3>Date:{{ $c->created_at->format('d/m/Y') }}</h3>
                    <ul>
                        @foreach ($c->diagnostics as $daignostic)
                            <li class="">
                                {{ $daignostic->name }}
                                <i class="fas fa-times text-danger "
                                    wire:confirm="Etês-vous sûre de réaliser l'opération ?"
                                    wire:click="delete({{ $daignostic->pivot->id }})" style="cursor: pointer"></i>
                            </li>
                        @endforeach
                    </ul>
                    <div>{!! htmlspecialchars_decode($c?->consultationComment?->body) !!}</div>
                    <hr>
                    @endforeach

            @endif
        </div>
    </x-modal.build-modal-fixed>
</div>
