<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ConsultationRequest extends Model
{
    use HasFactory;

    protected $fillable=[
        'request_number','consultation_sheet_id',
        'consultation_id','rate_id','consulted_by',
        'printed_by','validated_by'
    ];

    public function rate():BelongsTo{
        return $this->belongsTo(Rate::class,'rate_id');
    }
    public function consultationSheet():BelongsTo{
        return $this->belongsTo(ConsultationSheet::class,'consultation_sheet_id');
    }
    public function consultation():BelongsTo{
        return $this->belongsTo(Consultation::class,'consultation_id');
    }

    public function vitalSigns():BelongsToMany{
        return $this->belongsToMany(VitalSign::class)->withPivot(['id','value']);
    }
    public function medicalOffices():BelongsToMany{
        return $this->belongsToMany(MedicalOffice::class);
    }

}
