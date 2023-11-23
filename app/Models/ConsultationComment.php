<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConsultationComment extends Model
{
    use HasFactory;

    protected $fillable=['body','consultation_request_id'];
    public function consultationRequest():BelongsTo{
        return $this->belongsTo(ConsultationRequest::class,'consultation_request_id');
    }
}
