<div>
    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="{{$idModal}}" tabindex="-1" role="dialog" aria-labelledby="{{$idModal}}Label"
        aria-hidden="true">
        <div class="modal-dialog modal-{{$size}}" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="{{$idModal}}Label">
                        <i class="fas fa-plus-circle"></i> PASSE UN NOUVEAU PAIEMENT
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{$slot}}
               
            </div>
        </div>
    </div>
</div>
