<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndustryType extends Model
{
    use HasFactory;
    protected $table = 'industry_type';
    protected $fillable = ['name'];

}
