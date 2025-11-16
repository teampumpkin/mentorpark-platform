<?php

namespace App\Models;

use App\Models\MasterClass\MasterClass;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestRaisedByMentee extends Model
{
    use HasFactory;

    protected $table = 'request_raised_by_mentee';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'mentee_id',
        'mentor_id',
        'organization_id',
        'master_class_id',
        'sessions',
        'complete_master_class',
        'status',
        'responded_at',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'sessions' => 'array',
        'responded_at' => 'datetime',
    ];

    /**
     * Relationships
     */

    // Mentee (User who raised the request)
    public function mentee()
    {
        return $this->belongsTo(User::class, 'mentee_id');
    }

    // Mentor (User who receives the request)
    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    // Organization (if linked)
    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    // Master class
    public function masterClass()
    {
        return $this->belongsTo(MasterClass::class, 'master_class_id');
    }
}
