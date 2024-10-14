<div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="list-group">
                        @foreach ($categoryDiagnostics as $categoryDiagnostic)
                            <button type="button" wire:click='changeSelectedIndex({{ $categoryDiagnostic->id }})'
                                class="list-group-item list-group-item-action text-uppercase text-bold
                        {{ $selectedIndex == $categoryDiagnostic->id ? 'active' : '' }}"
                                aria-current="true">
                               <i class="fa fa-arrows-alt" aria-hidden="true"></i> {{ $categoryDiagnostic->name }}
                            </button>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6 text-danger">
                            <h3> Paintes & Symptomes</h3>
                            @foreach ($symptoms as $symptom)
                                <!-- checkbox -->
                                <div class="form-group clearfix">
                                    <div class="icheck-primary d-inline">
                                        <input wire:model.live="symptomSelected" type="radio"
                                            value="{{ $symptom->id }}" id="{{ str_replace(' ', '', $symptom->name) }}">
                                        <label for="{{ str_replace(' ', '', $symptom->name) }}">
                                            {{ $symptom->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-md-6 text-primary">
                            <h3> Diagnostics</h3>
                            @foreach ($diagnostics as $diagnostic)
                                <!-- checkbox -->
                                <div class="form-group clearfix">
                                    <div class="icheck-primary d-inline">
                                        <input wire:model.live="diagnosticSelected" type="radio"
                                            value="{{ $diagnostic->id }}"
                                            id="{{ str_replace(' ', '', $diagnostic->name) }}">
                                        <label for="{{ str_replace(' ', '', $diagnostic->name) }}">
                                            {{ $diagnostic->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
