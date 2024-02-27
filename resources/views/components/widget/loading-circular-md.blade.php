@props(['color'=>'text-danger'])
<span wire:loading {{ $attributes }} class="spinner-border spinner-border-sm {{ $color }}" role="status" aria-hidden="true"></span>
