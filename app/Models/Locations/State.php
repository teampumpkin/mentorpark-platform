<?php

namespace App\Models\Locations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $table = 'states';
    public $timestamps = true;

    protected $fillable = [
        'name', 'country_id', 'country_code', 'fips_code',
        'iso2', 'latitude', 'longitude', 'flag', 'wikiDataId'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
