<?php

namespace App\Models;

use App\Models\MasterClass\MasterClass;
use App\Models\MasterClass\MasterClassSession;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderAssignment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_id',
        'organizer_id',
        'user_id',
        'master_class_id',
        'session_id',
        'user_file_path',
        'user_file_name',
        'user_file_mime',
        'user_file_size',
        'organizer_file_path',
        'organizer_file_name',
        'organizer_file_mime',
        'organizer_file_size',
        'status',
        'remarks',
        'user_uploaded_at',
        'organizer_reviewed_at',
        'final_submitted_at',
        'uploaded_by',
    ];

    protected $casts = [
        'user_uploaded_at' => 'datetime',
        'organizer_reviewed_at' => 'datetime',
        'final_submitted_at' => 'datetime',
    ];

    /*------------------------------------------
    | Relationships
    |------------------------------------------*/

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function masterClass()
    {
        return $this->belongsTo(MasterClass::class);
    }

    public function session()
    {
        return $this->belongsTo(MasterClassSession::class, 'session_id');
    }

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /*------------------------------------------
    | Accessors & Computed Attributes
    |------------------------------------------*/

    public function getUserFileUrlAttribute(): ?string
    {
        return $this->user_file_path ? asset('storage/' . $this->user_file_path) : null;
    }

    public function getOrganizerFileUrlAttribute(): ?string
    {
        return $this->organizer_file_path ? asset('storage/' . $this->organizer_file_path) : null;
    }

    public function getReadableUserFileSizeAttribute(): string
    {
        return $this->formatFileSize($this->user_file_size);
    }

    public function getReadableOrganizerFileSizeAttribute(): string
    {
        return $this->formatFileSize($this->organizer_file_size);
    }

    protected function formatFileSize(?int $bytes): string
    {
        if (!$bytes) return 'N/A';

        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /*------------------------------------------
    | Helper Methods
    |------------------------------------------*/

    public function isAssigned(): bool
    {
        return $this->status === 'assigned';
    }

    public function isUploaded(): bool
    {
        return $this->status === 'uploaded';
    }

    public function isUnderReview(): bool
    {
        return $this->status === 'under_review';
    }

    public function isRedo(): bool
    {
        return $this->status === 'redo';
    }

    public function isSubmitted(): bool
    {
        return $this->status === 'submitted';
    }

    /*------------------------------------------
    | Query Scopes
    |------------------------------------------*/

    public function scopePending($query)
    {
        return $query->where('status', 'under_review');
    }

    public function scopeRedo($query)
    {
        return $query->where('status', 'redo');
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByOrganizer($query, $organizerId)
    {
        return $query->where('organizer_id', $organizerId);
    }
}
