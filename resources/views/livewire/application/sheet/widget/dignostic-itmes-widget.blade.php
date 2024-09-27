<div>
    <h4 class="">Diagnostics</h4>
    <div class="card">
        <div class="card-body">
            @if ($consultationRequest->diagnostics->isEmpty())
                <span class=" text-danger">
                    <h6 class="text-center"> Aucun diagnostic</h6>
                </span>
            @else
                <ul>
                    @foreach ($consultationRequest->diagnostics as $daignostic)
                        <li class="">
                            {{ $daignostic->name }}
                            <i class="fas fa-times text-danger " wire:confirm="Etês-vous sûre de réaliser l'opération ?"
                                wire:click="delete({{ $daignostic->pivot->id }})" style="cursor: pointer"></i>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

</div>
