<div>
    <div class="card">
        <div class="card-body">
            @if ($consultationRequest->diagnostics->isEmpty())
                <span class=" text-danger">
                    <h6 class="text-center"> Aucun diagnostic</h6>
                </span>
            @else
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="">Symptomes et plaintes</h4>
                        <ul>
                            @foreach ($consultationRequest->diagnostics as $daignostic)
                                <li class="">
                                    {{ $daignostic->name }}
                                    <i class="fas fa-times text-danger "
                                        wire:confirm="Etês-vous sûre de réaliser l'opération ?"
                                        wire:click="deleteDiagnostic({{ $daignostic->pivot->id }})" style="cursor: pointer"></i>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h4 class="">Diagnostics</h4>
                        <ul>
                            @foreach ($consultationRequest->symptoms as $symptom)
                                <li class="">
                                    {{ $symptom->name }}
                                    <i class="fas fa-times text-danger "
                                        wire:confirm="Etês-vous sûre de réaliser l'opération ?"
                                        wire:click="deleteSymptom({{ $symptom->pivot->id }})" style="cursor: pointer"></i>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                </div>

            @endif
        </div>
    </div>

</div>
