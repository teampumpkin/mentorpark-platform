<?php

namespace App\Models;

use App\Models\Locations\City;
use App\Models\Locations\Country;
use App\Models\Locations\State;
use App\Models\Master\IndustryType;
use App\Models\Master\Skill;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserInformation extends Model
{
    use HasFactory;
    protected $table = 'user_information';
    protected $fillable = [
        'user_id',
        'organization_id',
        'industry_type_id',
        'user_type',
        'about',
        'organization_name',
        'additional_description',
        'job_title',
        'total_experience',
        'skills',
        'goal',
        'linkedin',
        'twitter',
        'facebook',
        'instagram',
        'youtube',
        'website',
        'state',
        'country',
        'city',
        'your_level',
        'postal_code',
        'profile_photo',
        'mentor_motivation',
        'associate_yourself',
        'address',
    ];

    protected $casts = [
        'user_type' => 'array',
        'skills' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'user_information_skill', 'user_information_id', 'skill_id');
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

    public function industryType()
    {
        return $this->belongsTo(IndustryType::class, 'industry_type');
    }

}
