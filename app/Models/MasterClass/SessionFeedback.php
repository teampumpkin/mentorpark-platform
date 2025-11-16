<?php

namespace App\Models\MasterClass;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SessionFeedback extends Model
{
    protected $table = 'master_class_session_feedbacks';

    protected $fillable = [
        'master_class_id', 'session_id', 'feedback_type', 'feedback_question',
    ];

    public function masterClass()
    {
        return $this->belongsTo(MasterClass::class, 'master_class_id');
    }

    public function session()
    {
        return $this->belongsTo(MasterClassSession::class, 'session_id');
    }
}
