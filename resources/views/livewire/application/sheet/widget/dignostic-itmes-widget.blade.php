<div>
    <h4 class="text-secondary"><i class="fa fa-file" aria-hidden="true"></i> Historique</h4>
    <div class="card">
        <div class="card-body">
            @if ($consultationRequest->diagnostics->isEmpty() && $consultationRequest->symptoms->isEmpty())
                <span class=" text-danger">
                    <h6 class="text-center"> Aucun diagnostic et symptomes</h6>
                </span>
            @else
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="text-danger">Symptomes et plaintes</h4>
                        <ul>
                            @foreach ($consultationRequest->symptoms as $symptom)
                                <li class="text-danger">
                                    {{ $symptom->name }}
                                    <i class="fas fa-times text-danger "
                                        wire:confirm="Etês-vous sûre de réaliser l'opération ?"
                                        wire:click="deleteSymptom({{ $symptom->pivot->id }})"
                                        style="cursor: pointer"></i>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h4 class="text-primary">Diagnostics</h4>
                        <ul>
                            @foreach ($consultationRequest->diagnostics as $daignostic)
                                <li class="text-primary">
                                    {{ $daignostic->name }}
                                    <i class="fas fa-times text-danger "
                                        wire:confirm="Etês-vous sûre de réaliser l'opération ?"
                                        wire:click="deleteDiagnostic({{ $daignostic->pivot->id }})"
                                        style="cursor: pointer"></i>
                                </li>
                            @endforeach
                        </ul>

                    </div>

                </div>

            @endif
        </div>
    </div>

</div>
