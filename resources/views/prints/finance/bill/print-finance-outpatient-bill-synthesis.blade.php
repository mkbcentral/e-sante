<x-print-layout>
    @php
        $total_cdf = 0;
        $total_usd = 0;
    @endphp
    <div class="text-center"><img src="{{ public_path('entete.png') }}" alt="Heder Image"></div>
    <h4 class="text-center text-bold mt-2">RAPPORT DES RECETTES MENSUELLES HOSPITALISES</h4>
    <div class="text-left"><span>Mois de: {{ format_fr_month_name($month) }}/2025</span></div>
    
    <div class="text-right"><span>Fait à Lubumbashi, Le {{ date('d/m/Y') }}</span></div>
</x-print-layout>
