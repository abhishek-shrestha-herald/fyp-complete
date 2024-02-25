<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitConversion extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_unit_id',
        'first_unit_value',
        'second_unit_id',
        'second_unit_value',
    ];

    // Relationship

    public function firstUnit()
    {
        return $this->belongsTo(Unit::class, 'first_unit_id', 'id');
    }

    public function secondUnit()
    {
        return $this->belongsTo(Unit::class, 'second_unit_id', 'id');
    }
}
