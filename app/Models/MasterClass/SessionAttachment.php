<?php

namespace App\Models\MasterClass;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SessionAttachment extends Model
{
    protected $table = 'master_class_session_attachments';

    protected $fillable = [
        'master_class_id', 'master_class_session_id','user_id', 'attachment_path', 'file_name', 'file_original_name',
        'file_size', 'file_extension',
    ];

    public function masterClass()
    {
        return $this->belongsTo(MasterClass::class, 'master_class_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
