<?php

namespace App\Models\Event;

use App\Models\MasterClass\MasterClass;
use App\Models\MasterClass\MasterClassSession;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventCalendar extends Model
{
    use HasFactory;

    protected $table = 'event_calendar';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'google_event_id',
        'summary',
        'description',
        'start',
        'end',
        'attendees',
        'meet_link',
        'master_class_id',
        'master_class_session_id',
        'user_id',
    ];

    /**
     * Cast attributes to proper types.
     */
    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
        'attendees' => 'array',
    ];

    /**
     * Relation with MasterClassSession.
     */
    public function session()
    {
        return $this->belongsTo(MasterClassSession::class, 'master_class_session_id');
    }

    /**
     * Relation with MasterClass.
     */
    public function master_class()
    {
        return $this->belongsTo(MasterClass::class, 'master_class_id');
    }


}
