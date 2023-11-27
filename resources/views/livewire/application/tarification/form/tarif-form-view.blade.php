<div class="mt-2 pr-3">
    <div class="card">
        <div class="card-header bg-primary"><h6><x-icons.icon-plus-circle/> CREATION D'UN NOUVEAU TARIF</h6></div>
       <form wire:submit='store'>
           <div class="card-body">
               <div class="form-group">
                   <x-form.label value="{{ __('Nom tarif') }}" />
                   <x-form.input type='text' wire:model.blur='name' :error="'name'" />
                   <x-errors.validation-error value='name' />
               </div>
               <div class="form-group">
                   <x-form.label value="{{ __('Abbreviation') }}" />
                   <x-form.input type='text' wire:model.blur='abbreviation' :error="'abbreviation'" />
                   <x-errors.validation-error value='abbreviation' />
               </div>
               <div class="form-group">
                   <x-form.label value="{{ __('Prix privé') }}" />
                   <x-form.input type='text' wire:model.blur='price_private' :error="'price_private'" />
                   <x-errors.validation-error value='price_private' />
               </div>
               <div class="form-group">
                   <x-form.label value="{{ __('Prix abonné') }}" />
                   <x-form.input type='text' wire:model.blur='subscriber_price' :error="'subscriber_price'" />
                   <x-errors.validation-error value='subscriber_price' />
               </div>
           </div>
           <div class="card-footer d-flex justify-content-end">
               <x-form.button class="btn-primary" type='submit'><i class="fa fa-save"></i> Sauvegarder</x-form.button>
           </div>
       </form>
    </div>
</div>
