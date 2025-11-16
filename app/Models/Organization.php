<?php

namespace App\Models;

use App\Models\Locations\City;
use App\Models\Locations\Country;
use App\Models\Locations\State;
use App\Models\Master\IndustryType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;
    protected $table = 'organization';
    protected $fillable = [
        'name',
        'email',
        'phone',
        'website',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'industry_type',
        'registration_number',
        'founded_date',
        'logo_path',
        'is_active',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
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

    public function userInformation()
    {
        return $this->hasMany(UserInformation::class);
    }
}
