 <div class="card card-indigo">
     <div class="card-header">
         SOUS MENU
     </div>
     <div class="card-body">
         <div class="row">
             @foreach ($subMenus as $subMenu)
                 <div class="col-md-4">
                     <!-- checkbox -->
                     <div class="form-group clearfix">
                         <div class="icheck-primary d-inline">
                             <input type="checkbox" id="{{ str_replace(' ', '', $subMenu->name) }}"
                                 wire:model="subMenuItems" value="{{ $subMenu->id }}">
                             <label for="{{ str_replace(' ', '', $subMenu->name) }}" class="">
                                 {{ $subMenu->name }}
                             </label>
                         </div>
                     </div>
                 </div>
             @endforeach
         </div>
         <div class="d-flex justify-content-end">
             <x-form.button class="btn-success" type='button' wire:click='saveSubMenu'>
                 <i class="fa fa-save"></i>
                 Sauvegarder
             </x-form.button>
         </div>
     </div>
 </div>
