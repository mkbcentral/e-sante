<div>
    <h4 class=""><i class="fa fa-file" aria-hidden="true"></i> Signes vitaux</h4>
    <div class="card">
        <div class="card-body">
            @if ($consultationRequest->vitalSigns->isEmpty())
                <span class=" text-danger">
                    <h6 class="text-center"> Aucun signe vital</h6>
                </span>
            @else
                <ul>
                    @foreach ($consultationRequest->vitalSigns as $vitalSign)
                        <li class="">
                            {{ $vitalSign->name }}: <span class="text-bold">{{ $vitalSign->pivot->value }} {{ $vitalSign->unit }}</span>
                            <i class="fas fa-times text-danger " wire:confirm="Etês-vous sûre de réaliser l'opération ?"
                                wire:click="delete({{ $vitalSign->pivot->id }})" style="cursor: pointer"></i>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

</div>
