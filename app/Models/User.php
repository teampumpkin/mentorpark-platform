<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Master\Goal;
use App\Models\Master\Skill;
use App\Models\MasterClass\MasterClass;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'name',
        'user_slug',
        'email',
        'google_id',
        'google_token',
        'mobile',
        'password',
        'role_names',
        'organization_id'
    ];

    protected $casts = [
        'role_names' => 'array',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'mobile_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login_at' => 'datetime',
        ];
    }

    public function information(): HasOne
    {
        return $this->hasOne(UserInformation::class);
    }

    public function goals()
    {
        return $this->belongsToMany(Goal::class, 'user_goals');
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'user_skills');
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function masterClasses(): BelongsToMany
    {
        return $this->belongsToMany(MasterClass::class, 'master_class_mentees', 'user_id', 'master_class_id');
    }

    public function organization_masterClasses(): HasMany
    {
        return $this->hasMany(MasterClass::class, 'organization_id');
    }
}
