<?php

namespace App\Models;

use App\Livewire\Helpers\Date\DateFormatHelper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ConsultationSheet extends Model
{
    use HasFactory;
    protected $fillable=[
        'number_sheet','name','date_of_birth','phone','other_phone','email',
        'blood_group','gender','type_patient_id','municipality','rural_area',
        'street','street_number', 'subscription_id','hospital_id','agent_service_id',
        'registration_number', 'source_id'
    ];

    protected $casts=[
        'date_of_birth'=>'datetime'
    ];

    public function getDateOfBirthAttribute($value): string
    {
        return Carbon::parse($value)->toFormattedDate();
    }

    /**
     * @return string|null
     * Get patient age
     */
    public function getPatientAge(): ?string
    {
        return DateFormatHelper::getUserAge($this->date_of_birth);
    }

    /**
     * Get the hosîtal that owns the ConsultationSheet
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hospital(): BelongsTo
    {
        return $this->belongsTo(Hospital::class, 'hospital_id');
    }

    /**
     * Get the subscription that owns the ConsultationSheet
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class, 'subscription_id');
    }

    /**
     * Get the typePatient that owns the ConsultationSheet
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function typePatient(): BelongsTo
    {
        return $this->belongsTo(TypePatient::class, 'type_patient_id');
    }

    public function consultationRequests():HasMany{
        return $this->hasMany(ConsultationRequest::class);
    }

    /**
     * Get the source that owns the ConsultationSheet
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class, 'source_id');
    }

    public function  getFreshConsultation():ConsultationRequest{
        return ConsultationRequest::where('consultation_sheet_id',$this->id)
            ->orderBy('created_at','DESC')->first();
    }

}
