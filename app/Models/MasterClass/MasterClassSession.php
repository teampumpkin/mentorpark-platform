<?php

namespace App\Models\MasterClass;

use App\Models\Locations\City;
use App\Models\Locations\Country;
use App\Models\Locations\State;
use App\Models\Master\IndustryType;
use App\Models\OrderAssignment;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MasterClassSession extends Model
{
    protected $table = 'master_class_sessions';

    protected $fillable = [
        'master_class_id', 'session_type', 'title', 'slug', 'start_date_time', 'end_date_time',
        'session_description', 'price', 'discount_type', 'discount_value', 'hide_price', 'skills' , 'isActive', 'user_id',
    ];

    protected $casts = [
        'start_date_time' => 'datetime',
        'end_date_time' => 'datetime',
        'skills' => 'array',
    ];

    public function masterClass()
    {
        return $this->belongsTo(MasterClass::class, 'master_class_id');
    }

    public function feedbacks()
    {
        return $this->hasMany(SessionFeedback::class, 'session_id');
    }

    public function mentors()
    {
        return $this->hasMany(MasterClassesSessionMentor::class, 'session_id');
    }

    public function attachments()
    {
        return $this->hasMany(SessionAttachment::class, 'master_class_session_id');
    }

    public function countryRel()
    {
        return $this->belongsTo(Country::class, 'country');
    }

    public function stateRel()
    {
        return $this->belongsTo(State::class, 'state');
    }

    public function cityRel()
    {
        return $this->belongsTo(City::class, 'city');
    }

    public function assignments()
    {
        return $this->hasMany(OrderAssignment::class, 'session_id');
    }

}
