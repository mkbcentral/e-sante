<div class="card">
    <div class="card-header bg-primary">
        <div class="d-flex justify-content-between align-items-center">
            <h5>Autres diagnostics</h5>
            <x-form.button class="btn-dark btn-sm" wire:click="addToConsultation">
                <i class="fa fa-plus-circle"></i> Ajouter
            </x-form.button>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            @foreach($diagnostics as $diagnostic)
                <div class="col-sm-3">
                    <div class="form-group clearfix">
                        <div  class="icheck-primary d-inline">
                            <input type="checkbox" id="{{str_replace(' ', '',$diagnostic->name)}}"
                                   wire:model="diagnosticsSelected" value="{{$diagnostic->id}}">
                            <label for="{{str_replace(' ', '',$diagnostic->name)}}"
                                   class="">
                                {{$diagnostic->name}}
                            </label>
                        </div>
                    </div></div>
                <!-- checkbox -->

            @endforeach
        </div>
    </div>
</div>
