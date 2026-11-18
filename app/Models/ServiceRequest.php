<?php

namespace App\Models;

use App\Enums\DocumentVerificationStatus;
use App\Enums\RequestStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_number',
        'student_id',
        'service_type_id',
        'qr_token',
        'status',
        'purpose',
        'pickup_schedule',
        'admin_notes',
        'tu_approved_by',
        'tu_approved_at',
        'kurikulum_approved_by',
        'kurikulum_approved_at',
        'rejection_note',
    ];

    protected $casts = [
        'status'                => RequestStatus::class,
        'pickup_schedule'       => 'datetime',
        'tu_approved_at'        => 'datetime',
        'kurikulum_approved_at' => 'datetime',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function serviceType(): BelongsTo
    {
        return $this->belongsTo(ServiceType::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(ServiceRequestItem::class);
    }

    public function statusHistories(): HasMany
    {
        return $this->hasMany(RequestStatusHistory::class);
    }

    public function handover(): HasMany
    {
        return $this->hasMany(Handover::class);
    }

    public function returnTransaction(): HasMany
    {
        return $this->hasMany(DocumentReturn::class, 'service_request_id');
    }

    public function tuApprovedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tu_approved_by');
    }

    public function kurikulumApprovedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'kurikulum_approved_by');
    }

    // SLA Duration Calculation
    public function getSlaFormattedAttribute(): string
    {
        $start = $this->created_at;
        $statusVal = is_object($this->status) ? $this->status->value : $this->status;

        $end = in_array($statusVal, ['completed', 'borrowed', 'returned', 'rejected', 'verified'], true)
            ? $this->updated_at
            : now();

        $diffInMinutes = $start->diffInMinutes($end);

        if ($diffInMinutes < 60) {
            return "{$diffInMinutes} menit";
        }

        $hours = floor($diffInMinutes / 60);
        $minutes = $diffInMinutes % 60;

        return "{$hours} jam {$minutes} mnt";
    }

    public function getIsOverSlaAttribute(): bool
    {
        $statusVal = is_object($this->status) ? $this->status->value : $this->status;

        // Standar SLA Sekolah = 24 Jam Pemrosesan
        return $this->created_at->diffInHours(now()) > 24 && ! in_array($statusVal, [
            'completed', 'borrowed', 'returned', 'rejected', 'verified'
        ], true);
    }
}