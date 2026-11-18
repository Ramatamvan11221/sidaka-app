<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentReturn extends Model
{
    use HasFactory;

    protected $table = 'returns';

    protected $fillable = [
        'service_request_id',
        'processed_by',
        'returned_at',
        'condition_notes',
    ];

    protected $casts = [
        'returned_at' => 'datetime',
    ];

    public function serviceRequest(): BelongsTo
    {
        return $this->belongsTo(ServiceRequest::class);
    }

    public function processor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }
}