<div>
    <x-modal.build-modal-fixed
        idModal='consultation-detail'
        size='lg' headerLabel="DETAILS DE LA CONSULTATION"
        headerLabelIcon='fa fa-folder-plus'>
        <div>
            @if($consultationRequest != null)
                <x-widget.patient.card-patient-info
                    :consultationSheet='$consultationRequest->consultationSheet' />
                @foreach($categoriesTarif as $index => $category)
                    @if(!$category->getConsultationTarifItemls($consultationRequest,$category)->isEmpty())
                        <h4>{{$category->name}}</h4>
                        <table class="table table-striped table-sm">
                            <thead class="bg-primary">
                            <tr>
                                <th class="">DESIGNATION</th>
                                <th class="text-center">NUMBRE</th>
                                <th class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($category->getConsultationTarifItemls($consultationRequest,$category) as $item)
                                <tr style="cursor: pointer;">
                                    <td class="text-uppercase">
                                        @if($isEditing && $idSelected==$item->id)
                                            <select class="form-control" wire:model.live='idTarif'>
                                                @foreach ($tarifs as $tarif)
                                                    <option value="{{$tarif->id}}" class="text-uppercase">
                                                        {{ $tarif->abbreviation==null?$tarif->name:$tarif->abbreviation }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @else
                                            - {{$item->name}}
                                        @endif
                                    </td>
                                    <td class="text-uppercase text-center">
                                        @if($isEditing && $idSelected==$item->id)
                                            <x-form.input type='text' wire:model='qty' wire:keydown.enter='update'
                                                          :error="'qty'"/>
                                        @else
                                            {{$item->qty}}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <x-form.edit-button-icon
                                            wire:click="edit({{$item->id}},{{$item->qty}},{{$item->category_id}},{{$item->id_tarif}})"
                                            class="btn-sm"/>
                                        <x-form.delete-button-icon wire:click="delete({{$item->id}})" class="btn-sm"/>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                @endforeach
                <h4>MEDICATION</h4>
                @livewire('application.product.widget.products-with-consultation-item-widget',
                ['consultationRequest'=>$consultationRequest])
            @endif
        </div>

    </x-modal.build-modal-fixed>
</div>
