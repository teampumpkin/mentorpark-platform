<?php

namespace App\Models\MasterClass;

use App\Models\OrderAssignment;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MasterClass extends Model
{
    protected $table = 'master_classes';

    protected $fillable = [
        'title', 'slug', 'timezone', 'banner_image', 'description',
        'price', 'discount_type', 'discount_value', 'hide_price',
        'whatsapp_notification', 'email_notification', 'isDraft', 'isActive', 'user_id',
    ];

    public function sessions()
    {
        return $this->hasMany(MasterClassSession::class, 'master_class_id');
    }

    public function attachments()
    {
        return $this->hasMany(SessionAttachment::class, 'master_class_id')
            ->whereNull('master_class_session_id');
    }

    public function mentees()
    {
        return $this->hasMany(MasterClassMentee::class, 'master_class_id');
    }

    public function feedbacks()
    {
        return $this->hasMany(SessionFeedback::class, 'master_class_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function assignments()
    {
        return $this->hasMany(OrderAssignment::class, 'master_class_id');
    }
}
