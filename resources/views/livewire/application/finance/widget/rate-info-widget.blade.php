
<h3 class="text-bold {{ Auth::user()?->setting?->is_dark_mode == true ? 'text-info' : 'text-indigo' }} ">Taux 1$= <span>{{ $rate }}</span> CDF</h3>
