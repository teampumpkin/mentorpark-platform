<?php

namespace App\Models\Master;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;
    protected $table = 'skills';
    protected $fillable = ['name'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_skills');
    }
}
