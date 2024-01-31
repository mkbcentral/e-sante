 <div class="col-md-3">
     <div>
         <div class="input-group">
             <input type="file" class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04"
                 aria-label="Upload" wire:model='file'>
             <button class="btn btn-secondary" type="button" id="inputGroupFileAddon04" wire:click='importPrivateSheets'>
                 <div class="spinner-border spinner-border-sm" role="status" wire:loading
                     wire:target='importPrivateSheets'>
                     <span class="visually-hidden"></span>
                 </div>
                 <i class="fas fa-file-download "></i>
                 Importer fiches privé
             </button>
         </div>
         <x-errors.validation-error value='file' />
     </div>
 </div>
