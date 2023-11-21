@props(['consultationSheet'])
<div class="card">
    <div class="card-body">
        <h5 class="text-bold">INDENTITES</h5>
        <hr>
        <div class="row invoice-info">
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
                <h3 class="text-uppercase text-primary"><b>N° Fiche: {{$consultationSheet->number_sheet.'/'.$consultationSheet->subscription->name}}</b></h3>
                <div class="h6">
                    <b>Noms:</b> <span class="text-uppercase">{{$consultationSheet->name}}</span><br>
                    <b>Genre:</b> {{$consultationSheet->gender}}<br>
                    <b>Age:</b> {{$consultationSheet->getPatientAge($consultationSheet->date_of_birth)}}<br>
                    <b>Age:</b> {{$consultationSheet->typePatient->name}}
                </div>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col h6">
                <address>
                    <span>{{$consultationSheet->municipality}}</span>,
                    <span>{{$consultationSheet->rural_area}}</span><br>
                    <span>{{$consultationSheet->street}}</span>
                    <span>{{$consultationSheet->street_number}}</span><br>
                    Phone: {{$consultationSheet->phone.' '.$consultationSheet->other_phone}}<br>
                    Email: {{$consultationSheet->email}}
                </address>
            </div>
        </div>

    </div>
</div>


