@props(['sortAsc','sortBy','sortField'])
@if ($sortBy==$sortField)
    @if ($sortAsc)
        <i class="fas fa-sort-alpha-up"></i>
    @else
        <i class="fas fa-sort-alpha-up-alt"></i>
    @endif
@endif
