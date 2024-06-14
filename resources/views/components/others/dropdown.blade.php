 @props(['title'=>'','icon'=>''])
 <div class="btn-group">
     <button type="button" class="btn btn-link dropdown-icon" data-toggle="dropdown" aria-expanded="false">
         <i class="{{ $icon }}" aria-hidden="true"></i>
         {{ $title }}
     </button>
     <div class="dropdown-menu" role="menu" style="">
        {{ $slot }}
     </div>
 </div>
