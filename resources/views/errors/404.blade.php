<x-app-layout>
    <div class="p-4 text-center">
        <div class="mt-4 text-bold text-danger" style="font-size: 150px">
            <span> <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>Server error</span>
        </div>
        <div class="mt-4 text-bold text-info" style="font-size: 30px">
            <span> Aucune resource disponible SVP !</span>
        </div>
         <div class="mt-2 text-bold text-info" style="font-size: 20px">
           <a wire:navigate href="{{ route('dashboard') }}">
            <i class="fas fa-arrow-circle-left"></i>
            Retour
        </a>
        </div>
    </div>
</x-app-layout>
