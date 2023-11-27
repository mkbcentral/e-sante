@props(['consultationSheet'])
<div>
    <span><span class="text-bold">Nom:</span> {{$consultationSheet->name}}</span><br>
    <span><span class="text-bold">Genre:</span> {{$consultationSheet->gender}}</span><br>
    <span><span class="text-bold">Age:</span> {{$consultationSheet->getPatientAge()}}</span><br>
    <span><span class="text-bold">Type:</span> {{$consultationSheet->subscription->name}}</span>
</div>
