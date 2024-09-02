<div>
    <x-modal.build-modal-fixed idModal='form-expense-voucher' size='md' bg='bg-indigo'
        headerLabel="{{ $expenseVoucher == null ? 'CREATION BON DEPENSE' : 'EDITION BON DEPENSE' }}"
        headerLabelIcon="{{ $expenseVoucher == null ? 'fa fa-folder-plus' : 'fa fa-pen' }}">
        <form wire:submit='handlerSubmit'>
            <form wire:submit='handlerSubmit'>
                <div class="card-body">
                    <div class="form-group">
                        <h5 class="pb-2">Devise</h5>
                        <x-widget.finance.fin-currency wire:model.live="currency_id" />
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <x-form.label value="{{ __('Nom complet') }}" />
                            <x-form.input type='text' wire:model.blur='name' :error="'name'" />
                            <x-errors.validation-error value='name' />
                        </div>
                        <div class="form-group col-md-6">
                            <x-form.label value="{{ __('Montant') }}" />
                            <x-form.input type='text' wire:model.blur='amount' :error="'amount'" />
                            <x-errors.validation-error value='amount' />
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                        <x-form.label value="{{ __('Cetegorie') }}" />
                        <x-widget.list-cat-expense-widget wire:model.blur='category_spend_money_id' :error="'category_spend_money_id'" />
                        <x-errors.validation-error value='category_spend_money_id' />
                    </div>
                    <div class="form-group col-md-6">
                        <x-form.label value="{{ __('Service') }}" />
                        <x-widget.list-agent-service-widget wire:model.blur='agent_service_id' :error="'agent_service_id'" />
                        <x-errors.validation-error value='agent_service_id' />
                    </div>
                    </div>

                    <div class="form-group">
                        <x-form.label value="{{ __('Source dépense') }}" />
                        <x-widget.finance.source-payroll wire:model.live='payroll_source_id ' :error="'payroll_source_id '" />
                        <x-errors.validation-error value='payroll_source_id ' />
                    </div>
                    <div class="form-group">
                        <x-form.label value="{{ __('Description') }}" />
                        <x-form.input type='text' wire:model.blur='description' :error="'description'" />
                        <x-errors.validation-error value='description' />
                    </div>
                    <div class=" d-flex justify-content-end">
                        <x-form.button class="btn-primary" type='submit'><i class="fa fa-save"></i> Sauvegarder
                        </x-form.button>
                    </div>
                </div>
            </form>
        </form>
    </x-modal.build-modal-fixed>
    @push('js')
        <script type="module">
            //Open edit sheet modal
            window.addEventListener('close-form-expense-voucher', e => {
                $('#form-expense-voucher').modal('hide')
            });
        </script>
    @endpush
</div>
