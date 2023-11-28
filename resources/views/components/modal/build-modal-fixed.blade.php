<!-- Modal -->
<div wire:ignore.self class="modal fade" id="{{ $idModal }}" tabindex="-1" role="dialog"
    aria-labelledby="{{ $idModal }}Label" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-{{ $size }}" role="document">
        <div class="modal-content">
            <div class="modal-header {{$bg}}">
                <h5 class="modal-title" id="{{ $idModal }}Label">
                    <i class="{{ $headerLabelIcon }}"></i> {{ $headerLabel }}
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
