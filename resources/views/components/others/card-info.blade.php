@props(['label' => '', 'countValue' => '', 'bg' => ''])
<div class="info-box  bg-{{ $bg }}">
    <div class="info-box-content">
        <span class="info-box-text text-bold h4">{{ $label }}</span>
        <span class="info-box-number h3">
            {{ $countValue }}
        </span>
    </div>
    <a {{ $attributes }} wire:navigate class="small-box-footer">Voir
        détails
        <i class="fas fa-arrow-circle-right"></i></a>
</div>
