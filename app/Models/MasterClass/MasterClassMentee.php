<?php

namespace App\Models\MasterClass;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MasterClassMentee extends Model
{
    protected $table = 'master_class_mentees';

    protected $fillable = ['master_class_id', 'user_id', 'email'];

    public function masterClass()
    {
        return $this->belongsTo(MasterClass::class, 'master_class_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
