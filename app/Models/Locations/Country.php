<?php

namespace App\Models\Locations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $table = 'countries';
    public $timestamps = true;

    protected $fillable = [
        'name', 'iso3', 'iso2', 'phonecode', 'capital',
        'currency', 'currency_symbol', 'tld', 'native',
        'region', 'subregion', 'timezones', 'translations',
        'latitude', 'longitude', 'emoji', 'emojiU',
        'flag', 'wikiDataId', 'created_at', 'updated_at'
    ];

    public function states()
    {
        return $this->hasMany(State::class);
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
