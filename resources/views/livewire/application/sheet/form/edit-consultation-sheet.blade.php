<div>
    <x-modal.build-modal-fixed
        idModal='form-edit-sheet'
        size='xl' headerLabel=' MODIFIER LA FICHE DE CONSULTATION'
        headerLabelIcon='fa fa-edit'>
        <form wire:submit='update'>
            <div class="card">
                <div class="card-body">
                    <div class="card p-2">
                        <h3 class="text-danger text-bold text-uppercase"><i class="fa fa-user"></i> {{$subscription!=null?$subscription->name:''}}</h3>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <x-form.label value="{{ __('Numero de fiche') }}" />
                                <x-form.input type='text' wire:model.blur='form.number_sheet' :error="'form.number_sheet'" />
                                <x-errors.validation-error value='form.number_sheet' />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <x-form.label value="{{ __('Nom complet') }}" />
                                <x-form.input type='text' wire:model.blur='form.name' :error="'form.name'" />
                                <x-errors.validation-error value='form.name' />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <x-form.label value="{{ __('Date de naissance') }}" />
                                <x-form.input-date-picker id="dateOfBirth" :error="'form.date_of_birth'" wire:model.blur='form.date_of_birth'/>
                                <x-errors.validation-error value='form.date_of_birth' />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <x-form.label value="{{ __('Genre') }}" />
                                <x-widget.list-gender-widget wire:model.blur='form.gender' :error="'form.gender'" />
                                <x-errors.validation-error value='form.gender' />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <x-form.label value="{{ __('Type patient') }}" />
                                <x-widget.list-type-patient-widget wire:model.blur='form.type_patient_id' class="form-control" :error="'form.type_patient_id'" />
                                <x-errors.validation-error value='form.type_patient_id' class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <x-form.label value="{{ __('N° Tél') }}" />
                                <x-form.input-phone mask="data-mask-phone" wire:model.blur='form.phone' :error="'form.phone'"/>
                                <x-errors.validation-error value='form.phone' />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <x-form.label value="{{ __('Autre nTél') }}" />
                                <x-form.input-phone mask="other_phone " wire:model.blur='form.other_phone' :error="'form.other_phone'"/>
                                <x-errors.validation-error value='form.other_phone' />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <x-form.label value="{{ __('Email') }}" />
                                <x-form.input type='email' wire:model.blur='form.email' :error="'form.email'" />
                                <x-errors.validation-error value='form.email' />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <x-form.label value="{{ __('Commune') }}" />
                                <x-widget.list-municipality-widget wire:model.live='form.municipality' :error="'form.municipality'" />
                                <x-errors.validation-error value='form.municipality' />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <x-form.label value="{{ __('Quartier') }}" />
                                <x-widget.list-rural-area-widget municipalityName="{{$municipality_name}}" wire:model.blur='form.rural_area' :error="'form.rural_area'" />
                                <x-errors.validation-error value='form.rural_area' />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <x-form.label value="{{ __('Avenue') }}" />
                                <x-form.input type='text' wire:model.blur='form.street' :error="'form.street'" />
                                <x-errors.validation-error value='form.street' />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <x-form.label value="{{ __('Numéro') }}" />
                                <x-form.input type='text' wire:model.blur='form.street_number' :error="'form.street_number'" />
                                <x-errors.validation-error value='form.street_number' />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @if($subscription?->is_personnel)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <x-form.label value="{{ __('Service') }}" />
                                    <x-widget.list-agent-service-widget wire:model.blur='form.agent_service_id' :error="'form.agent_service_id'" />
                                    <x-errors.validation-error value='form.agent_service_id' />
                                </div>
                            </div>
                        @elseif($subscription?->is_subscriber)
                            <div class="col-md-12">
                                <div class="form-group">
                                    <x-form.label value="{{ __('N° matricule') }}" />
                                    <x-form.input type='text' wire:model.blur='form.registration_number' :error="'form.registration_number'" />
                                    <x-errors.validation-error value='form.registration_number' />
                                </div>
                            </div>
                        @endif

                    </div>
                    <div class="card mt-3 p-2">
                        <h5 class="pb-2">Goupe sanguin</h5>
                        <x-widget.list-blood-group-widget wire:model.blur="form.blood_group" />
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <x-form.button class="btn-primary" type='submit'><i class="fa fa-sync"></i> Mettre à jour</x-form.button>
                </div>
            </div>
        </form>
    </x-modal.build-modal-fixed>
</div>
@push('js')
    <script type="module">
        window.addEventListener('close-form',e=>{
            $('#form-edit-sheet').modal('hide')
        });
    </script>
@endpush
