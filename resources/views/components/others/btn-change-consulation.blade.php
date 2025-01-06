@props([
    'isSelected' => false,
    'icon' => 'fa-calendar-day text-secondary',
    'label' => 'Journalière',
])
<button {{ $attributes }} type="button" class="btn {{ $isSelected == true ? 'btn-secondary' : ' btn-link' }}">
    <i class="fa {{ $icon }} {{ $isSelected == true ? 'text-white' : 'text-info' }}" aria-hidden="true"></i>
    {{ $label }}
</button>
