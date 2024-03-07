<div>
    <x-modal.build-modal-fixed idModal='form-pay-roll' size='md' bg='bg-success'
        headerLabel="{{ $payroll == null ? 'CREATION ETAT DE PAIE' : 'EDITION ETAT DE PAIE' }}"
        headerLabelIcon="{{ $payroll == null ?'fa fa-folder-plus':'fa fa-pen'}}">
        <form wire:submit='handlerSubmit'>
            <div class="card p-1">
                <div class="card-body">
                    <div class="form-group">
                        <x-form.label value="{{ __('DESCRIPTION') }}" />
                        <x-form.input type='text' wire:model.blur='description' :error="'description'" />
                        <x-errors.validation-error value='description' />
                    </div>
                    <div class="form-group">
                        <label for="cat-spend">Catgorie</label>
                        <select id="cat-spend" class="form-control"
                         wire:model.blur='category_spend_money_id'>
                            <option value="">Choisir</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <x-errors.validation-error value='category_spend_money_id' />
                    </div>
                    <div class="form-group">
                        <h5 class="pb-2">Devise</h5>
                        <div class="row">
                            @foreach ($currencies as $currency)
                                <div class="col-md-2">
                                    <!-- radio -->
                                    <div class="form-group clearfix">
                                        <div class="icheck-success d-inline">
                                            <input type="radio" value="{{ $currency->id }}" id="{{ $currency->name }}"
                                                wire:model.live="currency_id">
                                            <label for="{{ $currency->name }}">
                                                {{ $currency->name }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class=" d-flex justify-content-end">
                        <x-form.button class="btn-success" type='submit'><i class="fa fa-save"></i> Sauvegarder
                        </x-form.button>
                    </div>
                </div>
            </div>
        </form>
    </x-modal.build-modal-fixed>
    @push('js')
        <script type="module">
            //Open edit sheet modal
            window.addEventListener('close-form-pay-roll', e => {
                $('#form-pay-roll').modal('hide')
            });
        </script>
    @endpush
</div>
