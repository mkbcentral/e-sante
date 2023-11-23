@props(['consultationSheet'])
<div class="card">
    <div class="card-body">
      <div class="d-flex justify-content-between">
          <h5 class="text-bold">INDENTITES</h5>
          <h5 class="text-bold text-primary"><i class="fa fa-calendar"></i> Date: {{$consultationSheet->created_at->format('d/M/Y')}}</h5>
      </div>
        <hr>
        <div class="row invoice-info">
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
                <h3 class="text-uppercase text-primary"><b>N° Fiche: {{$consultationSheet->number_sheet.'/'.$consultationSheet->subscription->name}}</b></h3>
                <div class="h6">
                    <b>Noms:</b> <span class="text-uppercase">{{$consultationSheet->name}}</span><br>
                    <b>Genre:</b> {{$consultationSheet->gender}}<br>
                    <b>Age:</b> {{$consultationSheet->getPatientAge($consultationSheet->date_of_birth)}}<br>
                    <b>Type:</b> {{$consultationSheet->typePatient->name}}
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
            <div class="col-sm-4 invoice-col h6">
               @if($consultationSheet != null)
                    @if(!$consultationSheet->getFreshConsultation()->vitalSigns->isEmpty())
                        <address>
                            @foreach($consultationSheet->getFreshConsultation()->vitalSigns as $vitalSigne)
                                <span><span class="text-bold">{{$vitalSigne->name}}:</span> {{$vitalSigne->pivot->value}}/{{$vitalSigne->unit}}</span><br>
                            @endforeach
                        </address>
                    @endif
                        <h6 class="text-uppercase text-primary"><b>Antecedents</b></h6>
                        @if(!$consultationSheet->getFreshConsultation()->diagnostics->isEmpty())
                            <address>
                                <div class="h6">
                                @foreach($consultationSheet->getFreshConsultation()->diagnostics as $diagnostic)
                                        <span class="">{{$diagnostic->name}}</span>,
                                @endforeach
                                </div>
                            </address>
                        @endif
               @endif
            </div>

        </div>

    </div>
</div>


