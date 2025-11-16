<?php

namespace App\Models\Master;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    use HasFactory;
    protected $table = 'goals';
    protected $fillable = ['name'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_goals');
    }
}
