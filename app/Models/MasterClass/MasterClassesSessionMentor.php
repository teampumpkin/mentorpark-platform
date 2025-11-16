<?php

namespace App\Models\MasterClass;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterClassesSessionMentor extends Model
{
    use HasFactory;

    protected $table = 'master_classes_session_mentors';

    protected $fillable = [
        'master_class_id',
        'session_id',
        'name',
        'email',
        'isAccepted',
        'accepted_date',
    ];

    protected $casts = [
        'isAccepted' => 'boolean',
        'accepted_date' => 'date',
    ];

    // Define relations if needed
    public function masterClass()
    {
        return $this->belongsTo(MasterClass::class, 'master_class_id');
    }

    public function session()
    {
        return $this->belongsTo(MasterClassSession::class, 'session_id');
    }
}
