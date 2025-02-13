<div>
    <x-modal.build-modal-fixed idModal='diagnostic-items' size='xl' headerLabel="Autres diagnostics"
        headerLabelIcon='fa fa-folder-plus'>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="list-group">
                            @foreach ($categoryDiagnostics as $category)
                                <a href="#" class="list-group-item list-group-item-action active">{{$category->name}}</a>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            @foreach ($diagnostics as $diagnostic)
                                <div class="col-sm-3">

                                    <div class="form-group clearfix">
                                        <div class="icheck-primary d-inline">
                                            <input type="radio" id="{{ str_replace(' ', '', $diagnostic->name) }}"
                                                wire:model.live="diagnosticsSelected" value="{{ $diagnostic->id }}">
                                            <label for="{{ str_replace(' ', '', $diagnostic->name) }}" class="">
                                                {{ $diagnostic->name }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- checkbox -->
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </x-modal.build-modal-fixed>
</div>
