<?php

namespace App\Models\Locations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $table = 'cities';
    public $timestamps = true;

    protected $fillable = [
        'name', 'state_id', 'state_code', 'country_id',
        'country_code', 'latitude', 'longitude',
        'flag', 'wikiDataId'
    ];

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
