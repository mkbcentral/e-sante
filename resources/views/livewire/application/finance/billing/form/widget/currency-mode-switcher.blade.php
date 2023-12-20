
<div>
    <div  class="d-flex justify-content-end align-items-center">
       <div class="bg-dark p-2" style="border: none;border-radius: 50px">
           <div class="custom-control custom-switch">
               <input style="display: none" wire:model.live="isUSD"
               type="checkbox" class="custom-control-input" id="mode-selector">
               <label class="custom-control-label" for="mode-selector">{{$currencyName=='CDF'?'CDF':'USD'}}</label>
           </div>
       </div>
    </div>
</div>
@push('js')
    <script type="module">
        $('#mode-selector').on('change',function () {
            $('body').toggleClass('dark-mode')
            $('nav').toggleClass('navbar-dark')
        })
    </script>
@endpush
