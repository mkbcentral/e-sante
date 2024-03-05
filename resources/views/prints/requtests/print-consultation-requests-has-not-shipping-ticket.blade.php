<x-print-layout>
    <div class="text-center"><img src="{{ public_path('entete.png') }}" alt="Heder Image"></div>
    <h4 class="text-center text-bold mt-2">LISTE DES SANS BON {{$subscription->name}}   wire: </h4>
    <table class="table table-striped table-sm">
        <thead class="bg-dark text-white text-uppercase">
            <tr>
                <th class="text-center">#</th>
                <th>Nom</th>
                <th class="text-center">Matricule</th>
                <th class="text-right">SOURCE</th>
            </tr>
        </thead>
        <tbody>
            @if ($consultationRequests->isEmpty())

            @else
            @foreach ($consultationRequests as $index => $consultationRequest)
                <tr>
                    <td class="text-center">{{$index+1}}</td>
                    <td>{{$consultationRequest->consultationSheet->name}}</td>
                    <td class="text-center">{{$consultationRequest->consultationSheet?->registration_number}}</td>
                    <td class="text-right">{{$consultationRequest->consultationSheet->source->name}}</td>
                </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</x-print-layout>
