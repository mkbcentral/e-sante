<div class="card">
    <div class="card-body">
        @props(['consultationSheet','title'=>'FICHE DE CONSULTATION','icon'=>''])
      <div class="d-flex justify-content-center">
          <h3 class="text-bold"> <i class="{{$icon}}" aria-hidden="true"></i> {{$title}} N°  {{$consultationSheet?->number_sheet.'/'.$consultationSheet?->subscription->name}}</h3>
      </div>
        <hr>
        <div class="row invoice-info">
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
                <h4 class="text-uppercase text-primary"><b>Identités</b></h4>
                <div class="h6">
                    <b>Noms:</b> <span class="text-uppercase">{{$consultationSheet?->name}}</span><br>
                    <b>Genre:</b> {{$consultationSheet?->gender}}<br>
                    <b>Age:</b> {{$consultationSheet?->getPatientAge($consultationSheet?->date_of_birth)}}<br>
                    <b>Type:</b> {{$consultationSheet?->typePatient?->name}}
                </div>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col h6">
                 <h6 class="text-uppercase text-primary"><b>Contact</b></h6>
                <address>
                    Phone: {{$consultationSheet?->phone.' '.$consultationSheet?->other_phone}}<br>
                    Email: {{$consultationSheet?->email}}
                </address>
            </div>
             <!-- /.col -->
            <div class="col-sm-4 invoice-col h6">
                 <h6 class="text-uppercase text-primary"><b>Adresse physique</b></h6>
                <address>
                    <span>{{$consultationSheet?->municipality}}</span>,
                    <span>{{$consultationSheet?->rural_area}}</span><br>
                    <span>{{$consultationSheet?->street}}</span>
                </address>
            </div>
        </div>

    </div>
</div>


