<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'symbol'
    ];

    // Relationships

    public function firstUnitConversion()
    {
        return $this->hasMany(UnitConversion::class, 'first_unit_id', 'id');
    }

    public function secondUnitConversion()
    {
        return $this->hasMany(UnitConversion::class, 'second_unit_id', 'id');
    }
}
