 <div class="card card-navy">
     <div class="card-header">
         MENUS PRINCIPAUX
     </div>
     <div class="card-body">
         <div class="row">
             @foreach ($mainMenus as $mainMenu)
                 <div class="col-md-4">
                     <!-- checkbox -->
                     <div class="form-group clearfix">
                         <div class="icheck-primary d-inline">
                             <input type="checkbox" id="{{ str_replace(' ', '', $mainMenu->name) }}"
                                 wire:model="mainMenuItems" value="{{ $mainMenu->id }}"
                                 {{ $user->mainMenus()->pluck('main_menu_id')->contains($mainMenu->id)? 'checked': '' }}>
                             <label for="{{ str_replace(' ', '', $mainMenu->name) }}" class="">
                                 {{ $mainMenu->name }}
                             </label>
                         </div>
                     </div>
                 </div>
             @endforeach
         </div>
         <div class="d-flex justify-content-end">
             <x-form.button class="btn-success" type='button' wire:click='saveMainMenu'>
                 <i class="fa fa-save"></i>
                 Sauvegarder
             </x-form.button>
         </div>
     </div>
 </div>
