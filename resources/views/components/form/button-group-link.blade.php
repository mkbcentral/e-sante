@props(['bg' => 'btn-secondary', 'label' => 'Actions'])
<div class="btn-group">
    <button type="button" class="btn {{ $bg }} btn-sm"><i class="fas fa-file-export"></i>
        {{ $label }} </button>
    <button type="button" class="btn {{ $bg }} btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
        <span class="sr-only">Toggle Dropdown</span>
    </button>
    <div class="dropdown-menu" role="menu">
       {{ $slot }}
    </div>
</div>
