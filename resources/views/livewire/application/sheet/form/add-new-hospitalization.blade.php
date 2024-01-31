<div class="row">
    <div class="col-md-12">
        <h4 class="text-navy"><i class="fa fa-bed" aria-hidden="true"></i> HOSPITALISATION</h4>
        <div class="card p-2">
            <form wire:submit='handlerSubmit'>
                <h5 class="text-info "><i class="{{$consultationRequestHospitalization==null?'fa fa-plus-circle':'fa fa-pen' }} " aria-hidden="true"></i> {{ $formLabel }}</h5>
                <hr>
                <div class="d-flex  align-content-center ">
                    <div class="form-group">
                        <x-form.label value="{{ __('Chambre') }}" />
                        <x-widget.list-hospitalization-widget wire:model.blur='hospitalization_room_id'
                            :error="'hospitalization_room_id'" />
                        <x-errors.validation-error value='hospitalization_room_id' />
                    </div>
                    <div class="form-group">
                        <x-form.label value="{{ __('Nombre jour') }}" />
                        <x-form.input type='number' wire:model='number_of_day' :error="'number_of_day'" />
                        <x-errors.validation-error value='number_of_day' />
                    </div>
                </div>
            </form>
        </div>
        <table class="table table-bordered table-sm">
            <thead class="bg-indigo">
                <tr>
                    <th>#</th>
                    <th>Chambre</th>
                    <th>Nombre</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if ($consultationRequestHospitalizations->isEmpty())
                    <tr>
                        <td colspan="4" class="text-center">
                            <x-errors.data-empty />
                        </td>
                    </tr>
                @else
                    @foreach ($consultationRequestHospitalizations as $index => $consultationRequestHospitalization)
                        <tr style="cursor: pointer;" id="row1">
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $consultationRequestHospitalization?->hospitalizationRoom?->name }}</td>
                            <td>{{ $consultationRequestHospitalization->number_of_day }}</td>
                            <td class="text-center">
                                <x-form.edit-button-icon wire:click="edit({{ $consultationRequestHospitalization }})" class="btn-sm" />
                                <x-form.delete-button-icon wire:confirm="Etes-vous de supprimer?"
                                    wire:click="delete({{ $consultationRequestHospitalization }})" class="btn-sm" />
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
